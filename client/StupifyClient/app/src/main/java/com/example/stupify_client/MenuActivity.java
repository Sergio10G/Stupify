package com.example.stupify_client;

import android.content.Intent;
import android.os.Bundle;
import android.util.TypedValue;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.FragmentContainerView;
import androidx.fragment.app.FragmentManager;

import com.example.stupify_client.fragments.CategoryList;
import com.example.stupify_client.fragments.SongList;
import com.example.stupify_client.model.Category;
import com.example.stupify_client.model.FirebaseDAO;
import com.example.stupify_client.model.Metadata;
import com.example.stupify_client.model.Song;
import com.google.android.exoplayer2.MediaMetadata;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;

import java.util.ArrayList;

public class MenuActivity extends AppCompatActivity {

    private FirebaseDAO fbDAO;
    private FirebaseUser user = null;

    private TextView lblUser;
    private FragmentContainerView fcv;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);

        lblUser = findViewById(R.id.lblUser);
        fcv = findViewById(R.id.fragmentContainerView);

        user = getIntent().getParcelableExtra("User");
        fbDAO = FirebaseDAO.getInstance();

        if (user == null) {
            redirectToErrorActivity("Ha habido un error con el usuario. Cierre la aplicación y vuelva a abrirla.");
        }

        String name = "User";
        if (user.getEmail() != null) {
            name = extractNameFromEmail(user.getEmail());
        }

        lblUser.setText(name);
        lblUser.setTextSize(TypedValue.COMPLEX_UNIT_SP, 20.0f * (10.0f / (float) name.length()));

        FragmentManager fm = getSupportFragmentManager();
        ArrayList<Category> categories = fbDAO.getCategories();

        fm.beginTransaction().replace(R.id.fragmentContainerView, CategoryList.newInstance(categories))
                .commit();
    }

    @Override
    protected void onResume() {
        super.onResume();

        if (user == null) {
            redirectToErrorActivity("Ha habido un error con el usuario. Cierre la aplicación y vuelva a abrirla.");
        }
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        FirebaseAuth.getInstance().signOut();
    }

    private void redirectToErrorActivity(String msg) {
        Intent errorAct =  new Intent(getApplicationContext(), ErrorActivity.class);
        errorAct.putExtra("ErrorMsg", msg);
        startActivity(errorAct);
    }

    private String extractNameFromEmail(String email) {
        return email.substring(0, email.indexOf("@"));
    }

    public void showSongsFragment(int catId) {
        Category category = fbDAO.getCategoryById(catId);
        ArrayList<Song> songList = fbDAO.getSongsByCategory(catId);

        FragmentManager fm = getSupportFragmentManager();
        fm.beginTransaction().replace(R.id.fragmentContainerView, SongList.newInstance(category.getCategory(), category.getId(), songList))
                .addToBackStack(null)
                .commit();
    }

    public void launchPlayer(int songId, int catId) {
        Metadata md = fbDAO.getMetadata();
        Intent playerIntent = new Intent(getApplicationContext(), PlayerActivity.class);
        playerIntent.putExtra("serverIP", md.getServerIP());
        playerIntent.putExtra("songId", songId);
        playerIntent.putExtra("catId", catId);
        startActivity(playerIntent);
    }
}