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
        The main thing to look out for is whether an HDRI is <a href="http://blog.hdrihaven.com/what-is-clipping/" target="_blank">unclipped</a> or not. They usually don't mention anything if it is indeed clipped, so watch out. Being unclipped means the <b>full range of brightness in the scene</b> was captured, including the super crazy bright sunshine. If an HDRI is clipped (aka "clamped"), it will produce unrealistic lighting which is usually flat and lacking contrast.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="sun"></a></div>
    <a href="#sun"><h2>How do you reach 24+ EVs?</h2></a>
    <p>
        When a particularly high dynamic range is needed (e.g. capturing the sun or bright street lights), I shoot the whole HDRI with a medium dynamic range and then capture the light sources again separately using a very strong ND filter or two to make sure they're not clipped. Then, after correcting color casts and accounting for the exposure change, combine that with the rest of the HDRI.
    </p>
    <p>
        More details about this process are described in my article here: <a href="https://blog.hdrihaven.com/how-to-shoot-the-sun/" target="_blank">How to Shoot the Sun</a>
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
        This file size difference would more than double the stress on the server, which already struggles with more than 30TB of bandwidth each month, while not providing any significant improvement to the quality of the HDRIs. It would also increase your loading (i.e. rendering) times in your 3D software.
    </p>
    <p>
        Lossy EXR compression methods do exist (e.g. DWAA) and would reduce the file size even further, however they are not widely supported and often have serious deal-breaking artifacts around bright light sources.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="equipment"></a></div>
    <div class="anchor-wrapper"><a class="anchor" name="software"></a></div>
    <a href="#equipment"><h2>What equipment/software do you use?</h2></a>
    <p>
        This changes every now and then, and there are now multiple photographers shooting HDRIs for this site, so take a look at my article on <a href="https://blog.hdrihaven.com/how-to-create-high-quality-hdri/" target="_blank">creating your own HDRIs</a> to answer your actual question ;)
    </p>
    <p>
        If you're brand new to creating HDRIs, my <a href="http://adaptivesamples.com/2016/03/16/make-your-own-hdri/" target="_blank">previous article</a> might be easier to follow.
    </p>


    <div class="anchor-wrapper"><a class="anchor" name="360cam"></a></div>
    <a href="#360cam"><h2>Why don't you use a 360 camera?</h2></a>
    <p>
        There are two main reasons: Resolution, and highlight clipping...
    </p>
    <p>
        360 cameras generally have a very low resolution, simply due to the nature of their size and inherent quality of lenses that size. The <a href="https://www.threesixtycameras.com/360-degree-camera-comparison/" target="_blank">highest resolution</a> dual camera 360 cam at the time of writing this (October 2019) can produce a 7k panorama, which is a quarter of the total pixels needed at a <a href="http://blog.gregzaal.com/2016/02/23/what-makes-good-hdri/#Resolution" target="_blank">bare minimum</a> for HDRIs in my opinion (which is 14k). There is <a href="https://www.panono.com/en/hardware/" target="_blank">one 360 cam</a> I know of that uses a few dozen wide angle lenses and can produce 16k HDRIs, but it's sold as a service charging you per panorama and doesn't seem to give you much control over the output, and still has the clipping issue...
    </p>
    <p>
        <a href="http://blog.hdrihaven.com/what-is-clipping/" target="_blank">Preventing highlight clipping</a> is absolutely paramount when making high quality HDRIs that accurately capture light from the real world. 360 cameras use multiple fisheye lenses that have a bulbus front element, which makes it impossible to fit an <a href="https://en.wikipedia.org/wiki/Neutral-density_filter" target="_blank">ND filter</a> on the lenses, which makes it impossible to avoid clipping.
    </p>
    <p>
        So, 360 cams might be a useful tool for your own personal use, or for TDs on a film set that need to be fast and are willing to sacrifice on quality, but as a tool for producing the highest quality HDRIs for public consumption, they're not a good option at all.
    </p>


</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
