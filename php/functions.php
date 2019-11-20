<?php

// Site Variables
$SITE_NAME = "HDRI Haven";
$SITE_DESCRIPTION = "100% Free High Quality HDRIs for Everyone";
$SITE_TAGS = "HDR,HDRI,IBL,environment,equirectangular,free,cc0,creative commons";
$SITE_DOMAIN = "hdrihaven.com";
$SITE_URL = "https://".$SITE_DOMAIN;
$SITE_LOGO = "/core/img/HDRI Haven Logo.svg";
$SITE_LOGO_URL = $SITE_URL.$SITE_LOGO;
$META_URL_BASE = $SITE_URL."/hdri_images/meta/";
$DEFAULT_AUTHOR = "Greg Zaal";
$CONTENT_TYPE = "hdris";  // For DB table name & library url
$CONTENT_TYPE_SHORT = "hdri";  // For CSS classes
$CONTENT_TYPE_NAME = "HDRIs";  // For display
$TEX1_CONTENT_TYPE = "hdri-sphere";
$TEX1_CONTENT_METHOD = "hdri-real";
$HANDLE_PATREON = "hdrihaven";
$HANDLE_TWITTER = "HDRIHaven";
$HANDLE_FB = "hdrihaven";

require_once($_SERVER['DOCUMENT_ROOT'].'/core/core.php');


// ============================================================================
// Constants & Utils
// ============================================================================

$VAULT_1 = null;
$VAULT_2 = null;
$VAULT_3 = null;
foreach ($PATREON_GOALS as $g){
    $d = $g['description'];
    if (str_contains($d, "Vault #1")){
        $VAULT_1 = $g;
    }
    else if (str_contains($d, "Vault #2")){
        $VAULT_2 = $g;
    }
    else if (str_contains($d, "Vault #3")){
        $VAULT_3 = $g;
    }
}

$STANDARD_CATEGORIES = ["all" => "All HDRI Haven HDRIs",
                        "outdoor" => "Outside buildings or natural structures",
                        "skies" => "Few or no nearby trees/buildings protruding above the horizon",
                        "indoor" => "Inside buildings, caves or other shelters",
                        "studio" => "In a photography studio with various lighting setups",
                        "nature" => "Natural or rural environments with few or no man-made elements around",
                        "urban" => "Man-made environments such as cities or inside buildings",
                        "night" => "Night time HDRIs",
                        "sunrise-sunset" => "When the sun is very low or even just below the horizon",
                        "morning-afternoon" => "Before/after noon when the sun is a bit low in the sky",
                        "midday" => "Around noon when the sun is high in the sky",
                        "clear" => "No clouds visible",
                        "partly cloudy" => "Some clouds visible",
                        "overcast" => "Very cloudy, usually with flat lighting",
                        "high contrast" => "Producing clear, harsh shadows usually from a single strong light source (e.g. sun or street lamp)",
                        "medium contrast" => "Producing soft/weak but distinct shadows or variation in color",
                        "low contrast" => "Producing very soft shadows usually by large weak light sources (e.g. overcast sky)",
                        "natural light" => "Lit from natural sources (e.g. sky, sun)",
                        "artificial light" => "Lit from man-made sources (lamps)",
                        ];
$STANDARD_RESOLUTIONS = [];
for ($i=1; $i<=32; $i++){
    $r = $i.'k';
    $rf = ($i*1024).'x'.($i*512);
    $STANDARD_RESOLUTIONS[$r] = $rf;
}








// ============================================================================
// Database functions
// ============================================================================

function make_sort_SQL($sort) {
    // Return the ORDER BY part of an SQL query based on the sort method
    $sql = "ORDER BY id DESC";
    switch ($sort) {
        case "date_published":
            $sql = "ORDER BY date_published DESC, download_count DESC, date_taken ASC";
            break;
        case "date_taken":
            $sql = "ORDER BY date_taken DESC, download_count DESC, date_published ASC";
            break;
        case "popular":
            $sql = "ORDER BY download_count/POWER(ABS(DATEDIFF(date_published, NOW()))+1, 1.2) DESC, download_count DESC, date_taken DESC";
            break;
        case "downloads":
            $sql = "ORDER BY download_count DESC, date_published DESC, date_taken DESC";
            break;
        default:
            $sql = "ORDER BY id DESC";
    }
    return $sql;
}

function make_search_SQL($search, $category="all", $author="all") {
    // Return the WHERE part of an SQL query based on the search

    $only_past = "date_published <= NOW()";
    $sql = "WHERE ".$only_past;

    if ($search != "all"){
        // Match multiple words using AND
        $terms = explode(" ", $search);
        $i = 0;
        $terms_sql = "";
        foreach ($terms as $t){
            $i++;
            if ($i > 1){
                $terms_sql .= " AND";
            }
            if (str_contains($t, "backplate")){
                $terms_sql .= " backplates=1";
            }else{
                $terms_sql .= " (CONCAT(';',tags,';') REGEXP '[; ]".$t."[; ]' OR CONCAT(';',categories,';') REGEXP '[; ]".$t."[; ]' OR name LIKE '%".$t."%')";
            }
        }
        $sql .= " AND ".$terms_sql;
    }

    if ($category != "all"){
        $sql .= " AND (categories LIKE '%".$category."%')";
    }

    if ($author != "all"){
        $sql .= " AND (author LIKE '".$author."')";
    }

    return $sql;
}

