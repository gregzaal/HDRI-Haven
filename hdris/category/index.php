<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

// Parameters
// Defaults:
$sort = "popular";
$search = "all";
$category = "all";
$author = "all";

// Get params (if they were passed)
if (isset($_GET["o"]) && trim($_GET["o"])){
    $sort = $_GET["o"];
}
if (isset($_GET["s"]) && trim($_GET["s"])){
    $search = $_GET["s"];
}
if (isset($_GET["c"]) && trim($_GET["c"])){
    $category = $_GET["c"];
}
if (isset($_GET["a"]) && trim($_GET["a"])){
    $author = $_GET["a"];
}

$sort = htmlspecialchars($sort);
$search = htmlspecialchars($search);
$category = htmlspecialchars($category);
$author = htmlspecialchars($author);

include_start_html("HDRIs: ".nice_name($category, "category"));
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

$conn = db_conn_read_write();

track_search($search, $category, $reuse_conn=NULL)
?>

<div id="sidebar-toggle"><i class="material-icons">apps</i></div>

<div id="sidebar">
    <div class="sidebar-inner">
        <h3>Categories</h3>
        <?php
        make_category_list($sort, $conn, $category);
        ?>
    </div>
</div>

<div id="hdri-grid-wrapper">
    <?php 
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
    
    include ($_SERVER['DOCUMENT_ROOT'].'/hdris/category/grid_options.php');

    echo "</div>";  // .title-bar

    echo "<div id='hdri-grid'>";
    echo make_hdri_grid($sort, $search, $category, $author, $conn, 0);
    echo "</div>"
    ?>
</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
