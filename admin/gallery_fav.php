<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

$mode = 1;
if (isset($_GET["mode"])){
    $mode = $_GET["mode"];
}
$set_mode = 0;
if ($mode == 0){
    $set_mode = 1;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gallery Favouriting</title>
    <link href='/css/style.css' rel='stylesheet' type='text/css' />
    <link href='/css/admin.css' rel='stylesheet' type='text/css' />
    <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>
<body>

<div id="page-wrapper">

<?php
    $conn = db_conn_read_only();
    $renders = get_gallery_renders($conn);
    foreach ($renders as $r){
        if (($mode == "1" and $r['favourite']) or ($mode == "0" and !$r['favourite'])) {
            $src = "/files/gallery/L/".$r['file_name'];
            $id = $r['id'];
            echo "<div class='gallery-fav'>";
            echo "<img src=\"".$src."\">";
            echo "<a href=\"gallery_fav_mod.php?id=".$id."&mode=".$set_mode."\" target='_blank'>";
            if ($set_mode == "1"){
                echo "<i class='fa fa-heart'></i>";
            }else{
                echo "<i class='fa fa-trash'></i>";
            }
            echo "</a>";
            echo "</div>";
        }
    }
?>

</div>

</body>
</html>
