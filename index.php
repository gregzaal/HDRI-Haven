<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("HDRI Haven");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id='landing-banner-wrapper'>
    <div id='banner-img-a'>
        <div class='banner-img-credit'>Render by <a href="http://mondlicht-studios.de/">Mondlicht Studios</a></div>
    </div>
    <div id='banner-img-b' class='hide'>
        <div class='banner-img-credit'></a></div>
    </div>
    <div id='banner-img-paddle-l' class='banner-img-paddle'><i class="material-icons">keyboard_arrow_left</i></div>
    <div id='banner-img-paddle-r' class='banner-img-paddle'><i class="material-icons">keyboard_arrow_right</i></div>


    <div id='banner-title-wrapper'>
        <img src="/core/img/HDRI Haven Logo.svg" id="banner-logo" />
        <p>100% Free HDRIs, for Everyone.</p>
    </div>
</div>

<div id='landing-page'>

    <div class="segment-b">
        <div class="segment-inner">
            <div class="col-2">
                <h1>100% Free</h1>
                <p>All HDRIs are licenced as <b>CC0</b> and can be downloaded instantly, giving you complete freedom.</p>
                <p>No paywalls, email forms or account systems.</p>
                <a href="/p/license.php">
                    <div class='button'>Read More</div>
                </a>
            </div>

            <div class="col-2">
                <h1>16k, Unclipped</h1>
                <p>"Free" and "quality" don't always have to be mutually exclusive.</p>
                <p>The HDRIs here are some of the best you'll find, giving you crispy shadows, reflections and backgrounds.</p>
                <a href="http://adaptivesamples.com/2016/02/23/what-makes-good-hdri/">
                    <div class='button'>Read more</div>
                </a>
            </div>
        </div>
    </div>

    <div class="segment-a">
        <div class="segment-inner">

            <h1>Supported by you<img src="/files/site_images/icons/heart.svg" class='heart'></h1>
            <div class="col-2">
                <h2 class="patreon-stat" id="patreon-num-patrons"><?php echo sizeof($GLOBALS['PATRON_LIST']) ?> patrons</h2>
            </div>
            <div class="col-2">
                <h2 class="patreon-stat" id="patreon-income">$<?php echo $GLOBALS['PATREON_EARNINGS'] ?> per month</h2>
            </div>

            <div class='patreon-bar-wrapper'>
                <div class="patreon-bar-outer">
                    <div class="patreon-bar-inner-wrapper">
                        <div class="patreon-bar-inner" style="width: <?php echo $GLOBALS['PATREON_CURRENT_GOAL']['completed_percentage'] ?>%"></div>
                    </div>
                </div>
                <div class="patreon-current-goal">Current goal: <b><?php
                    echo goal_title($GLOBALS['PATREON_CURRENT_GOAL']);
                    echo " ($";
                    echo $GLOBALS['PATREON_CURRENT_GOAL']['amount_cents']/100;
                    echo ")";
                ?></b><i class="material-icons hide-mobile">arrow_upward</i></div>
            </div>

            <div class="text-block">
                <p>Creating HDRIs is expensive. Camera equipment and travel costs are notoriously high, but there are also the day-to-day costs of running this site, serving huge HDR files to thousands of users.</p>
                <p>This is where you come in. With your support, not only can we keep HDRI Haven alive and running, but <b>we can improve it.</b> Higher resolution HDRIs, more of them, more often, and in more interesting places.</p>
                <p>Not only can you contribute financially, but you can get directly involved in the process, helping decide what HDRIs I shoot, where I travel and ultimately how your money is spent (verified by <a href="/p/finance-reports.php" target="_blank">monthly finance reports</a>).</p>
            </div>

            <a href="https://polyhaven.com/support-us" target="_blank">
                <div class='button-inline'>Read More / Become a Patron<img src="/files/site_images/icons/heart.svg" class='heart-inline'></div>
            </a>
        </div>
    </div>

    <?php
    $conn = db_conn_read_only();
    $comm_sponsors = get_commercial_sponsors($conn);
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

    <div class="segment-montage">
        <div class="segment-montage-hover"></div>
        <a href="/hdris">
            <div class='button'>Browse 200+ HDRIs</div>
        </a>
    </div>

    <div class="segment-a">
        <div class="segment-inner segment-about">
            <h1>About</h1>
            <img class='me' src="/files/site_images/me_256.jpg">
            <p>
                Hi there! My name is Greg Zaal, and I'm a CG artist and Open Source advocate.
            </p>
            <p>
                HDRI Haven is my little site where you can find high quality HDRIs for free, no catch.
            </p>
            <p>
                All HDRIs here are <a href="/p/license.php">CC0</a> (public domain). No paywalls, accounts or email spam. Just download what you want, and use it however.
            </p>
            <p>
                If you like what I do and want to keep this site alive, consider <a href="https://polyhaven.com/support-us">supporting me on Patreon</a>.
            </p>
            <p>
                I also help run HDRI Haven's two sister sites: <a href="https://texturehaven.com/">Texture Haven</a> and <a href="https://3dmodelhaven.com/">3D Model Haven</a>.
            </p>
        </div>
        <div style="clear: both"></div>
    </div>

</div>  <!-- #landing-page -->

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
