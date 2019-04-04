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

$filename = $slug."_".$res.".".$ext;
$filepath = $GLOBALS['SYSTEM_ROOT']."/files/hdris/{$filename}";

// Redirect to search if the HDRI is not in the DB.
if (sizeof($info) <= 1){
    header("Location: /hdris/category/?s=".$slug);
}

$canonical = "https://hdrihaven.com/hdri/?h=".$slug;
include_start_html("Downloading: {$info['name']}", "", $canonical, "");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

echo "<div id='page-wrapper'>";

if (file_exists($filepath)){
    increment_download_count($info['id'], $res, $conn);
    echo "<h1>Downloading: <b>{$slug}_{$res}.{$ext}</b> ...</h1>";

    $url = "/files/hdris/{$filename}";
    echo '<p>Your download should be starting now - if not, try this <a href="'.$url.'" download="'.$filename.'">direct link</a>.</p>';
    echo '<iframe width="1" height="1" frameborder="0" src="'.$url.'"></iframe>';
}else{
    echo "<h1>File not found :(</h1>";    
    echo "<p>If there should be something here, please let us know that you're getting this error by emailing ";
    insert_email();
    echo ".</p>";
    echo "<p>Please include the page URL to help us identify the issue:<br>https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]</p>";
}

echo "</div>";
?>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
 
