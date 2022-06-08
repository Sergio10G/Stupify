<?php
session_start();

if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_POST['submit']) || $_POST['submit'] == null){
    echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    echo '<h3>Redirigiendo a la página principal...</h3>';
    header("Refresh:2; url=../");
}
else {
    require_once "../model/classes.php";
    require_once "../model/database.php";
    require_once "../model/utils.php";

    $option = $_POST['submit'];

    if (isset($_POST['newIp']) && $_POST['newIp'] !== null) {
        $newIp = $_POST['newIp'];
    }
    else {
        $newIp = "127.0.0.1";
    }

    if ($option == 1) {
        $out = [];
        exec("sh /stupify/scripts/diagnostic.sh", $out);
        header('location: ../pages/admin.php?chosen_tab=diagnostic');
    }
    else if ($option == 2) {
        if ($db->setServerIp($newIp)) {
            header('location: ../pages/admin.php?chosen_tab=diagnostic&msg=<span class="text-success">IP sincronizada con éxito.</span>');
        }
        else {
            header('location: ../pages/admin.php?chosen_tab=diagnostic&msg=<span class="text-danger">No se ha podido sincronizar la IP con la BDD.</span>');
        }
    }
    else {
        header('location: ../pages/admin.php?chosen_tab=diagnostic&msg=<span class="text-danger">El acceso ha sido incorrecto.</span>');
    }
    
}
?>