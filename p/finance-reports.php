<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Finance Reports");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');

$conn = db_conn_read_only();
$sql = "SELECT sum(amount_c)/100 FROM savings WHERE type=\"travel\"";
$balance_travel = round(array_values(mysqli_fetch_assoc(mysqli_query($conn, $sql)))[0]);
$sql = "SELECT sum(amount_c)/100 FROM savings WHERE type=\"equipment\"";
$balance_equipment = round(array_values(mysqli_fetch_assoc(mysqli_query($conn, $sql)))[0]);
$conn->close();
?>

<div id="page-wrapper">
    <h1>Finance Reports</h1>
    <p>
        Since all income for HDRI Haven comes from donations, I treat this money as if it's not my own, instead still belonging to the people who are investing in the platform.
    </p>
    <p>
        All spendings, savings and allocations of the income each month is detailed in the public spreadsheets below.
    </p>
    <p>
        In a nutshell:
    <ul>
        <li>The income is first used to cover the running costs (server hosting and other necessary services).</li>
        <li>Then, I (Greg Zaal) personally take 20% of the remainder as a salary to cover my time working on building, maintaining and improving the website, as well as checking, processing and uploading HDRIs from the various HDRI authors.</li>
        <li>The remainder (~75% of the original income) is shared between the HDRI authors whose work was published that month, relative to the number of HDRIs they each published. For more details on how this amount is shared, look at one of the months below.</li>
    </ul>
    </p>
    <p>
        If you have any questions, feel free to email me at <?php insert_email() ?>.
    </p>

    <h2>Detailed Monthly Reports</h2>
    <ul>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1oLm5tZhfDsxyrGOQvJ4xqW2FUlCbzpzKccx1AmYd31M/edit?usp=sharing">August 2018</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/16wib6zEofhsCCtC3k0MvBfIfjcL9HtBfsVGj5qyoj3Q/edit?usp=sharing">July 2018</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1sloxQDB9bYtJKtaeXLCbY5WjogvC-Y0dimEvqa_iePI/edit?usp=sharing">June 2018</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1O_0erYD3EofQf55MwKQA_1YqslP9TvBLAG0btAyuZzI/edit?usp=sharing">May 2018</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1_hO7dUWh_HjbZMR40ye9ogXKT6OozsWKnt0N2WAyVfc/edit?usp=sharing">April 2018</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1sHzHxoHzUo_orhHE0Ro36WzbwQvsRW84TOgGJ-Gsr90/edit?usp=sharing">March 2018</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1pa5dQbNAhxknCkECFBZLyIVuFtRyrIipdgApx-YsfRo/edit?usp=sharing">February 2018</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1e676qn5VG6Y7nZPI4UBulAvBjmhjTsfIvbszVnvteng/edit?usp=sharing">January 2018</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/17ps67HlCubmyR_8uq4j8xs4lZ6INT6e-t6B0Ht-rdpk/edit?usp=sharing">December 2017</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1FM0ajmBFhHn7JcHlfpxBS0ASNz4cdyec5PcxVS2EJyE/edit?usp=sharing">November 2017</a>
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1KYJdZfVw-ZLUBy8dqFheK4FI7TlJG31ChL2U4DFGKM0/edit?usp=sharing">October 2017</a> - More info and stats about the first month <a href="https://blog.hdrihaven.com/2017/11/20/an-unbelievable-first-month-stats-reports-etc/">here</a>.
        </li>
    </ul>

    <p>
        For a quick visual overview of how HDRI Haven has grown, I recommend checking out the <a href="https://graphtreon.com/creator/hdrihaven">Graphtreon page</a>.
    </p>

    <?php 
    $conn = db_conn_read_only();

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

    $conn->close();
    ?>

    <div class='col-2' style='vertical-align: top'>
    <h2>Travel Savings</h2>
    <p>Savings to spend on traveling to new locations, shooting different types of HDRIs.</p>
    <p>Current travel balance: <b class='<?php echo ($balance_travel>0?"green":"red"); ?>-text'>R<?php echo $balance_travel; ?></b> (<a href="https://www.google.co.za/search?q=<?php echo abs($balance_travel) ?>+zar+in+usd" target="_blank">ZAR</a>)</p>

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
            echo "R".($x['amount_c']/100);
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </div>


    <div class='col-2' style='vertical-align: top'>
    <h2>Equipment Savings</h2>
    <p>Savings to spend on camera gear or other hardware necessary to shooting and stitching HDRIs.</p>
    <p>Current equipment balance: <b class='<?php echo ($balance_equipment>0?"green":"red"); ?>-text'>R<?php echo $balance_equipment; ?></b> (<a href="https://www.google.co.za/search?q=<?php echo abs($balance_equipment) ?>+zar+in+usd" target="_blank">ZAR</a>)</p>

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
            echo "R".($x['amount_c']/100);
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </div>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
