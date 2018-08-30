</body>
</html>

<?php
if (!in_array($_SERVER['PHP_SELF'], $GLOBALS['NO_CACHE'])){
    include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_bottom.php');
}
?>
