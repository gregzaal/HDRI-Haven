<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

// Parameters
// Defaults:
$sort = "popular";
$search = "all";
$category = "all";
$author = "all";

// Get params (if they were passed)
$none_set = true;
if (isset($_GET["o"]) && trim($_GET["o"])){
    $sort = $_GET["o"];
    $none_set = false;
}
if (isset($_GET["s"]) && trim($_GET["s"])){
    $search = $_GET["s"];
    $none_set = false;
}
if (isset($_GET["c"]) && trim($_GET["c"])){
    $category = $_GET["c"];
    $none_set = false;
}
if (isset($_GET["a"]) && trim($_GET["a"])){
    $author = $_GET["a"];
    $none_set = false;
}

$sort = htmlspecialchars($sort);
$search = htmlspecialchars($search);
$category = htmlspecialchars($category);
$author = htmlspecialchars($author);

$canonical = "https://hdrihaven.com/hdris/?";
$canonical .= "c=".$category;
if ($author != "all"){
    $canonical .= "&a=".$author;
}
if ($search != "all"){
    $canonical .= "&s=".$search;
}
include_start_html("HDRIs: ".nice_name($category, "category"), "", $canonical, "");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

$conn = db_conn_read_only();

$ads_testing = rand(1, 2);  // A/B testing for ad placement
?>

<div id="sidebar-toggle"><i class="material-icons">apps</i></div>

<div id="sidebar" <?php if($ads_testing == 2){echo "style='flex-direction:column-reverse'";}?> >
    <div class="sidebar-inner">
        <h3>Categories</h3>
        <?php
        make_category_list($sort, $conn, $category, true);
        ?>
        </div>
</div>

<div id="item-grid-wrapper">
    <?php
    if ($none_set){
        include ($_SERVER['DOCUMENT_ROOT'].'/hdris/grid_banner.php');
    }
    echo "<div class='title-bar'>";
    echo "<h1>";
    if ($search != "all") {
        echo "Search: \"".$search."\"";
        if ($category != "all") {
            echo " in category: ".nice_name($category, "category");
        }
    }else if ($category == "all"){
        echo "All HDRIs";
    }else{
        echo "Category: ".nice_name($category, "category");
    }
    if ($author != "all") {
        echo " by ".$author;
    }
    echo "</h1>";

    include ($_SERVER['DOCUMENT_ROOT'].'/hdris/grid_options.php');

    echo "</div>";  // .title-bar

    echo "<div id='item-grid'>";
    echo make_item_grid($sort, $search, $category, $author, $conn, 0);
    echo "</div>"
    ?>
</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
