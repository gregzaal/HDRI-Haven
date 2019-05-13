<?php

// ============================================================================
// Constants & Utils
// ============================================================================

include($_SERVER['DOCUMENT_ROOT'].'/php/secret_config.php');

$WORKING_LOCALLY = substr($_SERVER['DOCUMENT_ROOT'], 0, 3) == "C:/" || substr($_SERVER['DOCUMENT_ROOT'], 0, 3) == "X:/";

$SYSTEM_ROOT = $_SERVER['DOCUMENT_ROOT'];
if ($WORKING_LOCALLY){
    $SYSTEM_ROOT = $GLOBALS['LOCAL_WORKING_FOLDER'];
}

require_once($_SERVER['DOCUMENT_ROOT'].'/vendor/patreon/patreon/src/patreon.php');
use Patreon\API;
use Patreon\OAuth;

$patreon = get_patreon();
$PATRON_LIST = $patreon[0];
$PATREON_GOALS = $patreon[2];
$PATREON_CURRENT_GOAL = null;
foreach ($PATREON_GOALS as $g){
    if ($g['completed_percentage'] < 100 && strpos($g['description'], "[reached") == false){
        $PATREON_CURRENT_GOAL = $g;
        break;
    }
}
$PATREON_EARNINGS = floor(($PATREON_CURRENT_GOAL['amount_cents']*($PATREON_CURRENT_GOAL['completed_percentage']/100))/100);
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

// Don't cache these pages | GET params ignored | matched to $_SERVER['PHP_SELF']
$NO_CACHE = ["/gallery/do_submit.php",
             "/gallery/moderate.php"
            ];

function nice_name($name, $mode="normal"){
    $str = str_replace('_', ' ', $name);
    if ($mode=="category"){
        // Some categories have a slash in them, but that would ruin URLs so they are stored as a dash instead and then replaced with a slash for display
        $str = implode('/', array_map('ucfirst', explode('-', $str)));
    }
    $str = ucwords($str);
    return $str;
}

function starts_with($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

function ends_with($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}

function str_contains($haystack, $needle) {
    return strpos($haystack, $needle) !== false;
}

function fmoney($i){
    return number_format($i, 2, '.', ' ');
}

function random_hash($length=8){
    $chars = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789";
    $hash = "";
    for ($i=0; $i<$length; $i++){
        $hash .= $chars[rand(0, strlen($chars)-1)];
    }
    return $hash;
}

function simple_chars_only($str){
    return preg_replace("/[^A-Za-z0-9 ]/", '', $str);
}

function map_range($value, $fromLow, $fromHigh, $toLow, $toHigh) {
    $fromRange = $fromHigh - $fromLow;
    $toRange = $toHigh - $toLow;
    $scaleFactor = $toRange / $fromRange;

    $tmpValue = $value - $fromLow;
    $tmpValue *= $scaleFactor;
    return $tmpValue + $toLow;
}

function time_ago($strtime) {
    // Source: http://goo.gl/LQJWnW

    $time = time() - strtotime($strtime); // to get the time since that moment

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        $rstr = $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'')." ago";
        if ($text == 'day'){
            $rstr = "<span class='new-hdri'>".$rstr."</span>";
        }
        return $rstr;
    }
    return "<span class='new-hdri'>Today</span>";
}

function is_in_the_past($d) {
    return (time() - strtotime($d) > 0);
}

function clear_cache(){
    $cache_dir = $_SERVER['DOCUMENT_ROOT']."/php/cache/";
    $r = array_map('unlink', glob("$cache_dir*.html"));
    return sizeof($r);  // Number of cache files cleared
}

function first_in_array($a){
    // Return first item of array, php is silly
    $a = array_reverse($a);
    return array_pop($a);
}

function array_sort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function resize_image($old_fp, $new_fp, $format, $size_x, $size_y, $quality=85){
    $img = new imagick($old_fp);
    $img->resizeImage($size_x, $size_y, imagick::FILTER_SINC, 1, true);
    $img->setImageFormat($format);
    $img->setImageCompression(Imagick::COMPRESSION_JPEG);
    $img->setImageCompressionQuality($quality);
    $img->writeImage($new_fp);
}

function clean_email_string($string) {
    $bad = array("content-type","bcc:","to:","cc:","<script>");
    return str_replace($bad,"",$string);
}

