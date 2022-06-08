<?php 
$categories = $db->getCategories();

echo '
<h1 class="mb-3">Subida de canción</h1>
<form method="POST" action="../controller/upload_song.php" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col">
            <div class="mb-3">
                <input type="text" class="form-control" name="title" placeholder="Título" required>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <input type="text" class="form-control" name="author" placeholder="Autor" required>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Categorías</label>
            <div class="input-group border rounded mb-3" id="category-list">
';
foreach ($categories as $category) {
    echo '
        <div id="category">
            <label>'.$category->category.'</label>
            <input class="form-check-input" name="categories[]" type="checkbox" value="'.$category->id.'">
        </div>
    ';
}
echo '
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col">
            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input class="form-control" type="file" name="photo" accept=".jpg">
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label class="form-label">Archivo de audio</label>
                <input class="form-control" type="file" name="audiofile" accept="audio/wav, audio/mp3">
            </div>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="btn btn-success" name="submit" value="1">Subir canción</button>
    </div>
</form>
';
?>