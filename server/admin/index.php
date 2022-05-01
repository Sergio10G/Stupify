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
    <?php // Modulo de sesión
        
        // Constantes:
        // ACCESS_TOKEN: Token de inicio de sesión.
        //
        // Variables:
        // $token: Token de inicio de sesión introducido por el usuario.
        // $_POST['token']: Token que el usuario envía con la petición POST.
        // $_SESSION['sesion_iniciada]: Booleano que controla si se ha iniciado sesión.
        
        require_once "./session_start.php"
    ?>

    <?php 
        if (!$_SESSION['sesion_iniciada']) {
            echo '
                <div class="container border p-4 contenedor_padre" style="margin-top: 200px;">
                    <div class="row">
                        <center><h1>ACCESO DE ADMINISTRACIÓN</h1></center>
                    </div>
                    <form method="POST" action="index.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="token" class="form-label">Token</label>
                            <input name="token" type="password" class="form-control" id="token" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            ';
        }
        else {
            header("location: ./admin.php");
        }
    ?>
</body>
</html>