function debug_email($subject, $text){
    $email_to = $GLOBALS['ADMIN_EMAIL'];
    $email_from = "info@hdrihaven.com";
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'MIME-Version: 1.0' . "\r\n" .
    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $subject, clean_email_string($text), $headers);
}

function debug_console($str){
    echo "<script>";
    echo "console.log(\"".$str."\");";
    echo "</script>";
}

function pprint($x){
    echo "<pre>";
    print_r ($x);
    echo "</pre>";
}

function join_paths() {
    $paths = array();
    foreach (func_get_args() as $arg) {
        if ($arg !== '') { $paths[] = $arg; }
    }
    return preg_replace('#/+#','/',join('/', $paths));
}


// ============================================================================
// HTML
// ============================================================================

function include_start_html($title, $slug="", $canonical="", $t1="") {
    ob_start();
    include $_SERVER['DOCUMENT_ROOT']."/php/html/start_html.php";
    $html = ob_get_contents();
    $textures_one = "";
    ob_end_clean();

    if ($title == "Render Gallery" || starts_with($title, "HDRI: ")){
        $html = str_replace('%GALLERYJS%', "<link rel=\"stylesheet\" href=\"/js/flexImages/jquery.flex-images.css\"><script src=\"/js/flexImages/jquery.flex-images.min.js\"></script>", $html);
    }else{
        $html = str_replace('%GALLERYJS%', "", $html);
    }

    if ($title != "HDRI Haven"){
        $title .= " | HDRI Haven";
        $html = str_replace('%LANDINGJS%', "", $html);
    }else{
        $html = str_replace('%LANDINGJS%', "<script src='/js/landing-slider.js'></script>", $html);
        $textures_one = "<!-- START Textures.one integration -->
        <meta name=\"tex1:display-name\" content=\"HDRI Haven\" />
        <meta name=\"tex1:display-domain\" content=\"hdrihaven.com\" />
        <meta name=\"tex1:patreon\" content=\"hdrihaven\" />
        <meta name=\"tex1:twitter\" content=\"HDRIHaven\" />
        <meta name=\"tex1:instagram\" content=\"\" />
        <meta name=\"tex1:logo\" content=\"https://hdrihaven.com/files/site_images/logo_line.svg\" />
        <meta name=\"tex1:icon\" content=\"https://hdrihaven.com/favicon.png\" />
        <!-- END Textures.one integration -->";
    }
    $html = str_replace('%TITLE%', $title, $html);

    $html = str_replace('%METATITLE%', $title, $html);
    $html = str_replace('%DESCRIPTION%', '100% Free High Quality HDRIs for Everyone', $html);
    $keywords = 'HDR,HDRI,IBL,environment,equirectangular,free,cc0,creative commons';
    if ($t1 != ""){
        $keywords = $t1['tags'] . "," . $keywords;
    }
    $html = str_replace('%KEYWORDS%', $keywords, $html);

    $author = "Greg Zaal";
    if ($t1 != ""){
        $author = $t1['author'];
    }
    $html = str_replace('%AUTHOR%', $author, $html);

    if ($canonical != ""){
        $html = str_replace('%URL%', $canonical, $html);
    }else{
        $html = str_replace('%URL%', "https://hdrihaven.com$_SERVER[REQUEST_URI]", $html);
    }

    if ($slug != ""){
        $preview_img = "https://hdrihaven.com/files/hdri_images/meta/{$slug}.jpg";
        $html = str_replace('%FEATURE%', $preview_img, $html);
        if ($t1 != ""){
            $textures_one = "<!-- START Textures.one integration -->\n";
            $textures_one .= "<meta name=\"tex1:name\" content=\"".$t1['name']."\" />\n";
            $textures_one .= "<meta name=\"tex1:tags\" content=\"".$t1['tags']."\" />\n";
            $textures_one .= "<meta name=\"tex1:preview-image\" content=\"$preview_img\" />\n";
            $textures_one .= "<meta name=\"tex1:type\" content=\"hdri-real\" />\n";
            $textures_one .= "<meta name=\"tex1:releasedate\" content=\"".$t1['date_published']."\" />\n";
            $textures_one .= "<!-- END Textures.one integration -->";
        }
    }else{
        $html = str_replace('%FEATURE%', "https://hdrihaven.com/feature.jpg", $html);
    }

    $html = str_replace('%TEXTURESONE%', $textures_one, $html);

    echo $html;
}

function include_disqus($id) {
    ob_start();
    include $_SERVER['DOCUMENT_ROOT']."/php/html/disqus.php";
    $html = ob_get_contents();
    ob_end_clean();

    $id = str_replace("'", "\'", $id);
    echo str_replace('%ID%', $id, $html);
}

