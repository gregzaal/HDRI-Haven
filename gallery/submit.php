<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Submit Your Render", $slug="", $canonical="https://hdrihaven.com/gallery/submit.php", $t1="");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>Submit Your Render to the HDRI Haven Gallery</h1>

    <div class='warning-block' style='font-size: 0.9em;'>
    <p style="padding:0;margin:0.5em">Render Gallery submissions are temporarily disabled while we migrate to <a href="https://polyhaven.com">polyhaven.com</a>. This is expected to take a few weeks.</p>
    <p style="padding:0;margin:0.5em">In the meantime, we'd love you to share your renders with us on <a href="https://discord.gg/Dms7Mrs">Discord</a> :)</p>

    <p style="padding:0;margin:0.5em">-Greg (2021/07/14)</p>
    </div>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
