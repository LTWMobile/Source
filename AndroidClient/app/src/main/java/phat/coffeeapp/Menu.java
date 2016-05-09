package phat.coffeeapp;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Bitmap;
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
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;



/**
 * Created by Phat on 13/10/2015.
 */
public class Menu extends AppCompatActivity {
    private String token;
    private String[] drinks;
    private String[] prices;
    private String[] drinkId;
    private ArrayList<Bitmap> imageBitmap = new ArrayList<Bitmap>();
    private ArrayList<Item> myList = new ArrayList<Item>();
    private ArrayAdapter<Item> adapter = null;
    private ArrayList<Item> listOrder = new ArrayList<Item>();

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setTitle("Coffee Menu");
        setContentView(R.layout.menu_activity);
        Bundle extras = getIntent().getExtras();
        if(extras != null) {
            token = extras.getString("Token");
            drinks = extras.getStringArray("Drinks");
            prices = extras.getStringArray("Prices");
            drinkId = extras.getStringArray("DrinkID");
            imageBitmap = extras.getParcelableArrayList("bitmaps");
        }

        final ListView list = (ListView) findViewById(R.id.listView);

        for(int i = 0; i < drinks.length; i++) {
            Bitmap mIcon = imageBitmap.get(i);
            myList.add(new Item(drinks[i], prices[i], drinkId[i], mIcon, 1));
        }

        adapter = new ListItem(Menu.this, R.layout.item, myList);
        list.setAdapter(adapter);

        list.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                final Item item = myList.get(position);
                final Dialog dialog = new Dialog(Menu.this);
                dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
                dialog.setContentView(R.layout.check_dialog);
                TextView name = (TextView) dialog.findViewById(R.id.coffee);
                name.setText(item.getName());
                dialog.show();
                FloatingActionButton fabok = (FloatingActionButton) dialog.findViewById(R.id.fabOK);
                final EditText add = (EditText) dialog.findViewById((R.id.add_quantity));
                add.setOnFocusChangeListener(new View.OnFocusChangeListener() {

                    @Override
                    public void onFocusChange(View v, boolean hasFocus) {
                        add.post(new Runnable() {
                            @Override
                            public void run() {
                                InputMethodManager imm = (InputMethodManager) getBaseContext().getSystemService(Context.INPUT_METHOD_SERVICE);
                                imm.showSoftInput(add, InputMethodManager.SHOW_IMPLICIT);
                            }
                        });
                    }
                });
                add.requestFocus();
                fabok.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        if (add.getText().length() > 0){
                            boolean exist = false;
                            if (listOrder.size() == 0)
                                listOrder.add(new Item(item.getName(),item.getValue(), item.getId(), null, Integer.parseInt(add.getText().toString())));
                            else {
                                for (int i = 0; i < listOrder.size(); i++) {
                                    if (item.getName().equals(listOrder.get(i).getName())) {
                                        listOrder.get(i).quantity += Integer.parseInt(add.getText().toString());
                                        exist = true;
                                        break;
                                    }
                                }
                                if (!exist)
                                    listOrder.add(new Item(item.getName(), item.getValue(),item.getId(), null, Integer.parseInt(add.getText().toString())));
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
                LayoutInflater inflater = (LayoutInflater) Menu.this.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                itemView = inflater.inflate(R.layout.item, parent, false);
            }
            Item currentitem = myList.get(position);
            ImageView image = (ImageView) itemView.findViewById(R.id.icon);
            image.setImageBitmap(currentitem.getIcon());
            TextView name = (TextView) itemView.findViewById(R.id.name);
            name.setText(currentitem.getName());
            TextView value = (TextView) itemView.findViewById(R.id.value);
            value.setText(currentitem.getValue());
            return itemView;
        }
    }

    public void ListOrder(View view){
        Intent intent = new Intent(getApplicationContext(), ListOrder.class);
        intent.putParcelableArrayListExtra("key", listOrder);
        intent.putExtra("Token",token);
        this.startActivityForResult(intent, 1);

    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == 1) {
            if(resultCode == Activity.RESULT_OK){
                listOrder = data.getParcelableArrayListExtra("result");
            }
            if (resultCode == Activity.RESULT_CANCELED) {
                //Write your code if there's no result
            }
        }
    }

}
