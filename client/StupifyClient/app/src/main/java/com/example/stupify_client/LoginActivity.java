package com.example.stupify_client;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.FirebaseDatabase;

public class LoginActivity extends AppCompatActivity {

    private FirebaseAuth auth = null;

    private EditText txtEmail;
    private EditText txtPassword;
    private Button btnLogin;
    private Button btnRegister;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        txtEmail = findViewById(R.id.txtEmail);
        txtPassword = findViewById(R.id.txtPassword);
        btnLogin = findViewById(R.id.btnLogin);
        btnRegister = findViewById(R.id.btnRegister);

        // Registering is disabled for the time being
        btnRegister.setEnabled(false);

        btnLogin.setOnClickListener(view -> {
            String email, password;
            email = txtEmail.getText().toString();
            password = txtPassword.getText().toString();
            fbUserLogin(email, password);
        });

        btnRegister.setOnClickListener(view -> {
            String email, password;
            email = txtEmail.getText().toString();
            password = txtPassword.getText().toString();
            fbUserRegister(email, password);
        });
    }

    @Override
    protected void onResume() {
        super.onResume();

        auth = FirebaseAuth.getInstance();

        if (auth == null) {
            Intent errorAct =  new Intent(getApplicationContext(), ErrorActivity.class);
            errorAct.putExtra("ErrorMsg", "No se ha podido conectar con Firebase.");
            startActivity(errorAct);
        }
    }

    private boolean validateEmail(String email) {
        String regex = "(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:["
                     + "\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21\\x23-\\x5b\\x5d-\\x7f]|\\\\[\\x01-"
                     + "\\x09\\x0b\\x0c\\x0e-\\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)"
                     + "+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9"
                     + "]|[1-9]?[0-9]))\\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a"
                     + "-z0-9-]*[a-z0-9]:(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21-\\x5a\\x53-\\x7f"
                     + "]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])+)\\])";
        return email.matches(regex);
    }

    private boolean invalidInputs(String email, String password) {
        if (email == null || !validateEmail(email)) {
            Toast.makeText(getApplicationContext(), "Email invalido", Toast.LENGTH_SHORT)
                    .show();
            clearFields();
            return true;
        }
        if (password == null || password.length() < 6) {
            Toast.makeText(getApplicationContext(), "Contraseña invalida", Toast.LENGTH_SHORT)
                    .show();
            clearFields();
            return true;
        }
        return false;
    }

    private void fbUserLogin(String email, String password) {
        if (invalidInputs(email, password)) {
            return;
        }
        auth.signInWithEmailAndPassword(email, password)
                .addOnCompleteListener(this, new OnCompleteListener<AuthResult>() {
                    @Override
                    public void onComplete(@NonNull Task<AuthResult> task) {
                        if (task.isSuccessful()) {
                            FirebaseUser user = auth.getCurrentUser();
                            operationResult(user);
                        }
                        else {
                            Toast.makeText(LoginActivity.this, "Usuario incorrecto", Toast.LENGTH_SHORT)
                                    .show();
                            operationResult(null);
                        }
                    }
                });
    }

    private void fbUserRegister(String email, String password) {
        if (invalidInputs(email, password)) {
            return;
        }
        auth.createUserWithEmailAndPassword(email, password)
                .addOnCompleteListener(this, new OnCompleteListener<AuthResult>() {
                    @Override
                    public void onComplete(@NonNull Task<AuthResult> task) {
                        if (task.isSuccessful()) {
                            FirebaseUser user = auth.getCurrentUser();
                            operationResult(user);
                        }
                        else {
                            Toast.makeText(LoginActivity.this, "Error al intentar crear un nuevo usuario", Toast.LENGTH_SHORT).show();
                            operationResult(null);
                        }
                    }
                });
    }

    private void operationResult (FirebaseUser user) {
        clearFields();
        if (user != null) {
            Intent menuAct = new Intent(getApplicationContext(), MenuActivity.class);
            menuAct.putExtra("User", user);
            startActivity(menuAct);
        }
    }

    private void clearFields() {
        txtEmail.setText("");
        txtPassword.setText("");
    }
}