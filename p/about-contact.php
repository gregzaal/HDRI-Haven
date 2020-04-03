<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("About / Contact");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <div class='me-wrapper'>
        <img style="max-width:256px;float:left;margin-right:2em" src="/core/img/HDRI Haven Logo.svg">
    </div>
    <h1>Hi there!</h1>
    <p>
        HDRI Haven is where you can find high quality HDRIs for free, no catch.
    </p>
    <p>
        All HDRIs here are <a href="/p/license.php">CC0</a> (public domain). No paywalls, accounts or email spam. Just download what you want, and use it however.
    </p>
    <p>
        HDRI Haven is officially linked with <a href="https://texturehaven.com">Texture Haven</a> and <a href="https://3dmodelhaven.com">3D Model Haven</a>.
    </p>

    <div style="clear: both"></div>

    <div class="author-list">
    <h1>HDRI Authors:</h1>
    <ul>
    <?php
    $conn = db_conn_read_only();
    $row = 0; // Default incase of SQL error
    $sql = "SELECT * FROM authors ORDER BY `id`";
    $result = mysqli_query($conn, $sql);
    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($array, $row);
        }
    }

    $items = get_from_db("popular", "all", "all", "all", $conn);

    foreach ($array as $a){
        $author_pic = join_paths($GLOBALS['SYSTEM_ROOT'], "/files/site_images/authors/".$a['name']."_150p.jpg");
        if (file_exists($author_pic)){
            echo "<li>";
            echo "<img class='me-med' src=\"".filepath_to_url($author_pic)."\" />";
            echo "<p>";
            echo "<b>".$a['name']."</b>";
            echo "<br>";
            if ($a['link']){
                echo "<a href=\"".$a['link']."\">";
                echo "<i class='material-icons'>link</i>";
                echo "</a>";
            }
            if ($a['email']){
                echo "<a href=\"mailto:".$a['email']."\">";
                echo "<i class='material-icons'>mail_outline</i>";
                echo "</a>";
            }
            // if ($a['donate']){
            //     echo "<a href=\"".$a['donate']."\">";
            //     echo "<i class='material-icons'>favorite_border</i>";
            //     echo "</a>";
            // }
            echo "<br>";
            echo "<a href=\"/hdris/?a=".$a['name']."\">";
            $n_items = 0;
            foreach ($items as $i){
                if ($i['author'] == $a['name']){
                    $n_items++;
                }
            }
            echo $n_items;
            echo " hdris</a>";
            echo "</p>";
            echo "</li>";
        }
    }
    ?>
    </ul>
    </div>

    <h1>Get Involved</h1>
    <p>
        Since all of the income for this site comes from the community, it's only fair that the community gets to decide what happens with it.
    </p>
    <p>
        All Patrons have access to a private Trello board where they can add ideas and vote on new locations, trips, and generally decide where the money goes.
    </p>
    <p>
        If you want to get involved and help keep this site alive at the same time, consider supporting <a href="https://www.patreon.com/hdrihaven/overview">HDRI Haven on Patreon</a>.
    </p>

    <h1>Contact</h1>
    <p>Got a question? Please read the <a href="/p/faq.php">FAQ</a> first :)</p>
    <p>The easiest ways to get hold of me is through email: <?php insert_email() ?></p>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
