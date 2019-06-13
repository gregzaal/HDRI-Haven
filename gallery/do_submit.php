<?php

$required_variables = ["author", "hdri-used"];
foreach ($required_variables as $v){
    if(!isset($_POST[$v])){
        header("Location: /gallery/submit.php?error="."Not all required fields filled in.");
        die();
    }
}

include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');

$hash = random_hash(8);
$filename_hash = random_hash(4);

$hdri_used = str_replace(" ", "_", strtolower($_POST["hdri-used"]));

// File checks
// Shamelessly copy-pasta'd from https://www.w3schools.com/php/php_file_upload.asp
$ext = strtolower(pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION));
$target_dir = $GLOBALS['SYSTEM_ROOT']."/files/gallery/upload/";
$file_name = simple_chars_only($_POST["author"])."_".simple_chars_only($hdri_used)."_".$filename_hash .".". $ext;
$target_file = $target_dir . $file_name;
$uploadOk = 1;
$error = "";
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check == false) {
        $error = "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $error = "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 5.1*1024*1024) {
    $error = "Sorry, your file is too large (over 5MB).";
    $uploadOk = 0;
}
// Allow certain file formats
$allowed_file_types = ['jpg', 'jpeg', 'png'];
if (!in_array($ext, $allowed_file_types)){
    $error = "Sorry, only JPG and PNG files are allowed.";
    $uploadOk = 0;
}
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $error = "Sorry, there was an unknown error uploading your file. Please submit it via email instead to ".inset_email();
    }
}
if ($uploadOk == 0) {
    header("Location: /gallery/submit.php?error=".$error);
    die();
}


include_start_html("Render Submitted");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');


$conn = db_conn_read_write();  // Create Database connection first so we can use `mysqli_real_escape_string`
$sql_pairs = [
    "hash" => '"'.$hash.'"',
    "artwork_name" => '"'.mysqli_real_escape_string($conn, $_POST["artwork-name"]).'"',
    "file_name" => '"'.$file_name.'"',
    "author" => '"'.mysqli_real_escape_string($conn, $_POST["author"]).'"',
    "author_email" => '"'.mysqli_real_escape_string($conn, $_POST["author-email"]).'"',
    "author_link" => '"'.mysqli_real_escape_string($conn, $_POST["author-link"]).'"',
    "hdri_used" => '"'.mysqli_real_escape_string($conn, $hdri_used).'"',
    "software" => '"'.mysqli_real_escape_string($conn, $_POST["software-used"]).'"',
];

$author_link = mysqli_real_escape_string($conn, $_POST["author-link"]);
if (!starts_with($author_link, "http")){
    $author_link = "http://".$author_link;
}
$sql_pairs["author_link"] = '"'.$author_link.'"';

$sql = "INSERT INTO gallery (".implode(", ", array_keys($sql_pairs)).") VALUES (".implode(", ", array_values($sql_pairs)).")";
$result = mysqli_query($conn, $sql);

$hdris = get_from_db("popular", "all", "all", "all", $conn);
$hdri_names = [];
foreach ($hdris as $h){
    $hdri_names[$h['slug']] = $h['name'];
}
$hdri_is_valid = false;
if (in_array(mysqli_real_escape_string($conn, $hdri_used), array_column($hdris, 'slug'))){
    $hdri_is_valid = true;
}

echo '<div id="page-wrapper">';
if ($result == 1){
    echo "<h1>Thanks!</h1>";
    echo "<p>";
    echo "Your render submission has been received, please give me a day or two to review it";
    if ($_POST["author-email"] != ""){
        echo " and I'll get back to you when it's published :)";
    }else{
        echo ".</p>";
        echo "<p>";
        echo "Because you did not provide your email address, I won't be able to tell you when it has (or hasn't) been accepted. Please check back on the <a href='/gallery'>gallery page</a> in a few days time to see it, or <a href='/p/about-contact.php'>contact me</a> if you have any questions.";
    }
    echo "</p>";

    $subject = "New Gallery Image Submission";
    $email_message = "<html><body>";
    $img_url = "https://hdrihaven.com/files/gallery/upload/".$file_name;
    $email_message .= "<p><a style='background-color: rgb(83, 161, 184);display:inline-block;padding: 0.75em 1em;color: white;text-decoration: none !important' href=\"".$img_url."\">Image</a></p>\r\n";
    $email_message .= "<p>Author: ".$_POST["author"]."</p>\r\n";
    $email_message .= "<p>Artwork Name: ".$_POST["artwork-name"]."</p>\r\n";
    $email_message .= "<p>Email: ".$_POST["author-email"]."</p>\r\n";
    $email_message .= "<p>Link: ".$_POST["author-link"]."</p>\r\n";
    $email_message .= "<p>HDRI Used: <a href='https://hdrihaven.com/hdri/?h=".$hdri_used."'>".$hdri_used."</a> ";
    if ($hdri_is_valid){
        $email_message .= "<span style='color:rgb(155, 214, 61)'>";
        $email_message .= "(Valid)";
        $email_message .= "</span>";
    }else{
        $email_message .= "<span style='color:#F96854'>";
        $email_message .= "(Invalid)";
        $email_message .= "</span>";
    }
    $email_message .= "</p>\r\n";
    $mod_url = "https://hdrihaven.com/gallery/moderate.php?h=".$hash;
    $email_message .= "<p>";
    $email_message .= "<a style='background-color: rgb(83, 161, 184);display:inline-block;padding: 0.75em 1em;color: white;text-decoration: none !important' href=\"".$mod_url."&d=y"."&f=0"."&u=".$hdri_used."\">Approve</a>";
    $email_message .= "<a style='background-color: rgb(83, 161, 184);display:inline-block;padding: 0.75em 1em;color: white;text-decoration: none !important;border-left:1px solid rgba(255,255,255,0.2)' href=\"".$mod_url."&d=y"."&f=1"."&u=".$hdri_used."\">&hearts;</a>";
    $email_message .= "</p>\r\n";
    $email_message .= "<p><a style='background-color: rgb(83, 161, 184);display:inline-block;padding: 0.75em 1em;color: white;text-decoration: none !important' href=\"".$mod_url."&d=n"."&f=0"."&u=".$hdri_used."\">Reject</a></p>\r\n";
    $email_message .= "</body></html>";

    $email_to = $GLOBALS['ADMIN_EMAIL'];
    $email_from = "info@hdrihaven.com";
    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'MIME-Version: 1.0' . "\r\n" .
    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $subject, clean_email_string($email_message), $headers);

}else{
    echo "<h1>Error :(</h1>";
    echo "<p>";
    echo "Something went wrong submitting your render. Please submit it by email instead to: ".insert_email();
    echo "</p>";
}
echo "</div>";

include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
