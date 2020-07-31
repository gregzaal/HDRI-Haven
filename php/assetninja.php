<?php

include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_top.php');

$latest_version = "1.1";
$available_versions = [
    "1.0",
    "1.1",
];
$version = $latest_version;
if (isset($_GET["v"]) && trim($_GET["v"])){
    $v = $_GET["v"];
    if (in_array($v, $available_versions)){
        $version = $v;
    }else{
        http_response_code(404);
        echo "Version {$v} not found. Available versions: ";
        echo json_encode($available_versions, JSON_PRETTY_PRINT);
        die();
    }
}

$items = get_from_db();
$json = array();

$json['version'] = $version;
$json['latest_version'] = $latest_version;
$json['last_updated'] = time();

$assets = array();
foreach ($items as $i){
    $slug = $i['slug'];
    $a = array();
    $a['author'] = $i['author'];
    $a['date_published'] = strtotime($i['date_published']);
    $a['license'] = "CC0";

    $tags = $i['tags'].";".$i['categories'];
    $tags = explode(';', $tags);
    $a['tags'] = $tags;

    $files = [];
    $ext = $i['ext'];
    foreach (array_keys($GLOBALS['STANDARD_RESOLUTIONS']) as $r){
        $local_url = join_paths($GLOBALS['SYSTEM_ROOT'], "files", "hdris", $slug.'_'.$r.'.'.$ext);
        if (file_exists($local_url)){
            $url = "https://hdrihaven.com/files/hdris/{$slug}_{$r}.{$ext}";
            if (version_compare($version, '1.1', '>=')) {
                $file = array();
                $file['url'] = $url;
                $file['mtime'] = filemtime($local_url);
                $file['size'] = filesize($local_url);
                array_push($files, $file);
            } else {
                array_push($files, $url);
            }
        }
    }
    $a['files'] = $files;

    $assets[$slug] = $a;
}
$json['assets'] = $assets;

echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_bottom.php');

?>
