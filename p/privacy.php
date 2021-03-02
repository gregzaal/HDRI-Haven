<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Privacy");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>Privacy Info</h1>

    <h2>Third Party Cookies</h2>
    <p>
        We use some third party services (Google Analytics, Revive Adserver) which store cookies on your device that are necessary for using their services, and track data about you for their own purposes. You can read more about what data they store and how they use it on their own Privacy Policies:
    </p>
    <ul>
        <li><a href="https://policies.google.com/technologies/partner-sites">Google</a> (site analytics)</li>
        <li><a href="https://www.revive-adserver.net/privacy/">Revive</a> (banner ads)</li>
    </ul>
    <p>
        If you are not comfortable with this, we recommend you use a trusted open source ad-blocker such as <a href="https://github.com/gorhill/uBlock">uBlock Origin</a>.
    </p>

    <h2>IP Logging</h2>
    <p>
        This server logs a hashed version of your IP address when you download an asset.
    </p>
    <p>
        This helps us to see which assets are downloaded by the most users instead of only a total download count. Doing this allows us to see what is popular and make decisions about what to shoot next.
    </p>
    <p>
        If you're not comfortable with this, you can use a VPN to obscure your public IP address. If you wish for us to delete all records downloads from your IP address, you can <?php insert_email("contact us") ?>.
    </p>

    <h2>Patron Names in Footer</h2>
    <p>
        The user names of all active supporters on Patreon are automatically shown in the footer of every page on this site.
    </p>
    <p>
        These names are publically accessibly on the Patreon website, but if you would like your name in the footer removed or changed, please contact me either <?php insert_email("by email") ?> or direct message on Patreon.
    </p>

    <hr>

    <p>
        Other than what's mentioned above, we do not store any user data or cookies.
    </p>
    <p>
        If you have any other questions or concerns, please contact me: <?php insert_email() ?>
    </p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
