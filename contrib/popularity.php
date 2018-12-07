<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("HDRI Popularity");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

// Parameters
// Defaults:
$Y = date("Y");
$M = date("m");
$T = 0;  // Total bonus income in USD cents. Optional.
$debug = false;

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
if (isset($_GET["debug"])){
    $debug = true;
}

$Y = htmlspecialchars($Y);
$M = htmlspecialchars($M);

$conn = db_conn_read_only();

$from_date = $Y.'/'.$M.'/01';
$to_date = $Y.'/'.($M+1).'/01';
$sql = "SELECT * FROM `hdris` WHERE date_published >= \"".$from_date."\" and date_published < \"".$to_date."\"";
$result = mysqli_query($conn, $sql);
$hdris_this_month = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $hdris_this_month[$row['name']] = $row;
    }
}

echo '<div id="page-wrapper" class="contrib-earnings-page">';
echo '<h1>HDRI Popularity Ratings</h1>';

$date_str = date("F Y", strtotime($from_date));
echo "<p>This page shows the popularity rating of HDRIs published in <b>{$date_str}</b>.</p>";
echo "<p>The popularity rating* is used to determine the bonus earnings for the author of each HDRI. More popular HDRIs earn the author more income (on top of the base rate).</p>";
echo "<p>The purpose of rewarding more popular HDRIs is to encourage HDRI contributions that are more useful or more wanted by users.</p>";

