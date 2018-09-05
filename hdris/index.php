<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("HDRIs");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
$conn = db_conn_read_only();
?>

<div id='hdris-landing-page'>
    <div class='segment-a'>
        <div class='segment-inner'>
            <div class='col-4'>
                <img class="hdri-landing-banner-icon" src="/files/site_images/icons/zoom.svg">
                <h2>16k</h2>
                <p>That's 134 megapixels, enough to give you crystal clear reflections and backgrounds.</p>
            </div>
            <div class='col-4'>
                <img class="hdri-landing-banner-icon" src="/files/site_images/icons/sun.svg">
                <h2>Unclipped</h2>
                <p>Up to 26 EVs of dynamic range, producing extremely realistic lighting.</p>
            </div>
            <div class='col-4'>
                <img class="hdri-landing-banner-icon" src="/files/site_images/icons/download.svg">
                <h2>100% Free</h2>
                <p>No sign-up or silly email forms, download immediately. CC0 license for complete freedom.</p>
            </div>
            <div class='col-4'>
                <img class="hdri-landing-banner-icon" src="/files/site_images/icons/patreon_logo.svg">
                <h2>Supported by You</h2>
                <p><a href="https://www.patreon.com/hdrihaven/overview" target="_blank">Join <?php echo sizeof($GLOBALS['PATRON_LIST']) ?> generous patrons</a> and help grow the quality and quantity of HDRIs here.</p>
            </div>
        </div>
    </div>

    <div class='segment-b category-segment'>
        <div class='category-list-images'>
            <ul>
                <?php 
                $pop = most_popular_in_each_category($conn);
                $i = 0;
                foreach (array_keys($GLOBALS['STANDARD_CATEGORIES']) as $c){
                    $i++;
                    echo "<a href='/hdris/category/?c=".$c."'>";
                    echo "<li title=\"".$GLOBALS['STANDARD_CATEGORIES'][$c]."\">";
                    echo "<div class='background-image'";
                    if ($i == 1){
                        echo " id='list-start-pos'";
                    }
                    echo " style=\"background: url(/files/hdri_images/tonemapped/180/".$pop[$c].".jpg) no-repeat center center\"";
                    echo "></div>";
                    echo "<p>".nice_name($c, "category")."</p>";
                    echo "</li>";
                    echo "</a>";
                }
                ?>
                <li id="list-end-pos" style="visibility:hidden"></li>
            </ul>
        </div>
        <div class='fade-gradient-left hide hide-mobile'></div>
        <div class='fade-gradient-right hide-mobile'></div>
        <i class="material-icons hide hide-mobile" id="scroll-cat-left">keyboard_arrow_left</i>
        <i class="material-icons hide-mobile" id="scroll-cat-right">keyboard_arrow_right</i>
    </div>

    <div class="segment-a">
        <h1>Latest HDRIs</h1>
        <div id='hdri-grid'>
        <?php
        echo make_hdri_grid("date_published", "all", "all", "all", $conn, 8);
        ?>
        </div>
        <a href="/hdris/category?c=all">
            <div class='button'>More ></div>
        </a>
    </div>
</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
