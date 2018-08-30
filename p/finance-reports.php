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
        Note: For now here's just a list of spreadsheets. I'll make some pretty graphs when there is more data to deal with, as well as explain and visualize how the travel costs are paid off using the monthly savings.
    </p>
    <p>If you have any questions, feel free to email me at <?php insert_email() ?></p>
    <ul>
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

    <h2>Travel Reports</h2>
    <ul>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1gsVMENinn_PG5GS9A2ITyxD1U-AshG6cchxdb_UeKTE/edit?usp=sharing">KwaZulu-Natal 2018</a>
        </li>
        <li>
            <a href="/hdris/category/?o=popular&c=studio&s=small+studio">Small Studio</a> shoot: R3000 (<a href="https://www.google.co.za/search?q=3000+zar+in+usd" target="_blank">ZAR</a>)
        </li>
        <li>
            <a href="https://docs.google.com/spreadsheets/d/1WrjLImQWRuaTPavW7rhBGzT9mlT-bMSXZVJzvadJ52Y/edit?usp=sharing">Italy 2017</a>
        </li>
    </ul>

    <h2>Savings</h2>
    <p>The current balance of savings calculated from monthly reports and travel reports combined:</p>
    <div class='col-2 center'>
        <p>Travel Balance: <b class='<?php echo ($balance_travel>0?"green":"red"); ?>-text'>R<?php echo $balance_travel; ?></b> (<a href="https://www.google.co.za/search?q=<?php echo abs($balance_travel) ?>+zar+in+usd" target="_blank">ZAR</a>)</p>
    </div>
    <div class='col-2 center'>
        <p>Equipment Balance: <b class='<?php echo ($balance_equipment>0?"green":"red"); ?>-text'>R<?php echo $balance_equipment; ?></b> (<a href="https://www.google.co.za/search?q=<?php echo abs($balance_equipment) ?>+zar+in+usd" target="_blank">ZAR</a>)</p>
    </div>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
