<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Submit Your Render");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>Submit Your Render to the HDRI Haven Gallery</h1>

    <p>Have you created some <a href="/gallery">awesome artwork</a> using one of my HDRIs? Show it off on this site!</p>

    <h2>Rules:</h2>
    <ol>
        <li>The artwork must be your own creation, and you must be allowed to display it publically.</li>
        <li>You must have used one of the HDRIs from this site in the creation of your image.</li>
        <li>Nudity or other NSFW content will not be accepted.</li>
    </ol>

    <h2>Note:</h2>
    <p>
        Your image will be displayed on the main gallery page for a minimum of three weeks.<br>
        In order to keep the gallery from becoming cluttered, some images may be removed after this time.
    </p>
    <p>
        Please limit your submissions to a maximum of <b>3 per month</b> of your best work.
    </p>

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
            <input type="text" name="author-email" placeholder="george@starwars.com" value="">
            <p><em>(optional)</em><br>Used to notify you when your artwork is published. Stored securely and not shared with anyone.</p>
        </div>
            
        <div class="form-item">
            <h2>Link:</h2>
            <input type="text" name="author-link" placeholder="http://www.starwars.com/" value="">
            <p><em>(optional)</em> Your website/portfolio.</p>
        </div>
            
        <div class="form-item">
            <h2>HDRI Used:</h2>
            <input type="text" name="hdri-used" placeholder="Satara Night" value="" required>
            <p>The name of the HDRI you used in this render. <a href="/hdris/category/?c=all">See the list here</a>.</p>
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
