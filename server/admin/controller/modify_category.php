<?php 

require_once "../model/classes.php";
require_once "../model/database.php";

session_start();

if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_POST['submit']) || $_POST['submit'] == null){
    echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    echo '<h3>Redirigiendo a la página principal...</h3>';
    header("Refresh:2; url=../");
}
else {
    $option = $_POST['submit'];

    $access = substr($option, 0, 1);
    $id = substr($option, 2, 1);

    if ($access == "0") {
        
        header('location: ../pages/add_song_categories.php?categoryId='.$id);
    }
    else if ($access == "1") {
        $id = substr($option, 2, 1);
        $db->deleteCategory(intval($id));
        header('location: ../pages/admin.php?chosen_tab=categories&msg=<span class="text-success">Categoría eliminada.</span>');
    }
    else {
        header('location: ../pages/admin.php?chosen_tab=categories&msg=<span class="text-danger">El acceso ha sido incorrecto.</span>');
    }
}
?>