<?php 

function songHasCategory($songId, $songCats, $categoryId) {
    $hasCategory = false;
    foreach ($songCats as $key => $songCat) {
        if ($songCat->catId == intval($categoryId) && $songCat->songId == $songId) {
            $hasCategory = true;
            break;
        }
    }
    return $hasCategory;
}

?>