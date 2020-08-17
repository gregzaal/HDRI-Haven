<?php

// Run this on the server as a cron job
// 0 0 * * * /usr/bin/php /home/.../db_backup.php

include('/home/hdrhav/hdrihaven.com/php/secret_config.php');
$filename = "hdrhav-sql-backup.sql";

$tmp_file = "/tmp/{$filename}";

$cmd = "/usr/bin/mysqldump --opt --user=".$GLOBALS['DB_USER_R']." --password=\"".$GLOBALS['DB_PASS_R']."\" --host=localhost ".$GLOBALS['DB_NAME']." > ".$tmp_file;
$result = exec($cmd);

// Sync with B2
$cmd = "rclone copy \"{$tmp_file}\" \"b2:havenbackups\"";
$result = exec($cmd);

?>
