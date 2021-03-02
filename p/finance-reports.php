<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Finance Reports");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

$conn = db_conn_read_only();

$sql = "SELECT sum(amount_c)/100 FROM savings WHERE type=\"travel\"";
$balance_travel = array_values(mysqli_fetch_assoc(mysqli_query($conn, $sql)))[0];
$sql = "SELECT sum(amount_c)/100 FROM savings WHERE type=\"equipment\"";
$balance_equipment = array_values(mysqli_fetch_assoc(mysqli_query($conn, $sql)))[0];
?>

<div id="page-wrapper">
    <h1>Finance Reports</h1>
    <p>
        We're in a transition period at the moment, merging the 3 Haven sites into Poly Haven. Our past financial reports are all detailed below. In future (when polyhaven.com is ready) we'll have a fancier system of showing all of our spendings and savings.
    </p>
    <p>
        If you have any questions, feel free to email me at <?php insert_email() ?>.
    </p>

    <h2>Detailed Monthly Reports</h2>
    <p style="font-size: 1em">
    <?php
    $sql = "SELECT * FROM `finance_reports` ORDER BY `datetime` desc";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $link = $row['link'];
            $month = date("F Y", strtotime($row['datetime']));
            echo "<a href=\"{$link}\">";
            echo "<span class='button-inverse-small'>{$month}</span>";
            echo "</a>";
        }
    }
    ?>
    </p>

    <p>
        For a quick visual overview of how HDRI Haven has grown over time, I recommend checking out the <a href="https://graphtreon.com/creator/hdrihaven">Graphtreon page</a>.
    </p>

    <hr />

    <p>
        The following tables show my personal monthly savings towards improving the content on this site.
    </p>
    <p>
        As I'm no longer the only photographer publishing work on HDRI Haven, this only includes my small portion of the Patreon income. Other photographers may be spending or saving their earnings differently.
    </p>

    <?php
    $sql = "SELECT * FROM `savings` WHERE type = \"travel\" ORDER BY `datetime` desc";
    $result = mysqli_query($conn, $sql);
    $travel = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $travel[$row['id']] = $row;
        }
    }

    $sql = "SELECT * FROM `savings` WHERE type = \"equipment\" ORDER BY `datetime` desc";
    $result = mysqli_query($conn, $sql);
    $equipment = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $equipment[$row['id']] = $row;
        }
    }
    ?>

    <div class='col-2' style='vertical-align: top'>
    <h2>Travel Savings</h2>
    <p>Savings to spend on traveling to new locations, shooting different types of HDRIs.</p>
    <p>Current travel balance: <b class='<?php echo ($balance_travel>0?"green":"red"); ?>-text'>R<?php echo fmoney($balance_travel); ?></b> (<a href="https://www.google.co.za/search?q=<?php echo abs($balance_travel) ?>+zar+in+usd" target="_blank">ZAR</a>)</p>

    <div class='savings-tables'>
    <table cellspacing=0>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <?php
        foreach($travel as $x){
            echo "<tr>";
            echo "<td>".date("Y-m-d", strtotime($x['datetime']))."</td>";
            echo "<td>";
            if ($x['link']){
                echo "<a href=\"{$x['link']}\">";
                echo $x['description'];
                echo "</a>";
            }else{
                echo $x['description'];
            }
            echo "</td>";
            echo "<td class='".($x['amount_c']>0?"green":"red")."-text'>";
            echo "R".fmoney($x['amount_c']/100);
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </div>
    </div>


    <div class='col-2' style='vertical-align: top'>
    <h2>Equipment/General Savings</h2>
    <p>Savings to spend on camera gear, hardware, or any other infrequent expenses.</p>
    <p>Current equipment balance: <b class='<?php echo ($balance_equipment>0?"green":"red"); ?>-text'>R<?php echo fmoney($balance_equipment); ?></b> (<a href="https://www.google.co.za/search?q=<?php echo abs($balance_equipment) ?>+zar+in+usd" target="_blank">ZAR</a>)</p>

    <div class='savings-tables'>
    <table cellspacing=0>
        <tr>
            <th>Date</th>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <?php
        foreach($equipment as $x){
            echo "<tr>";
            echo "<td>".date("Y-m-d", strtotime($x['datetime']))."</td>";
            echo "<td>";
            if ($x['link']){
                echo "<a href=\"{$x['link']}\">";
                echo $x['description'];
                echo "</a>";
            }else{
                echo $x['description'];
            }
            echo "</td>";
            echo "<td class='".($x['amount_c']>0?"green":"red")."-text'>";
            echo "R".fmoney($x['amount_c']/100);
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </div>
    </div>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
