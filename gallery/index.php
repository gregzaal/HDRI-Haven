<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Render Gallery");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="lightbox-wrapper" class="hide">
    <img id="lightbox-img" src="#">
    <p id="lightbox-text">
        <i><span id="artwork-name"></span></i>
        by
        <a id="author-link" target="_blank" href=""><span id="author-name"></span></a>
        using
        <a id="hdri-used-link" target="_blank" href=""><span id="hdri-used-name"></span></a>
    </p>
    <div class='item-info'>
    </div>
    <div id="lightbox-close"><i class="material-icons">close</i></div>
</div>

<h1 class='center' style="padding-top:1.5em">Render Gallery</h1>

<div id="gallery-wrapper">
<div class="flex-images">
    <?php
    $conn = db_conn_read_only();
    $renders = get_gallery_renders($conn);
    $hdris = get_from_db("popular", "all", "all", "all", $conn);
    $hdri_names = [];
    foreach ($hdris as $h){
        $hdri_names[$h['slug']] = $h['name'];
    }
    foreach ($renders as $r){
        if (in_array($r['hdri_used'], array_column($hdris, 'slug'))){
            if ($r['approval_pending'] == 0){
                $src = "/files/gallery/S/".$r['file_name'];
                $src_L = "/files/gallery/L/".$r['file_name'];
                $real_src = $GLOBALS['SYSTEM_ROOT'].$src;
                $size = getimagesize($real_src);
                if ($r['author_link'] == "" || $r['author_link'] == "none"|| $r['author_link'] == "http://"){
                    $r['author_link'] = "#";
                }
                echo "<div class='item lightbox-trigger gallery-click' data-w='".$size[0]."' data-h='".$size[1]."'";
                echo " lightbox-src=\"".$src_L."\"";
                echo " gallery-id=\"".$r['id']."\"";
                echo " artwork-name=\"".$r['artwork_name']."\"";
                echo " author-name=\"".$r['author']."\"";
                echo " author-link=\"".$r['author_link']."\"";
                echo " hdri-used-name=\"".$hdri_names[$r['hdri_used']]."\"";
                echo " hdri-used-link=\"/hdri/?h=".$r['hdri_used']."\"";
                echo ">";
                echo "<img src=\"".$src."\">";
                echo "</div>";
            }
        }
    }
    ?>
    <a href="submit.php">
    <div id="submit-render-btn" class="item" data-w="200" data-h="200">
        <p><br><span style="font-size:5em; font-weight:300">+</span><br>Submit Your Render</p>
    </div>
    </a>
</div>
</div>

<script type="text/javascript">
    $('#gallery-wrapper').flexImages({rowHeight: 400});
</script>


<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
