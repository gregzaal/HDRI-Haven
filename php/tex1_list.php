<?php

include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_top.php');

$hdris = get_from_db();
$a = [];
foreach ($hdris as $h){
    array_push($a, "https://hdrihaven.com/hdri/?h=".$h['slug']);
}
echo implode(',', $a);

include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_bottom.php');

?>