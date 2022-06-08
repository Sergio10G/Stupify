package com.example.stupify_client.model;

import android.graphics.Bitmap;
import android.util.Log;

import androidx.annotation.NonNull;

import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;

import java.util.ArrayList;
import java.util.HashMap;

public class FirebaseDAO {
    private static FirebaseDAO instance;

    private static final FirebaseDatabase db = FirebaseDatabase.getInstance();
    private static final DatabaseReference categoriesRef = db.getReference("stupifyDB/categories");
    private static final DatabaseReference songCatRef = db.getReference("stupifyDB/song-cat");
    private static final DatabaseReference songsRef = db.getReference("stupifyDB/songs");
    private static final DatabaseReference metadataRef = db.getReference("stupifyDB/metadata");

    private final BitmapDownloadCallback bmDownloadCallback = new BitmapDownloadCallback() {
        @Override
        public void processFinished(HashMap<Integer, Bitmap> bitmaps) {
            songPhotos.clear();
            songPhotos.putAll(bitmaps);
            Log.d("DL", "Song images downloaded");
        }

        @Override
        public void processFailed(String errorMsg) {
            Log.e("DL", "Error downloading song images: " + errorMsg);
        }
    };

    private boolean songsReady = false;
    private boolean mdReady = false;
    private boolean alreadyDownloaded = false;

    private final ArrayList<Category> categories = new ArrayList<>();
    private final ArrayList<SongCat> songCats = new ArrayList<>();
    private final ArrayList<Song> songs = new ArrayList<>();
    private final HashMap<Integer, Bitmap> songPhotos = new HashMap<>();
    private Metadata metadata;

    private FirebaseDAO() {
        categoriesRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                categories.clear();
                for (DataSnapshot ds : dataSnapshot.getChildren()) {
                    Category cat = ds.getValue(Category.class);
                    categories.add(cat);
                }
                Log.d("DB", "Categories read");
                /*
                Log.d("D", "Values from categories: ");
                for (Category cat: categories) {
                    Log.d("D", cat.toString());
                }
                */
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
                Log.d("DB", "SongCats read");
                /*
                Log.d("D", "Values from song-cat: ");
                for (SongCat sc: songCats) {
                    Log.d("D", sc.toString());
                }
                */
            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {
                Log.w("W", "Failed trying to read from db (song-cat): ", databaseError.toException());
            }
        });

        songsRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                songsReady = false;
                alreadyDownloaded = false;
                songs.clear();
                for (DataSnapshot ds : dataSnapshot.getChildren()) {
                    Song s = ds.getValue(Song.class);
                    songs.add(s);
                }
                Log.d("DB", "Songs read");
                /*
                Log.d("D", "Values from songs: ");
                for (Song s: songs) {
                    Log.d("D", s.toString());
                }
                */
                songsReady = true;
                downloadBmIfReady();
            }

            @Override
            public void onCancelled(@NonNull DatabaseError databaseError) {
                Log.w("W", "Failed trying to read from db (songs): ", databaseError.toException());
            }
        });

        metadataRef.addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(@NonNull DataSnapshot dataSnapshot) {
                mdReady = false;
                alreadyDownloaded = false;
                metadata = dataSnapshot.getValue(Metadata.class);
                Log.d("DB", "Metadata read");
                if (metadata.getServerIP().equals("127.0.0.1")) {
                    metadata.setServerIP("10.0.2.2");
                }
                // Log.d("D", "Value from metadata: " + metadata.toString());
                mdReady = true;
                downloadBmIfReady();
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

    public void downloadBmIfReady() {
        if (songsReady && mdReady && !alreadyDownloaded) {
            alreadyDownloaded = true;
            BitmapDownloadAsync bda = new BitmapDownloadAsync(bmDownloadCallback,
                    metadata.getServerIP(),
                    songs);
            bda.execute();
        }
    }

    public HashMap<Integer, Bitmap> getSongPhotos() {
        return songPhotos;
    }

    public Bitmap getSongPhotoById(int id) {
        if (songPhotos.size() == 0) {
            return null;
        }
        else {
            boolean contained = false;
            for (int songId : songPhotos.keySet()) {
                if (songId == id) {
                    contained = true;
                    break;
                }
            }
            if (!contained) {
                return null;
            }
        }
        return songPhotos.get(id);
    }

}
