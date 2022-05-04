<?php
    class Song {
        public $id;
        public $title;
        public $author;
        public $photo;
        public $audiofile;

        public function __construct($id, $title, $author, $photo, $audiofile)
        {
            $this->id = $id;
            $this->title = $title;
            $this->author = $author;
            $this->photo = $photo;
            $this->audiofile = $audiofile;
        }

        public static function fromJSON($json) {
            $obj = json_decode($json);
            if ($obj != null) {
                $song = new Song($obj->id, $obj->title, $obj->author, $obj->photo, $obj->audiofile);
                return $song;
            }
            else {
                return null;
            }
        }
    }

    class Category{
        public $id;
        public $category;

        public function __construct($id, $category)
        {
            $this->id = $id;
            $this->category = $category;
        }

        public static function fromJSON($json) {
            $obj = json_decode($json);
            if ($obj != null) {
                $cat = new Category($obj->id, $obj->category);
                return $cat;
            }
            else {
                return null;
            }
        }
    }

    class SongCat{
        public $songId;
        public $catId;

        public function __construct($songId, $catId) {
            $this->songId = $songId;
            $this->catId = $catId;
        }

        public static function fromJSON($json) {
            $obj = json_decode($json);
            if ($obj != null) {
                $sc = new SongCat($obj->songId, $obj->catId);
                return $sc;
            }
            else {
                return null;
            }
        }
    }
?>