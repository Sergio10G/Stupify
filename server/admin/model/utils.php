<?php 

function songHasCategory($songId, $songCats, $categoryId) {
    $hasCategory = false;
    foreach ($songCats as $key => $songCat) {
        if ($songCat->catId == $categoryId && $songCat->songId == $songId) {
            $hasCategory = true;
            break;
        }
    }
    return $hasCategory;
}

function returnBiggestNumber(array $list) {
    if ($list === null || count($list) == 0) {
        return null;
    }
    $cur_biggest = intval($list[0]);
    foreach ($list as $num) {
        if (intval($num) > $cur_biggest) {
            $cur_biggest = intval($num);
        }
    }
    return $cur_biggest;
}

function dateDifferenceToText(array $diff) {
    $formattedOut = "";
    $outs = [];
    
    if ($diff['y'] != 0) {
        $out = $diff['y']." año";
        if ($diff['y'] > 1) {
            $out .= "s";
        }
        array_push($outs, $out);
    }
    if ($diff['m'] != 0) {
        $out = $diff['m']." mes";
        if ($diff['m'] > 1) {
            $out .= "es";
        }
        array_push($outs, $out);
    }
    if ($diff['d'] != 0) {
        $out = $diff['d']." día";
        if ($diff['d'] > 1) {
            $out .= "s";
        }
        array_push($outs, $out);
    }
    if ($diff['h'] != 0) {
        $out = $diff['h']." hora";
        if ($diff['h'] > 1) {
            $out .= "s";
        }
        array_push($outs, $out);
    }
    if ($diff['i'] != 0) {
        $out = $diff['i']." minuto";
        if ($diff['i'] > 1) {
            $out .= "s";
        }
        array_push($outs, $out);
    }
    if ($diff['s'] != 0) {
        $out = $diff['s']." segundo";
        if ($diff['s'] > 1) {
            $out .= "s";
        }
        array_push($outs, $out);
    }

    $i = 0;
    $count = count($outs);
    foreach ($outs as $out) {
        $formattedOut .= $out;
        if ($i == $count - 2) {
            $formattedOut .= " y ";
        }
        else if ($i < $count - 1) {
            $formattedOut .= ", ";
        }
        $i++;
    }
    return $formattedOut;
}

?>