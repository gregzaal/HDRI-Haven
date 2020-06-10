<script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
<script>
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "rgb(65, 187, 217)"
    },
    "button": {
      "background": "rgb(242, 191, 56)"
    }
  },
  "content": {
    "href": "https://hdrihaven.com/p/privacy.php"
  }
});
</script>
</body>
</html>

<?php
if (!in_array($_SERVER['PHP_SELF'], $GLOBALS['NO_CACHE'])){
    include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_bottom.php');
}
?>
