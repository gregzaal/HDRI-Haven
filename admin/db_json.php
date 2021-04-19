<?php
include($_SERVER['DOCUMENT_ROOT'] . '/php/functions.php');

$sql = "SELECT * FROM hdris ORDER BY date_published DESC, date_taken ASC";
$conn = db_conn_read_only();
$result = mysqli_query($conn, $sql);
$data = array();
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $data[$row['name']] = $row;
  }
}

$json_data = [];

foreach ($data as $asset) {

  $slug = $asset['slug'];

  $asset['categories'] = explode(';', $asset['categories']);
  $asset['tags'] = explode(';', $asset['tags']);
  $asset['authors'] = [$asset['author'] => "All"];
  $asset['date_published'] = strtotime($asset['date_published']);
  $asset['date_taken'] = strtotime($asset['date_taken']) + (3600 * $asset['timezone_offset']);
  $asset['download_count'] = (int) $asset['download_count'];
  $asset['evs_cap'] = (int) $asset['evs_cap'];
  $asset['old_id'] = (int) $asset['id'];
  $asset['whitebalance'] = (int) $asset['whitebalance'];
  $asset['staging'] = (bool) !$asset['is_published'];
  if ($asset['coords'] && $asset['coords'] != '0') {
    $coords = explode(',', $asset['coords']);
    $asset['coords'] = [(float)(trim($coords[0])), (float)(trim($coords[1]))];
  } else {
    unset($asset['coords']);
  }

  $bool_props = [
    'is_published',
    'nsfw',
    'prepaid',
    'donated',
    'staging'
  ];
  foreach ($bool_props as $p) {
    if ($asset[$p]) {
      $asset[$p] = (bool) $asset[$p];
    } else {
      unset($asset[$p]);
    }
  }
  if (!$asset['whitebalance']) {
    unset($asset['whitebalance']);
  }

  unset($asset['id']);
  unset($asset['author']);
  unset($asset['size_1k']);
  unset($asset['size_2k']);
  unset($asset['size_4k']);
  unset($asset['size_8k']);
  unset($asset['size_16k']);
  unset($asset['vault']);
  unset($asset['slug']);
  unset($asset['evs_full']);
  unset($asset['is_published']);
  unset($asset['ext']);
  unset($asset['backplates']);
  unset($asset['problem']);
  unset($asset['timezone_offset']);

  $json_data[$slug] = $asset;
}



print_ra(json_encode($json_data, JSON_PRETTY_PRINT));

if ($GLOBALS['WORKING_LOCALLY']) {
  file_put_contents("Y:/Poly Haven/polyhaven.com/pages/db_json_hdris.json", json_encode($json_data, JSON_PRETTY_PRINT));
}
