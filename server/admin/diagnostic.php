<?php
    if (!isset($_SESSION) || !$_SESSION['sesion_iniciada']){
        header("location: ./admin.php");
    }
?>