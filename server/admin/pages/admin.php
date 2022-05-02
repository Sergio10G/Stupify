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

    if (!isset($_SESSION) || !$_SESSION['sesion_iniciada']){
        echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    }
    else {
        if (isset($_GET['chosen_tab'])) {
            $chosen_tab = $_GET['chosen_tab'];
        }
        else {
            $chosen_tab = 'diagnostic';
        }

        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
        }
        else {
            $msg = '';
        }

        // Header
        echo '
            <div id="header" class="border-bottom">
                <form method="GET" action="admin.php" enctype="multipart/form-data" id="form-header">
        ';

        if ($chosen_tab == 'diagnostic') {
            echo '
                <button type="submit" class="btn btn-warning" name="chosen_tab" value="diagnostic">Diagnóstico</button>
            ';
        }
        else {
            echo '
                <button type="submit" class="btn btn-primary" name="chosen_tab" value="diagnostic">Diagnóstico</button>
            ';
        }
        if ($chosen_tab == 'upload') {
            echo '
                <button type="submit" class="btn btn-warning" name="chosen_tab" value="upload">Subida</button>
            ';
        }
        else {
            echo '
                <button type="submit" class="btn btn-primary" name="chosen_tab" value="upload">Subida</button>
            ';
        }
        if ($chosen_tab == 'songs') {
            echo '
                <button type="submit" class="btn btn-warning" name="chosen_tab" value="songs">Canciones</button>
            ';
        }
        else {
            echo '
                <button type="submit" class="btn btn-primary" name="chosen_tab" value="songs">Canciones</button>
            ';
        }
        if ($chosen_tab == 'categories') {
            echo '
                <button type="submit" class="btn btn-warning" name="chosen_tab" value="categories">Categorías</button>
            ';
        }
        else {
            echo '
                <button type="submit" class="btn btn-primary" name="chosen_tab" value="categories">Categorías</button>
            ';
        }

        echo '       
                </form>
            </div>
        ';
    
        // Body
        echo '
            <div id="main" class="border-bottom">
                <div id="msg"> ' . $msg . ' </div>
        ';
        switch ($chosen_tab) {
            case 'diagnostic':
                echo 'DIAGNOSTICO';
                break;
                
            case 'upload':
                echo '
                <h1 class="mb-3">Subida de canción</h1>
                <form method="POST" action="../controller/upload_song.php" enctype="multipart/form-data" id="form-upload">
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
                            <div class="input-group border mb-3">
                                <div id="category">
                                    <label>Categoría 1</label>
                                    <input class="form-check-input" name="categories[]" type="checkbox" value="1">
                                </div>
                                <div id="category">
                                    <label>Categoría 2</label>
                                    <input class="form-check-input" name="categories[]" type="checkbox" value="2">
                                </div>
                                <div id="category">
                                    <label>Categoría 3</label>
                                    <input class="form-check-input" name="categories[]" type="checkbox" value="3">
                                </div>
                                <div id="category">
                                    <label>Categoría 4</label>
                                    <input class="form-check-input" name="categories[]" type="checkbox" value="4">
                                </div>
                                <div id="category">
                                    <label>Categoría 5</label>
                                    <input class="form-check-input" name="categories[]" type="checkbox" value="5">
                                </div>
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
                                <input class="form-control" type="file" name="audiofile" accept="audio/wav">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-success" name="submit" value="1">Subir canción</button>
                    </div>
                </form>
                ';
                break;

            case 'songs':
                echo 'CANCIONES';
                break;
            
            case 'categories':
                echo 'CATEGORIAS';
                break;
            
            default:
                echo '<h2>La página '.$chosen_tab.' no existe.</h2>';
                break;
        }
        echo '
            </div>
        ';
    
        // Footer
        echo '
            <div id="footer">
                <span>Developed by Sergio Díez García</span>
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