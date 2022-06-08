<?php 
    require_once "../model/classes.php";
    require_once "../model/database.php";
echo '
    <h1 class="mb-3">Diagnóstico del servidor</h1>
    <form method="POST" action="../controller/diagnostic.php" enctype="multipart/form-data">
    ';
    $file = file_get_contents("/stupify/diagnostic.json");
    $diag = Diagnostic::fromJSON($file);

    $dateDiag = date_create_from_format('U', intval($diag->timestamp));
    $dateNow = date_create_from_format('U', time());
    $diff = (array) date_diff($dateDiag, $dateNow);
    
    echo '
    <div class="row mb-4">
        <div class="col mb-3">
            <button type="submit" name="submit" value="1" class="btn btn-primary">Realizar diagnóstico</button>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col mb-3">
            Último diagnóstico hace <span class="fw-bold">'.dateDifferenceToText($diff).'.</span>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col mb-3">
            <div>
                <span class="fw-bold me-1">Estado del servidor apache:</span>
                <span class="text-'.($diag->apache_status == "active" ? "success" : "danger").'">'.$diag->apache_status.'</span>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col mb-3">
            <div >
                <span class="fw-bold me-1">IP privada del servidor:</span>
                <span>'.$diag->private_ip.'</span>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-3 mb-3">
            <div>
                <span class="fw-bold me-1">IP pública del servidor:</span>
                <span>'.$diag->public_ip.'</span>
            </div>
        </div>
        <div class="col-3 mb-3">
            <div>
                <span class="fw-bold me-1">IP pública en la BDD:</span>
                <span>'.$db->getServerIp().'</span>
            </div>
        </div>
        <div class="col-3 mb-3">
            <div>
        '.
        ($diag->public_ip == $db->getServerIp() ? 
        '<span class="text-success">Las IP\'s coinciden</span>' : 
        '<span class="text-danger">Las IP\'s no coinciden</span>
            <input type="hidden" name="newIp" value="'.$diag->public_ip.'"/>
            </div>
        </div>
        <div class="col-3 mb-3">
            <div>
            <button type="submit" name="submit" value="2" class="btn btn-primary">Sincronizar IP con la BDD</button>
        ').'
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col mb-3">
            <div >
                <span class="fw-bold me-1">Nº de canciones alojadas:</span>
                <span>'.count($db->getSongs()).'</span>
            </div>
        </div>
    </div>
    ';
    
    echo '
    </form>
    ';

?>