<?php
    session_start();
    define('ACCESS_TOKEN', '!!access1@admin');

    if(isset($_POST['token'])){
        $token = $_POST['token'];
    }
    else{
        $token = null;
    }

    if(!isset($_SESSION["sesion_iniciada"])){
        $_SESSION["sesion_iniciada"] = false;
    }
        
    if($token !== null && $token == ACCESS_TOKEN){
        $_SESSION["sesion_iniciada"] = true;
    }
?>