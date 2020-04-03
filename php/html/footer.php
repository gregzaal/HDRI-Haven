</div>  <!-- #push-footer -->
<?php
echo "<div id='footer'";
if (starts_with($_SERVER['REQUEST_URI'], "/hdris/")){
    echo " class='footer-cat'";
}
echo ">";
?>
    <div class='footer-patrons'>
        <h2>Patrons</h2>
        <div class="patron-list">
            <?php
            foreach ($GLOBALS['PATRON_LIST'] as $p){
                echo "<span class='patron patron-rank-".$p[1]."'>".$p[0]."</span> ";
            }
            ?>
        </div>

        <?php
        $comm_sponsors = get_commercial_sponsors(isset($conn) ? $conn : NULL);
        if (!empty($comm_sponsors)){
            echo "<div class='segment-a'>";
            echo "<div class='segment-inner'>";
            echo "<h2>Also supported by:</h2>";
            echo "<div class='commercial_sponsors'>";
            foreach ($comm_sponsors as $s){
                echo "<a href= \"".$s['link']."\" target='_blank'>";
                echo "<img src=\"/files/site_images/commercial_sponsors/";
                echo $s['logo'];
                echo "\" alt=\"";
                echo $s['name'];
                echo "\" title=\"";
                echo $s['name'];
                echo "\"/>";
                echo "</a>";
            }
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>

        <a href="https://www.patreon.com/hdrihaven/overview">
            <div class="button-red">
                Join the ranks, support HDRI Haven on Patreon.
            </div>
        </a>
    </div>

    <div class='social'>
        <a href="https://www.facebook.com/hdrihaven/"><img src="/files/site_images/icons/facebook.svg"></a>
        <a href="https://twitter.com/HDRIHaven"><img src="/files/site_images/icons/twitter.svg"></a>
        <a href="https://discord.gg/Dms7Mrs"><img src="/files/site_images/icons/discord.svg"></a>
    </div>

    <ul class='footer-links'>
        <li><a href="/">Home</a></li>
        <li><a href="/p/about-contact.php">About</a></li>
        <li><a href="/p/about-contact.php">Contact</a></li>
        <li><a href="/p/license.php">License</a></li>
        <li><a href="/p/privacy.php">Privacy</a></li>
        <li><a href="/p/faq.php">FAQ</a></li>
        <li><a href="/p/finance-reports.php">Finance Reports</a></li>
        <li><a href="https://blog.hdrihaven.com/">Blog</a></li>
        <li><a href="https://github.com/gregzaal/HDRI-Haven">Source</a></li>
        <!-- <li><a href="/p/stats.php">Stats</a></li> -->
    </ul>
</div>
