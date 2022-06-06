package com.example.stupify_client.model;

import android.os.Parcel;
import android.os.Parcelable;

public class Category implements Parcelable {
    private String category;
    private int id;

    public static final Parcelable.Creator<Category> CREATOR =
            new Parcelable.Creator<Category>() {
                @Override
                public Category createFromParcel(Parcel source) {
                    return new Category(source);
                }

                @Override
                public Category[] newArray(int size) {
                    return new Category[size];
                }
            };

    public Category() { }

    public Category (Parcel in) {
        category = in.readString();
        id = in.readInt();
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel dest, int flags) {
        dest.writeString(category);
        dest.writeInt(id);
    }

    @Override
    public String toString() {
        return "Category{" +
                "category='" + category + '\'' +
                ", id=" + id +
                '}';
    }

    public String getCategory() {
        return category;
    }

    public void setCategory(String category) {
        this.category = category;
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
}
