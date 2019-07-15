</div>  <!-- #push-footer -->
<?php 
echo "<div id='footer'";
if (starts_with($_SERVER['REQUEST_URI'], "/hdris/category/")){
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
        
        <h3>Also supported by:</h3>
        <div class="commercial_sponsors">
            <a href="http://dawid.nz/" target="_blank">
                <img src="/files/site_images/commercial_sponsors/DAWID.NZ_Logo_White.png" />
            </a>
        </div>

        <a href="https://www.patreon.com/hdrihaven/overview">
            <div class="button-red">
                Join the ranks, support HDRI Haven on Patreon.
            </div>
        </a>
    </div>

    <div class='social'>
        <a href="https://www.facebook.com/hdrihaven/"><img src="/files/site_images/icons/facebook.svg"></a>
        <a href="https://twitter.com/HDRIHaven"><img src="/files/site_images/icons/twitter.svg"></a>
        <div id='email-form'>
            <form action='https://gumroad.com/follow_from_embed_form' class='form gumroad-follow-form-embed' method='post'>
                <input name='seller_id' type='hidden' value='798267932401'>
                <input name='email' placeholder='Monthly email updates' type='email'><!--
                --><button data-custom-highlight-color='' type='submit'>Subscribe</button>
            </form>
        </div>
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
