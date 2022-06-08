<?php
    use Kreait\Firebase\Factory;
    require '../vendor/autoload.php';
    require_once '../model/classes.php';
    require_once '../model/utils.php';

    class Database {
        public $factory;
        public $realtimeDatabase;

        public function __construct()
        {
            $this->factory = (new Factory)
                 ->withServiceAccount('/stupify/etc/stupify-360f5-firebase-adminsdk-6fz48-87dc04ce2e.json')
                 ->withDatabaseUri('https://stupify-360f5-default-rtdb.europe-west1.firebasedatabase.app/');
            $this->realtimeDatabase = $this->factory->createDatabase();
        }

        public function getServerIp(): String {
            $svipRef = $this->realtimeDatabase->getReference('/stupifyDB/metadata/serverIP');
            $svip = $svipRef->getValue();
            return $svip;
        }

        public function setServerIp(String $serverIP): String {
            $svipRef = $this->realtimeDatabase->getReference('/stupifyDB/metadata/serverIP');
            $ret = $svipRef->set($serverIP);
            return ret !== null;
        }

        public function getLastSongId(): int {
            $songsRef = $this->realtimeDatabase->getReference('/stupifyDB/songs');
            $songsSnap = $songsRef->getSnapshot();
            if (!$songsSnap->hasChildren()) {
                return 0;
            }
            else {
                $keys = $songsRef->getChildKeys();
                return returnBiggestNumber($keys);
            }
        }

        public function getLastCategoryId(): int {
            $catsRef = $this->realtimeDatabase->getReference('/stupifyDB/categories');
            $catsSnap = $catsRef->getSnapshot();
            if (!$catsSnap->hasChildren()) {
                return 0;
            }
            else {
                $keys = $catsRef->getChildKeys();
                return returnBiggestNumber($keys);
            }
        }

        public function insertSong(Song $song): bool {
            $songsRef = $this->realtimeDatabase->getReference('/stupifyDB/songs');
            $ret = $songsRef->getChild($song->id)->set($song);
            return $ret !== null;
        }

        public function getSongs(): array {
            $songsRef = $this->realtimeDatabase->getReference('/stupifyDB/songs');
            $dbSongs = $songsRef->getValue();
            $songs = [];

            foreach ($dbSongs as $key => $s) {
                if ($s != null) {
                    $song = new Song($s['id'], $s['title'], $s['author'], $s['photo'], $s['audiofile']);
                    array_push($songs, $song);
                }
            }
            return $songs;
        }

        public function insertCategory(Category $category): bool {
            $catsRef = $this->realtimeDatabase->getReference('/stupifyDB/categories');
            $ret = $catsRef->getChild($category->id)->set($category);
            return $ret !== null;
        }

        public function pushSongCat(SongCat $sc): void {
            $scRef = $this->realtimeDatabase->getReference('/stupifyDB/song-cat');
            $scRef->push($sc);
        }

        public function getCategories(): array {
            $catsRef = $this->realtimeDatabase->getReference('/stupifyDB/categories');
            $dbCats = $catsRef->getValue();
            $categories = [];

            foreach ($dbCats as $key => $cat) {
                if ($cat != null) {
                    //$category = Category::fromJSON($cat);
                    $category = new Category($cat["id"], $cat["category"]);
                    array_push($categories, $category);
                }
            }
            return $categories;
        }

        public function getCategory($categoryId): Category {
            $cat = $this->realtimeDatabase->getReference('/stupifyDB/categories/'.$categoryId)->getValue();
            $category = new Category($cat['id'], $cat['category']);
            return $category;
        }

        public function getSong($songId): Song {
            $sng = $this->realtimeDatabase->getReference('/stupifyDB/songs/'.$songId)->getValue();
            $song = new Song($sng['id'], $sng['title'], $sng['author'], $sng['photo'], $sng['audiofile']);
            return $song;
        }

        public function getSongCats(): array {
            $scs = $this->realtimeDatabase->getReference('/stupifyDB/song-cat')->getValue();
            $songCats = [];
            foreach ($scs as $key => $sc) {
                $catId = $sc['catId'];
                $songId = $sc['songId'];
                $songCat = new SongCat($songId, $catId);
                $songCats[$key] = $songCat;
                //array_push($songCats, $songCat);
            }
            return $songCats;
        }

        public function deleteSongCatsFromCat($categoryId): void {
            $scs = $this->realtimeDatabase->getReference('/stupifyDB/song-cat')->getValue();
            foreach ($scs as $key => $sc) {
                if ($sc['catId'] == $categoryId) {
                    $this->realtimeDatabase->getReference('/stupifyDB/song-cat/'.$key)->remove();
                }
            }
        }

        public function deleteSongCatsFromSong($songId): void {
            $scs = $this->realtimeDatabase->getReference('/stupifyDB/song-cat')->getValue();
            foreach ($scs as $key => $sc) {
                if ($sc['songId'] == $songId) {
                    $this->realtimeDatabase->getReference('/stupifyDB/song-cat/'.$key)->remove();
                }
            }
        }

        public function deleteCategory($categoryId): void {
            $this->deleteSongCatsFromCat($categoryId);
            $this->realtimeDatabase->getReference('/stupifyDB/categories/'.$categoryId)->remove();
        }

        public function deleteSong($songId): void {
            $this->deleteSongCatsFromSong($songId);
            $this->realtimeDatabase->getReference('/stupifyDB/songs/'.$songId)->remove();
        }
    }
    
    if (!isset($db) || $db == null) {
        $db = new Database();
    }
    
?>
