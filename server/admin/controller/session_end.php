<?php
    session_start();
    if (isset($_SESSION) && isset($_POST) && $_POST['called'] == "1") {
        session_destroy();
    }
    header("location: ../index.php");
?>