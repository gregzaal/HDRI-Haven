<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add HDRI</title>
    <link href='/css/style.css' rel='stylesheet' type='text/css' />
    <link href='/css/admin.css' rel='stylesheet' type='text/css' />
    <link href="https://fonts.googleapis.com/css?family=PT+Mono" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="new_hdri.js"></script>
</head>
<body>

<div id="page-wrapper">

<div class="col-2">
    <img src="/files/hdri_images/meta/" id="preview-img">
</div>

<div class="col-2">

<form action="/admin/new_hdri_submit.php" method="GET" id="new-hdri-form">
    <!-- [Calc EVs]
    [Fetch file sizes] -->

    
    <div class="form-item">
    <h2>Name:</h2>
    <input id="form-name" type="text" name="name" value="">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <div class="tooltip hidden">The name of the HDRI, as seen on the site (e.g. <q>Simon's Town Harbour</q>).</div>
    </div>

    <div class="form-item">
    <h2>Slug:</h2>
    <input id="form-slug" type="text" name="slug-visible" value="" disabled>
    <input id="form-slug-actual" type="text" name="slug" value="" hidden>  <!-- Duplicate hidden slug since disabled inputs aren't included in the GET parameters -->
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <label><input id="auto-slug" type="checkbox" name="auto-slug" value="Auto" checked>Auto</label><br>
    <div class="tooltip hidden">Unique identifier used for technical purposes. No punctuation or spaces allowed (e.g. <q>simons_town_harbour</q>).</div>
    </div>

    <div class="form-item">
    <h2>Date and time taken:</h2>
    <input id="form-date-taken" type="text" name="date_taken" value="">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <div class="tooltip hidden">When this HDRI was shot (e.g. <q>2017/05/22 17:59</q>).</div>
    </div>

    <div class="form-item">
    <h2>Timezone Offset:</h2>
    <input id="form-timezone" type="text" name="timezone_offset" value="0">
    </div>

    <div class="form-item">
    <h2>Darkest Shot: </h2>
    <input id="form-dr_d_shutter" type="text" name="dr_d_shutter" placeholder="Shutter Speed" value="">
    <input id="form-dr_d_aperture" type="text" name="dr_d_aperture" placeholder="Aperture" value="">
    <input id="form-dr_d_iso" type="text" name="dr_d_iso" placeholder="ISO" value="">
    <input id="form-dr_d_filter" type="text" name="dr_d_filter" placeholder="ND Filter EVs" value="">
    <br>
    <h2>Lightest Shot:</h2>
    <input id="form-dr_l_shutter" type="text" name="dr_l_shutter" placeholder="Shutter Speed" value="">
    <input id="form-dr_l_aperture" type="text" name="dr_l_aperture" placeholder="Aperture" value="">
    <input id="form-dr_l_iso" type="text" name="dr_l_iso" placeholder="ISO" value="">
    <input id="form-dr_l_filter" type="text" name="dr_l_filter" placeholder="ND Filter EVs" value="">
    </div>

    <div class="form-item">
    <h2>Whitebalance:</h2>
    <input id="form-whitebalance" type="text" name="whitebalance" value="0">
    </div>

    <div class="form-item">
    <h2>Coordinates:</h2>
    <input id="form-coord_x" type="text" name="coord_x" value="0">
    <input id="form-coord_y" type="text" name="coord_y" value="0">
    <label><input id="form-coords_are_approx" type="checkbox" name="coords_are_approx" value="Approximate">Approximate</label><br>
    </div>

    <div class="form-item">
    <h2>Categories:</h2>
    <input id="form-cats" type="text" name="cats" value="">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <div class="tooltip hidden">The category this HDRI belongs to, as grouped in the sidebar.<br>Choose several from below, or type new ones into the box.</div>
    <div id="button-list">
    <?php
    echo "<div class='cat-type'>";
    $cats = array_keys($GLOBALS['STANDARD_CATEGORIES']);
    foreach ($cats as $cat){
        if ($cat){
            if ($cat != 'all'){
                echo "<div class='button cat-option'>";
                echo $cat;
                echo "</div>";
            }
        }
    }
    echo "</div>";
    ?>
    </div>
    </div>
    
    <div class="form-item">
    <h2>Tags:</h2>
    <input id="form-tags" type="text" name="tags" value="">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <div class="tooltip hidden">What someone might search for (e.g. <q>old, dirty, red, damaged</q>).<br>Choose several from below, or type new ones into the box.</div>
    <div id="button-list">
    <?php
    echo "<div class='cat-type'>";
    $db = get_from_db("popular", "all", "all", "all", NULL, 0);
    $all_tags = [];
    foreach ($db as $item){
        $tags = explode(";",  str_replace(',', ';', $item['tags']));
        foreach ($tags as $t){
            $t = strtolower($t);
            if (array_key_exists($t, $all_tags)){
                $all_tags[$t] = $all_tags[$t] + 1;
            }else{
                $all_tags[$t] = 1;
            }
        }
    }
    arsort($all_tags);
    foreach (array_keys($all_tags) as $tag){
        if ($tag){
            $freq = $all_tags[$tag];
            echo "<div class='button tag-option' style='opacity:";
            echo pow(($freq/7), 1)+0.4;
            echo ";font-size:";
            echo min(100, map_range($freq, 1, 3, 75, 100));
            echo "%'>";
            echo $tag;//." ".$freq;
            echo "</div>";
        }
    }
    echo "</div>";
    ?>
    </div>
    </div>
    
    <div class="form-item">
    <h2>When to publish:</h2>
    <input id="form-date-published" type="text" name="date_published" value="Immediately">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i><br>
    <div class="tooltip hidden">The date and time (24h format) when this product should be published, in the format: <q>YYYY/MM/DD HH:MM:SS</q>.<br>(e.g. <q>2017/05/22 17:59</q>, or just <q>2017/05/22</q> which will publish at midnight).</div>
    </div>
    
    <div class="form-item">
    <h2>Backplates:</h2>
    <input id="form-backplates" type="checkbox" name="backplates" value="">
    </div>
    
    <div class="form-item">
    <h2>Problem:</h2>
    <input id="form-problem" type="text" name="problem" value="">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <div class="tooltip hidden">Any issue with the HDRI, e.g. clipped, low res...<br>This is the actual text displayed on the site.</div>
    </div>
    
    <div class="form-item">
    <h2>Author:</h2>
    <input id="form-author" type="text" name="author" value="Greg Zaal">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <div class="tooltip hidden">The original creator of this HDRI. Credit is shown on the HDRI page.</div>
    </div>
    
    <div class="form-item">
    <h2>File Format:</h2>
    <input id="form-author" type="text" name="author" value="hdr">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <div class="tooltip hidden">hdr, exr, etc...</div>
    </div>
    
    <div class="form-item">
    <h2>Facebook/Twitter:</h2>
    <input id="form-twitface" type="text" name="twitface" value="New ##category## HDRI - ##name##: ##link## #b3d #free #hdri #cc0">
    </div>
    
    <div class="form-item">
    <h2>Reddit:</h2>
    <input id="form-reddit" type="text" name="reddit" value="##category## HDRI: ##name##">
    <i class="fa fa-question-circle show-tooltip" aria-hidden="true"></i>
    <div class="tooltip hidden">Leave blank to skip posting to Reddit</div>
    </div>

    <div>
    <button id='submit' class='button'>Submit<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
    </div>


</form>


</div>
</div>

</body>
</html>
