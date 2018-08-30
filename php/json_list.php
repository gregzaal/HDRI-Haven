<?php

include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_top.php');

$hdris = get_from_db();
$json = array();
foreach ($hdris as $h){
    $t = $h['tags'].";".$h['categories'];
    $json[$h['slug']] = $t;
}

echo json_encode($json, JSON_PRETTY_PRINT);

include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_bottom.php');

?>
