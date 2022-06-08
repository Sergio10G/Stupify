<?php

require_once "../model/classes.php";
require_once "../model/database.php";

session_start();

if (!isset($_SESSION) || !$_SESSION['sesion_iniciada'] || !isset($_POST['submit']) || $_POST['submit'] != "1"){
    echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    echo '<h3>Redirigiendo a la página principal...</h3>';
    header("Refresh:2; url=../");
}
else {
    if(isset($_POST['category'])) {
        $category = $_POST['category'];
    }
    else {
        $category = null;
    }

    $categories = $db->getCategories();

    $categoryExists = false;

    foreach($categories as $cat) {
        if ($cat->category == $category) {
            $categoryExists = true;
            break;
        }
    }

    if (!$categoryExists) {
        if ($category != null && $category != "") {
            $id = $db->getLastCategoryId() + 1;
            $cat = new Category($id, $category);
            //var_dump($cat);
            if ($db->insertCategory($cat)) {
                header('location: ../pages/admin.php?chosen_tab=categories&msg=<span class="text-success">Categoría insertada con éxito.</span>');
            }
            else {
                header('location: ../pages/admin.php?chosen_tab=categories&msg=<span class="text-danger">Error en el acceso a la base de datos.</span>');
            }
        }
        else {
            header('location: ../pages/admin.php?chosen_tab=categories&msg=<span class="text-danger">La categoría introducida es inválida.</span>');
        }
    }
    else {
        header('location: ../pages/admin.php?chosen_tab=categories&msg=<span class="text-danger">La categoría introducida ya existe.</span>');
    }    
    }

?>