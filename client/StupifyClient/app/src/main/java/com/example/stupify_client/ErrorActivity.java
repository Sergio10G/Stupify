package com.example.stupify_client;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.widget.TextView;

public class ErrorActivity extends AppCompatActivity {
    TextView txtError;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_error);

        String msgError = getIntent().getStringExtra("ErrorMsg");

        if (msgError == null || msgError.equals("")) {
            msgError = "Error desconocido o mensaje de error no detectado.";
        }

        txtError = findViewById(R.id.txtError);
        txtError.setText(msgError);
    }
}