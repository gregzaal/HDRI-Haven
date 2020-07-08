<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add HDRI</title>
    <link href='/css/style.css' rel='stylesheet' type='text/css' />
    <link href='/css/admin.css' rel='stylesheet' type='text/css' />
    <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="new_hdri.js"></script>
</head>
<body>

<div id="page-wrapper">
<div id="page" class="center-all">

<?php

$conn = db_conn_read_write();  // Create Database connection first so we can use `mysqli_real_escape_string`

$name = mysqli_real_escape_string($conn, $_POST["name"]);
$author = mysqli_real_escape_string($conn, $_POST["author"]);
$fileformat = mysqli_real_escape_string($conn, $_POST["fileformat"]);
$slug = $_POST["slug"];

if (!empty($_FILES['colorchart']['name'])) {
    $ext = strtolower(pathinfo(basename($_FILES['colorchart']['name']),PATHINFO_EXTENSION));
    $target_file = join_paths($GLOBALS['SYSTEM_ROOT'], "files", "colorcharts", $slug.".".$ext);
    $tmp_file = $_FILES['colorchart']['tmp_name'];
    move_uploaded_file($tmp_file, $target_file);
}

$sql_fields = [];
$sql_fields['name'] = $name;
$sql_fields['author'] = $author;
$sql_fields['ext'] = $fileformat;
$sql_fields['slug'] = $slug;
function format_tagcat($s, $conn){
    $s = trim(str_replace(",", ";", str_replace(", ", ";", $s)), ",");
    return mysqli_real_escape_string($conn, $s);
}
$categories = format_tagcat($_POST["cats"], $conn);
$sql_fields['categories'] = $categories;
$sql_fields['tags'] = format_tagcat($_POST["tags"], $conn);
$sql_fields['date_taken'] = $_POST["date_taken"];
$sql_fields['problem'] = $_POST["problem"];
$sql_fields['timezone_offset'] = $_POST["timezone_offset"];
$sql_fields['coords'] = $_POST["coords"];
if (isset($_POST['backplates'])) {
    echo "backplates: ";
    echo $_POST['backplates'];
    echo "<br>";
    $sql_fields['backplates'] = "1";
}
$sql_fields['whitebalance'] = $_POST["whitebalance"];

$date_published = $_POST["date_published"];
if ($date_published != "Immediately"){
    $sql_fields['date_published'] = $_POST["date_published"];
}

// Dynamic range calculation
$dr_d_shutter = $_POST['dr_d_shutter'];
$dr_l_shutter = $_POST['dr_l_shutter'];

if (str_contains($dr_d_shutter, "/")){
    $fraction = explode("/", $dr_d_shutter);
    $dr_d_shutter = $fraction[0]/$fraction[1];
}
if (str_contains($dr_l_shutter, "/")){
    $fraction = explode("/", $dr_l_shutter);
    $dr_l_shutter = $fraction[0]/$fraction[1];
}

$dr_shutter = log($dr_l_shutter/$dr_d_shutter, 2);
$dr_aperture = log($_POST['dr_d_aperture']/$_POST['dr_l_aperture'], 1.41421);
$dr_iso = log($_POST['dr_l_iso']/$_POST['dr_d_iso'], 2);
$dr_filter = $_POST['dr_d_filter'] - $_POST['dr_l_filter'];

$dr_total = $dr_shutter + $dr_aperture + $dr_iso + $dr_filter;
$sql_fields['evs_cap'] = round($dr_total);

// XXX
// echo "<pre>";
// print_r($sql_fields);
// echo "</pre>";

foreach (array_keys($sql_fields) as $k){
    $sql_fields[$k] = "'".$sql_fields[$k]."'";
}
$sql_value_str = implode(", ", array_values($sql_fields));
$sql_field_str = implode(", ", array_keys($sql_fields));

$sql = "INSERT INTO hdris (".$sql_field_str.") VALUES (".$sql_value_str.")";

// XXX
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo $sql;
$result = mysqli_query($conn, $sql);

