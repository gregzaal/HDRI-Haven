var i = 0;
var still_loading = false;
var next_image = function(direction) {
    if (direction > 0){
        i++;
    }else{
        i--;
    }

    // Wrap
    if (i == images.length){
        i = 0;
    }else if(i == -1){
        i = images.length -1;
    }

    var b_next = $('#banner-img-a');
    var b_prev = $('#banner-img-b');
    if ($('#banner-img-b').hasClass('hide')){
        b_next = $('#banner-img-b');
        b_prev = $('#banner-img-a');
    }

    var url = "/files/site_images/landing/"+images[i][0];
    b_next.css('background', "url("+url+") no-repeat center center");
    var tmp_img = new Image();
    tmp_img.src = url;
    if (still_loading == false){
        still_loading = true;
        tmp_img.onload = function(){
            still_loading = false;
            b_next.children('.banner-img-credit').html("Render by "+images[i][1]);

            // Ensure nice fade without white flash
            b_next.css('z-index', "12");
            b_prev.css('z-index', "11");

            b_next.removeClass('hide');
            setTimeout(function(){
                b_prev.addClass('hide');
            }, 300);
        };
    }
}

var now_playing = null;
var on_load = function(){
    images = [
        ["mondlicht_studios_bmw_lagoon.jpg", "<a href=\"http://mondlicht-studios.de/\">Mondlicht Studios</a>"],
        ["jan-morek-1.jpg", "<a href=\"http://www.janmorek.com/\">J&#225;n Morek</a>"],
        ["robert_bodis_red_straight.jpg", "<a href=\"https://www.behance.net/robertbodis\">Robert Bodis</a>"],
        ["alberto_merc.jpg", "<a href=\"https://www.behance.net/AlbertoLuque\">Alberto Luque</a>"],
        ["hussein_interior.jpg", "<a href=\"http://www.formlab.co.ke/\">FormLab Studio</a>"],
        ["parking_garage.jpg", "<a href=\"https://www.behance.net/jackdarton\">Jackdarton</a>"],
        ["zach_final_takeoff.jpg", "<a href=\"http://zachariasreinhardt.com/\">Zacharias Reinhardt</a>"],
        ["pink_road.jpg", "<a href=\"https://www.behance.net/jackdarton\">Jackdarton</a>"],
        ["hamburg.jpg", "<a href=\"http://gregzaal.com/\">Greg</a>, <a href=\"https://racoon.media/\">Jim van Hazendonk</a> and <a href=\"https://www.artstation.com/cameroncasey\">Cameron Casey</a>"],
    ];

    setTimeout(function(){
        now_playing = setInterval("next_image(1)", 5000);
    }, 3000);

    $('.banner-img-paddle').click(function() {
        clearInterval(now_playing);
    });
    $('#banner-img-paddle-l').click(function() {next_image(-1)});
    $('#banner-img-paddle-r').click(function() {next_image(1)});
};

$(document).ready(on_load);
