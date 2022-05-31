<?php
$songs = $db->getSongs();
$songCats = $db->getSongCats();

echo '
<h1 class="mb-3">Listado de canciones</h1>
<form method="POST" action="../controller/song_actions.php" enctype="multipart/form-data" id="form-songs">
    <div class="input-group border" id="form-songs-list">
';
foreach ($songs as $song) {
    echo '
    <div id="song" class="border">
        <img src="../img/'.$song->photo.'">
        <div id="song-data">
            <span id="song-data-title">'.$song->title.'</span>
            <span id="song-data-author">'.$song->author.'</span>
        </div>
        <div id="song-categories">
    ';
    $category = null;
    $uncategorized = true;
    foreach ($songCats as $key => $songCat) {
        if ($songCat->songId == $song->id) {
            $category = $db->getCategory($songCat->catId);
            if ($category != null) {
                $uncategorized = false;
                echo '<div id="song-category" class="border">'.$category->category.'</div>';
            }
        }
    }
    if ($uncategorized) {
        echo '<div id="song-category" class="border border-danger text-danger">Sin categorizar</div>';
    }
    
    echo '
        </div>
        <div id="song-options">
            <button type="submit" class="btn btn-warning" name="submit" value="0-'.$song->id.'">Modificar</button>
            <button type="submit" class="btn btn-danger" name="submit" value="1-'.$song->id.'">Eliminar</button>
        </div>
    </div>
    
    ';
}
echo '
    </div>
</form>
';
?>

