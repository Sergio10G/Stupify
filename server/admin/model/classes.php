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
    }

    class Category{
        public $id;
        public $category;

        public function __construct($id, $category)
        {
            $this->id = $id;
            $this->category = $category;
        }
    }

    class SongCat{
        public $songId;
        public $catId;

        public function __construct($songId, $catId) {
            $this->songId = $songId;
            $this->catId = $catId;
        }
    }

    class Diagnostic{
        public $timestamp;
        public $apache_status;

        public function __construct($timestamp, $apache_status) {
            $this->timestamp = $timestamp;
            $this->apache_status = $apache_status;
        }

        public static function fromJSON($json) {
            $arr = json_decode($json);
            if ($arr != null) {
                $obj = new Diagnostic($arr->timestamp, $arr->apache_status);
                return $obj;
            }
            else {
                return null;
            }
        }
    }
?>