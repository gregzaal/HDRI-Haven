<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Contributor Earnings");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

// Parameters
// Defaults:
$Y = date("Y");
$M = date("m");
$T = 0;  // Actual income for HDRI contributors that month, in USD cents. Optional.

// Get params (if they were passed)
if (isset($_GET["y"]) && trim($_GET["y"])){
    $Y = $_GET["y"];
}
if (isset($_GET["m"]) && trim($_GET["m"])){
    $M = $_GET["m"];
}
if (isset($_GET["t"]) && trim($_GET["t"])){
    $T = $_GET["t"];
}

$Y = htmlspecialchars($Y);
$M = htmlspecialchars($M);
$T = htmlspecialchars($T);

$date_str = $Y.'/'.str_pad($M, 2, '0', STR_PAD_LEFT);
$from_date = $Y.'/'.$M.'/01';
$to_date = $Y.'/'.($M+1).'/01';
$sql = "SELECT * FROM `hdris` WHERE date_published >= \"".$from_date."\" and date_published < \"".$to_date."\"";
$conn = db_conn_read_only();
$result = mysqli_query($conn, $sql);
$array = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $array[$row['name']] = $row;
    }
}

echo '<div id="page-wrapper" class="contrib-earnings-page">';
echo '<h1>Earnings for '.$date_str.'</h1>';

$weight_mods = [
    'backplates' => 1.3,
    'problem' => 0.8,
];
echo "<p>Earnings for each HDRI are weighted based on their quality:</p>";
echo "<ul>";
echo "<li>HDRIs that meet the standard on the site (16k resolution, no clipping, minimal artifacts) are weighted the default 1.0.</li>";
echo "<li>HDRIs with some kind of issue (e.g. lower resolution or clipped), but are otherwise worth publishing are weighted ".$weight_mods['problem'].".</li>";
echo "<li>HDRIs that also include backplates are weighted ".$weight_mods['backplates'].".</li>";
echo "</ul>";

$author_total_weights = [];
$any_prepaid = false;
echo "<h2>HDRIs published this month:</h2>";
echo "<table cellspacing=0>";
echo "<tr>";
echo "<th>HDRI</th>";
echo "<th>Date Published</th>";
echo "<th>Author</th>";
echo "<th>Problem</th>";
echo "<th>Backplates</th>";
echo "<th>Weight</th>";
echo "</tr>";
foreach ($array as $h){
    $a = $h['author'];
    $weight = 1;
    if ($h['problem']){
        $weight = $weight * $weight_mods['problem'];
    }
    if ($h['backplates']){
        $weight = $weight * $weight_mods['backplates'];
    }
    if (array_key_exists($a, $author_total_weights)){
        $author_total_weights[$a] = $author_total_weights[$a] + $weight;
    }else{
        $author_total_weights[$a] = $weight;
    }
    echo "<tr>";
    echo "<td><a href=\"/hdri/?h=".$h['slug']."\">".$h['name']."</a>";
    if ($h['prepaid']){
        $any_prepaid = true;
        echo "**";
    }
    echo "</td>";
    echo "<td>".date("d F Y", strtotime($h['date_published']))."</td>";
    echo "<td>".$a."</td>";
    echo "<td>".$h['problem']."</td>";
    echo "<td>".($h['backplates']==1 ? "Yes" : "")."</td>";
    echo "<td>".$weight."</td>";
    echo "</tr>";
}
echo "</table>";


echo "<h2>Author Weights:</h2>";
$max_weight = array_sum($author_total_weights);
echo "<table cellspacing=0>";
echo "<tr>";
echo "<th>Author</th>";
echo "<th>Total Weight (".$max_weight.")</th>";
echo "<th>Percentage</th>";
if ($T != 0){
    echo "<th>Earnings<sup>*</sup></th>";
}
echo "</tr>";
foreach (array_keys($author_total_weights) as $a){
    $aw = $author_total_weights[$a];
    $p = round($aw/$max_weight*100, 2);
    echo "<tr>";
    echo "<td>".$a."</td>";
    echo "<td>".$aw."</td>";
    echo "<td>".$p."%</td>";
    if ($T != 0){
        echo "<td>$".round($p/100/100*$T, 2)."</td>";
    }
    echo "</tr>";
}
echo "</table>";

if ($T != 0){
    echo "<p>";
    echo "<sup>* Earnings shown may not be accurate as the values displayed are derrived from parameters in the URL. Check the finance reports for exact values. However, the ratios between earnings are correct.</sup>";
    echo "</p>";
}
if ($any_prepaid){
    echo "<p>";
    echo "<sup>** This HDRI was paid for up-front, but is still shown here to take part in the calculations for other HDRIs.</sup>";
    echo "</p>";
}

echo '</div>';
?>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
