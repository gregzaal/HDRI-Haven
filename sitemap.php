<?php
header('Content-type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

// Main Pages
$urls = [
    ["https://hdrihaven.com/", "monthly"],
    ["https://hdrihaven.com/hdris/", "weekly"],
    ["https://hdrihaven.com/p/about-contact.php", "monthly"],
];
foreach ($urls as $u){
    echo "<url>\n";
    echo "<loc>".$u[0]."</loc>\n";
    echo "<changefreq>".$u[1]."</changefreq>\n";
    echo "<priority>0.5</priority>\n";
    echo "</url>\n";
}

// HDRIs
$hdris = get_from_db();
foreach ($hdris as $h){
    echo "<url>\n";
    echo "<loc>https://hdrihaven.com/hdri/?h=".$h['slug']."</loc>\n";
    echo "<lastmod>".date("Y-m-d", strtotime($h['date_published']))."</lastmod>\n";
    echo "<priority>0.8</priority>\n";
    echo "<changefreq>monthly</changefreq>\n";
    echo "<image:image>\n";
    echo "<image:loc>https://hdrihaven.com/files/hdri_images/meta/".$h['slug'].".jpg</image:loc>\n";
    echo "</image:image>\n";
    echo "<image:image>\n";
    echo "<image:loc>https://hdrihaven.com/files/hdri_images/tonemapped/8192/".$h['slug'].".jpg</image:loc>\n";
    echo "</image:image>\n";
    echo "</url>\n";
}

// Categories
foreach (array_keys($GLOBALS['STANDARD_CATEGORIES']) as $c){
    if ($c){
        if ($c != 'all'){
            echo "<url>\n";
            echo "<loc>https://hdrihaven.com/hdris/category/?c=".$c."</loc>\n";
            echo "<priority>0.5</priority>\n";
            echo "<changefreq>weekly</changefreq>\n";
            echo "</url>\n";
        }
    }
}

echo '</urlset>';
?>