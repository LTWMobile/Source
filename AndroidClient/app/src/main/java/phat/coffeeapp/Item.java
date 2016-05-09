package phat.coffeeapp;

import android.graphics.Bitmap;
import android.os.Parcel;
import android.os.Parcelable;
import android.util.Log;

/**
 * Created by Phat on 13/10/2015.
 */
public class Item implements Parcelable{
    public String name;
    public String value;
    public String id;
    public Bitmap icon;
    public int quantity;

    public String getId() {
        return id;
    }

    public Item(String name, String value, String id, Bitmap icon, int quantity) {
        this.name = name;
        this.value = value;
        this.id = id;
        this.icon = icon;
        this.quantity = quantity;

    }

    public Item(Parcel source) {
        Log.v("TAG", "ParcelData(Parcel source): time to put back parcel data");
        icon = source.readParcelable(Bitmap.class.getClassLoader());
        name = source.readString();
        value = source.readString();
        quantity = source.readInt();
        id = source.readString();
        //source.readStringArray(String[]);
    }

    public static final Parcelable.Creator<Item> CREATOR = new Parcelable.Creator<Item>() {
        @Override
        public Item createFromParcel(Parcel in) {
            return new Item(in);
        }

        @Override
        public Item[] newArray(int size) {
            return new Item[size];
        }
    };

    public String getName() {
        return name;
    }

    public String getValue() {
        return value;
    }

    public Bitmap getIcon() {
        return icon;
    }

    public int getQuantity() {
        return quantity;
    }

    @Override
    public int describeContents() {
        return this.hashCode();
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        //Log.v("TAG", "writeToParcel..." + flags);
        dest.writeValue(icon);
        dest.writeString(name);
        dest.writeString(value);
        dest.writeInt(quantity);
        dest.writeString(id);
    }

    /*public class CREATOR implements Parcelable.Creator<Item> {
        public Item createFromParcel(Parcel source) {
            return new Item(source);
        }
        public Item[] newArray(int size) {
            return new Item[size];
        }
    }*/
}