function increment_download_count($id, $res, $reuse_conn=NULL){
    if (is_null($reuse_conn)){
        $conn = db_conn_read_write();
    }else{
        $conn = $reuse_conn;
    }

    if (!$id){
        header("Location: /hdris/");
    }else{
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            // Use original IP instead of Cloudflare node IP
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        // Main download_counting table
        $sql = "INSERT INTO download_counting (`ip`, `hdri_id`, `res`) ";
        $sql .= "VALUES (INET_ATON(\"".$_SERVER['REMOTE_ADDR']."\"), \"".$id."\", \"".$res."\")";
        $result = mysqli_query($conn, $sql);

        // Product table
        $sql = "UPDATE hdris SET download_count=download_count+1 WHERE id='".$id."'";
        $result = mysqli_query($conn, $sql);

        if (is_null($reuse_conn)){
            $conn->close();
        }
    }
}

function get_sponsors($slug, $reuse_conn=NULL){
    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }
    $row = 0; // Default incase of SQL error
    $sql = "SELECT * FROM sponsors WHERE hdri='".$slug."' ORDER BY datetime ASC";
    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($array, $row);
        }
    }
    if (is_null($reuse_conn)){
        $conn->close();
    }

    return $array;
}


// ============================================================================
// HDRI Grid
// ============================================================================

function make_grid_item($i, $category="all"){
    $html = "";

    $slug = $i['slug'];
    $html .= "<a href=\"/hdri/?";
    if ($category != "all"){
        $html .= "c=".$category."&amp;";
    }
    $html .= "h=".$slug;
    $html .= "\">";
    $html .= "<div class='grid-item'>";

    $html .= "<div class='thumbnail-wrapper'>";

    // Encoded tiny proxy images so that there is *something* to look at while the images load
    $html .= "<img ";
    $html .= "class='thumbnail-proxy' ";
    $local_file = join_paths($GLOBALS['SYSTEM_ROOT'], "files", "hdri_images", "thumbnails", "s", $slug.'.jpg');
    $imageData = base64_encode(file_get_contents($local_file));
    $html .= "src=\"data:image/jpeg;base64,".$imageData."\" ";
    $html .= "/>";

    // Main thumbnail images that are only loaded when they come into view
    $html .= "<img ";
    $html .= "class='thumbnail' ";
    $local_file = join_paths($GLOBALS['SYSTEM_ROOT'], "files", "hdri_images", "thumbnails", "s", '_dummy.png');
    $imageData = base64_encode(file_get_contents($local_file));
    $html .= "src=\"data:image/png;base64,".$imageData."\" ";
    $html .= "data-src=\"/files/hdri_images/thumbnails/{$slug}.jpg\" ";
    $html .= "alt=\"HDRI: {$i['name']}\" ";
    $html .= "/>";

    $problem = $i['problem'];
    if ($problem){
        // Show problem in left corner if present
        $html .= '<div class="problem-wrapper">';
        $html .= '<div class="problem">';
        $html .= '<div class="problem-text">'.$problem.'</div>';
        $html .= '</div>';
        $html .= '<div class="problem-triangle-shadow"></div>';
        $html .= '<div class="problem-triangle"></div>';
        $html .= '<div class="problem-icon">!</div>';
        $html .= '</div>';
    }

    $age = time() - strtotime($i['date_published']);
    if ($age < 7*86400){
        // Show "New!" in right corner if HDRI is less than 7 days old
        $html .= '<div class="new-triangle-shadow"></div>';
        $html .= '<div class="new-triangle"></div>';
        $html .= '<div class="new">New!</div>';
    }

    $html .= "</div>";  //.thumbnail-wrapper

    $html .= "<div class='description-wrapper'>";
    $html .= "<div class='description'>";

    $html .= "<div class='title-line'>";
    $html .= "<h3>".$i['name']."</h3>";
    $html .= "</div>";

    $html .= "<p class='age'>";
    $html .= time_ago($i['date_published']);
    $html .= " &sdot; ";
    $html .= $i['author'];
    $html .= "</p>";

    $html .= "</div>";  // description

    if ($i['backplates']){
        $html .= "<div class='has-backplates' title='Has Backplates'>";
        $html .= '<i class="material-icons">burst_mode</i>';
        $html .= "</div>";
    }

    $html .= "</div>";  // description-wrapper

    $html .= "</div>";  // grid-item
    $html .= "</a>";

    return $html;
}

?>
