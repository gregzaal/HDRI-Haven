<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("About / Contact");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <div class='me-wrapper'>
        <img class='me' src="/files/site_images/me_256.jpg">
    </div>
    <h1>Hi there!</h1>
    <p>My name is Greg Zaal, I'm a CG artist and Open Source advocate.</p>
    <p>I've worked on a few short films, Blender add-ons and training material for sites like <a href="http://cgcookie.com/" target="_blank">CG Cookie</a>, <a href="https://cgmasters.net/training-courses/character-creation-volume-3-5-cycles-convert/" target="_blank">CG Masters</a> and <a href="https://www.blenderguru.com/search?q=greg+zaal" target="_blank">BlenderGuru</a>.</p>
    <p>Other places where you can find info about me:
        <a href="https://www.blendernetwork.org/greg-zaal" target="_blank">Blender Network</a>,
        <a href="http://portfolio.gregzaal.com" target="_blank">Portfolio</a>,
        <a href="http://adaptivesamples.com" target="_blank">Blog</a>,
        <a href="https://twitter.com/gregzaal" target="_blank">Twitter</a>.
    </p>

    <div style="clear: both"></div>

    <h1>About</h1>
    <p>
        HDRI Haven is where you can find high quality HDRIs for free, no catch.
    </p>
    <p>
        All HDRIs here are <a href="/p/license.php">CC0</a> (public domain). No paywalls, accounts or email spam. Just download what you want, and use it however.
    </p>
    <p>
        HDRI Haven is officially linked with <a href="https://texturehaven.com">Texture Haven</a> and <a href="https://3dmodelhaven.com">3D Model Haven</a>.
    </p>

    <h1>Get Involved</h1>
    <p>
        Since all of the income for this site comes from the community, it's only fair that the community gets to decide what happens with it.
    </p>
    <p>
        All Patrons have access to a private Trello board where they can add ideas and vote on new locations, trips, and generally decide where the money goes.
    </p>
    <p>
        If you want to get involved and help keep this site alive at the same time, consider supporting <a href="https://www.patreon.com/hdrihaven/overview">HDRI Haven on Patreon</a>.
    </p>

    <h1>Contact</h1>
    <p>Got a question? Please read the <a href="/p/faq.php">FAQ</a> first :)</p>
    <p>The easiest ways to get hold of me is through email: <?php insert_email() ?></p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
