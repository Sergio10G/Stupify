package com.example.stupify_client;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;

import com.example.stupify_client.model.FirebaseDAO;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.database.FirebaseDatabase;

public class MainActivity extends AppCompatActivity {

    private FirebaseAuth auth = null;
    private FirebaseDAO fbDAO;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }

    @Override
    protected void onStart() {
        super.onStart();

        auth = FirebaseAuth.getInstance();
        fbDAO = FirebaseDAO.getInstance();

        if (auth != null && fbDAO.isDbConnected()) {
            Intent loginAct = new Intent(getApplicationContext(), LoginActivity.class);
            startActivity(loginAct);
        }
        else {
            Intent errorAct =  new Intent(getApplicationContext(), ErrorActivity.class);
            errorAct.putExtra("ErrorMsg", "No se ha podido conectar con Firebase.");
            startActivity(errorAct);
        }
    }
}