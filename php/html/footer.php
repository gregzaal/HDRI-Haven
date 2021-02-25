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
        insert_commercial_sponsors($heading="Also supported by:", $reuse_conn=(isset($conn) ? $conn : NULL));
        ?>

        <a href="https://polyhaven.com/support-us">
            <div class="button-red">
                Join the ranks, support HDRI Haven on Patreon.
            </div>
        </a>
    </div>

    <div class='social'>
        <a href="https://polyhaven.com/facebook"><img src="/core/img/icons/facebook.svg"></a>
        <a href="https://polyhaven.com/twitter"><img src="/core/img/icons/twitter.svg"></a>
        <a href="https://discord.gg/Dms7Mrs"><img src="/core/img/icons/discord.svg"></a>
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
