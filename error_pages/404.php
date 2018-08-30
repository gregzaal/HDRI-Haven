<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("404");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1 class='red-text'>Error: 404</h1>

    <p>This page can't be found :(</p>
    <p>If you're looking for a particular HDRI, try <a href="/hdris/category">searching for it here</a>.</p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
