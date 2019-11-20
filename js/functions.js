var click_functions = function(){

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
};

var on_load = function(){
    // Narrower Pannellum FoV for mobile
    if ($('#pannellum-wrapper').width() < 760){
        $('#pannellum-frame').attr('src', $('#pannellum-frame').attr('src')+"&hfov=70");
    }
};

$(document).ready(click_functions);
$(document).ready(on_load);
