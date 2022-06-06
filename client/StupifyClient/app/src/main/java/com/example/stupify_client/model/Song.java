package com.example.stupify_client.model;

import android.os.Parcel;
import android.os.Parcelable;

public class Song implements Parcelable {
    private String audiofile;
    private String author;
    private int id;
    private String photo;
    private String title;

    public static final Parcelable.Creator<Song> CREATOR =
            new Parcelable.Creator<Song>() {

                @Override
                public Song createFromParcel(Parcel source) {
                    return null;
                }

                @Override
                public Song[] newArray(int size) {
                    return new Song[0];
                }
            };

    public Song() { }

    protected Song(Parcel in) {
        audiofile = in.readString();
        author = in.readString();
        id = in.readInt();
        photo = in.readString();
        title = in.readString();
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(audiofile);
        dest.writeString(author);
        dest.writeInt(id);
        dest.writeString(photo);
        dest.writeString(title);
    }

    @Override
    public String toString() {
        return "Song{" +
                "audiofile='" + audiofile + '\'' +
                ", author='" + author + '\'' +
                ", id=" + id +
                ", photo='" + photo + '\'' +
                ", title='" + title + '\'' +
                '}';
    }

    public String getAudiofile() {
        return audiofile;
    }

    public void setAudiofile(String audiofile) {
        this.audiofile = audiofile;
    }

    public String getAuthor() {
        return author;
    }

    public void setAuthor(String author) {
        this.author = author;
    }

    public int getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = Math.toIntExact(id);
    }

    public void setIdInt(int id) {
        this.id = id;
    }

    public String getPhoto() {
        return photo;
    }

    public void setPhoto(String photo) {
        this.photo = photo;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }
}
