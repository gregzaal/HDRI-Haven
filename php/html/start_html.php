<?php
if (!in_array($_SERVER['PHP_SELF'], $GLOBALS['NO_CACHE'])){
    include($_SERVER['DOCUMENT_ROOT'].'/php/html/cache_top.php');
}
?>
<html>
<head>
    <title>%TITLE%</title>

    <!-- CSS -->
    <link href='/css/style.css' rel='stylesheet' type='text/css' />
    <link href='/css/style_large.css' rel='stylesheet' media='screen and (max-width: 2559px)' type='text/css' />
    <link href='/css/style_medium.css' rel='stylesheet' media='screen and (max-width: 1299px)' type='text/css' />
    <link href='/css/style_small.css' rel='stylesheet' media='screen and (max-width: 759px)' type='text/css' />

    <!-- Google Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:900,500,400,300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <!-- Meta -->
    <meta name="description" content="%DESCRIPTION%"/>
    <meta name="keywords" content="%KEYWORDS%">
    <meta name="author" content="Greg Zaal">

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

    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    %GALLERYJS%

    <script src="/js/functions.js"></script>
    %LANDINGJS%

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

</head>
<body>

<div class="main-wrapper">