function insert_email(){
    echo '<script type="text/javascript">';
    echo 'var s3 = "hdrihaven.com";';
    echo 'var s1 = "info";';
    echo 'var s2 = "@";';
    echo 'var s4 = s1 + s2 + s3;';
    echo 'document.write("<a href=" + "mail" + "to:" + s1 + s2 + s3 + " target=\"_blank\">" + s4 + "</a>");';
    echo '</script>';
}


// ============================================================================
// Database functions
// ============================================================================

function db_conn_read_only(){
    $servername = $GLOBALS['DB_SERV'];
    $dbname = $GLOBALS['DB_NAME'];
    $username = $GLOBALS['DB_USER_R'];
    $password = $GLOBALS['DB_PASS_R'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function db_conn_read_write(){
    $servername = $GLOBALS['DB_SERV'];
    $dbname = $GLOBALS['DB_NAME'];
    $username = $GLOBALS['DB_USER'];
    $password = $GLOBALS['DB_PASS'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function num_items($search="all", $category="all", $reuse_conn=NULL){
    $size = 0;

    // Create connection
    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }
    $search_text = make_search_SQL(mysqli_real_escape_string($conn, $search), $category, "all");

    $sql = "SELECT name FROM hdris ".$search_text;    
    $rows = mysqli_query($conn, $sql)->num_rows;

    if (is_null($reuse_conn)){
        $conn->close();
    }

    return $rows;
}

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

function get_from_db($sort="popular", $search="all", $category="all", $author="all", $reuse_conn=NULL, $limit=0){
    $sort_text = make_sort_SQL($sort);

    // Create connection
    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }
    $search_text = make_search_SQL(mysqli_real_escape_string($conn, $search), $category, $author);

    $sql = "SELECT * FROM hdris ".$search_text." ".$sort_text;
    if ($limit > 0){
        $sql .= " LIMIT ".$limit;
    }
    $result = mysqli_query($conn, $sql);

    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $array[$row['name']] = $row;
        }
    }
    if (is_null($reuse_conn)){
        $conn->close();
    }

    return $array;
}

function get_item_from_db($item, $reuse_conn=NULL){
    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }
    $row = 0; // Default incase of SQL error
    $sql = "SELECT * FROM hdris WHERE slug='".$item."'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }

    if (is_null($reuse_conn)){
        $conn->close();
    }

    return $row;
}

function get_all_tags($conn=NULL){
    $db = get_from_db("popular", "all", "all", "all", $conn, 0);
    $all_tags = [];
    foreach ($db as $item){
        $tags = explode(";",  str_replace(',', ';', $item['tags']));
        foreach ($tags as $t){
            $t = strtolower($t);
            if (!in_array($t, $all_tags)){
                array_push($all_tags, $t);
            }
        }
    }
    sort($all_tags);
    return $all_tags;
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

function track_search($search_term, $category="", $reuse_conn=NULL){
    if ($search_term != "all"){
        if (is_null($reuse_conn)){
            $conn = db_conn_read_write();
        }else{
            $conn = $reuse_conn;
        }
        $search_term = mysqli_real_escape_string($conn, $search_term);
        $category = mysqli_real_escape_string($conn, $category);

        $sql = "INSERT INTO searches (`category`, `search_term`) ";
        $sql .= "VALUES (\"".$category."\", \"".$search_term."\")";
        $result = mysqli_query($conn, $sql);

        if (is_null($reuse_conn)){
            $conn->close();
        }
    }
}

function get_similar($slug, $reuse_conn=NULL){

    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }
    $items = get_from_db("popular", "all", "all", "all", $conn);
    if (is_null($reuse_conn)){
        $conn->close();
    }

    $this_item = array();
    foreach ($items as $row){
        if ($row['slug'] == $slug){
            $this_item = $row;
            break;
        }
    }
    if (!$this_item){
        // Unpublished items will not be in 'get_from_db', so just don't show their similar items
        return NULL;
    }
    $similarities = array();
    foreach ($items as $row){
        $row_slug = $row['slug'];
        if ($row_slug != $slug){
            $cats = explode(";", $row['categories']);
            foreach ($cats as $cat){
                if (strpos((';'.$this_item['categories'].';'), (';'.$cat.';')) !== FALSE){
                    if (array_key_exists($row_slug, $similarities)){
                        $similarities[$row_slug] = $similarities[$row_slug] + 1;
                    }else{
                        $similarities[$row_slug] = 1;
                    }
                }
            }
            $tags = explode(";", $row['tags']);
            foreach ($tags as $tag){
                if (strpos((';'.$this_item['tags'].';'), (';'.$tag.';')) !== FALSE){
                    if (array_key_exists($row_slug, $similarities)){
                        $similarities[$row_slug] = $similarities[$row_slug] + 1;
                    }else{
                        $similarities[$row_slug] = 1;
                    }
                }
            }
        }
    }
    arsort($similarities);
    $similar_slugs = array_slice(array_keys($similarities), 0, 6);  // only the first 6 keys

    $similar = array();
    foreach ($similar_slugs as $s){
        foreach ($items as $i){
            if ($i['slug'] == $s){
                array_push($similar, $i);
            }
        }
    }

    return $similar;
}