if ($result == 1){
    echo "<h1>Success!</h1>";
    echo "<p>";
    echo "<em>".$_POST["name"]."</em> ";  // Use GET instead of $name since $name with apostrophy will show Apostro\'phy instead of Apostro'phy
    echo "successfully added to the database.";
    echo "</p>";
    echo "<p>If you need to edit or update this product, you can do so from the <a href='https://service.byte.nl/phpmyadmin/index.php?server=10160'>phpMyAdmin interface</a>.</p>";

    echo '<a href="/admin" class="no-underline">';
    echo '<div class="button"><i class="fa fa-home" aria-hidden="true"></i> Admin Home</div>';
    echo '</a> ';
    echo '<a href="/admin/new_hdri.php" class="no-underline">';
    echo '<div class="button"><i class="fa fa-plus" aria-hidden="true"></i> Add Another</div>';
    echo '</a> ';
    echo '<a href="https://hdrihaven.com/hdri/?h='.$slug.'" class="no-underline">';
    echo '<div class="button"><i class="fa fa-eye" aria-hidden="true"></i> View This HDRI</div>';
    echo '</a> ';

    // Social Media
    $primary_cats = ["studio", "night", "indoor", "urban", "overcast", "outdoor"];  // In order of preference
    $pcat = "";
    foreach ($primary_cats as $c){
        if (str_contains($categories, $c)){
            $pcat = nice_name($c);
            break;
        }
    }
    $vars = [
        "category" => $pcat,
        "name" => urlencode($name),
        "author" => $author,
        "link" => "https://hdrihaven.com/hdri/?h=".$slug,
    ];
    function format_vars($str, $vars){
        foreach (array_keys($vars) as $v){
            $str = str_replace("##".$v."##", $vars[$v], $str);
        }
        return str_replace("  ", " ", $str);
    }
    $sql_fields = [];
    $sql_fields['name'] = $name;
    $sql_fields['author'] = $author;
    $sql_fields['twitface'] = format_vars(mysqli_real_escape_string($conn, $_POST["twitface"]), $vars);
    $sql_fields['reddit'] = format_vars(mysqli_real_escape_string($conn, $_POST["reddit"]), $vars);
    $sql_fields['link'] = "https://hdrihaven.com/hdri/?h=".$slug;
    $sql_fields['image'] = "https://hdrihaven.com/files/hdri_images/meta/".$slug.".jpg";
    $sql_fields['post_datetime'] = date_format(date_modify(date_create(date("Y-m-d", strtotime($date_published))), "+16 hour"), "Y-m-d H:i:s");
    foreach (array_keys($sql_fields) as $k){
        $sql_fields[$k] = "'".$sql_fields[$k]."'";
    }
    $sql_value_str = implode(", ", array_values($sql_fields));
    $sql_field_str = implode(", ", array_keys($sql_fields));
    $sql = "INSERT INTO social_media (".$sql_field_str.") VALUES (".$sql_value_str.")";
    $result = mysqli_query($conn, $sql);

}else{
    echo "<h1>Submission Failed.</h1>";

    // Check for existing
    $existing_sql = "SELECT * from hdris WHERE slug='".$slug."'";
    $existing_result = mysqli_query($conn, $existing_sql);
    if (mysqli_num_rows($existing_result) > 0){
        echo "<p>There is already a product with the slug <em>".$slug."</em>, maybe you have already added this product?</p>";
        echo "<p>Otherwise go back and choose a different slug.</p>";
    }else{
        echo "<p>Looks like something went wrong :(<br>Here is the generated SQL query to help you figure out the problem:</p>";
        echo "<p>".$sql."</p> ";
    }

    echo '<a href="javascript:history.back()" class="no-underline">';
    echo '<div class="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</div>';
    echo '</a> ';
    echo '<a href="javascript:window.location.href=window.location.href" class="no-underline">';
    echo '<div class="button"><i class="fa fa-refresh" aria-hidden="true"></i> Try Again</div>';
    echo '</a> ';
}

?>

</div>
</div>

</body>
</html>
