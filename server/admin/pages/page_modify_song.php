<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <div id="container">
<?php
session_start();

if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_GET['songId']) || $_GET['songId'] == null){
    echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    echo '<h3>Redirigiendo a la página principal...</h3>';
    header("Refresh:2; url=../");
}
else {
    require_once "../model/classes.php";
    require_once "../model/database.php";
    require_once "../model/utils.php";
    
    $songId = $_GET['songId'];
    $song = $db->getSong(intval($songId));
    
    if ($song != null) {
        $songCats = $db->getSongCats();
        $categories = $db->getCategories();

        echo '
        <div id="header">
        </div>
        <div id="main" class="border rounded">
            <h1 class="mb-3">Modificar información de la canción</h1>
            <form method="POST" action="../controller/modify_song.php" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="title" placeholder="Título" value="'.$song->title.'" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="author" placeholder="Autor" value="'.$song->author.'" required>
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
                                <input class="form-check-input" name="categories[]" type="checkbox" value="'.$category->id.'"
            ';
            
            if (songHasCategory($song->id, $songCats, $category->id)) {
                echo 'checked';
            }
            
            echo '>
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
                        <label class="form-label">Foto actual: '.$song->photo.'</label>
                        <br>
                        <label class="form-label">Nueva foto</label>
                        <input class="form-control" type="file" name="photo" accept=".jpg">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Archivo de audio actual: '.$song->audiofile.'</label>
                        <br>
                        <label class="form-label">Nuevo archivo de audio</label>
                        <input class="form-control" type="file" name="audiofile" accept="audio/wav">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <span class="text-danger text-center">Atención: Se borrarán los archivos de imágen y de audio actuales.</span>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-success mb-2" name="submit" value="0-'.$song->id.'">Actualizar información</button>
                <button type="submit" class="btn btn-warning" name="submit" value="1-'.$song->id.'">Volver</button>
            </div>
        </form>
        ';
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
    else {

    }
}
?>      
    </div>
</body>
</html>