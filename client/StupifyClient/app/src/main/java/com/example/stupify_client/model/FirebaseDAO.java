package com.example.stupify_client.model;

import android.util.Log;

import androidx.annotation.NonNull;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.List;

public class FirebaseDAO {
    private static FirebaseDAO instance;

    private static final FirebaseDatabase db = FirebaseDatabase.getInstance();
    private static final DatabaseReference categoriesRef = db.getReference("stupifyDB/categories");
    private static final DatabaseReference songCatRef = db.getReference("stupifyDB/song-cat");
    private static final DatabaseReference songsRef = db.getReference("stupifyDB/songs");
    private static final DatabaseReference metadataRef = db.getReference("stupifyDB/metadata");

    private static final ArrayList<Category> categories = new ArrayList<>();
    private static final ArrayList<SongCat> songCats = new ArrayList<>();
    private static final ArrayList<Song> songs = new ArrayList<>();
    private static Metadata metadata;

    private FirebaseDAO() {
        categoriesRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                categories.clear();
                for (DataSnapshot ds : dataSnapshot.getChildren()) {
                    Category cat = ds.getValue(Category.class);
                    categories.add(cat);
                }
                Log.d("D", "Values from categories: ");
                for (Category cat: categories) {
                    Log.d("D", cat.toString());
                }
            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {
                Log.w("W", "Failed trying to read from db (categories): ", databaseError.toException());
            }
        });

        songCatRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                songCats.clear();
                for (DataSnapshot ds : dataSnapshot.getChildren()) {
                    SongCat sc = ds.getValue(SongCat.class);
                    songCats.add(sc);
                }
                Log.d("D", "Values from song-cat: ");
                for (SongCat sc: songCats) {
                    Log.d("D", sc.toString());
                }
            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {
                Log.w("W", "Failed trying to read from db (song-cat): ", databaseError.toException());
            }
        });

        songsRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                songs.clear();
                for (DataSnapshot ds : dataSnapshot.getChildren()) {
                    Song s = ds.getValue(Song.class);
                    songs.add(s);
                }
                Log.d("D", "Values from songs: ");
                for (Song s: songs) {
                    Log.d("D", s.toString());
                }
            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {
                Log.w("W", "Failed trying to read from db (songs): ", databaseError.toException());
            }
        });

        metadataRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                metadata = dataSnapshot.getValue(Metadata.class);
                Log.d("D", "Value from metadata: " + metadata.toString());
            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {
                Log.w("W", "Failed trying to read from db (metadata): ", databaseError.toException());
            }
        });
    }

    public static FirebaseDAO getInstance() {
        if (instance == null) {
            instance = new FirebaseDAO();
        }
        return instance;
    }

    public boolean isDbConnected() {
        return db != null;
    }

    public ArrayList<Category> getCategories() {
        return categories;
    }

    public Category getCategoryById(int id) {
        for (Category cat : categories) {
            if (cat.getId() == id) {
                return cat;
            }
        }
        return null;
    }

    public ArrayList<Song> getSongs() {
        return songs;
    }

    public Song getSongById(int id) {
        for (Song s : songs) {
            if (s.getId() == id) {
                return s;
            }
        }
        return null;
    }

    public ArrayList<SongCat> getSongCats() {
        return songCats;
    }

    public Metadata getMetadata() {
        return metadata;
    }

    public ArrayList<Song> getSongsByCategory(int categoryId) {
        ArrayList<Song> songsByCat = new ArrayList<>();
        for (SongCat sc : songCats) {
            if (sc.getCatId() == categoryId) {
                songsByCat.add(getSongById(sc.getSongId()));
            }
        }
        return songsByCat;
    }

}