function most_popular_in_each_category($reuse_conn=NULL){
    // Return array with single most popular HDRI for each category (keys)

    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }

    $a = [];
    $items = get_from_db("popular", "all", "all", "all", $conn);
    foreach (array_keys($GLOBALS['STANDARD_CATEGORIES']) as $c){
        $found = false;
        foreach ($items as $h){
            $category_arr = explode(';', $h['categories']);
            if (in_array($c, $category_arr) or $c == "all"){
                $last_of_cat = $h;  // In case no unused match is found
                if (!in_array($h['slug'], array_values($a))){
                    $a[$c] = $h['slug'];
                    $found = true;
                    break;
                }
            }
        }
        if (!$found){
            $a[$c] = $last_of_cat['slug'];
        }
    }

    if (is_null($reuse_conn)){
        $conn->close();
    }

    return $a;
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

function get_gallery_renders($all=false, $reuse_conn=NULL){
    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }
    $row = 0; // Default incase of SQL error
    $sql = "SELECT * FROM gallery";
    if (!$all){
        $sql .= " WHERE favourite=1 OR TIMESTAMPDIFF(DAY, date_added, now()) < 21";
    }
    $sql .= " ORDER BY POWER(clicks+10*click_weight, 0.7)/POWER(ABS(DATEDIFF(date_added, NOW()))+1, 1.1) DESC, clicks DESC, date_added DESC";
    // $sql = "SELECT * FROM gallery WHERE favourite=1 OR TIMESTAMPDIFF(DAY, date_added, now()) < 21 ORDER BY POWER(clicks+10*click_weight, 0.7)/POWER(ABS(DATEDIFF(date_added, NOW()))+1, 1.1) DESC, clicks DESC, date_added DESC";
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

function make_category_list($sort, $reuse_conn=NULL, $current="all"){
    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }
    echo "<div class='category-list-wrapper'>";
    echo "<ul>";
    foreach (array_keys($GLOBALS['STANDARD_CATEGORIES']) as $c){
        $num_in_cat = num_items("all", $c, $conn);
        echo "<a href='/hdris/category/?c=".$c."&amp;o={$sort}'>";
        echo "<li title=\"".$GLOBALS['STANDARD_CATEGORIES'][$c]."\"";
        if ($current != "all" && $c == $current){
            echo " class='current-cat'";
        }
        echo ">";
        echo "<i class=\"material-icons\">keyboard_arrow_right</i>";
        echo nice_name($c, "category");
        echo "<div class='num-in-cat'>".$num_in_cat."</div>";
        echo "</li>";
        echo "</a>";
    }
    echo "</ul>";
    echo "</div>";
}

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
    $html .= "<img ";
    $html .= "class='thumbnail' ";
    $html .= "src=\"/files/hdri_images/thumbnails/{$slug}.jpg\" ";
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
    
    $html .= "<p class='age'>".time_ago($i['date_published'])."</p>";

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

function make_hdri_grid($sort="popular", $search="all", $category="all", $author="all", $conn=NULL, $limit=0){
    $items = get_from_db($sort, $search, $category, $author, $conn, $limit);
    $html = "";
    if (!$items) {
        $html .= "<p>";
        $html .= "<p>Sorry! There are no HDRIs";
        if ($search != 'all'){
            $html .= " that match the search \"".htmlspecialchars($search)."\"";
        }
        if ($category != 'all'){
            $html .= " in the category \"".nice_name($category, "category")."\"";
        }
        if ($author != 'all'){
            $html .= " by ".$author;
        }
        $html .= " :(</p>";
    }else{
        foreach ($items as $i){
            $html .= make_grid_item($i, $category);
        }
    }
    return $html;
}


