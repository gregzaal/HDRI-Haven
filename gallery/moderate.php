<?php

if(!isset($_GET['h'])){
    header("Location: /gallery");
}
if(!isset($_GET['d'])){
    header("Location: /gallery");
}
if(!isset($_GET['f'])){
    header("Location: /gallery");
}
if(!isset($_GET['u'])){
    header("Location: /gallery");
}

include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Moderate Render Submission");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

$hash = $_GET['h'];
$hash = preg_replace("/[^A-Za-z0-9]/", '', $hash);;  // For some reason a carriage return sneaks into the hash sometimes?
$decision = $_GET['d'];
$hdri_used = $_GET['u'];
$favourite = $_GET['f'];

$conn = db_conn_read_write();
$renders = get_gallery_renders(true, $conn);
if (in_array($hash, array_column($renders, 'hash'))){
    $file_name = "";
    foreach($renders as $r){
        if ($hash == $r['hash']){
            $file_name = $r['file_name'];
            break;
        }
    }
    $old_fp = $GLOBALS['SYSTEM_ROOT']."/files/gallery/upload/".$file_name;
    $file_name = str_replace(".png", ".jpg", $file_name);
    $file_name = str_replace(".PNG", ".jpg", $file_name);
    $new_fp_L = $GLOBALS['SYSTEM_ROOT']."/files/gallery/L/".$file_name;
    $new_fp_S = $GLOBALS['SYSTEM_ROOT']."/files/gallery/S/".$file_name;

    if ($decision == "y"){
        $sql = "UPDATE gallery SET approval_pending=0, file_name=\"".$file_name."\", favourite=".$favourite.", hdri_used=\"".$hdri_used."\" WHERE hash=\"".$hash."\"";
        resize_image($old_fp, $new_fp_L, "jpg", 1920, 1080);
        resize_image($old_fp, $new_fp_S, "jpg", 1000, 400);
    }else{
        $sql = "DELETE FROM gallery WHERE hash=\"".$hash."\"";
    }
    $result = mysqli_query($conn, $sql);


    echo '<div id="page-wrapper">';
    echo '<h1>Moderation</h1>';

    if ($decision == "y"){
        echo "<p>Approved</p>";
    }else{
        echo "<p>Rejected</p>";
    }

    if ($result == 1){
        echo "<p>SQL success</p>";
        unlink($old_fp);  // Delete uploaded image
    }else{
        echo "<p>SQL FAILED!</p>";
    }

    echo '</div>';

}else{
    echo "<p>nope</p>";
}


include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
