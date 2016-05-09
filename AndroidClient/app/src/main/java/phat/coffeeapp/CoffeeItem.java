package phat.coffeeapp;

import com.google.gson.annotations.SerializedName;
/**
 * Created by Phat on 14/11/2015.
 */
public class CoffeeItem {

    @SerializedName("id")
    private String drinkId;
    @SerializedName("name")
    private String cfname;
    @SerializedName("price")
    private String cfprice;
    @SerializedName("quantity")
    private String quantity;
    @SerializedName("thumbnail")
    private String thumbnail;

    public String getCFName() {
        return cfname;
    }

    public void setCFName(String name) {
        this.cfname = name;
    }

    public String getCFPrice() {
        return cfprice;
    }


    public String getDrinkId() {
        return drinkId;
    }

    public void setDrinkId(String drinkId) {
        this.drinkId = drinkId;
    }

    public void setCFPrice(String price) {
        this.cfprice = price;
    }

    public void setThumbnail(String thumbnail) {
        this.thumbnail = thumbnail;
    }

    public String getThumbnail() {
        return thumbnail;
    }
}
