package phat.coffeeapp;

import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.Reader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by Phat on 14/11/2015.
 */
public class API {
    private static Reader reader=null;
    public static Reader getData(String urlString, String contents) throws IOException {
        //InputStream is=null;
        URL url=new URL(urlString);
        HttpURLConnection conn=(HttpURLConnection) url.openConnection();
        conn.setRequestMethod("POST");
        String urlParameters = contents;
        conn.setDoOutput(true);
        DataOutputStream wr = new DataOutputStream(conn.getOutputStream());
        wr.writeBytes(urlParameters);
        wr.flush();
        wr.close();
        conn.connect();
        int responseCode = conn.getResponseCode();
        if(responseCode == 200) {
            reader = new InputStreamReader(conn.getInputStream());
        }

        return reader;
    }
}
