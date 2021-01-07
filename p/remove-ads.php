<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Remove Ads");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<script src="/js/jquery.md5.js"></script>

<script>
    function check_code(){
        // The goal here is just to be a very basic step of "authentication", but in reality ad-blockers are free so there's no point in wasting time implementing something that's actually secure. So we can be very lenient about what secret code is accepted (stripping punctuation and converting case).
        var code = $('#secret-code').val();
        code = $.md5($.trim(code).toLowerCase().replace(/[.,\/#!$%\^&\*;:{}=\-_`'"~()]/g, ""));
        if (code == "8c1e3e398a2584b8ee7f4f63bf959869"){
            localStorage.setItem("remove-ads", "yes");  // Totally secure and completely unhackable!
            $('#response').removeClass('hidden');
        }
    }
    $(document).ready(function(){
        $('#secret-code').val("");
        $('#secret-code').keyup(check_code);
        $('#secret-code').change(check_code);
    });
</script>

<div id="page-wrapper">
    <h1>Remove Ads on <?php echo $GLOBALS['SITE_NAME']; ?></h1>
    <p>
        Don't like ads? Neither do we. <a href="https://polyhaven.com/support-us">Donate $1</a> (or more) to <?php echo $GLOBALS['SITE_NAME']; ?> to enable an ad-free experience across the whole site, helping us fund future <?php echo $GLOBALS['CONTENT_TYPE_NAME']; ?> at the same time.
    </p>

    <p>
        Already a patron? Enter the <a href="https://www.patreon.com/posts/38362368">secret code</a> below:
    </p>
    <div id="ad-removal-form">
        <input placeholder="Paste secret code here." value="" id="secret-code">
        <p id="response" class='hidden'><span class='green-text'>Nice! Thanks for your support!</span><br><span class='small'>Now just go back, reload the page, and you should no longer see any ads on this device :)</span></p>
    </div>
    <script>
        if (localStorage.getItem("remove-ads") == "yes"){
            $('#response').removeClass('hidden');
            $('#response .green-text').html("You've already entered the code correctly :)");
        }
    </script>
</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
