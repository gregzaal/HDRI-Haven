<div id="header">
    <div id="header-logo">
        <a href="/"><img src="/files/site_images/logo_line.svg" width="256" /></a>
    </div>

    <div id="navbar-toggle"><i class="material-icons">menu</i></div>

    <ul id="navbar">
        <a href="/hdris"><li>HDRIs</li></a><!--
        --><a class='shrink-hack' href="https://texturehaven.com/"><li>Textures</li></a><!--
        --><a class='shrink-hack' href="https://www.patreon.com/hdrihaven/posts?public=true"><li>News</li></a><!--
        --><a href="/gallery"><li>Gallery</li></a><!--
        --><a href="https://www.patreon.com/hdrihaven/overview"><li>Support Me</li></a><!--
        --><a href="/p/about-contact.php"><li>About/Contact</li></a>
    </ul>

    <div class='patreon-bar-wrapper' title="Next goal on Patreon: <?php 
        echo goal_title($GLOBALS['PATREON_CURRENT_GOAL']);
        echo " ($";
        echo $GLOBALS['PATREON_EARNINGS'];
        echo " of $";
        echo $GLOBALS['PATREON_CURRENT_GOAL']['amount_cents']/100;
        echo ")";
        ?>">
        <a href="https://www.patreon.com/hdrihaven/overview">
        <div class="patreon-bar-outer">
            <div class="patreon-bar-inner-wrapper">
                <div class="patreon-bar-inner" style="width: <?php
                    echo $GLOBALS['PATREON_CURRENT_GOAL']['completed_percentage'] ?>%">
                    <div class='patreon-bar-text'>
                        <img src="/files/site_images/icons/patreon_logo.svg">
                        <span class="text">
                        <?php 
                        echo "$";
                        echo ($GLOBALS['PATREON_CURRENT_GOAL']['amount_cents']/100) - $GLOBALS['PATREON_EARNINGS'];
                        echo " to go";
                        ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
</div>
<div class="nav-bar-spacer"></div>
<div id="push-footer">
