<?php
include('/home/hdrhav/hdrihaven.com/php/secret_config.php');

$servername = $GLOBALS['DB_SERV'];
$dbname = $GLOBALS['DB_NAME'];
$username = $GLOBALS['DB_USER'];
$password = $GLOBALS['DB_PASS'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, 'utf8');

$sql = "SELECT * FROM social_media WHERE post_datetime <= NOW() ORDER BY post_datetime ASC";
$result = mysqli_query($conn, $sql);
$array = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($array, $row);
    }
}

foreach($array as $post){
    if (!$post['published']){
        $sql = "UPDATE social_media SET published=1 WHERE id=".$post['id'];  // Do this first in case something breaks and we get stuck in an infinite loop of trying to publish the same thing.
        $result = mysqli_query($conn, $sql);

        echo "Running id: ".$post['id']."<br>";
        // Facebook and Twitter
        $text = $post['twitface'];
        $img = $post['image'];
        $xml = "value1=".$text."&value2=".$img;
        $hook_url = $GLOBALS['HOOK_FACEOOK'];
        $ch = curl_init($hook_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);
        curl_close($ch);

        // Reddit
        $text = $post['reddit'];
        if ($text){
            $link = $post['link'];
            // NOTE: URL cannot contain an '&'
            $xml = "value1=".$text."&value2=".$link;
            $hook_url = $GLOBALS['HOOK_REDDIT'];
            $ch = curl_init($hook_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            $response = curl_exec($ch);
            curl_close($ch);
        }

        // Discord
        $webhookurl = $GLOBALS['HOOK_DISCORD'];
        $json_data = json_encode([
            "username" => "HDRI Haven",
            "avatar_url" => "https://hdrihaven.com/favicon.png",
            "tts" => false,
            "embeds" => [
                [
                    "title" => $post['name'],
                    "type" => "rich",
                    "url" => $post['link'],
                    "color" => hexdec("41bbd9"),
                    "footer" => [
                        "text" => "by ".$post['author'],
                        "icon_url" => "https://hdrihaven.com/files/site_images/authors/".rawurlencode($post['author'])."_50p.jpg"
                    ],
                    "image" => [
                        "url" => $post['image']
                    ],
                    "author" => [
                        "name" => "New HDRI!",
                        "url" => $post['link']
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
        $ch = curl_init( $webhookurl );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec( $ch );
        curl_close( $ch );

        break;
    }
}

?>
