<?php
$songs = $db->getSongs();

echo '
<h1 class="mb-3">Listado de canciones</h1>
<form method="POST" action="../controller/modify_song.php" enctype="multipart/form-data" id="form-songs">
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

        </div>
        <div id="song-options">
            <button type="submit" class="btn btn-warning" name="submit" value="1">Modificar</button>
            <button type="submit" class="btn btn-danger" name="submit" value="2">Eliminar</button>
        </div>
    </div>
    
    ';
}
echo '
    </div>
</form>
';
?>

