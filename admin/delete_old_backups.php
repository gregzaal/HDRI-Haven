<?php

$backup_dir = "/home/hdrhav/backup/";

// Delete old files
$older_than = 30;  // days
$older_than = 30*24*60*60;  // seconds
echo "begin<br>";
foreach (glob($backup_dir."*.sql") as $file) {
    echo ("<br>".$file);
    if(time() - filectime($file) > $older_than){
        echo " - Deleting";
        unlink($file);
    }
}
echo "<br>end";

?>