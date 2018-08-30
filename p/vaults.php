<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Vaults");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>

<div id="page-wrapper">
    <h1>The Vaults</h1>

    <div class="vault-wrapper">
        <div class="col-3">
            <div class="vault-number">1</div>
            <h2>+20 HDRIs</h2>
            <div class='patreon-bar-wrapper'>
                <div class="patreon-bar-outer<?php if ($GLOBALS['VAULT_1']['completed_percentage'] >= 100){echo " achieved";} ?>">
                    <div class="patreon-bar-inner-wrapper">
                        <div class="patreon-bar-inner<?php if ($GLOBALS['VAULT_1']['completed_percentage'] >= 100){echo " achieved";} ?>" style="width: <?php echo $GLOBALS['VAULT_1']['completed_percentage'] ?>%"></div>
                    </div>
                </div>
                <p><?php
                echo '$'.$GLOBALS['PATREON_EARNINGS'];
                echo ' of ';
                echo '$'.$GLOBALS['VAULT_1']['amount_cents']/100;
                ?></p>
            </div>
        </div>
        <div class="col-3">
            <div class="vault-number">2</div>
            <h2>+40 HDRIs</h2>
            <div class='patreon-bar-wrapper'>
                <div class="patreon-bar-outer<?php if ($GLOBALS['VAULT_2']['completed_percentage'] >= 100){echo " achieved";} ?>">
                    <div class="patreon-bar-inner-wrapper">
                        <div class="patreon-bar-inner<?php if ($GLOBALS['VAULT_2']['completed_percentage'] >= 100){echo " achieved";} ?>" style="width: <?php echo $GLOBALS['VAULT_2']['completed_percentage'] ?>%"></div>
                    </div>
                </div>
                <p><?php
                echo '$'.$GLOBALS['PATREON_EARNINGS'];
                echo ' of ';
                echo '$'.$GLOBALS['VAULT_2']['amount_cents']/100;
                ?></p>
            </div>
        </div>
        <div class="col-3">
            <div class="vault-number">3</div>
            <h2>+60 HDRIs</h2>
            <div class='patreon-bar-wrapper'>
                <div class="patreon-bar-outer<?php if ($GLOBALS['VAULT_3']['completed_percentage'] >= 100){echo " achieved";} ?>">
                    <div class="patreon-bar-inner-wrapper">
                        <div class="patreon-bar-inner<?php if ($GLOBALS['VAULT_3']['completed_percentage'] >= 100){echo " achieved";} ?>" style="width: <?php echo $GLOBALS['VAULT_3']['completed_percentage'] ?>%"></div>
                    </div>
                </div>
                <p><?php
                echo '$'.$GLOBALS['PATREON_EARNINGS'];
                echo ' of ';
                echo '$'.$GLOBALS['VAULT_3']['amount_cents']/100;
                ?></p>
            </div>
        </div>
    </div>

    <hr>
    <p>
        There are three vaults containing an increasing number of HDRIs, for a total of 120.
    </p>
    <p>
        Each one will be unlocked and made available for <b>free for everyone</b> once their funding goal is met <a href="https://www.patreon.com/hdrihaven/overview">on Patreon</a>.
    </p>
    <p>
        The HDRIs in each vault are ones that were previously for sale on the old site. Right now, the only HDRIs on this site are either completely new ones, or ones that were already free on the old site.
    </p>
    <p>
        This serves two purposes:
    </p>
    <ol>
        <li>
            People who previously bought the HDRIs (before <a href="https://blog.hdrihaven.com/2017/10/01/why-the-change/">the change</a>) won't suddenly find those same HDRIs available for free. No one likes buying something at full price only to see it go on sale the next day. This would be even worse.
        </li>
        <li>
            It reduces the number of HDRIs on this site initially, keeping my costs low. Once each funding goals is met and the new HDRIs unlocked, I'll be able to afford to upgrade the server to accomodate all the new HDRIs (more hard drive space and increased bandwidth).
        </li>
    </ol>
    <p>
        The Vaults are not a paywall of any kind. <b>Donating on Patreon does not give you access to these vaults.</b> Like any good vault, it's physically impossible to get inside without the right key.
    </p>
    <p>
        The only way to get them is to <a href="https://www.patreon.com/hdrihaven/overview">help donate on Patreon</a>, tell your friends about HDRI Haven, and eventually they will be released publically for everyone once their respective funding goals are met by the total monthy amount donated by the community.
    </p>
    <div class='center' style='margin-top: 2em;'>
        <a href="https://www.patreon.com/hdrihaven/overview">
            <div class='button'>Help Unlock the Vaults</div>
        </a>
    </div>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
