package phat.coffeeapp;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.design.widget.FloatingActionButton;
import android.support.v7.app.AppCompatActivity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;

import com.google.gson.GsonBuilder;

import java.io.IOException;
import java.io.Reader;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Phat on 11/11/2015.
 */
public class ListOrder extends AppCompatActivity {

    private String token;
    private String orderParameters;
    StatusCF stt;
    private ArrayList<Item> myListOrder = null;
    private ArrayAdapter<Item> adapterOrder = null;
    private TextView total;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.list_order);

        total = (TextView) findViewById(R.id.total);
        Intent intent = this.getIntent();
        myListOrder = intent.getParcelableArrayListExtra("key");
        token = intent.getStringExtra("Token");
        int price = 0;
        for (Item i : myListOrder) {
            price += Integer.parseInt(i.getValue().substring(0, i.getValue().length() - 1)) * i.getQuantity();
        }
        total.setText("Total: " + String.valueOf(price) + "K");
        final ListView list = (ListView) findViewById(R.id.listOrder);

        adapterOrder = new ListItem(ListOrder.this, R.layout.item_order, myListOrder);
        list.setAdapter(adapterOrder);

        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view, final int position, long id) {
                final Item item = myListOrder.get(position);
                final Dialog dialog = new Dialog(ListOrder.this);
                dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
                dialog.setContentView(R.layout.remove_dialog);
                TextView name = (TextView) dialog.findViewById(R.id.nameremove);
                name.setText(item.getName());
                dialog.show();
                FloatingActionButton fabx = (FloatingActionButton) dialog.findViewById(R.id.fabX);
                final EditText remove = (EditText) dialog.findViewById((R.id.re_quantity));
                remove.setOnFocusChangeListener(new View.OnFocusChangeListener() {

                    @Override
                    public void onFocusChange(View v, boolean hasFocus) {
                        remove.post(new Runnable() {
                            @Override
                            public void run() {
                                InputMethodManager imm = (InputMethodManager) getBaseContext().getSystemService(Context.INPUT_METHOD_SERVICE);
                                imm.showSoftInput(remove, InputMethodManager.SHOW_IMPLICIT);
                            }
                        });
                    }
                });
                remove.requestFocus();
                fabx.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        if (remove.getText().length() > 0) {
                            if (Integer.parseInt(remove.getText().toString()) >= item.quantity) {
                                myListOrder.remove(position);
                                int price = 0;
                                for (Item i : myListOrder) {
                                    price += Integer.parseInt(i.getValue().substring(0, i.getValue().length() - 1)) * i.getQuantity();
                                }
                                total.setText("Total: " + String.valueOf(price) + "K");
                                adapterOrder.notifyDataSetChanged();
                            } else {
                                item.quantity -= Integer.parseInt(remove.getText().toString());
                                int price = 0;
                                for (Item i : myListOrder) {
                                    price += Integer.parseInt(i.getValue().substring(0, i.getValue().length() - 1)) * i.getQuantity();
                                }
                                total.setText("Total: " + String.valueOf(price) + "K");
                                adapterOrder.notifyDataSetChanged();
                            }
                        }
                        dialog.dismiss();
                        return;
                    }
                });
            }
        });
    }

    public class ListItem extends ArrayAdapter<Item> {
        public ListItem(Context context, int resource, List<Item> objects) {
            super(context, resource, objects);
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            View itemView = convertView;
            if (itemView == null) {
                LayoutInflater inflater = (LayoutInflater) ListOrder.this.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                itemView = inflater.inflate(R.layout.item_order, parent, false);
            }
            Item currentitem = myListOrder.get(position);
            TextView name = (TextView) itemView.findViewById(R.id.nameorder);
            name.setText(currentitem.getName());
            TextView value = (TextView) itemView.findViewById(R.id.valueorder);
            value.setText(currentitem.getValue());
            TextView quantity = (TextView) itemView.findViewById(R.id.quantity);
            quantity.setText(String.valueOf(currentitem.getQuantity()));
            return itemView;
        }
    }


    public void Back(View view) {
        Intent returnintent = new Intent();
        returnintent.putParcelableArrayListExtra("result", myListOrder);
        setResult(Activity.RESULT_OK, returnintent);
        finish();
        return;
    }

    public void Order(View view) {
        if (myListOrder.size() == 0) {
            return;
        }
        String[] arrID = new String[myListOrder.size()];
        String[] arrquantity = new String[myListOrder.size()];
        orderParameters ="";
        for (int i = 0; i < myListOrder.size(); i++) {
            arrID[i] = myListOrder.get(i).getId();
            arrquantity[i] = String.valueOf(myListOrder.get(i).getQuantity());
            orderParameters += "id%5B" + String.valueOf(i) + "%5D=" + arrID[i] + "&";
        }
        for(int j = 0; j < myListOrder.size(); j++) {
            orderParameters += "sl%5B" + String.valueOf(j) + "%5D=" + arrquantity[j] + "&";
        }
        orderParameters = orderParameters.substring(0,orderParameters.length() - 1) + "&token=" + token;
        new CoffeeOrder().execute();

        return;
    }


    class CoffeeOrder extends AsyncTask<Void, Void, Void> {
        ProgressDialog dlg;

        @Override
        protected Void doInBackground(Void... params) {
            try {
                Reader rd = API.getData("http://hungphongbk.tmp-technology.com/takecoffee/public/order", orderParameters); // (link , parameters
                stt = new GsonBuilder().create().fromJson(rd,StatusCF.class);
            }
            catch (IOException e) {
                e.printStackTrace();
            }
            return null;
        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            dlg = new ProgressDialog(ListOrder.this);
            dlg.setCancelable(false);
            dlg.setMessage("Ordering...");
            dlg.show();
        }

        @Override
        protected void onPostExecute(Void aVoid) {
            super.onPostExecute(aVoid);
            dlg.dismiss();
            if (stt== null) {
                AlertDialog err = new AlertDialog.Builder(ListOrder.this).create();
                err.setTitle("ERROR");
                err.setMessage("Network error expected!");
                err.setButton(DialogInterface.BUTTON_NEUTRAL, "Close", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        dialog.dismiss();

                    }
                });
                err.show();

            }
            else {
                String str = stt.getStatusCF();
                if (str.equals("OK")) {
                    AlertDialog succ = new AlertDialog.Builder(ListOrder.this).create();
                    succ.setTitle("Coffee Order");
                    succ.setMessage("Order Successfully.");
                    succ.setButton(DialogInterface.BUTTON_NEUTRAL, "Close", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            dialog.dismiss();
                            myListOrder.clear();
                            adapterOrder.notifyDataSetChanged();
                            Intent returnintent = new Intent();
                            returnintent.putParcelableArrayListExtra("result", myListOrder);
                            setResult(Activity.RESULT_OK, returnintent);
                            finish();
                        }
                    });
                    succ.show();
                }
                else {
                    AlertDialog err = new AlertDialog.Builder(ListOrder.this).create();
                    err.setTitle("ERROR");
                    err.setMessage("Unknown Error !");
                    err.setButton(DialogInterface.BUTTON_NEUTRAL, "Close", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            dialog.dismiss();
                            finish();
                        }
                    });
                    err.show();
                }
            }
        }
    }
}