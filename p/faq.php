<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("FAQ");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>Frequently Asked Questions</h1>

    <?php make_faq(); ?>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
