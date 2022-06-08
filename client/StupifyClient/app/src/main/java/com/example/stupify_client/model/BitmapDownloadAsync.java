package com.example.stupify_client.model;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;

import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;

public class BitmapDownloadAsync extends AsyncTask<String, Integer, String> {
    private BitmapDownloadCallback delegate;
    private String serverIP;
    private ArrayList<Song> songList;
    private HashMap<Integer, Bitmap> bitmaps;
    private boolean hadAnError;
    private String errorMsg;

    public BitmapDownloadAsync(BitmapDownloadCallback delegate, String serverIP, ArrayList<Song> songList) {
        this.delegate = delegate;
        this.serverIP = serverIP;
        this.songList = songList;
        bitmaps = new HashMap<>();
        hadAnError = false;
        errorMsg = "";
    }

    @Override
    protected String doInBackground(String... strings) {
        if (delegate == null || (serverIP == null || serverIP.equals("")) ||
                (songList == null || songList.size() == 0)) {
            hadAnError = true;
            errorMsg = "Received some null parameters:\n" +
                    "  delegate: " + (delegate == null ? "null" : "non null") + "\n" +
                    "  serverIP: " + (serverIP == null || serverIP.equals("") ? "null" : "non null") + "\n" +
                    "  songList: " + (songList == null || songList.size() == 0 ? "null" : "non null") +
                    ".";
            return null;
        }
        try {
            for (Song song : songList) {
                String imgUrl = "http://" + serverIP + "/admin/img/" + song.getPhoto();
                HttpURLConnection connection = (HttpURLConnection) new URL(imgUrl).openConnection();
                connection.connect();
                InputStream is = connection.getInputStream();
                Bitmap bmp = BitmapFactory.decodeStream(is);
                bitmaps.put(song.getId(), bmp);
            }
        }
        catch (Exception e) {
            hadAnError = true;
            errorMsg = e.getMessage();
        }
        return null;
    }

    @Override
    protected void onPostExecute(String s) {
        super.onPostExecute(s);
        if (hadAnError) {
            delegate.processFailed(errorMsg);
        }
        else {
            delegate.processFinished(bitmaps);
        }
    }
}
