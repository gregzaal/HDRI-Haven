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
?>

<div id="sidebar-toggle"><i class="material-icons">apps</i></div>

<div id="sidebar">
    <div class="sidebar-inner">
        <h3>Categories</h3>
        <?php
        make_category_list($sort, $conn, $category, true);
        ?>
        </div>
    <div class="adsense-unit" id="ads-sidebar">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
        style="display:inline-block;width:200px;height:200px"
        data-ad-client="ca-pub-2284751191864068"
        data-ad-slot="4181153207"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    </div>
    <!-- <a href="https://www.patreon.com/hdrihaven" target="_blank"> -->
    <div class="button-inverse-small" id="remove-ads"
    style="display: block; margin: 0; text-align: center; cursor:not-allowed; font-size: 95%"
    title="While we're figuring out ad placement based on Patron feedback, removal of ads is not yet implemented. In future all patrons (from $1 and up) will be able to remove ads."><strike>Remove Ads</strike> <em>Coming soon</em></div>
    <!-- </a> -->
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
