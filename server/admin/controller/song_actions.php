<?php 
session_start();

if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_POST['submit']) || $_POST[ 'submit'] == null){
    echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    echo '<h3>Redirigiendo a la página principal...</h3>';
    header("Refresh:2; url=../");
}
else {
    require_once "../model/classes.php";
    require_once "../model/database.php";

    $option = $_POST['submit'];

    $access = substr($option, 0, 1);
    $id = substr($option, 2, 1);

    if (($access == "0" || $access == "1") && $id != null) {
        $songs = $db->getSongs();
    }
    else {
        $songs = null;
    }

    if ($songs != null) {
        $song = null;

        foreach ($songs as $sng) {
            if ($sng->id == intval($id)) {
                $song = $sng;
                break;
            }
        }

        if ($song != null) {

            if ($access == "0") {
                header('location: ../pages/page_modify_song.php?songId='.$id);
            }
            else if ($access == "1") {
                unlink("../img/".$song->photo);
                unlink("../songs/".$song->audiofile);
                exec("rm -f /stupify/res/img/".$song->photo);
                exec("rm -f /stupify/res/songs/".$song->audiofile);
                $db->deleteSong(intval($id));
                header('location: ../pages/admin.php?chosen_tab=songs&msg=<span class="text-success">Canción eliminada con éxito.</span>');
            }
            else {
                header('location: ../pages/admin.php?chosen_tab=songs&msg=<span class="text-danger">El acceso ha sido incorrecto.</span>');
            }
        }
        else {
            header('location: ../pages/admin.php?chosen_tab=songs&msg=<span class="text-danger">Canción no encontrada.</span>');
        }
    }
    else {
        header('location: ../pages/admin.php?chosen_tab=songs&msg=<span class="text-danger">Ha ocurrido algún error.</span>');
    }
}
?>