<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("EV Difference Calculator");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>EV Difference Calculator</h1>

    <p>Use this page to calculate the exposure difference in stops/EVs between two images by inputting the shutter speed, aperture, ISO and ND filter reduction (if any).</p>

    <form id="ev-calc-form">
    <div class="form-item">
    <h2>Image A: </h2>
    <input class="ev-calc" id="form-a_shutter" type="text" name="a_shutter" placeholder="Shutter Speed" value="">
    <input class="ev-calc" id="form-a_aperture" type="text" name="a_aperture" placeholder="Aperture" value="">
    <input class="ev-calc" id="form-a_iso" type="text" name="a_iso" placeholder="ISO" value="">
    <input class="ev-calc" id="form-a_filter" type="text" name="a_filter" placeholder="ND Filter EVs" value="">
    <br>
    </div>
    <div class="form-item">
    <h2>Image B:</h2>
    <input class="ev-calc" id="form-b_shutter" type="text" name="b_shutter" placeholder="Shutter Speed" value="">
    <input class="ev-calc" id="form-b_aperture" type="text" name="b_aperture" placeholder="Aperture" value="">
    <input class="ev-calc" id="form-b_iso" type="text" name="b_iso" placeholder="ISO" value="">
    <input class="ev-calc" id="form-b_filter" type="text" name="b_filter" placeholder="ND Filter EVs" value="">
    </div>
    <div class="form-item">
        <h2 id="message">Fill in the fields above, the result will be shown here.</h2>
    </div>
    </form>

    <ul>
        <li>
            <b>Shutter Speed</b> is in seconds, and supports fractions. E.g. <pre>1/4000</pre> for 1/4000th of a second, or <pre>30</pre> for 30 seconds.
        </li>
        <li>
            <b>Aperture</b> should be without the "F/". E.g. <pre>8</pre> for F/8, or <pre>2.2</pre> for F/2.2.
        </li>
        <li>
            <b>ISO</b> is as you'd expect. If left blank, will default to <pre>100</pre>.
        </li>
        <li>
            In the <b>Filter</b> box, type the number of EVs/stops that your filter darkens an image. E.g. for a 3-stop filter (AKA "ND8") type <pre>3</pre>, or a 12-stop filter (AKA "ND4096") type <pre>12</pre>. If no filter was used, leave it blank or type <pre>0</pre>.
        </li>
    </ul>

</div>

<script type="text/javascript">
    function doCalc() {

        var decimals = function(i, d){
            i = i*Math.pow(10, d);
            i = Math.round(i);
            i = i/Math.pow(10, d);
            return i;
        }

        var a_shutter = $('#form-a_shutter').val();
        var b_shutter = $('#form-b_shutter').val();
        var a_aperture = $('#form-a_aperture').val();
        var b_aperture = $('#form-b_aperture').val();
        var a_iso = $('#form-a_iso').val();
        var b_iso = $('#form-b_iso').val();
        var a_filter = $('#form-a_filter').val();
        var b_filter = $('#form-b_filter').val();

        var shouldnt_be_empty = [];


        // Sanity checks and defaults
        if (! /^\d+(\/\d+)?(.\d+)?$/.test(a_shutter)) {
            return "Error: Invalid input for shutter speed A.";
        }
        if (! /^\d+(\/\d+)?(.\d+)?$/.test(b_shutter)) {
            return "Error: Invalid input for shutter speed B.";
        }
        if (! /^\d*\.?\d+$/.test(a_aperture)) {
            return "Error: Invalid input for aperture A.";
        }
        if (! /^\d*\.?\d+$/.test(b_aperture)) {
            return "Error: Invalid input for aperture B.";
        }
        if (! /^\d+$/.test(a_iso)) {
            return "Error: Invalid input for ISO A.";
        }
        if (! /^\d+$/.test(b_iso)) {
            return "Error: Invalid input for ISO B.";
        }
        if (! /^\d*\.?\d+$/.test(a_filter)) {
            if (a_filter != ""){
                return "Error: Invalid input for filter A.";
            }else{
                a_filter = "0";
            }
        }
        if (! /^\d*\.?\d+$/.test(b_filter)) {
            if (b_filter != ""){
                return "Error: Invalid input for filter B.";
            }else{
                b_filter = "0";
            }
        }

        if (a_shutter.includes("/")){
            f = a_shutter.split("/");
            n = parseFloat(f[0]);
            d = parseFloat(f[1]);
            a_shutter = n/d;
        }else{
            a_shutter = parseFloat(a_shutter);
        }
        if (b_shutter.includes("/")){
            f = b_shutter.split("/");
            n = parseFloat(f[0]);
            d = parseFloat(f[1]);
            b_shutter = n/d;
        }else{
            b_shutter = parseFloat(b_shutter);
        }
        a_aperture = parseFloat(a_aperture);
        b_aperture = parseFloat(b_aperture);
        a_iso = parseFloat(a_iso);
        b_iso = parseFloat(b_iso);
        a_filter = parseFloat(a_filter);
        b_filter = parseFloat(b_filter);

        Math.log = (function() {
            var log = Math.log;
            return function(n, base) {
                return log(n)/(base ? log(base) : 1);
            };
        })();
        var dr_shutter = Math.log(b_shutter/a_shutter, 2);
        var dr_aperture = Math.log(a_aperture/b_aperture, Math.sqrt(2));
        var dr_iso = Math.log(b_iso/a_iso, 2);
        var dr_filter = a_filter - b_filter;

        var dr_total = dr_shutter + dr_aperture + dr_iso + dr_filter;

        dr_total = decimals(dr_total, 3);

        if (dr_total >= 0){
            return "Image A is <b>" + Math.abs(dr_total) + "EVs darker</b> than Image B.";
        }else{
            return "Image A is <b>" + Math.abs(dr_total) + "EVs brighter</b> than Image B.";
        }
    }
    $('.ev-calc').keyup(function () {
        var result = doCalc();
        $('#message').html(result);
    });
    $(document).ready(function(){
        var result = doCalc();
        $('#message').html(result);
    });
</script>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
