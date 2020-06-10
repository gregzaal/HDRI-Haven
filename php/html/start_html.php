<?php
if (!in_array($_SERVER['PHP_SELF'], $GLOBALS['NO_CACHE'])){
    include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_top.php');
}
?>
<html>
<head>
    <title>%TITLE%</title>

    <!-- CSS -->
    <link href='<?php content_hashed_url("/css/style.css"); ?>' rel='stylesheet' type='text/css' />
    <link href='<?php content_hashed_url("/css/style_medium.css"); ?>' rel='stylesheet' media='screen and (max-width: 1299px)' type='text/css' />
    <link href='<?php content_hashed_url("/css/style_small.css"); ?>' rel='stylesheet' media='screen and (max-width: 759px)' type='text/css' />

    <!-- Google Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Lato:900,400|Roboto:900,500,300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <!-- Meta -->
    <meta name="description" content="%DESCRIPTION%"/>
    <meta name="keywords" content="%KEYWORDS%">
    <meta name="author" content="%AUTHOR%">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="rgb(83, 161, 184)">

    <link rel="canonical" href="%URL%" />

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="%METATITLE%" />
    <meta property="og:description" content="%DESCRIPTION%" />
    <meta property="og:url" content="%URL%" />
    <meta property="og:site_name" content="HDRI Haven" />
    <meta property="og:image" content="%FEATURE%" />

    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">

    %TEXTURESONE%

    %MAP%

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    %GALLERYJS%

    <script src='<?php content_hashed_url("/core/core.js"); ?>'></script>
    <script src='<?php content_hashed_url("/js/functions.js"); ?>'></script>
    %LANDINGJS%

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />

    <!-- Google analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-63647398-1', 'auto');
        ga('send', 'pageview');
    </script>
    <meta name="google-site-verification" content="lQBTSj6zheJOtznpvHO_x1GjXffWy__cJy7B-lcE3y0" />

    <!-- Google AdSense -->
    <script data-ad-client="ca-pub-2284751191864068" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <?php
    if ($GLOBALS['WORKING_LOCALLY']) {
        echo '<style>';
        echo 'ins { background-color: rgba(255,0,0,0.35); }';
        echo '</style>';
    }
    ?>

</head>
<body>

<div class="main-wrapper">
