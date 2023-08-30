package com.example.myfirstapp;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.Service;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Build;
import android.os.Bundle;
import android.os.IBinder;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.maps.model.LatLng;
import com.google.maps.android.data.geojson.GeoJsonPoint;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import androidx.annotation.Nullable;
import androidx.annotation.RequiresApi;
import androidx.core.app.ActivityCompat;
import androidx.core.app.NotificationCompat;
import androidx.core.app.NotificationManagerCompat;

public class LocationService extends Service implements LocationListener {
    private LocationManager locationManager;
    public double latitude, longitude;
    public GeoJsonPoint point;
    public String bike_rented, path, rack, is_new_rent;
    public String url_prefix = "https://9c49-31-156-175-204.ngrok.io";
    public boolean inForbidden, inPoi = false;
    public Dialog dialog;
    public Context ctx;


    @RequiresApi(api = Build.VERSION_CODES.Q)

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        locationManager = (LocationManager) getApplicationContext().getSystemService(Context.LOCATION_SERVICE);
        path = "LINESTRING(";
        is_new_rent = "true";
        //myLocationManager lm = new myLocationManager();

        if (ActivityCompat.checkSelfPermission(getApplicationContext(), Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(getApplicationContext(), Manifest.permission.ACCESS_BACKGROUND_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions((Activity) getApplicationContext(), new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 100);
            ActivityCompat.requestPermissions((Activity) getApplicationContext(), new String[]{Manifest.permission.ACCESS_BACKGROUND_LOCATION}, 100);
        }
        bike_rented = intent.getStringExtra("bike");
        rack = intent.getStringExtra("rack");
        ctx = (Context) intent.getParcelableExtra("ctx");
        locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 5000, 0, this);
        return START_STICKY;
    }

    @Override
    public void onDestroy() {
        locationManager.removeUpdates(this);
    }

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
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

        System.out.println("ZIOPERAAAAAAAAAAAAAA");
        //locationManager.removeUpdates(this);
        //System.out.println("PUNTO: " + point.toString());
        //Toast.makeText(MainActivity.this, path, Toast.LENGTH_SHORT).show();

