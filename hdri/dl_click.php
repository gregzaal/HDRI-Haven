<?php

// Track which HDRI was downloaded and at what resolution - for statistical purposes.
// IP addresses are stored (after obfuscation) so that we can count the number of unique downloads of an HDRI,
// ignoring the same person downloading different resolutions of the same HDRI

include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

if(isset($_POST['id']) and isset($_POST['res'])){
    $id = $_POST['id'];
    $res = $_POST['res'];

    $conn = db_conn_read_write();

    // Main download_counting table
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        // Use original IP instead of Cloudflare node IP
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $ip_hash = simple_hash($_SERVER['REMOTE_ADDR']);
    $sql = "INSERT INTO download_counting (`ip`, `hdri_id`, `res`) ";
    $sql .= "VALUES (\"".$ip_hash."\", \"".$id."\", \"".$res."\")";

    // HDRI table
    $sql .= "; ";
    $sql .= "UPDATE hdris SET download_count=download_count+1 WHERE id='".$id."'";
    $result = mysqli_multi_query($conn, $sql);
}

?>
