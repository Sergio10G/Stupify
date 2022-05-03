<?php
    require_once "../model/classes.php";
    require_once "../model/database.php";

    session_start();
    
    if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_POST['submit']) || $_POST['submit'] != "1"){
        echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    }
    else {
        if(isset($_POST['title'])) {
            $title = $_POST['title'];
        }
        else {
            $title = 'Titulo por defecto';
        }
    
        if(isset($_POST['author'])) {
            $author = $_POST['author'];
        }
        else {
            $author = 'Sin autor';
        }
    
        if(isset($_POST['categories'])) {
            $categories = $_POST['categories'];
        }
        else {
            $categories = [];
        }
    
        if(isset($_FILES['photo'])) {
            $photo = $_FILES['photo'];
        }
        else {
            $photo = [];
        }
    
        if(isset($_FILES['audiofile'])) {
            $audiofile = $_FILES['audiofile'];
        }
        else {
            $audiofile = [];
        }
    
        $songs = scandir("/stupify/res/songs");
        $photos = scandir("/stupify/res/img");
    
        $repeatedSong = false;
    
        foreach ($songs as $sng) {
            echo $sng."<br>";
            if ($sng == $audiofile['name']) {
                echo "ding";
                $repeatedSong = true;
                break;
            }
        }

        echo "<hr>";
    
        $repeatedPhoto = false;
    
        foreach ($photos as $ph) {
            echo $ph."<br>";
            if ($ph == $photo['name']) {
                echo "ding";
                $repeatedPhoto = true;
                break;
            }
        }
    
        
        if ($repeatedSong) {
            header('location: ../pages/admin.php?chosen_tab=upload&msg=<span class="text-danger">La canción seleccionada ya existe en el servidor.</span>');
        }
        else if ($repeatedPhoto) {
            header('location: ../pages/admin.php?chosen_tab=upload&msg=<span class="text-danger">La foto seleccionada ya existe en el servidor.</span>');
        }
        else {
            $id = $db->getLastSongId() + 1;

            $song = new Song($id, $title, $author, $categories, $photo['name'], $audiofile['name']);

            if ($db->insertSong($song)) {
                move_uploaded_file($audiofile['tmp_name'], "/stupify/res/songs/".$audiofile['name']);
                move_uploaded_file($photo['tmp_name'], "/stupify/res/img/".$photo['name']);
                header('location: ../pages/admin.php?chosen_tab=upload&msg=<span class="text-success">Canción subida con éxito.</span>');
            }
            else {
                header('location: ../pages/admin.php?chosen_tab=upload&msg=<span class="text-danger">Error en el acceso a la base de datos.</span>');
            }
        }
    }
?>