        RequestQueue queue;
        String url = url_prefix + "/php/updateLocation.php";
        StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        boolean oldInForb, oldInPoi;
                        oldInForb = inForbidden;
                        oldInPoi = inPoi;
                        if (response.contains("-forb")){
                            inForbidden = true;
                            if (inForbidden != oldInForb){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification");
                                builder.setContentTitle("Entering in a forbbidden area");
                                builder.setContentText("You are in a forbidden area for ride a bike, area name: " + response.replace("-forb", ""));
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(1, builder.build());
                            }
                        }
                        if (response.contains("-poi")){
                            inPoi = true;
                            if (inPoi != oldInPoi){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification");
                                builder.setContentTitle("Entering in a Point Of Interest area");
                                builder.setContentText("In this area there is a good point of interest, POI name: " + response.replace("-poi", ""));
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(1, builder.build());
                            }
                        }
                        if (response.equals("false")){
                            inForbidden = false;
                            inPoi = false;
                            if (inForbidden != oldInForb){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification");
                                builder.setContentTitle("Leaving a forbidden area");
                                builder.setContentText("You are not anymore in a forbidden area");
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(1, builder.build());
                            }
                            if (inPoi != oldInPoi){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification");
                                builder.setContentTitle("Leaving a Point Of Interest area");
                                builder.setContentText("You are not anymore in a POI area");
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(1, builder.build());
                            }
                        }
                        if (response.contains("--")){
                            inForbidden = true;
                            inPoi = true;
                            String[] names = response.split("--");
                            if (inForbidden != oldInForb) {
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification");
                                builder.setContentTitle("Entering in a forbbidden area");
                                builder.setContentText("You are in a forbidden area for ride a bike, area name: " + names[0]);
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(1, builder.build());
                            }
                            if (inPoi != oldInPoi){
                                NotificationCompat.Builder builder = new NotificationCompat.Builder(getApplicationContext(), "MyNotification");
                                builder.setContentTitle("Entering in a Point Of Interest area");
                                builder.setContentText("In this area there is a good point of interest, POI name: " + names[1]);
                                builder.setSmallIcon(R.drawable.ic_launcher_background);
                                builder.setAutoCancel(true);

                                NotificationManagerCompat managerCompat = NotificationManagerCompat.from(getApplicationContext());
                                managerCompat.notify(1, builder.build());
                            }
                        }
                        //System.out.println(response);
                        //Toast.makeText(MainActivity.this, response, Toast.LENGTH_SHORT).show();
                    }
                },
                error -> Toast.makeText(getApplicationContext(), "Errore malo", Toast.LENGTH_SHORT).show()){
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

        String url_endrent = url_prefix + "/php/check_endrack.php";
        StringRequest stringRequest_end = new StringRequest(Request.Method.POST, url_endrent,
                new Response.Listener<String>() {
                    @SuppressLint("SetTextI18n")
                    @Override
                    public void onResponse(String response){
                        System.out.println("RES: " + response);
                        try {
                            JSONObject res = new JSONObject(response.replace("[", "").replace("]", ""));
                            System.out.println("JSONRES: " + res.getString("name"));

                            // 1. Instantiate an <code><a href="/reference/android/app/AlertDialog.Builder.html">AlertDialog.Builder</a></code> with its constructor
                            AlertDialog.Builder builder = new AlertDialog.Builder(ctx);

                            // 2. Chain together various setter methods to set the dialog characteristics
                            builder.setMessage("Rack name: " + res.getString("name") + "\n" +
                                    "Rack id: " + res.getString("id") + "\n" +
                                    "Rack distance: " + res.getString("st_distance"))
                                    .setTitle("You are near rack, do you want to end the rental?");

                            builder.setPositiveButton("End rental", new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int id) {
                                    // User clicked OK button
                                }
                            });
                            builder.setNegativeButton("Continue rental", new DialogInterface.OnClickListener() {
                                public void onClick(DialogInterface dialog, int id) {
                                    // User cancelled the dialog
                                }
                            });


                            // 3. Get the <code><a href="/reference/android/app/AlertDialog.html">AlertDialog</a></code> from <code><a href="/reference/android/app/AlertDialog.Builder.html#create()">create()</a></code>
                            AlertDialog dialog = builder.create();
                            dialog.show();

                            /*dialog = new Dialog(getApplication());
                            dialog.setContentView(R.layout.my_dialog);
                            //dialog.getWindow().setBackgroundDrawable(getDrawable(R.drawable.common_google_signin_btn_icon_dark_normal_background));
                            dialog.getWindow().setLayout(ViewGroup.LayoutParams.MATCH_PARENT, ViewGroup.LayoutParams.WRAP_CONTENT);
                            dialog.setCancelable(false);
                            dialog.getWindow().getAttributes().windowAnimations = R.style.amu_ClusterIcon_TextAppearance;

                            TextView r_name = dialog.findViewById(R.id.txt_name);
                            r_name.setText("Rack name: " + res.getString("name"));

                            TextView r_id = dialog.findViewById(R.id.txt_id);
                            r_id.setText("Rack id: " + res.getString("id"));

                            TextView r_dist = dialog.findViewById(R.id.txt_dist);
                            r_dist.setText("Rack distance: " + res.getString("st_distance"));

                            Button end = dialog.findViewById(R.id.button_end);
                            Button cont = dialog.findViewById(R.id.button_cont);

                            end.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    dialog.dismiss();
                                }
                            });

                            cont.setOnClickListener(new View.OnClickListener() {
                                @Override
                                public void onClick(View view) {
                                    dialog.dismiss();
                                }
                            });
                            dialog.show();*/
                        } catch (JSONException ignored) {
                        }
                        Toast.makeText(getApplicationContext(), response, Toast.LENGTH_SHORT).show();
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
        queue.add(stringRequest_end);
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
}
