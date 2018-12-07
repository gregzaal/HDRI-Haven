<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Donate");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>Make a once-off donation</h1>
    <p>
        While I prefer to receive donations regularly through <a href="https://www.patreon.com/hdrihaven/overview">Patreon</a> or <a href="https://liberapay.com/gregzaal">Liberapay</a> so that my budget is more predictable, I certainly won't say no to any other kind of donations :)
    </p>
    <a href="https://paypal.me/gregzaal"><div class='button'>PayPal</div></a>
    <a href="#"><div class='button' id='btc-btn'>Bitcoin</div></a>
    <a href="#"><div class='button' id='ltc-btn'>Litecoin</div></a>
    <a href="#"><div class='button' id='eth-btn'>Ethereum</div></a>
    <div id='btc-address-wrapper'></div>

    <p>
        Or <a href="/p/about-contact.php">contact me</a> if there's some other way you'd like to donate.
    </p>

    <p>
        Donations under $100 will get added to the monthly Patreon income and shared among HDRI authors. Larger donations will be added directly to the travel and/or equipment budget. See the <a href="/p/finance-reports.php">public finance reports</a> for more details.
    </p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