// ============================================================================
// Patreon
// ============================================================================

function pledge_rank($pledge_amount){
    $pledge_rank = 1;
    if ($pledge_amount >= 2000) {
        $pledge_rank = 5;
    }else if ($pledge_amount >= 1000){
        $pledge_rank = 4;
    }else if ($pledge_amount >= 500){
        $pledge_rank = 3;
    }else if ($pledge_amount >= 300){
        $pledge_rank = 2;
    }
    return $pledge_rank;
}

function get_name_changes($reuse_conn=NULL){
    if (is_null($reuse_conn)){
        $conn = db_conn_read_only();
    }else{
        $conn = $reuse_conn;
    }
    
    $sql = "SELECT * FROM patron_name_mod";
    $result = mysqli_query($conn, $sql);
    $array = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $array[$row['id']] = $row;
        }
    }
    if (is_null($reuse_conn)){
        $conn->close();
    }

    $name_replacements = [];
    $add_names = [];
    $remove_names = [];
    foreach ($array as $i){
        $n_from = $i['n_from'];
        $n_to = $i['n_to'];
        if ($n_to and $n_from){
            $name_replacements[$n_from] = $n_to;
        }else if($n_to and !$n_from){
            $add_names[$n_to] = $i['rank'];
        }else{
            array_push($remove_names, $n_from);
        }
    }

    return [$name_replacements, $add_names, $remove_names];
}

