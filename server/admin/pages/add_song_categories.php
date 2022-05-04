<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir canciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <div id="container">
        <div id="header" class="border-bottom">
            <h1 class="text-center">Añadir categoría a diferentes canciones</h1>
        </div>
        <div id="main" class="border-bottom">
<?php

function songHasCategory($songId, $songCats, $categoryId) {
    $hasCategory = false;
    foreach ($songCats as $key => $songCat) {
        if ($songCat->catId == intval($categoryId) && $songCat->songId == $songId) {
            $hasCategory = true;
            break;
        }
    }
    return $hasCategory;
}

session_start();

if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_GET['categoryId'])) {
    echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
}
else {
    require_once "../model/classes.php";
    require_once "../model/database.php";
    
    $categoryId = $_GET['categoryId'];
    $categories = $db->getCategories();

    $categoryExists = false;

    foreach ($categories as $category) {
        if ($category->id == intval($categoryId)) {
            $categoryExists = true;
            break;
        }
    }

    if ($categoryExists) {
        $category = $db->getCategory(intval($categoryId));
        $songCats = $db->getSongCats();
        $songs = $db->getSongs();

        echo '
        <h1 class="mb-3">Categoría '.$category->category.'</h1>
        <form method="POST" action="../controller/add_categories_to_songs.php" enctype="multipart/form-data">
            <div class="row">
                <label class="form-label">Canciones</label>
                <div class="input-group border mb-3" id="song-list">
        ';
        foreach ($songs as $song) {
            echo '
                    <div id="song-item">
                        <label>'.$song->author.' - '.$song->title.'</label>
                        <input class="form-check-input" name="songs[]" type="checkbox" value="'.$song->id.'"';
                        if (songHasCategory($song->id, $songCats, $categoryId)) {
                            echo 'checked';
                        }
                        echo '>
                    </div>
            ';
        }
        echo '
                </div>
            </div>
            <div class="row mb-3">
                <input type="hidden" name="categoryId" value="'.$category->id.'">
                <button type="submit" class="btn btn-success" name="submit" value="1">Actualizar categorías</button>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-warning" name="submit" value="2">Volver</button>
            </div>
        </form>
        ';
    }
    else {
        echo '<h1 style="color:red;">ERROR: La categoría '.$categoryId.' no existe.</h1>';
    }
    echo '
    </div>
        <div id="footer">
            <span>Developed by Sergio Díez García © 2022</span>
            <form method="POST" action="../controller/session_end.php" enctype="multipart/form-data">
                <input type="hidden" name="called" value="1">
                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
        </div>
    ';
}
?>
    </div>
</body>
</html>