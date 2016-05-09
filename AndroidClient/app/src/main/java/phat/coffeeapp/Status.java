package phat.coffeeapp;

import com.google.gson.annotations.SerializedName;

/**
 * Created by Phat on 20/11/2015.
 */
public class Status {
    @SerializedName("status")
    private String status;

    public void setStatus(String status) {
        this.status = status;
    }

    public String getStatus() {
        return status;
    }

}
