var click_functions = function(){

    // Grid option menus
    $('.grid-option').click(function() {
        var dropdown = $(this).children('.dropdown');
        if (dropdown.css('visibility') == 'hidden') {
            dropdown.css({'visibility': 'visible', 'opacity': '1'});
            $('.grid-option').not(this).children('.dropdown').css({'visibility': 'hidden', 'opacity': '0'});
        }else{
            dropdown.css({'visibility': 'hidden', 'opacity': '0'});
        }
    });

    // Problem HDRI text
    $('.problem-wrapper').children().mouseenter(function() {
        $(this).parent().children('.problem').addClass("problem-hover");
    });
    $('.problem-wrapper').children().mouseleave(function() {
        $(this).parent().children('.problem').removeClass("problem-hover");
    });

    // Navbar Mobile
    $('#navbar-toggle').click(function() {
        var navbar = $('#navbar');
        if (navbar.css("display") != "none"){
            navbar.css("display", "none");
        }else{
            navbar.css("display", "block");
        }
    });

    // Sidebar Mobile
    $('#sidebar-toggle').click(function() {
        var sidebar = $('#sidebar');
        if (sidebar.css("display") != "none"){
            sidebar.animate({'left': "-200px"}, 200, function(){
                sidebar.css("display", "none");
            });
        }else{
            sidebar.css("display", "block");
            sidebar.animate({'left': "0"}, 200);
        }
    });

    // Category balls scroller
    $('#scroll-cat-right').click(function() {
        var scroll_cat_dist = $(".category-list-images a").width();
        $('.category-list-images').animate({'left': "-="+scroll_cat_dist}, 200, hide_cat_scroll_arrows);
    });
    $('#scroll-cat-left').click(function() {
        var scroll_cat_dist = $(".category-list-images a").width();
        $('.category-list-images').animate({'left': "+="+scroll_cat_dist}, 200, hide_cat_scroll_arrows);

    });
    function hide_cat_scroll_arrows(){
        var start = $('#list-start-pos').offset().left;
        var end = $('#list-end-pos').offset().left;

        if (start > 0){
            $('.fade-gradient-left').addClass('hide');
            $('#scroll-cat-left').addClass('hide');
        }else{
            $('.fade-gradient-left').removeClass('hide');
            $('#scroll-cat-left').removeClass('hide');
        }

        if (end < $(window).width()-200){
            $('.fade-gradient-right').addClass('hide');
            $('#scroll-cat-right').addClass('hide');
        }else{
            $('.fade-gradient-right').removeClass('hide');
            $('#scroll-cat-right').removeClass('hide');
        }
    }


    // 360 pannellum preview
    $('#btn-preview-360').click(function() {
        $('#pannellum-wrapper').css("display", "block");
        $('#pannellum-wrapper').animate({'opacity': "1"}, 500);
        if ($('window').width() < 760){
            $('#hdri-preview').addClass('hdri-preview-mobile');
        }
    });
    $('#btn-preview-360-exit').click(function() {
        $('#hdri-preview').removeClass('hdri-preview-mobile');
        $('#pannellum-wrapper').animate({'opacity': "0"}, 500, function(){
            $('#pannellum-wrapper').css("display", "none");
        });
    });


    // Exposure preview
    $('#btn-exposure-preview').click(function() {
        $('#exposure-wrapper').css("display", "block");
        $('#exposure-wrapper').animate({'opacity': "1"}, 500);
    });
    $('#btn-exposure-preview-exit').click(function() {
        $('#exposure-wrapper').animate({'opacity': "0"}, 500, function(){
            $('#exposure-wrapper').css("display", "none");
        });
    });
    function set_evs(e){
        // TODO wait for image load before changing
        var img = $("#exposure-img");
        var src_folder = img.attr("src").split('/');
        src_folder.pop();
        src_folder = src_folder.join('/');

        img.attr('src', src_folder+"/"+e+".jpg");
        img.attr('ev', e);

        var estr = e;
        if (e > 0){
            estr = "+"+e;
        }
        $('#btn-exposure-reset').html(estr+" EVs");
    }
    $('.btn-exposure-adj').click(function() {
        var direction = $(this).html();
        var img = $("#exposure-img");
        var current_evs = parseInt(img.attr('ev'));
        var new_evs = 0;
        if (direction == "-"){
            new_evs = Math.max(current_evs-2, -8);
        }else{
            new_evs = Math.min(current_evs+2, 8);
        }
        set_evs(new_evs);
    });
    $('#btn-exposure-reset').click(function() {
        set_evs(0);
    });


    // 16k popup
    $('#toggle-16k-info').click(function(e) {
        e.stopPropagation();
        var popup = $('#popup-16k');
        if (popup.hasClass("hide")) {
            popup.removeClass("hide");
        }else{
            popup.addClass("hide");
        }
    });


    // Hide popups when clicking outside of them
    $('body').click(function() {
        $('#popup-16k').addClass("hide");
    });


    // BTC address
    $('#btc-btn, #ltc-btn, #eth-btn').click(function() {
        var div = $("#btc-address-wrapper");
        if (this.id == "btc-btn"){
            div.html("BTC Address: <pre>1KcBgjVrypwxzef5nxcB4CwQiUy9qWHLw2</pre>");
        } else if (this.id == "ltc-btn"){
            div.html("LTC Address: <pre>LMiaHuUMqXgsE1Wwk9XinK4N3V9RGs2gSc</pre>");
        } else if (this.id == "eth-btn"){
            div.html("ETH Address: <pre>0xcf840f9a2b9b97df0b64e2f1bbff2baf9fd297b6</pre>");
        }
        div.css("display", "inline");
    });

    // Lightbox
    $('.lightbox-trigger').click(function() {
        $('#lightbox-img').attr("src", "");
        $('#lightbox-wrapper').removeClass("hide");
        $('#lightbox-img').attr("src", $(this).attr("lightbox-src"));
        
        if ($("#artwork-name").length){  // Gallery
            $("#artwork-name").html($(this).attr("artwork-name"));
            $("#author-name").html($(this).attr("author-name"));
            $("#author-link").attr("href", $(this).attr("author-link"));
            $("#hdri-used-name").html($(this).attr("hdri-used-name"));
            $("#hdri-used-link").attr("href", $(this).attr("hdri-used-link"));

            if ($(this).attr("author-link") == "#"){
                $("#author-link").addClass("hide-link");
            }else{
                $("#author-link").removeClass("hide-link");
            }

            if ($(this).hasClass("gallery-click")){
                $.post("click.php", {id: $(this).attr("gallery-id")});
                console.log("click!");
            }
        }

        if ($("#href-dlbp-pretty").length){  // Backplates
            $("#href-dlbp-pretty").attr("href", $(this).attr("dlbp-pretty"));
            $("#href-dlbp-plain").attr("href", $(this).attr("dlbp-plain"));
            $("#href-dlbp-raw").attr("href", $(this).attr("dlbp-raw"));
            $("#href-dlbp-pretty").attr("download", $(this).attr("dlbp-pretty").substring($(this).attr("dlbp-pretty").lastIndexOf('/')+1));
            $("#href-dlbp-plain").attr("download", $(this).attr("dlbp-plain").substring($(this).attr("dlbp-plain").lastIndexOf('/')+1));
            $("#href-dlbp-raw").attr("download", $(this).attr("dlbp-raw").substring($(this).attr("dlbp-raw").lastIndexOf('/')+1));
        }
    });
    $('#lightbox-close, #lightbox-wrapper').click(function() {
        $('#lightbox-wrapper').addClass("hide");
        $('#lightbox-img').attr("src", $(this).attr("lightbox-src"));
    });
    $('#href-dlbp-pretty, #href-dlbp-plain, #href-dlbp-raw').click(function(evt) {
        evt.stopPropagation();  // Prevent lightbox closing after downloading backplate
    });
};

var on_load = function(){

    // Push footer to bottom
    var h = $("#header").height();
    var f = $("#footer").height();
    var css = "calc(100vh - "+h+"px - "+f+"px)";
    $('#push-footer').css("min-height", css);

    // Narrower Pannellum FoV for mobile
    if ($('#pannellum-wrapper').width() < 760){
        $('#pannellum-frame').attr('src', $('#pannellum-frame').attr('src')+"&hfov=70");
    }
};

$(document).ready(click_functions);
$(document).ready(on_load);
