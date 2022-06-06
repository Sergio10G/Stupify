package com.example.stupify_client.fragments;

import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;
import android.util.Log;
import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.example.stupify_client.MenuActivity;
import com.example.stupify_client.R;
import com.example.stupify_client.model.Song;

import java.util.ArrayList;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link SongList#newInstance} factory method to
 * create an instance of this fragment.
 */
public class SongList extends Fragment {

    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_CATEGORY = "category";
    private static final String ARG_CATEGORY_ID = "categoryId";
    private static final String ARG_SONG_LIST = "songList";

    private String category;
    private int categoryId;
    private ArrayList<Song> songList;

    public SongList() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param category The name of the chosen category.
     * @param categoryId Category id.
     * @param songList The songs that belong to said category.
     * @return A new instance of fragment SongList.
     */
    public static SongList newInstance(String category, int categoryId, ArrayList<Song> songList) {
        SongList fragment = new SongList();
        Bundle args = new Bundle();
        args.putString(ARG_CATEGORY, category);
        args.putInt(ARG_CATEGORY_ID, categoryId);
        args.putParcelableArrayList(ARG_SONG_LIST, songList);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            category = getArguments().getString(ARG_CATEGORY);
            categoryId = getArguments().getInt(ARG_CATEGORY_ID);
            songList = getArguments().getParcelableArrayList(ARG_SONG_LIST);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_song_list, container, false);

        TextView lblCategory = view.findViewById(R.id.lblCategory);
        lblCategory.setText(category);
        lblCategory.setPaintFlags(lblCategory.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);

        ListView lv = view.findViewById(R.id.listView);
        int[] colors = {0xFFFFFFFF, 0xFFFFFFFF, 0};
        lv.setDivider(new GradientDrawable(GradientDrawable.Orientation.LEFT_RIGHT, colors));
        lv.setDividerHeight(2);
        Log.d("DEBUG", "" + songList.size());
        if (songList.size() > 0) {
            ArrayAdapter<Song> adapter =
                    new ArrayAdapter<Song>(getContext(), android.R.layout.simple_list_item_1, songList) {
                        @NonNull
                        @Override
                        public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
                            View v = super.getView(position, convertView, parent);

                            TextView tv = v.findViewById(android.R.id.text1);
                            tv.setTextSize(TypedValue.COMPLEX_UNIT_SP, 20.0f);
                            tv.setTextColor(Color.WHITE);
                            tv.setText(songList.get(position).getAuthor() + " - " + songList.get(position).getTitle());
                            tv.setPadding(0, 55, 0, 0);
                            return v;
                        }
                    };
            lv.setAdapter(adapter);
            lv.setOnItemClickListener((av, v, a1, a2) -> {
                Log.d("LIST", songList.get(a1).getAuthor() + " - " + songList.get(a1).getTitle());
                ((MenuActivity) getActivity()).launchPlayer(songList.get(a1).getId(), categoryId);
            });
        }
        else {
            ArrayList<String> empty_list_al = new ArrayList<>();
            empty_list_al.add("No hay canciones en la categoría seleccionada");
            ArrayAdapter<String> adapter =
                    new ArrayAdapter<String>(getContext(), android.R.layout.simple_list_item_1, empty_list_al) {
                        public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
                            View v = super.getView(position, convertView, parent);

                            TextView tv = v.findViewById(android.R.id.text1);
                            tv.setTextSize(TypedValue.COMPLEX_UNIT_SP, 30.0f);
                            tv.setTextColor(Color.WHITE);
                            tv.setText(empty_list_al.get(position));
                            tv.setPadding(0, 55, 0, 0);
                            return v;
                        }
                    };
            lv.setAdapter(adapter);
        }
        return view;
    }
}