function get_patreon(){
    $patreoncache = $_SERVER['DOCUMENT_ROOT'].'/php/patreon_data/_latest.json';

    // Some users request name change
    $conn = db_conn_read_only();
    list($name_replacements, $add_names, $remove_names) = get_name_changes($conn);

    // Get dummy data if working locally
    if ($GLOBALS['WORKING_LOCALLY']){
        $example_names = [
            "Joni Mercado",
            "S J Bennett",
            "Adam Nordgren",
            "RENDER WORX",
            "Pierre Beranger",
            "Pablo Lopez Soriano",
            "Frank Busch",
            "Sterling Roth",
            "Jonathan Sargent",
            "hector gil",
            "Philip bazel",
            "Llynara",
            "BlenderBrit",
            "william norberg",
            "Michael Szalapski",
        ];
        $patron_list = [];
        for ($i=0; $i<500; $i++){
            $pledge_rank_weights = [1,1,1,1, 2,2,2,2,2,2,2,2,2,2,2,2, 3,3,3, 4,4, 5];
            $pledge_rank = $pledge_rank_weights[array_rand($pledge_rank_weights)];
            $patron_full_name = $example_names[array_rand($example_names)];
            if (array_key_exists($patron_full_name, $name_replacements)){
                $patron_full_name = $name_replacements[$patron_full_name];
            }

            if (!in_array($patron_full_name, $remove_names)){
                array_push($patron_list, [$patron_full_name, $pledge_rank]);
            }
        }
        foreach (array_keys($add_names) as $p){
            array_splice($patron_list, rand(0, sizeof($patron_list)-1), 0, [[$p, $add_names[$p]]]);
        }


        $goals = [
            [
            "amount_cents" => 150000,
            "completed_percentage" => 83,
            "description" => "<strong>Enable 16K downloads<br><br></strong>Right now you can only download up to 8K resolution (to keep server costs affordable), but 99% of my HDRIs are actually 16K. It would be just a push of a button to make 16K available, but I need to make sure I can afford it first.<br><br><em>Money used for: server upgrade and higher bandwidth costs.</em>"
            ],
        ];

        $goals = array_sort($goals, "amount_cents", SORT_ASC);

        $data = [$patron_list, 1247, $goals];

        // Write to cache
        file_put_contents($patreoncache, json_encode($data, JSON_PRETTY_PRINT));

        return $data;
    }

    // Cache to avoid overusing Patreon API
    $cachetime = 120;  // How many minutes before the cache is invalid
    $cachetime *= 60;  // convert to seconds
    if (file_exists($patreoncache)) {
        if (time() - $cachetime < filemtime($patreoncache)){
            // echo "<!-- Patreon cache ".date('H:i', filemtime($patreoncache))." -->\n";
            $str = file_get_contents($patreoncache);
            return json_decode($str, true);
        }else{
            // Keep old cache file for statistical purposes
            rename($patreoncache, $_SERVER['DOCUMENT_ROOT'].'/php/patreon_data/'.time().'.json');
        }
    }

    $patreon_tokens = [];
    $patreon_tokens_path = $_SERVER['DOCUMENT_ROOT'].'/php/patreon_tokens.json';
    if (file_exists($patreon_tokens_path)){
        $str = file_get_contents($patreon_tokens_path);
        $patreon_tokens = json_decode($str, true);
    }
    $access_token = $patreon_tokens["access_token"];
    $refresh_token = $patreon_tokens["refresh_token"];
    $api_client = new Patreon\API($access_token);
    // Get your campaign data
    $campaign_response = $api_client->fetch_campaign();
        
    // If the token doesn't work, get a newer one
    if ($campaign_response['errors']) {
        echo "Got an error\n";
        echo "Refreshing tokens\n";
        // Make an OAuth client
        $client_id = $GLOBALS['CLIENT_ID'];
        $client_secret = $GLOBALS['CLIENT_SECRET'];
        $oauth_client = new Patreon\OAuth($client_id, $client_secret);
        // Get a fresher access token
        $tokens = $oauth_client->refresh_token($refresh_token, null);
        debug_email("Patreon Tokens", json_encode($tokens, JSON_PRETTY_PRINT));
        if ($tokens['access_token']) {
            $access_token = $tokens['access_token'];
            $fp = fopen($patreon_tokens_path, 'w');
            fwrite($fp, json_encode($tokens));
            fclose($fp);
            echo "Got a new access_token!";
        } else {
            echo "Can't fetch new tokens. Please debug, or write in to Patreon support.\n";
            print_r($tokens);
        }
        $api_client = new Patreon\API($access_token);
        $campaign_response = $api_client->fetch_campaign();
    }

    // get page after page of pledge data
    $campaign_id = $campaign_response['data'][0]['id'];
    $cursor = null;
    $patron_list = [];
    $total_earnings_c = 0;
    while (true) {
        $pledges_response = $api_client->fetch_page_of_pledges($campaign_id, 25, $cursor);
        // get all the users in an easy-to-lookup way
        $user_data = [];
        foreach ($pledges_response['included'] as $included_data) {
            if ($included_data['type'] == 'user') {
                $user_data[$included_data['id']] = $included_data;
            }
        }
        // loop over the pledges to get e.g. their amount and user name
        foreach ($pledges_response['data'] as $pledge_data) {
            $declined = $pledge_data['attributes']['declined_since'];
            if (!$declined){
                $pledge_amount = $pledge_data['attributes']['amount_cents'];
                $total_earnings_c += $pledge_amount;
                $pledge_rank = pledge_rank($pledge_amount);
                
                $patron_id = $pledge_data['relationships']['patron']['data']['id'];
                $patron_full_name = $user_data[$patron_id]['attributes']['full_name'];

                if (array_key_exists($patron_full_name, $name_replacements)){
                    $patron_full_name = $name_replacements[$patron_full_name];
                }

                if (!in_array($patron_full_name, $remove_names)){
                    array_push($patron_list, [$patron_full_name, $pledge_rank]);
                }
            }
        }
        // get the link to the next page of pledges
        $next_link = $pledges_response['links']['next'];
        if (!$next_link) {
            // if there's no next page, we're done!
            break;
        }
        // otherwise, parse out the cursor param
        $next_query_params = explode("?", $next_link)[1];
        parse_str($next_query_params, $parsed_next_query_params);
        $cursor = $parsed_next_query_params['page']['cursor'];
    }
    foreach (array_keys($add_names) as $p){
        array_splice($patron_list, rand(0, sizeof($patron_list)-1), 0, [[$p, $add_names[$p]]]);
    }

    $tmp = $campaign_response['included'];
    $goals = [];
    foreach ($tmp as $x){
        if ($x['type'] == 'goal'){
            array_push($goals, $x['attributes']);
        }
    }

    $goals = array_sort($goals, "amount_cents", SORT_ASC);

    $data = [$patron_list, $total_earnings_c/100, $goals];

    // Write to cache
    file_put_contents($patreoncache, json_encode($data, JSON_PRETTY_PRINT));
    return $data;
}

function goal_title($g){
    $d = $g['description'];
    $bits = explode("</strong>", $d);
    $t = $bits[0];
    $t = str_replace("<strong>", "", $t);
    $t = str_replace("<br>", "", $t);
    return $t;
}


?>