$rows = [];
$total_popularity = 0;
foreach ($hdris_this_month as $h){
    $row = [
        "slug" => $h['slug'],
        "name" => $h['name'],
        "date_published" => $h['date_published'],
        "author" => $h['author'],
        "backplates" => $h['backplates'],
    ];

    $sql = "SELECT * FROM `download_counting`
            WHERE hdri_id = ".$h['id']." AND
            (`datetime` >= \"".$h['date_published']."\" and `datetime` < DATE_ADD(\"".$h['date_published']."\", INTERVAL 28 DAY))";
    $result = mysqli_query($conn, $sql);

    $all_downloads = array();
    if (mysqli_num_rows($result) > 0) {
        while ($r = mysqli_fetch_assoc($result)) {
            $all_downloads[$r['id']] = $r;
        }
    }
    $known_ips = [];
    $unique_downloads = [];
    foreach ($all_downloads as $d){
        if (!in_array($d['ip'], $known_ips)){
            $unique_downloads[$d['id']] = $d;
            array_push($known_ips, $d['ip']);
        }
    }
    $row['unique_downloads'] = sizeof($unique_downloads);

    if ($debug){
        echo "<a href=\"/hdri/?h=".$h['slug']."\">";
        echo "<h2>".$h['name']."</h2>";
        echo "</a>";
        echo "<div style='
        padding: 0.5em 1em;
        width: calc(100% - 2em);
        '>";
    }
    $days = [];
    foreach ($unique_downloads as $d){
        $day = date("Y-m-d", strtotime($d['datetime']));
        if (in_array($day, array_keys($days))){
            $days[$day] = $days[$day] + 1;
        }else{
            $days[$day] = 1;
        }
    }

    if (sizeof($days) > 1){
        $days_sorted = $days;
        arsort($days_sorted);
        $median = array_values($days_sorted)[round(sizeof($days)*0.5)];
        $min = min(array_values($days));
        $max = max(array_values($days));
        $q1 = array_values($days_sorted)[round(sizeof($days)*0.75)];
        $q3 = array_values($days_sorted)[round(sizeof($days)*0.25)];
        $days_clamped = [];
        foreach (array_keys($days) as $d){
            $v = $days[$d];
            $vc = max(min($days[$d], $q3), $q1);  // Clamped inside IQR
            array_push($days_clamped, $vc);
            if ($debug){
            $bg_color = "black";
            switch(true){
                case $v == $max:
                    $bg_color = "red";
                    break;
                case $v == $min:
                    $bg_color = "blue";
                    break;
                case $v == $median:
                    $bg_color = "green";
                    break;
                case $v >= $q3:
                    $bg_color = "darkred";
                    break;
                case $v <= $q1:
                    $bg_color = "darkblue";
                    break;
            }
                echo "<div style='
                width:".(($v/$max)*100)."%;
                height: 14px;
                background-color: ".$bg_color.";
                margin-bottom: 2px;
                font-size: 12px;
                color: white;
                '>".$d." - ".$days[$d]."</div>";
            }
        }
        $popularity = array_sum($days_clamped) / sizeof($days_clamped);
        if ($h['backplates'] == 1){
            $popularity = $popularity * 1.4;
        }
        $row['popularity'] = $popularity;
        $total_popularity += $popularity;
        if ($debug){
            $old_avg = array_sum(array_values($days)) / sizeof(array_values($days));
            echo $q1." | <b>".$median."</b> | ".$q3."<br>";
            echo "<b>".round($popularity)."</b> (".round($old_avg).")<br>";
            echo "<br></div>";
        }
        array_push($rows, $row);
    }
}
echo "<table cellspacing=0>";
echo "<tr>";
echo "<th>HDRI</th>";
echo "<th>Date Published</th>";
echo "<th>Author</th>";
echo "<th>Unique Downloads**</th>";
echo "<th>Popularity*</th>";
if ($T != 0){
    echo "<th>Bonus</th>";
}
echo "</tr>";
$rows = array_sort($rows, "popularity", SORT_DESC);
$author_earnings = [];
foreach ($rows as $r){
    $age = ((time() - strtotime($r['date_published']))/86400);
    $relative_popularity = $r['popularity']/$total_popularity;
    $earnings = ($T/100)*$relative_popularity;
    if (array_key_exists($r['author'], $author_earnings)){
        $author_earnings[$r['author']] = $author_earnings[$r['author']] + $earnings;
    }else{
        $author_earnings[$r['author']] = $earnings;
    }
    echo "<tr>";
    echo "<td>
    <a href=\"/hdri/?h=".$r['slug']."\">".$r['name']."</a>";
    if ($r['backplates']){
        echo " <abbr title='Includes backplates (+40% popularity)'>+B</abbr>";
    }
    echo "</td>";
    echo "<td>";
    echo date("d F Y", strtotime($r['date_published']));
    if ($age < 28){
        echo " <abbr title='This HDRI is less than 28 days old, popularity has not yet stabilized.'>
        <i class='material-icons' style='color:#F96854'>warning</i>
        <abbr>";
    }
    echo "</td>";
    echo "<td>".$r['author']."</td>";
    echo "<td>".$r['unique_downloads']."</td>";
    echo "<td>".number_format($relative_popularity*100, 2, '.', ' ')."%</td>";
    if ($T != 0){
        echo "<td>$".fmoney($earnings)."</td>";
    }
    echo "</tr>";
}
echo "</table>";

if ($T != 0){
    echo "<h2>Author Totals:</h2>";
    echo "<table cellspacing=0>";
    echo "<tr>";
    echo "<th>Author</th>";
    echo "<th>Bonus</th>";
    echo "</tr>";
    foreach (array_keys($author_earnings) as $a){
        echo "<tr>";
        echo "<td>".$a."</td>";
        echo "<td>$".fmoney($author_earnings[$a])."</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<p><sup>
    * Popularity rating is determined by unique downloads over the first 28 days of the HDRI's publication, with some basic statistical maniplulation to lower the influence of large spikes and troughs in downloads.<br>
    This is to account for inconsistent social media influence, public holidays and server instabilities, and thus attempt to provide a fairer comparison of quality and usefulness between HDRIs.<br>
    Details about the exact calculations can be found in the <a href=\"https://github.com/gregzaal/HDRI-Haven/blob/master/contrib/popularity.php\" target='_blank'>source code</a> for this page.
    </sup></p>";

echo "<p><sup>
    ** Total downloads, counting each IP address only once, over the first 28 days of the HDRI's publication.
    </sup></p>";

echo '</div>';

$conn->close();

include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
