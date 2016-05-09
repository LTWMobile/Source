package phat.coffeeapp;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Phat on 14/11/2015.
 */
public class CoffeeInfo {

    @SerializedName("name")
    private String name;
    @SerializedName("address")
    private  String address;
    @SerializedName("phonenumber")
    private  String phonenum;
    @SerializedName("token")
    private String token;
    @SerializedName("thumbnail")
    private String thumbnail;
    @SerializedName("menu")
    private List<CoffeeItem> coffeeItems=new ArrayList<>();

    public String getName() {
        return name;
    }

    public  String getAddress(){
        return address;
    }

    public void setName(String name) {
        this.name = name;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getToken() {
        return token;
    }

    public void setToken(String token) {
        this.token = token;
    }

    public String getThumbnail() {
        return thumbnail;
    }

    public void setThumbnail(String thumbnail) {
        this.thumbnail = thumbnail;
    }

    public List<CoffeeItem> getCoffeeInfo() {
        return coffeeItems;
    }

    public void setCoffeeInfo(List<CoffeeItem> coffeeItems) {
        this.coffeeItems = coffeeItems;
    }

}
