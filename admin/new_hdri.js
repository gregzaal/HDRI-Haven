function allowedCharsOnly(str, allowed_chars){
    var return_str = "";
    for (var i = 0; i<str.length; i++){
        var c = str.charAt(i);
        var x = allowed_chars.indexOf(c);
        if (x != -1){
            return_str += c;
        }
    }
    return return_str;
}

function removeAllButLast(string, token) {
    var parts = string.split(token);
    if (parts[1]===undefined)
        return string;
    else
        return parts.slice(0,-1).join('') + token + parts.slice(-1)
}

function nextInDOM(_selector, _subject) {
    // From http://stackoverflow.com/a/12873187/2488994 by techfoobar
    var next = getNext(_subject);
    while(next.length != 0) {
        var found = searchFor(_selector, next);
        if(found != null) return found;
        next = getNext(next);
    }
    return null;
}
function getNext(_subject) {
    if(_subject.next().length > 0) return _subject.next();
    return getNext(_subject.parent());
}
function searchFor(_selector, _subject) {
    if(_subject.is(_selector)) return _subject;
    else {
        var found = null;
        _subject.children().each(function() {
            found = searchFor(_selector, $(this));
            if(found != null) return false;
        });
        return found;
    }
    return null; // will/should never get here
}
  

var go = function(){

    // Disable enter key
    $("form").bind("keypress", function(e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

    // Click functions
    $(".show-tooltip").click(function() {
        var tooltip = nextInDOM(".tooltip", $(this));
        // var tooltip = $(this).nextAll(".tooltip")[0];
        console.log(tooltip);
        if (tooltip.hasClass("hidden")){
            tooltip.removeClass("hidden");
        }else{
            tooltip.addClass("hidden");
        }
    });

    $(".product-type").click(function() {
        $(".cat-type").css("display", "none");
        $(".cat-"+$(this).val()).css("display", "block");

        var url = window.location.href;
        if (url.includes('?')){
            url = url.split('?')[0];
        }
        url = url + "?type=" + $(this).val()
        window.history.replaceState(null, null, url);
        // window.location.href = url;
    });

    $('#auto-slug').click(function() {
        if($("#form-slug").is(":disabled")){
            $("#form-slug").prop("disabled", false);
        }else{
            $("#form-slug").prop("disabled", true);
            autoSlug();
        }
    });

    $('.cat-option').click(function() {
        var newCat = $(this).html();
        var currentCats = $("#form-cats").val().replace(/;/, ",");
        if (currentCats == ""){
            $("#form-cats").val(newCat);
        }else{
            var currentCatsArr = currentCats.split(",");
            var newCats = [];
            for (var i=0; i<currentCatsArr.length; i++){
                var cat = currentCatsArr[i].trim();
                if (cat != newCat){
                    newCats.push(cat);
                }
            }
            newCats.push(newCat);
            $("#form-cats").val(newCats.join(", "));
        }
    });

    $('.tag-option').click(function() {
        var newTag = $(this).html();
        var currentTags = $("#form-tags").val().replace(/;/, ",");
        if (currentTags == ""){
            $("#form-tags").val(newTag);
        }else{
            var currentTagsArr = currentTags.split(",");
            var newTags = [];
            for (var i=0; i<currentTagsArr.length; i++){
                var tag = currentTagsArr[i].trim();
                if (tag != newTag){
                    newTags.push(tag);
                }
            }
            newTags.push(newTag);
            $("#form-tags").val(newTags.join(", "));
        }
    });


    // Form changes
    var validateSlug = function(str){
            str = str.toLowerCase().replace(/ /g, "_");
            return allowedCharsOnly(str, "qwertyuiopasdfghjklzxcvbnm_-0123456789");
    }
    var autoSlug = function(){
        if ($("#auto-slug").is(":checked")){
            var name = $('#form-name').val();
            $("#form-slug").val(validateSlug(name));
            $('#form-slug-actual').val($('#form-slug').val());
        }
    }
    var updateImage = function(){
        var img = $("#preview-img");
        img.attr("src", "/files/hdri_images/meta/"+$('#form-slug').val()+".jpg");
    }
    $('#form-name').keyup(autoSlug);
    $('#form-name').change(function(){
        updateImage();
    });
    $("#form-name").bind("keypress", function(e) {
        if (e.keyCode == 13) {
            updateImage();
        }
    });

    $("#form-slug").bind("keypress", function(e) {
        if (e.keyCode == 13) {
            updateImage();
        }
    });
    $('#form-slug').change(function(){
        $('#form-slug').val(validateSlug($('#form-slug').val()));
        $('#form-slug-actual').val($('#form-slug').val());
        updateImage();
    });

    var validateDateTime = function(str){
        str = str.replace(/\\/g, "\/");
        str = str.replace(/-/g, "\/");
        str = allowedCharsOnly(str, "0123456789:/ ");
        return str;
    }
    var validateDatePublished = function(str){
        str = validateDateTime(str);
        if (str == ""){
            return "Immediately";
        }
        return str;
    }
    $('#form-date-published').change(function(){
        $('#form-date-published').val(validateDatePublished($('#form-date-published').val()));
    });

    $('#form-date-taken').change(function(){
        $('#form-date-taken').val(validateDateTime($('#form-date-taken').val()));
    });

    var validateTagsCats = function(str){
        str = str.replace(/;/g, ",");
        str = str.replace(/, /g, ",");
        str = str.replace(/,/g, ", ");
        return str;
    }
    $('#form-cats').change(function(){
        $('#form-cats').val(validateTagsCats($('#form-cats').val()));
    });
    $('#form-tags').change(function(){
        $('#form-tags').val(validateTagsCats($('#form-tags').val()));
    });
};

$(document).ready(go);
