package phat.coffeeapp;

import com.google.gson.annotations.SerializedName;

public class StatusCF {
    @SerializedName("status")
    private String status;

    public void setStatusCF(String status) {
        this.status = status;
    }

    public String getStatusCF() {
        return status;
    }
}
