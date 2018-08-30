<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("500");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1 class='red-text'>Error: 500</h1>

    <p>Hmmm, something broke!</p>
    <p>The server may be overwhelmed by too many people, please wait a few minutes and try again.</p>
    <p>If that doesn't work, please let me know on <a href="https://www.facebook.com/hdrihaven/">facebook</a>, <a href="https://twitter.com/HDRIHaven">twitter</a>, or by emailing <?php insert_email(); ?></p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
