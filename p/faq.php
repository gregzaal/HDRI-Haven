<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("FAQ");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>Frequently Asked Questions</h1>

    <div class="anchor-wrapper"><a class="anchor" name="commercial"></a></div>
    <a href="#commercial"><h2>Can I use these HDRIs in commercial work?</h2></a>
    <p>
        Yes, of course. <a href="/p/license.php">More about the CC0 license here</a>.
    </p>

    <div class="anchor-wrapper"><a class="anchor" name="product"></a></div>
    <a href="#product"><h2>Can I include these HDRIs in a product I sell?</h2></a>
    <p>
        Yep. The only thing you can't do is claim to be the original author or re-license them. <a href="/p/license.php">More about the CC0 license here</a>.
    </p>
    <p>
        Please make it clear to your customers that these HDRIs are free and public domain, and if possible (though it's not required) include a link to HDRI Haven.
    </p>
    <p>
        If your product sells well, consider supporting the creation of these HDRIs <a href="https://www.patreon.com/hdrihaven/overview">on Patreon</a>.
    </p>

    <div class="anchor-wrapper"><a class="anchor" name="commissions"></a></div>
    <a href="#commissions"><h2>Do you do commissions?</h2></a>
    <p>
        If you need a particular HDRI and would like to hire me to shoot it for you, I'm happy to do so, just shoot me an email: <?php insert_email() ?>.
    </p>
    <p>
        A discount is available if you allow me to publish the HDRI(s) publicly too.
    </p>

    <div class="anchor-wrapper"><a class="anchor" name="what"></a></div>
    <a href="#what"><h2>What is an HDRI anyway?</h2></a>
    <p>
        Generally speaking, an HDRI (High Dynamic Range Image) is simply an image that contains more than 8 bits of data per pixel per channel. Image formats like JPG and PNG are typically 8-bit and are sometimes referred to as 'LDR' (Low Dynamic Range) images, whereas image formats like <a href="https://en.wikipedia.org/wiki/OpenEXR" target="_blank">EXR</a> and <a href="https://en.wikipedia.org/wiki/RGBE_image_format" target="_blank">HDR</a> store more data and are therefore HDRIs.
    </p>
    <p>
        However in the CG world (and on this site) we have come to use the term 'HDRI' to describe a 32-bit 360&deg;x180&deg; <a href="https://en.wikipedia.org/wiki/Equirectangular_projection" target="_blank">equirectangular</a> image that is used for lighting CG scenes.
    </p>
    <p>
        HDRIs are often used as the only light source in order to create a very realistically lit scene, or to match the lighting from video footage (using an HDRI shot on the same set as the video was taken). But of course they are also used to compliment standard lighting techniques and to add detail to reflections.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="usage"></a></div>
    <a href="#usage"><h2>How do I use these?</h2></a>
    <p>
        It's super easy, and no different from using any other HDRI. If you're using Blender, here's a <a href="https://youtu.be/KB768Ew8EVc" target="_blank">15 second video</a> to show you how it's done.
    </p>
    <p>
        All my HDRIs are unclipped, meaning you'll get realistic results automatically and do not need to adjust the gamma or plug the image into the strength/intensity input.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="stops"></a></div>
    <a href="#stops"><h2>How many stops/EVs do you capture for each HDRI?</h2></a>
    <p>
        As many as necessary. Usually 12, but sometimes as many as 24 in the case of super-bright light sources like the sun. Regardless of how many EVs were shot, every single HDRI on this site contains the complete dynamic range available in real life, so you won't see any highlight clipping.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="hdri"></a></div>
    <a href="#hdri"><h2>Is it 'HDR' or 'HDRI'?</h2></a>
    <p>
        It really doesn't matter which, people generally understand you either way. But if you want something to boast to your English teacher about, 'HDR' stands for 'High Dynamic Range', and the 'I' at the end stands for 'Image'...
    </p>
    <p>
        So you cannot say 'This is an HDR' because 'high dynamic range' is one big adjective without a noun. But you can say 'This is an HDRI' because 'image' is the noun that is being described as 'high dynamic range'. You can also say 'This is an HDR image', or 'This is an HDR panorama', as long as there's a noun after it.
    </p>
    <p>
        But like I said, it doesn't really matter. 'HDR' and 'HDRI' are both commonly used as nouns that mean the same thing.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="evs"></a></div>
    <a href="#evs"><h2>How do you measure the dynamic range (EVs)?</h2></a>
    <p>
        The number of EVs (or 'stops') is based purely on the number of brackets captured. For example, 12 EVs means 5 photos were taken with 3 EVs between them (shutter speeds: 1/4000, 1/500, 1/60 1/8, 1"), and since there are 4 gaps of 3 EVs between them, the dynamic range is said to be 12 EVs (4x3=12).
    </p>
    <p>
        Unfortunately there is no standardized way for measuring the dynamic range of an HDRI. Different people use different methods, so there's no reliable way that you as a user can tell whether website-A that claims 50 EVs of dynamic range is actually better than website-B that has 20 EVs.
    </p>
    <p>
        The main thing to look out for is whether an HDRI is <b>unclipped</b> or not. They usually don't mention anything if it is indeed clipped, so watch out. Being unclipped means the <b>full range of brightness in the scene</b> was captured, including the super crazy bright sunshine. If an HDRI is clipped (aka "clamped"), it will produce unrealistic lighting which is usually flat and lacking contrast.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="sun"></a></div>
    <a href="#sun"><h2>How do you reach 24+ EVs?</h2></a>
    <p>
        When a particularly high dynamic range is needed (e.g. capturing the sun or bright street lights), I shoot the whole HDRI with a medium dynamic range and then capture the light sources again separately using a very strong ND filter or two to make sure they're not clipped. Then, after correcting color casts and accounting for the exposure change, combine that with the rest of the HDRI.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="exr"></a></div>
    <a href="#exr"><h2>Why don't you use EXR instead of HDR?</h2></a>
    <p>
        This is a very common question and I've done numerous tests of my own to prove to myself that I'm doing the right thing by sticking to HDR. <a href="http://bit.ly/2HWI3jm">Here are some sample files</a> if you'd like to compare the formats yourself.
    </p>
    <p>
        While EXR files are objectively better than the HDR format, being true 32-bits per pixel per channel, the practical difference is insignificant.
    </p>
    <p>
        Generally 32-bit losslessly compressed EXR files are at least double the size of HDR files, while the difference between them (both the files themselves and the lighting they produce) is impossible to distinguish with the naked eye even when zooming in to potentially worst-case-scenario regions and flicking back and forth between them.
    </p>
    <p>
        This file size difference would more than double the stress on the server while not providing any significant improvement to the quality of the HDRIs, as well as increase your loading (i.e. rendering) times in your 3D software.
    </p>
    <p>
        Lossy EXR compression methods do exist (e.g. DWAA) and would reduce the file size even further, however they are not widely supported and often have serious deal-breaking artifacts around bright light sources.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="equipment"></a></div>
    <div class="anchor-wrapper"><a class="anchor" name="software"></a></div>
    <a href="#equipment"><h2>What equipment/software do you use?</h2></a>
    <p>
        This changes fairly often, so take a look at my long ass article on <a href="http://adaptivesamples.com/2016/03/16/make-your-own-hdri/" target="_blank">creating your own HDRIs</a> to answer your actual question ;)
    </p>
    <p>
        There you'll find several sections explaining the various advantages and disadvantages of different types of equipment and software - there are many ways to skin a cat, though some are more effective than others.
    </p>


</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
