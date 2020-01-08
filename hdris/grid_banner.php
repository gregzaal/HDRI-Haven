<div id='grid-banner'>
    <div class='segment-a'>
        <div class='segment-inner'>
            <div class='col-4'>
                <img class="grid-banner-icon" src="/core/img/icons/res.svg">
                <h2>16k+</h2>
                <p>That's 134 megapixels, giving you sharp reflections and backgrounds.</p>
            </div>
            <div class='col-4'>
                <img class="grid-banner-icon" src="/files/site_images/icons/sun.svg">
                <h2>Unclipped</h2>
                <p>Up to 26 EVs of dynamic range, producing extremely realistic lighting.</p>
            </div>
            <div class='col-4'>
                <img class="grid-banner-icon" src="/core/img/icons/download.svg">
                <h2>100% Free</h2>
                <p>Download immediately, no account required. <a href="/p/license.php" target="_blank">CC0</a> for complete freedom.</p>
            </div>
            <div class='col-4'>
                <img class="grid-banner-icon" src="/core/img/icons/patreon_logo_red.svg">
                <h2>Supported by You</h2>
                <p><a href="https://www.patreon.com/hdrihaven/overview" target="_blank">Join <?php echo sizeof($GLOBALS['PATRON_LIST']) ?> generous patrons</a> to help us keep making <?php echo $GLOBALS['CONTENT_TYPE_NAME'] ?>.</p>
            </div>
        </div>
    </div>

    <div class='segment-a category-segment'>
        <div class='category-list-images'>
            <ul>
                <?php
                $pop = most_popular_in_each_category($conn);
                $i = 0;
                foreach (array_keys($GLOBALS['STANDARD_CATEGORIES']) as $c){
                    $i++;
                    echo "<a href='/hdris/?c=".$c."'>";
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
</div>
