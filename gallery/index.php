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
        <a id="item-used-link" target="_blank" href=""><span id="item-used-name"></span></a>
    </p>
    <div class='item-info'>
    </div>
    <div id="lightbox-close"><i class="material-icons">close</i></div>
</div>

<h1 class='center' style="padding-top:1.5em; padding-bottom:0">Render Gallery</h1>
<p class='center'><em>Artwork submitted by dozens of users, created using our HDRIs.</em></p>

<div id="gallery-wrapper">
<div class="flex-images">
    <?php
    $conn = db_conn_read_only();
    $renders = get_gallery_renders(false, $conn);
    $hdris = get_from_db("popular", "all", "all", "all", $conn);
    $hdri_names = [];
    foreach ($hdris as $h){
        $hdri_names[$h['slug']] = $h['name'];
    }
    $n = -9;
    $ad_count = 0;
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
                echo " item-used-name=\"".$hdri_names[$r['hdri_used']]."\"";
                echo " item-used-link=\"/hdri/?h=".$r['hdri_used']."\"";
                echo ">";
                echo "<img class='flex-item' src=\"".$src."\">";
                echo "</div>";
                $n++;
                if ($n % 15 == 0 && $ad_count < 4){
                    echo "<div class='item' data-w='300' data-h='250'>";
                    echo "<div class='flex-item adsense-unit'>";
                    echo "<script async src=\"https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js\"></script>
                    <!-- Render Gallery -->
                    <ins class=\"adsbygoogle\"
                         style=\"display:inline-block;width:300px;height:250px\"
                         data-ad-client=\"ca-pub-2284751191864068\"
                         data-ad-slot=\"8342925341\"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>";
                    echo "</div>";
                    echo "</div>";
                    $ad_count++;
                }
            }
        }
    }
    ?>
    <a href="submit.php">
    <div id="submit-render-btn" class="item" data-w="200" data-h="200">
        <p><br><span style="font-size:5em; font-weight:300; display:block">+</span><br>Submit Your Render</p>
    </div>
    </a>
</div>
</div>

<script type="text/javascript">
    $('#gallery-wrapper').flexImages({rowHeight: 400, object: '.flex-item'});
</script>


<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
