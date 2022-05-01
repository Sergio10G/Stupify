<?php
    if (isset($_SESSION) && isset($_POST) && $_POST['called'] == "1") {
        session_abort();
    }
    header("location: ./index.php");
?>