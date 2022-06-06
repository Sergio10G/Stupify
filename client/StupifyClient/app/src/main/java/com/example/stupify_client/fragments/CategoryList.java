package com.example.stupify_client.fragments;

import android.app.ActionBar;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.drawable.Drawable;
import android.graphics.drawable.GradientDrawable;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.ListAdapter;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Parcelable;
import android.util.Log;
import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AbsListView;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.ScrollView;
import android.widget.TextView;

import com.example.stupify_client.MenuActivity;
import com.example.stupify_client.R;
import com.example.stupify_client.model.Category;

import org.w3c.dom.Text;

import java.util.ArrayList;
import java.util.List;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link CategoryList#newInstance} factory method to
 * create an instance of this fragment.
 */
public class CategoryList extends Fragment {

    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_CATEGORY_LIST = "categoryList";

    private ArrayList<Category> categoryList;

    public CategoryList() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param categoryList List of categories to display.
     * @return A new instance of fragment CategoryList.
     */
    public static CategoryList newInstance(ArrayList<Category> categoryList) {
        CategoryList fragment = new CategoryList();
        Bundle args = new Bundle();
        args.putParcelableArrayList(ARG_CATEGORY_LIST, categoryList);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            categoryList = getArguments().getParcelableArrayList(ARG_CATEGORY_LIST);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_category_list, container, false);

        TextView lblCategories = view.findViewById(R.id.lblCategories);
        lblCategories.setPaintFlags(lblCategories.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);

        ListView lv = view.findViewById(R.id.listView);
        int[] colors = {0xFFFFFFFF, 0xFFFFFFFF, 0};
        lv.setDivider(new GradientDrawable(GradientDrawable.Orientation.LEFT_RIGHT, colors));
        lv.setDividerHeight(2);
        ArrayAdapter<Category> adapter =
                new ArrayAdapter<Category>(getContext(), android.R.layout.simple_list_item_1, categoryList) {
                    @NonNull
                    @Override
                    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
                        View v = super.getView(position, convertView, parent);
                        TextView tv = v.findViewById(android.R.id.text1);
                        tv.setTextSize(TypedValue.COMPLEX_UNIT_SP, 30.0f);
                        tv.setTextColor(Color.WHITE);
                        tv.setText(categoryList.get(position).getCategory());
                        tv.setPadding(0, 55, 0, 55);
                        return v;
                    }
                };
        lv.setAdapter(adapter);
        lv.setOnItemClickListener((av, v, a1, a2) -> {
            int catId = categoryList.get(a1).getId();
            Log.d("LIST", catId + ", " + categoryList.get(a1).getCategory());
            ((MenuActivity) getActivity()).showSongsFragment(catId);
        });
        return view;
    }
}