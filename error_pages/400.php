<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("400");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1 class='red-text'>Error: 400</h1>

    <p>Hmmm, something broke!</p>
    <p>Please try reloading this page. If that doesn't work, please let me know by emailing <?php insert_email(); ?></p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
