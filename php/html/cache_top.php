<?php
// Based on the method from catswhocode.com (http://goo.gl/tuulz9)
global $cachefile;
// cachefile will be named ######_[file_name]_cached.html
$cachefile = $_SERVER['DOCUMENT_ROOT'].'/php/cache/'.md5("$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]").'_'.str_replace('.php', '', str_replace('/', '', $_SERVER['PHP_SELF'])).'_cached.html';

$cachetime = 60;  // How many minutes before the cache is invalid
$cachetime *= 60;  // convert to seconds

if ($GLOBALS['WORKING_LOCALLY']){
    $cachetime = 0;  // Don't cache if working locally
}

if (file_exists($cachefile)) {
    // Serve from the cache if it is younger than $cachetime
    if (time() - $cachetime < filemtime($cachefile)){
        echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
        include($cachefile);
        exit;
    }else{
        // Delete old cache file
        unlink($cachefile);
    }
}
ob_start(); // Start the output buffer
?>
