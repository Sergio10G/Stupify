<?php
    class Song {
        public $id;
        public $title;
        public $author;
        public $categories;
        public $photo;
        public $audiofile;

        function __construct($id, $title, $author, $categories, $photo, $audiofile)
        {
            $this -> id = $id;
            $this -> title = $title;
            $this -> author = $author;
            $this -> categories = $categories;
            $this -> photo = $photo;
            $this -> audiofile = $audiofile;
        }

        function toJSON() {
            return json_encode($this);
        }

        static function fromJSON($json) {
            $obj = json_decode($json);
            if ($obj != null) {
                $song = new Song(null, null, null, null, null, null);
                $song -> __construct($obj -> id, $obj -> title, $obj -> author, $obj -> categories, $obj -> photo, $obj -> audiofile);
                return $song;
            }
            else {
                return null;
            }
        }
    }
?>