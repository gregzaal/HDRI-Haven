<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("403");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1 class='red-text'>Error: 403</h1>

    <p>Sorry, you don't have permission to access this page :(</p>
    <p>If you're looking for a particular HDRI, try <a href="/hdris">searching for it here</a>.</p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
