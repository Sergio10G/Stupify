package com.example.stupify_client.model;

public class SongCat {
    private int catId;
    private int songId;

    public SongCat() { }

    @Override
    public String toString() {
        return "SongCat{" +
                "catId=" + catId +
                ", songId=" + songId +
                '}';
    }

    public int getCatId() {
        return catId;
    }

    public void setCatId(Long catId) {
        this.catId = Math.toIntExact(catId);
    }

    public void setCatIdInt(int catId) {
        this.catId = catId;
    }

    public int getSongId() {
        return songId;
    }

    public void setSongId(Long songId) {
        this.songId = Math.toIntExact(songId);
    }

    public void setSongIdInt(int songId) {
        this.songId = songId;
    }
}
