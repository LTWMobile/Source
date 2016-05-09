package phat.coffeeapp;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.widget.TextView;
import android.widget.Toast;
import android.widget.RelativeLayout;

import com.google.gson.GsonBuilder;

import java.io.IOException;
import java.io.InputStream;
import java.io.Reader;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Phat on 14/11/2015.
 */
public class QRCode_Scan extends AppCompatActivity {
    CoffeeInfo info;

    private String token;
    private String avatarUrl;
    Bitmap avatar;
    public String contents = "";
    private List<CoffeeItem> lst;
    static final String ACTION_SCAN = "com.google.zxing.client.android.SCAN";

    //RelativeLayout layout;
    TextView cfname;
    TextView cfaddress;
    String[] drinks;
    String[] prices;
    String[] drinkId;
    String[] imageUrl;
    ArrayList<Bitmap> imageList = new ArrayList<Bitmap>();

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_qrcode__scan);

    }

    public void scanQR(View v) {
        try {
            Intent intent = new Intent(ACTION_SCAN);
            intent.putExtra("SCAN_MODE", "QR_CODE_MODE");
            startActivityForResult(intent, 0);
        } catch (ActivityNotFoundException anfe) {
            showDialog(QRCode_Scan.this, "No Scanner Found", "Download a scanner code activity?", "Yes", "No").show();
        }
    }

    private static AlertDialog showDialog(final Activity act, CharSequence title, CharSequence message, CharSequence buttonYes, CharSequence buttonNo) {
        AlertDialog.Builder downloadDialog = new AlertDialog.Builder(act);
        downloadDialog.setTitle(title);
        downloadDialog.setMessage(message);
        downloadDialog.setPositiveButton(buttonYes, new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialogInterface, int i) {
                Uri uri = Uri.parse("market://search?q=pname:" + "com.google.zxing.client.android");
                Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                try {
                    act.startActivity(intent);
                } catch (ActivityNotFoundException anfe) {

                }
            }
        });
        downloadDialog.setNegativeButton(buttonNo, new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dialogInterface, int i) {
            }
        });
        return downloadDialog.show();
    }

    public void onActivityResult(int requestCode, int resultCode, Intent intent) {
        if (requestCode == 0) {
            if (resultCode == RESULT_OK) {
                contents = intent.getStringExtra("SCAN_RESULT");
                String format = intent.getStringExtra("SCAN_RESULT_FORMAT");

                if(contents.contains("id=") && contents.contains("table=") && contents.length() < 20) {

                    new CoffeeDownload().execute();
                }
                else {
                    Toast toast = Toast.makeText(this, "Content:" + contents + " Format:" + format, Toast.LENGTH_LONG);
                    toast.show();
                }
            }
        }

    }


    class ImageDownload extends AsyncTask<String[],Void,Bitmap> {
        ProgressDialog dlg;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            dlg=new ProgressDialog(QRCode_Scan.this);
            dlg.setCancelable(false);
            dlg.setMessage("Downloading Menu ...");
            dlg.show();
        }

        protected Bitmap doInBackground(String[]... urls) {
            String[] urlArray = urls[0];
            Bitmap mIcon11 = null;
            try {
                avatar = BitmapFactory.decodeStream(new java.net.URL(avatarUrl).openStream());
                for (int i = 0; i<urlArray.length; i++) {
                    String urldisplay = urlArray[i];
                    InputStream in = new java.net.URL(urldisplay).openStream();
                    mIcon11 = BitmapFactory.decodeStream(in);
                    mIcon11 = scaleDownBitmap(mIcon11,40,QRCode_Scan.this);
                    imageList.add(mIcon11);
                }

            } catch (Exception e) {
                Log.e("Error", e.getMessage());
                e.printStackTrace();
            }
            return mIcon11;
        }
        @Override
        protected void onPostExecute(Bitmap result) {
            getInfo();
        }
    }

    class CoffeeDownload extends AsyncTask<Void,Void,Void> {
        ProgressDialog dlg;

        @Override
        protected Void doInBackground(Void... params) {
            try
            {
                Reader rd= API.getData("http://hungphongbk.tmp-technology.com/takecoffee/public/",contents);
                info=new GsonBuilder().create().fromJson(rd, CoffeeInfo.class);
            } catch (IOException e) {
                e.printStackTrace();
            }
            return null;
        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            dlg=new ProgressDialog(QRCode_Scan.this);
            dlg.setCancelable(false);
            dlg.setMessage("Downloading...");
            dlg.show();
        }

        @Override
        protected void onPostExecute(Void aVoid) {
            super.onPostExecute(aVoid);
            dlg.dismiss();
            if(info==null){
                AlertDialog err=new AlertDialog.Builder(QRCode_Scan.this).create();
                err.setTitle("ERROR");
                err.setMessage("Network error expected!");
                err.setButton(DialogInterface.BUTTON_NEUTRAL, "Close", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();
                    }
                });
                err.show();
            } else {
                avatarUrl = info.getThumbnail();
                token = info.getToken();
                lst = info.getCoffeeInfo();
                drinks = new String[lst.size()];
                prices = new String[lst.size()];
                drinkId = new String[lst.size()];
                imageUrl = new String[lst.size()];
                for(int i = 0; i < lst.size(); i++) {
                    drinks[i] = lst.get(i).getCFName();
                    prices[i] = lst.get(i).getCFPrice().substring(0,lst.get(i).getCFPrice().length()-3) + "k";
                    drinkId[i] = lst.get(i).getDrinkId();
                    imageUrl[i] = lst.get(i).getThumbnail();
                }
                new ImageDownload().execute(imageUrl);

            }
        }
    }


    public static Bitmap scaleDownBitmap(Bitmap photo, int newHeight, Context context) {

        final float densityMultiplier = context.getResources().getDisplayMetrics().density;

        int h= (int) (newHeight*densityMultiplier);
        int w= (int) (h * photo.getWidth()/((double) photo.getHeight()));

        photo=Bitmap.createScaledBitmap(photo, w, h, true);

        return photo;
    }

    public  void getInfo(){
        Dialog dialog = new Dialog(QRCode_Scan.this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.dialog);
        //layout = (RelativeLayout) dialog.findViewById(R.id.layout);
       // layout.setBackground(new BitmapDrawable(avatar));
        cfname = (TextView) dialog.findViewById(R.id.name);
        cfaddress = (TextView) dialog.findViewById(R.id.address);
        cfname.setText(info.getName());
        cfaddress.setText(info.getAddress());
        dialog.show();
        TextView menu = (TextView) dialog.findViewById(R.id.gotoMenu);
        menu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(QRCode_Scan.this, Menu.class);
                intent.putExtra("Token",token);
                intent.putExtra("Drinks",drinks);
                intent.putExtra("Prices",prices);
                intent.putExtra("DrinkID",drinkId);
                intent.putParcelableArrayListExtra("bitmaps", imageList);
                startActivity(intent);
            }
        });
    }


}