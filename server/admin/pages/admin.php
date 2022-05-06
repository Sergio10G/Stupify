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
        require_once '../model/classes.php';
        require_once '../model/database.php';

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
                echo '
                <h1 class="mb-3">Diagnóstico del servidor</h1>
                <form method="POST" action="../controller/diagnostic.php" enctype="multipart/form-data">
                ';
                $file = file_get_contents("/stupify/diagnostic.json");
                $diag = Diagnostic::fromJSON($file);

                $dateDiag = date_create_from_format('U', intval($diag->timestamp));
                $dateNow = date_create_from_format('U', time());
                $diff = (array) date_diff($dateDiag, $dateNow);
                
                echo '
                <div class="row mb-3">
                    <div class="col">
                        <button type="submit" name="submit" value="1" class="btn btn-primary">Realizar diagnóstico</button>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        Último diagnóstico hace <span class="fw-bold">'.$diff['h'].' horas, '.$diff['i'].' minutos y '.$diff['s'].' segundos.</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="mb-3">
                            <span class="fw-bold me-1">Estado del servidor apache:</span>
                            <span class="text-'.($diag->apache_status == "active" ? "success" : "danger").'">'.$diag->apache_status.'</span>
                        </div>
                    </div>
                </div>
                ';
                
                echo '
                </form>
                ';
                break;
                
            case 'upload':
                require_once '../view/view_upload_song.php';
                break;

            case 'songs':
                require_once '../view/view_songs.php';
                break;
            
            case 'categories':
                require_once '../view/view_categories.php';
                break;
            
            default:
                echo '<h2>La página '.$chosen_tab.' no existe.</h2>';
                break;
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