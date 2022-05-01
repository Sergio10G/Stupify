<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<?php
    if (!isset($_SESSION) || !$_SESSION['sesion_iniciada']){
        echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
        var_dump($_SESSION);
        var_dump($_SESSION['sesion_iniciada']);
    }
    else {
        if (isset($_POST['chosen_tab'])) {
            $chosen_tab = $_POST['chosen_tab'];
        }
        else {
            $chosen_tab = 'diagnostic';
        }
    
        // Header
        echo '
            <div id="header">
                <form method="POST" action="admin.php" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-primary" name="chosen_tab" value="diagnostic">Diagnóstico</button>
                    <button type="submit" class="btn btn-primary" name="chosen_tab" value="upload">Subida</button>
                    <button type="submit" class="btn btn-primary" name="chosen_tab" value="songs">Canciones</button>
                    <button type="submit" class="btn btn-primary" name="chosen_tab" value="categories">Categorías</button>
                </form>
            </div>
        ';
    
        // Body
        switch ($chosen_tab) {
            case 'diagnostic':
                echo 'DIAGNOSTICO';
                break;
                
            case 'upload':
                echo 'SUBIDA';
            break;

            case 'songs':
                echo 'CANCIONES';
            break;
            
            case 'categories':
                echo 'CATEGORIAS';
                break;
            
            default:
                echo 'ERROR';
                break;
        }
    
        // Footer
        echo '
            <div id="footer">
                <span>Developed by Sergio Díez García</span>
                <form method="POST" action="session_end.php" enctype="multipart/form-data">
                    <input type="hidden" name="called" value="1">
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            </div>
        ';
    }  
?>
</body>
</html>