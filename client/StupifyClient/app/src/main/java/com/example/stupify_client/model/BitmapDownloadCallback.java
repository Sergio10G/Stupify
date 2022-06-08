package com.example.stupify_client.model;

import android.graphics.Bitmap;

import java.util.HashMap;

public interface BitmapDownloadCallback {
    void processFinished(HashMap<Integer, Bitmap> bitmaps);
    void processFailed(String errorMsg);
}
