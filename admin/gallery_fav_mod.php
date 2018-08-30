<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

$mode = $_GET["mode"];
$id = $_GET["id"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Modify Favourite</title>
    <link href='/css/style.css' rel='stylesheet' type='text/css' />
    <link href='/css/admin.css' rel='stylesheet' type='text/css' />
    <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>
<body>

<div id="page-wrapper">

<?php
    $sql = "UPDATE gallery SET favourite=";
    $sql .= $mode;
    $sql .= " WHERE id=";
    $sql .= $id;
    $conn = db_conn_read_write();
    $result = mysqli_query($conn, $sql);
    echo "<p>Done:<br>fav=".$mode."<br>id=".$id."</p>";
?>

</div>

</body>
</html>
