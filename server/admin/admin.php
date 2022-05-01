<?php
    if (!isset($_SESSION) || !$_SESSION['sesion_iniciada']){
        echo '<h1 style="color:red;">ERROR: Acceso prohibido.</h1>';
    }
    else {
        if (isset($_POST['chosen_tab'])) {
            $chosen_tab = $_POST['chosen_tab'];
        }
        else {
            $chosen_tab = 'diagnostic';
        }
    
        // Header
        echo '
            <div id="header">
                <form method="POST" action="admin.php" enctype="multipart/form-data">
                    <button type="submit" class="btn btn-primary" name="chosen_tab" value="diagnostic">Diagnóstico</button>
                    <button type="submit" class="btn btn-primary" name="chosen_tab" value="upload">Subida</button>
                    <button type="submit" class="btn btn-primary" name="chosen_tab" value="categories">Categorías</button>
                </form>
            </div>
        ';
    
        // Body
        switch ($chosen_tab) {
            case 'diagnostic':
                echo 'DIAGNOSTICO';
                break;
                
                case 'upload':
                echo 'SUBIDA';
                break;
            
            case 'categories':
                echo 'CATEGORIAS';
                break;
            
            default:
                echo 'ERROR';
                break;
        }
    
        // Footer
        echo '
            <div id="footer">
                <span>Developed by Sergio Díez García</span>
                <form method="POST" action="session_end.php" enctype="multipart/form-data">
                    <input type="hidden" name="called" value="1">
                    <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                </form>
            </div>
        ';
    }  
?>    