<?php
include($_SERVER['DOCUMENT_ROOT'] . '/php/functions.php');

$sql = "SELECT * FROM sponsors ORDER BY id ASC";
$conn = db_conn_read_only();
$result = mysqli_query($conn, $sql);
$data = array();
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    array_push($data, $row);
  }
}

// $json_data = [];

// foreach ($data as $asset) {

//   $slug = $asset['id'];

//   $json_data[$slug] = $asset;
// }



print_ra(json_encode($data, JSON_PRETTY_PRINT));
