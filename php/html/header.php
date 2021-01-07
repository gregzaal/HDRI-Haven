<div id="header">
    <div id="header-logos">
        <a href="/"><!--
            --><img src="/core/img/HDRI Haven Logo.svg" /><!--
            --><p class="this-haven"><b>HDRI</b>H<sub>AVEN</sub></p><!--
        --></a><!--
        --><a href="https://texturehaven.com/"><!--
            --><img class="other-haven" src="/core/img/Texture Haven Logo.svg" /><!--
            --><p><b>T<sub>EXTURE</sub></b>H<sub>AVEN</sub> <i class="material-icons">open_in_new</i></p><!--
        --></a><!--
        --><a href="https://3dmodelhaven.com/"><!--
            --><img class="other-haven" src="/core/img/Model Haven Logo.svg" /><!--
            --><p><sub>3D</sub><b>M<sub>ODEL</sub></b>H<sub>AVEN</sub> <i class="material-icons">open_in_new</i></p>
        </a>
    </div>

    <div id="navbar-toggle"><i class="material-icons">menu</i></div>

    <ul id="navbar">
        <a href="/hdris"><li>HDRIs</li></a><!--
        --><a class='shrink-hack' href="https://www.patreon.com/hdrihaven/posts?public=true"><li>News</li></a><!--
        --><a href="/gallery"><li>Gallery</li></a><!--
        --><a href="https://polyhaven.com/support-us"><li>Support Us</li></a><!--
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
        <a href="https://polyhaven.com/support-us">
        <div class="patreon-bar-outer">
            <div class="patreon-bar-inner-wrapper">
                <div class="patreon-bar-inner" style="width: <?php
                    echo $GLOBALS['PATREON_CURRENT_GOAL']['completed_percentage'] ?>%">
                    <div class='patreon-bar-text'>
                        <img src="/files/site_images/icons/patreon_logo.svg">
                        <span class="text">
                        <?php
                        echo "$";
                        echo max(0, ($GLOBALS['PATREON_CURRENT_GOAL']['amount_cents']/100) - $GLOBALS['PATREON_EARNINGS']);
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
