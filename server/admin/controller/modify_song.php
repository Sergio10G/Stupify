<?php
    session_start();

    if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_POST['submit']) || $_POST[ 'submit'] == null){
        echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    }
    else {
        require_once "../model/classes.php";
        require_once "../model/database.php";

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
    
        if(isset($_FILES['photo']) && $_FILES['photo']['name'] != "") {
            $photo = $_FILES['photo'];
        }
        else {
            $photo = null;
        }
    
        if(isset($_FILES['audiofile']) && $_FILES['audiofile']['name'] != "") {
            $audiofile = $_FILES['audiofile'];
        }
        else {
            $audiofile = null;
        }
        
        $option = $_POST['submit'];

        $access = substr($option, 0, 1);
        $id = substr($option, 2, 1);

        if ($access == 0) {
            $prevSong = $db->getSong($id);

            if ($photo != null) {
                $newPhotoName = $photo['name'];
            }
            else {
                $newPhotoName = $prevSong->photo;
            }

            if ($audiofile != null) {
                $newAudiofileName = $audiofile['name'];
            }
            else {
                $newAudiofileName = $prevSong->audiofile;
            }

            $song = new Song($id, $title, $author, $newPhotoName, $newAudiofileName);

            if ($db->insertSong($song)) {
                $db->deleteSongCatsFromSong($id);
                foreach ($categories as $category) {
                    $sc = new SongCat($id, intval($category));
                    $db->pushSongCat($sc);
                }
                
                if ($photo != null) {
                    exec("rm -f /stupify/res/img/".$prevSong->photo);
                    move_uploaded_file($photo['tmp_name'], "/stupify/res/img/".$photo['name']);
                    unlink("../img/".$prevSong->photo);
                    $out = [];
                    exec("ln -s /stupify/res/img/".$photo['name']." ../img/".$photo['name'], $out);
                }

                if ($audiofile != null) {
                    exec("rm -f /stupify/res/songs/".$prevSong->audiofile);
                    move_uploaded_file($audiofile['tmp_name'], "/stupify/res/songs/".$audiofile['name']);
                }
                header('location: ../pages/admin.php?chosen_tab=upload&msg=<span class="text-success">Canción actualizada con éxito.</span>');
            }
            else {
                header('location: ../pages/admin.php?chosen_tab=upload&msg=<span class="text-danger">Error en el acceso a la base de datos.</span>');
            }
        }
        else if ($access == 1) {
            header('location: ../pages/admin.php?chosen_tab=songs');
        }
        else {
            header('location: ../pages/admin.php?chosen_tab=songs&msg=<span class="text-danger">Ha ocurrido algún error.</span>');
        }
    }
?>