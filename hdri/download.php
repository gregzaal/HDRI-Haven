<?php 
// If parameter is not recieved, redirect to home
if (count($_GET) == 0){
    header( "Location: /hdris/" );
}

include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

if (isset($_GET["h"]) && trim($_GET["h"])){
    $slug = $_GET["h"];
}else {
    header("Location: /hdris/");
}
if (isset($_GET["r"]) && trim($_GET["r"])){
    $res = $_GET["r"];
}else{
    // Default to 1k
    $res = "1k";
}

$slug = htmlspecialchars($slug);
$res = htmlspecialchars($res);

$conn = db_conn_read_write();
$info = get_item_from_db($slug, $conn);
$ext = $info['ext'];

// Redirect to search if the HDRI is not in the DB.
if (sizeof($info) <= 1){
    header("Location: /hdris/category/?s=".$slug);
}

increment_download_count($info['id'], $res, $conn);

include_start_html("Downloading: {$info['name']}");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

echo "<div id='page-wrapper'>";
echo "<h1>Downloading: <b>{$slug}_{$res}.{$ext}</b> ...</h1>";

$filename = $slug."_".$res.".".$ext;
$url = "/files/hdris/{$filename}";
echo '<p>Your download should be starting now - if not, try this <a href="'.$url.'" download="'.$filename.'">direct link</a>.</p>';
echo '<iframe width="1" height="1" frameborder="0" src="'.$url.'"></iframe>';

echo "</div>";
?>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
 
