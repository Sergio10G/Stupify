<?php
    use Kreait\Firebase\Factory;
    require '../vendor/autoload.php';

    class Database {
        public $factory;
        public $realtimeDatabase;

        public function __construct()
        {
            $this->factory = (new Factory)
                 ->withServiceAccount('/stupify/etc/stupify-360f5-firebase-adminsdk-6fz48-1c2f019b1b.json')
                 ->withDatabaseUri('https://stupify-360f5-default-rtdb.europe-west1.firebasedatabase.app/');
            $this->realtimeDatabase = $this->factory->createDatabase();
        }

        public function getLastSongId() {
            $songsRef = $this->realtimeDatabase->getReference('/stupifyDB/songs');
            $songsSnap = $songsRef->getSnapshot();
            if (!$songsSnap->hasChildren()) {
                return 0;
            }
            else {
                $keys = $songsRef->getChildKeys();
                return $keys[count($keys) - 1];
            }
        }

        public function insertSong(Song $song) {
            $songsRef = $this->realtimeDatabase->getReference('/stupifyDB/songs');
            $ret = $songsRef->getChild($song->id)->set($song);
            if ($ret !== null) {
                return true;
            }
            else {
                return false;
            }
        }
    }
    
    if (!isset($db) || $db == null) {
        $db = new Database();
    }
    
?>
