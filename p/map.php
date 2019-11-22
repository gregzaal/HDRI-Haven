<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Map");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id='map'></div>

<script>
    function addMarker(props){
        var marker = L.marker(props.coords).addTo(map);
        marker.bindPopup(props.content).openPopup();
    }
    map = L.map('map');
    L.tileLayer('https://tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
      attribution: '<b style="font-weight:700">Location markers are approximate.</b> Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
      maxZoom: 18,
    }).addTo(map);

    <?php
    $items = get_from_db("date_published");
    $min_lat = 0;
    $max_lat = 0;
    $min_lon = 0;
    $max_lon = 0;
    foreach ($items as $i){
        if ($i['coords'] && $i['coords'] != '0'){
            $coords = explode(",", $i['coords']);
            $lat = trim($coords[0]);
            $lon = trim($coords[1]);
            $html = "<a href='/hdri/?h={$i['slug']}' title='{$i['name']}'>";
            $html .= "<img class='popup' src='/files/hdri_images/thumbnails/{$i['slug']}.jpg'>";
            $html .= "</a>";
            echo "addMarker({\"coords\": [{$lat}, {$lon}], \"content\": \"{$html}\"});";
            $min_lat = min($min_lat, $lat);
            $max_lat = max($max_lat, $lat);
            $min_lon = min($min_lon, $lon);
            $max_lon = max($max_lon, $lon);
        }
    }
    $middle_lat = ($min_lat + $max_lat) / 2;
    $middle_lon = ($min_lon + $max_lon) / 2;
    echo "map.setView([{$middle_lat}, {$middle_lat}], 3);";  // Center view
    ?>
</script>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
