<?php

include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

if(isset($_POST['id'])){
    $conn = db_conn_read_write();
    $sql = "UPDATE gallery SET clicks=clicks+1 WHERE id='".$_POST["id"]."'";
    $result = mysqli_query($conn, $sql);
    if (is_null($reuse_conn)){
        $conn->close();
    }
}

?>
