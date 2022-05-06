<?php
session_start();

if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_POST['submit']) || $_POST['submit'] == null){
    echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
}
else {
    $out = [];
    exec("sh /stupify/scripts/diagnostic.sh", $out);
    header('location: ../pages/admin.php?chosen_tab=diagnostic');
}
?>