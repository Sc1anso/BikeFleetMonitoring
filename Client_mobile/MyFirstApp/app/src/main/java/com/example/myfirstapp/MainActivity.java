package com.example.myfirstapp;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.app.NotificationCompat;
import androidx.core.app.NotificationManagerCompat;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.app.NotificationChannel;
import android.app.NotificationManager;
import android.content.Context;
import android.content.DialogInterface;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.webkit.JavascriptInterface;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.maps.model.LatLng;
import com.google.maps.android.data.geojson.GeoJsonPoint;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class MainActivity extends AppCompatActivity implements LocationListener {
    /**COSTANTE EXTRA MESSAGE, buona pratica inserire come prefisso il nome del pacchetto onde evitare conflitti con altre app*/
    public static final String com_example_myfirstapp_EXTRA_MESSAGE = "com.example.myfirstapp.MESSAGE";
    private WebView webView;
    private LocationManager locationManager;
    public double latitude, longitude;
    public GeoJsonPoint point;
    public String bike_rented, path, rack, is_new_rent;
    public String url_prefix = "https://2a1f-82-49-10-83.ngrok.io/prog_context";
    public boolean inForbidden = false, inPoi = false;
    public String rent_num, end_rack, old_rack = "";
    AlertDialog.Builder builder_aux;
    AlertDialog dialog_aux;
    public Long first_ts;
    public Long second_ts;
    //public String url_prefix = "http://192.168.64.2/prog_context";
    String GROUP_KEY_WORK_EMAIL = "com.android.example.WORK_EMAIL";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        webView = (WebView) findViewById(R.id.webView);
        WebSettings webSettings = webView.getSettings();

        webSettings.setAllowFileAccessFromFileURLs(true);
        webSettings.setAllowUniversalAccessFromFileURLs(true);
        webSettings.setAllowFileAccess(true);
        webSettings.setJavaScriptCanOpenWindowsAutomatically(true);
        webSettings.setDomStorageEnabled(true);
        webSettings.setJavaScriptEnabled(true);

        webView.addJavascriptInterface(new WebAppInterface(this), "Android");

        webView.setWebViewClient(new WebViewClient());

        webView.clearCache(true);
        //webView.loadUrl("http://10.0.2.2/php/bozza.html");
        webView.loadUrl(url_prefix + "/login.html");

        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            NotificationChannel channel = new NotificationChannel("MyNotification", "My Notify", NotificationManager.IMPORTANCE_DEFAULT);
            NotificationChannel channel1 = new NotificationChannel("MyNotification1", "My Notify", NotificationManager.IMPORTANCE_DEFAULT);
            NotificationChannel channel2 = new NotificationChannel("MyNotification2", "My Notify", NotificationManager.IMPORTANCE_DEFAULT);
            NotificationChannel channel3 = new NotificationChannel("MyNotification3", "My Notify", NotificationManager.IMPORTANCE_DEFAULT);
            NotificationChannel channel4 = new NotificationChannel("MyNotification4", "My Notify", NotificationManager.IMPORTANCE_DEFAULT);
            NotificationChannel channel5 = new NotificationChannel("MyNotification5", "My Notify", NotificationManager.IMPORTANCE_DEFAULT);
            NotificationManager manager = getSystemService(NotificationManager.class);
            manager.createNotificationChannel(channel);
            manager.createNotificationChannel(channel1);
            manager.createNotificationChannel(channel2);
            manager.createNotificationChannel(channel3);
            manager.createNotificationChannel(channel4);
            manager.createNotificationChannel(channel5);
        }
        builder_aux = new AlertDialog.Builder(MainActivity.this);
        dialog_aux = builder_aux.create();
        //storePosition(1,1, null);

        /*if (ContextCompat.checkSelfPermission(MainActivity.this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED &&
                ContextCompat.checkSelfPermission(MainActivity.this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(MainActivity.this, new String[]{Manifest.permission.ACCESS_COARSE_LOCATION, Manifest.permission.ACCESS_FINE_LOCATION}, 1);
        }*/



    }

    public void startTracking(String bike, String start_rack){
        locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
        path = "LINESTRING(";
        is_new_rent = "true";
        //myLocationManager lm = new myLocationManager();

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 100);
        }
        bike_rented = bike;
        rack = start_rack;

        RequestQueue q;
        String u = url_prefix + "/php/update_bike_lst.php";
        StringRequest stringReq = new StringRequest(Request.Method.POST, u,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {

                    }
                },
                error -> System.out.println("ERROR IN UPDATE START RACK")){
            @Override
            protected Map<String, String> getParams(){
                Map<String, String> params = new HashMap<>();
                //params.put("lat", String.valueOf(latitude));
                //params.put("lon", String.valueOf(longitude));
                //params.put("point", point.toString());
                params.put("bike", bike_rented);
                //params.put("path", path);
                params.put("rack", rack);
                //params.put("newrent", is_new_rent);
                return params;
            }
        };
        q = Volley.newRequestQueue(getApplicationContext());
        q.add(stringReq);
        locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 1000, 4, this);
        //locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
        //System.out.println("POINT: " + lm.getPoint());
    }

    public void stopTracking(){
        locationManager.removeUpdates(this);
    }

    public void storePosition(double latitude, double longitude, GeoJsonPoint p){
        //conn.connection();
    }

    @Override
    public void onBackPressed() {
        if (webView.canGoBack()) {
            webView.goBack();
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public void onLocationChanged(Location location) {

        latitude = location.getLatitude();
        longitude = location.getLongitude();
        point = new GeoJsonPoint(new LatLng(location.getLatitude(), location.getLongitude()));
        path = path.replace(")", "");
        path += ", " + longitude + " " + latitude;
        path = path.replace("(,", "(");
        path += ")";
        first_ts = System.currentTimeMillis();

        RequestQueue queue;
        String url = url_prefix + "/php/updateLocation.php";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        boolean oldInForb, oldInPoi;
                        oldInForb = inForbidden;
                        oldInPoi = inPoi;
                        JSONObject json_res;
                        String in_geo = "null", rent_id, geo_t = "null", geo_n = "null";
                        try {
                            json_res = new JSONObject(response);
                            in_geo = json_res.getString("inGeo");
                            rent_id = json_res.getString("rentId");
                            geo_n = json_res.getString("geoName");
                            geo_t = json_res.getString("geoType");
                            rent_num = rent_id;
                        } catch (JSONException e) {
                            System.out.println("SOMETHING WRONG HAPPEND IN JSON CONVERSION OF FIRST RESPONSE");
                            Toast.makeText(MainActivity.this, response, Toast.LENGTH_SHORT).show();
                        }
                        //Toast.makeText(MainActivity.this, "GPS timestamp (ms): " + first_ts.toString(), Toast.LENGTH_SHORT).show();
                        second_ts = System.currentTimeMillis();
                        Long diff_ts = second_ts - first_ts;
                        if (geo_t.equals("forb")){
                            inForbidden = true;
                            if (inForbidden != oldInForb){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification");
                                builder.setContentTitle("Entering in a forbbidden area");
                                String mytext = "You are in a forbidden area for ride a bike, area name: " + geo_n + "\n" +
                                        "Notify performance evaluation (ms): " + diff_ts.toString();
                                builder.setContentText(mytext);
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);
                                builder.setStyle(new NotificationCompat.BigTextStyle()
                                        .bigText(mytext));
                                //builder.setGroup(GROUP_KEY_WORK_EMAIL);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(1, builder.build());
                            }
                        }
                        if (geo_t.equals("poi")){
                            inPoi = true;
                            if (inPoi != oldInPoi){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification1");
                                builder.setContentTitle("Entering in a Point Of Interest area");
                                String mytext = "In this area there is a good point of interest, POI name: " + geo_n + "\n" +
                                        "Notify performance evaluation (ms): " + diff_ts.toString();
                                builder.setContentText(mytext);
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);
                                builder.setStyle(new NotificationCompat.BigTextStyle()
                                        .bigText(mytext));
                                //builder.setGroup(GROUP_KEY_WORK_EMAIL);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(2, builder.build());
                            }
                        }
                        if (in_geo.equals("false")){
                            inForbidden = false;
                            inPoi = false;
                            if (inForbidden != oldInForb){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification2");
                                builder.setContentTitle("Leaving a forbidden area");
                                builder.setContentText("You are not anymore in a forbidden area" + "\n" +
                                        "Notify performance evaluation (ms): " + diff_ts.toString());
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);
                                builder.setStyle(new NotificationCompat.BigTextStyle()
                                        .bigText("You are not anymore in a forbidden area" + "\n" +
                                                "Notify performance evaluation (ms): " + diff_ts.toString()));
                                //builder.setGroup(GROUP_KEY_WORK_EMAIL);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(3, builder.build());
                            }
                            if (inPoi != oldInPoi){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification3");
                                builder.setContentTitle("Leaving a Point Of Interest area");
                                builder.setContentText("You are not anymore in a POI area" + "\n" +
                                        "Notify performance evaluation (ms): " + diff_ts.toString());
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);
                                builder.setStyle(new NotificationCompat.BigTextStyle()
                                        .bigText("You are not anymore in a POI area" + "\n" +
                                                "Notify performance evaluation (ms): " + diff_ts.toString()));
                                //builder.setGroup(GROUP_KEY_WORK_EMAIL);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(4, builder.build());
                            }
                        }
                        if (geo_t.equals("both")){
                            inForbidden = true;
                            inPoi = true;
                            String[] names = geo_n.split("--");
                            if (inForbidden != oldInForb) {
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification4");
                                builder.setContentTitle("Entering in a forbbidden area");
                                builder.setContentText("You are in a forbidden area for ride a bike, area name: " + names[0] + "\n" +
                                        "Notify performance evaluation (ms): " + diff_ts.toString());
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);
                                builder.setStyle(new NotificationCompat.BigTextStyle()
                                        .bigText("You are in a forbidden area for ride a bike, area name: " + names[0] + "\n" +
                                                "Notify performance evaluation (ms): " + diff_ts.toString()));
                                //builder.setGroup(GROUP_KEY_WORK_EMAIL);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(5, builder.build());
                            }
                            if (inPoi != oldInPoi){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification5");
                                builder.setContentTitle("Entering in a Point Of Interest area");
                                builder.setContentText("In this area there is a good point of interest, POI name: " + names[1] + "\n" +
                                        "Notify performance evaluation (ms): " + diff_ts.toString());
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);
                                builder.setStyle(new NotificationCompat.BigTextStyle()
                                        .bigText("In this area there is a good point of interest, POI name: " + names[1] + "\n" +
                                                "Notify performance evaluation (ms): " + diff_ts.toString()));
                                //builder.setGroup(GROUP_KEY_WORK_EMAIL);



                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(6, builder.build());
                            }
                        }
                        //System.out.println(response);
                        //Toast.makeText(MainActivity.this, response, Toast.LENGTH_SHORT).show();
                    }
                },
                error -> Toast.makeText(getApplicationContext(), "Error (updateLoc)", Toast.LENGTH_SHORT).show()){
            @Override
            protected Map<String, String> getParams(){
                Map<String, String> params = new HashMap<>();
                params.put("lat", String.valueOf(latitude));
                params.put("lon", String.valueOf(longitude));
                params.put("point", point.toString());
                params.put("bike", bike_rented);
                params.put("path", path);
                params.put("srack", rack);
                params.put("newrent", is_new_rent);
                is_new_rent = "false";
                return params;
            }
        };
        queue = Volley.newRequestQueue(getApplicationContext());
        queue.add(stringRequest);

        String url_check_endrent = url_prefix + "/php/check_endrack.php";
        StringRequest stringRequest_check_end = new StringRequest(Request.Method.POST, url_check_endrent,
                new Response.Listener<String>() {
                    @SuppressLint("SetTextI18n")
                    @Override
                    public void onResponse(String response){
                        /*if (response.equals("[]")){
                            Toast.makeText(MainActivity.this, "ciao", Toast.LENGTH_LONG).show();
                        }*/
                        //Toast.makeText(MainActivity.this, response, Toast.LENGTH_SHORT).show();
                        try {
                            JSONObject res = new JSONObject(response);
                            //Toast.makeText(MainActivity.this, res.getString("name"), Toast.LENGTH_SHORT).show();
                            System.out.println("JSONRES: " + res.getString("name"));
                            // 1. Instantiate an <code><a href="/reference/android/app/AlertDialog.Builder.html">AlertDialog.Builder</a></code> with its constructor
                            AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);

                            // 2. Chain together various setter methods to set the dialog characteristics
                            builder.setMessage("Rack name: " + res.getString("name") + "\n" +
                                    "Rack id: " + res.getString("id") + "\n" +
                                    "Rack distance: " + res.getString("st_distance"))
                                    .setTitle("You are near rack, do you want to end the rental?");

                            end_rack = res.getString("id");

                            builder.setPositiveButton("End rental", new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int id) {
                                    // User clicked OK button
                                    stopTracking();
                                    String url_endrent = url_prefix + "/php/check_end.php";
                                    StringRequest stringRequest_end = new StringRequest(Request.Method.POST, url_endrent,
                                            new Response.Listener<String>() {
                                                @Override
                                                public void onResponse(String response) {
                                                    Toast.makeText(MainActivity.this, response, Toast.LENGTH_LONG).show();
                                                    System.out.println(response);
                                                }
                                            },
                                            error -> System.out.println("ERRORE END RENT@@@@@@@@@@@@@@@@@@@")){
                                        @Override
                                        protected Map<String, String> getParams(){
                                            Map<String, String> params = new HashMap<>();
                                            params.put("bike", bike_rented);
                                            params.put("erack", end_rack);
                                            params.put("rentn", rent_num);
                                            return params;
                                        }
                                    };
                                    queue.add(stringRequest_end);
                                }
                            });
                            builder.setNegativeButton("Continue rental", new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int id) {
                                    // User cancelled the dialog
                                    dialog = null;
                                }
                            });

                            if (!old_rack.equals(res.getString("name")) && !res.getString("name").equals("null")){
                                // 3. Get the <code><a href="/reference/android/app/AlertDialog.html">AlertDialog</a></code> from <code><a href="/reference/android/app/AlertDialog.Builder.html#create()">create()</a></code>
                                AlertDialog dialog = builder.create();
                                dialog_aux = dialog;
                                dialog.show();
                                /*Runnable dismissRunner = new Runnable() {
                                    public void run() {
                                        if( dialog != null )
                                            dialog.dismiss();
                                    }
                                };
                                new Handler().postDelayed(dismissRunner, 2000 );*/
                            }

                            if (!old_rack.equals(res.getString("name")) && res.getString("name").equals("null")){

                                dialog_aux.dismiss();
                            }

                            old_rack = res.getString("name");

                        } catch (JSONException ignored) {
                        }
                        //Toast.makeText(getApplicationContext(), response, Toast.LENGTH_SHORT).show();
                    }
                },
                error -> System.out.println("ERRORE SECONDA RICHIESTA")){
            @Override
            protected Map<String, String> getParams(){
                Map<String, String> params = new HashMap<>();
                params.put("point", "POINT(" + longitude + " " + latitude + ")");
                params.put("bike", bike_rented);
                params.put("srack", rack);
                return params;
            }
        };
        queue.add(stringRequest_check_end);
        //webView.evaluateJavascript("checkForEndRent( POINT(" + longitude + " " + latitude + "), " + bike_rented + ", " + rack + ")", null);

    }

    @Override
    public void onStatusChanged(String s, int i, Bundle bundle) {

    }

    @Override
    public void onProviderEnabled(String s) {

    }

    @Override
    public void onProviderDisabled(String s) {

    }

    public class WebAppInterface{
        Context mContext;

        /** Instantiate the interface and set the context */
        WebAppInterface(Context c) {
            mContext = c;
        }

        /** Show a toast from the web page */
        @JavascriptInterface
        public void showToast(String toast) {
            Toast.makeText(mContext, toast, Toast.LENGTH_SHORT).show();
        }

        @JavascriptInterface
        public void doLogIn() {
            webView = (WebView) findViewById(R.id.webView);
            //webView.loadUrl("http://10.0.2.2/php/bozza.html");

        }

        @JavascriptInterface
        public void sendNotification(String unlock_token, String bike_id) {
            NotificationCompat.Builder builder = new NotificationCompat.Builder(mContext, "MyNotification");
            builder.setContentTitle("Unlock code to rent bike number: " + bike_id);
            builder.setContentText("Code: " + unlock_token);
            builder.setSmallIcon(R.drawable.ic_launcher_background);
            builder.setAutoCancel(true);

            NotificationManagerCompat managerCompat = NotificationManagerCompat.from(mContext);
            managerCompat.notify(1, builder.build());
        }

        @JavascriptInterface
        public void getPosition(String bike, String rack) {
            /*Intent locservIntent = new Intent(getApplicationContext(), LocationService.class);
            locservIntent.putExtra("bike", bike);
            locservIntent.putExtra("rack", rack);
            locservIntent.putExtra("ctx", (Parcelable) MainActivity.this);
            startService(locservIntent);*/
            startTracking(bike, rack);
        }

        @JavascriptInterface
        public void stopRent(){
            /*Intent stoplocservIntent = new Intent(getApplicationContext(), LocationService.class);
            stopService(stoplocservIntent);*/
            stopTracking();
        }
    }

}