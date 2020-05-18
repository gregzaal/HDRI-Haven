<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Submit Your Render", $slug="", $canonical="https://hdrihaven.com/gallery/submit.php", $t1="");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>Submit Your Render to the HDRI Haven Gallery</h1>

    <p>Have you created some <a href="/gallery">awesome artwork</a> using one of my HDRIs? Show it off on this site!</p>

    <h2>Rules:</h2>
    <ol>
        <li>The artwork must be <b>your own creation</b>, and you must be allowed to display it publically.</li>
        <li>You must have used one of the HDRIs from this site in the creation of your image.</li>
        <li>Nudity or other NSFW content will not be accepted.</li>
    </ol>

    <h2>Note:</h2>
    <p>
    We get <b>a lot</b> of submissions, so unfortunately we can only accept the highest quality artwork to prevent the gallery from becoming cluttered.
    </p>
    <p>
        If you would like to receive critique for your render before submitting it, you can ask for it on our Discord server:<br><a href="https://discord.gg/Dms7Mrs" target="_blank">https://discord.gg/Dms7Mrs</a>
    </p>
    <p>
        If accepted, you will be notified by the email address you provide, and your image will be displayed on the main gallery page for a minimum of three weeks. If your work is exceptional, it may remain permanently.
    </p>
    <p>
        At the moment we don't have a system to notify you if your artwork was rejected, so if you do not receive a response with a day or two, unfortunately we could not accept it.
    </p>
    <p>
        The most common reasons for rejection are:
    </p>
    <ul>
        <li>Low-effort renders (e.g. simple lighting tests).</li>
        <li>Low quality artwork (see note above about receiving critique).</li>
        <li>No Haven HDRI was used.</li>
        <li>Very similar render from another artist already present (e.g. "car on backplate" type renders with the same backplate).</li>
        <li>Multiple similar renders of the same project (e.g. different camera angles) - only submit your best render.</li>
        <li>Too many submissions - typically we accept at most 3 images per artist per month.</li>
    </ul>

    <form action="do_submit.php" method="post" enctype="multipart/form-data" id="gallery-form">
        <?php
        if(isset($_GET["error"])) {
        echo "<div class=\"form-item error\">";
            echo "<h2>Error: </h2>";
            $error = htmlspecialchars($_GET["error"]);
            echo "<p> ".$error."</p>";
        echo "</div>";
        }
        ?>
        <div class="form-item">
            <h2>Upload image:</h2>
            <input type="file" name="file" id="file" required>
            <p><br>JPG or PNG, up to 5 MB.</p>
        </div>

        <div class="form-item">
            <h2>Artwork name:</h2>
            <input type="text" name="artwork-name" placeholder="Star Wars" value="">
            <p><em>(optional)</em></p>
        </div>

        <div class="form-item">
            <h2>Your name:</h2>
            <input type="text" name="author" placeholder="George Lucas" value="" required>
        </div>

        <div class="form-item">
            <h2>Your email:</h2>
            <input type="text" name="author-email" placeholder="george@starwars.com" value="" required>
            <p><br>Used only to notify you when your artwork is published. Stored securely and not shared with anyone.</p>
        </div>

        <div class="form-item">
            <h2>Link:</h2>
            <input type="text" name="author-link" placeholder="http://www.starwars.com/" value="">
            <p><em>(optional)</em> Your website/portfolio.</p>
        </div>

        <div class="form-item">
            <h2>HDRI Used:</h2>
            <?php
            echo "<input type=\"text\" name=\"hdri-used\" placeholder=\"Satara Night\" value=\"";
            if (isset($_GET["h"])){
                echo htmlspecialchars($_GET["h"]);
            }
            echo "\" required>";
            ?>
            <p>The name of the HDRI you used in this render. <a href="/hdris/?c=all">See the list here</a>.</p>
        </div>

        <div class="form-item">
            <h2>Software Used:</h2>
            <input type="text" name="software-used" placeholder="Blender, Maya, Daz 3D..." value="">
            <p><em>(optional)</em><br>The 3D software you used to create the render, to give me a better understanding of who to cater to.</p>
        </div>

        <input type="submit" value="Submit" name="submit" class="button">
    </form>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
