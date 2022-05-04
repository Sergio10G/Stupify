<?php
$categories = $db->getCategories();

echo '
<h1 class="mb-3">Listado de categorías</h1>
<form method="POST" action="../controller/insert_category.php" enctype="multipart/form-data">
    <label class="form-label">Introducir nueva categoría</label>
    <div class="row mb-3">
        <div class="col">
            <div class="mb-3">
                <input type="text" class="form-control" name="category" placeholder="Categoría" required>
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <button type="submit" class="btn btn-success" name="submit" value="1">Introducir     categoría</button>
            </div>
        </div>
    </div>
</form>
<form method="POST" action="../controller/modify_category.php" enctype="multipart/form-data" id="form-categories">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">id</th>
            <th scope="col">Categoría</th>
            <th scope="col">Canciones</th>
            <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody>
';
foreach ($categories as $category) {
    echo '
    <tr>
        <th scope="row">'.$category->id.'</th>
        <td>'.$category->category.'</td>
        <td><button type="submit" class="btn btn-primary" name="submit" value="0-'.$category->id.'">Añadir canciones</button></td>
        <td><button type="submit" class="btn btn-danger" name="submit" value="1-'.$category->id.'">Eliminar</button></td>
    </tr>
    ';
}
echo '
        </tbody>
    </table>
</form>
';
?>