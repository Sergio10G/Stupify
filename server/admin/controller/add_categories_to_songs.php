<?php 
require_once "../model/classes.php";
require_once "../model/database.php";

session_start();

if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_POST['submit']) || $_POST['submit'] == null){
    echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
}
else {
    $submit = $_POST['submit'];

    if(isset($_POST['categoryId'])) {
        $categoryId = $_POST['categoryId'];
    }
    else {
        $categoryId = null;
    }

    if(isset($_POST['songs'])) {
        $songs = $_POST['songs'];
    }
    else {
        $songs = [];
    }
    
    if ($submit == 1) {
        if ($categoryId != null) {
            $db->deleteSongCatsFromCat(intval($categoryId));
            if (count($songs) > 0) {
                foreach ($songs as $songId) {
                    $sc = new SongCat(intval($songId), intval($categoryId));
                    $db->pushSongCat($sc);
                }
            }
            header('location: ../pages/admin.php?chosen_tab=categories&msg=<span class="text-success">Categoría actualizada.</span>');
        }
        else {
            header('location: ../pages/admin.php?chosen_tab=categories&msg=<span class="text-danger">Ha ocurrido algún error al intentar añadir canciones a la categoría.</span>');
        }
    }
    else {
        header('location: ../pages/admin.php?chosen_tab=categories');
    }
}
?>