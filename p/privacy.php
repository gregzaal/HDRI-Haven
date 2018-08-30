<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Privacy");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>Privacy Info</h1>

    <h2>Patron Names in Footer</h2>
    <p>
        The names of all active supporters on Patreon are automatically shown in the footer of every page on this site.
    </p>
    <p>
        If you would like your name removed or changed, please contact me: <?php insert_email() ?>
    </p>

    <h2>IP Logging</h2>
    <p>
        This server logs your IP address when you download an HDRI (after some minor obfuscation).
    </p>
    <p>
        This helps me to see which HDRIs are downloaded the most by letting me track unique downloads (ignoring multiple downloads of the same HDRI) instead of only total downloads, thus helping me see more accurately what is popular and making decisions about what to shoot next.
    </p>
    <p>
        If you're not comfortable with this, you can use a VPN to obscure your public IP address.
    </p>

    <h2>Gallery Clicks</h2>
    <p>
        Clicks on images in the <a href="/gallery">Render Gallery</a> are tracked similarly to HDRI downloads in order to give an indication of popularity and allow me to sort the gallery by most popular images first.
    </p>
    
    <h2>Google Analytics</h2>
    <p>
        This website uses <a href="https://analytics.google.com/analytics/web/">Google Analytics</a> to track users who visit each page, which shows me how the site is performing and some basic demographics such as user locations, language, and browser info.
    </p>
    <p>
        Google likely uses this data in some of their own services and systems such as advertisement targeting and behaviour tracking. You can read more about how they use your data <a href="https://policies.google.com/technologies/partner-sites">here</a>.
    </p>
    <p>
        If you are not comfortable with this, you can use an ad-blocker such as <a href="https://github.com/gorhill/uBlock">uBlock Origin</a> to block all tracking by Google Analytics. Note that HDRI Haven does not display ads, so I'm fully comfortable with and encourage you to use an ad-blocker.
    </p>

    <h2>Disqus</h2>
    <p>
        <a href="https://disqus.com/">Disqus</a> is the third-party commenting system used on this website. They may collect data about you for various purposes similarly to Google Analytics. You can view their Privacy Policy <a href="https://help.disqus.com/terms-and-policies/disqus-privacy-policy">here</a>.
    </p>
    <p>
        Again, use an ad-blocker if you want to block these trackers.
    </p>

    <h2>Cookies</h2>
    <p>
        Both Google Analytics and Disqus use cookies to track you and store data. Other than that, cookies are not used anywhere else on this site.
    </p>
    <p>
        Your browser or ad-blocker may allow you to block these cookies.
    </p>

    <hr>

    <p>
        If you have any other questions or concerns, please contact me: <?php insert_email() ?>
    </p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
