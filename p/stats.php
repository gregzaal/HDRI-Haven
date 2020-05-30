<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/functions.php');
include_start_html("Stats");
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/header.php');
?>
<script src="/js/chart.js"></script>

<div id="stats-page">
    <h1 class='center'>Stats</h1>

    <div class="col-2">
        <canvas id="chart-daily-downloads"></canvas>
    </div>

    <div class="col-2">
        <canvas id="chart-monthly-downloads"></canvas>
    </div>

    <div class="col-2">
        <div class="col-2">
            <canvas id="chart-dayname"></canvas>
        </div>

        <div class="col-2">
            <canvas id="chart-hour"></canvas>
        </div>
    </div>

    <!--
    Top categories
    Top resolutions
    -->

    <?php
    $all_data = array();
    $conn = db_conn_read_only();

    $sql = "SELECT date(datetime) as date, count(*) as num, count(DISTINCT ip, hdri_id) as numu, count(DISTINCT ip) as users ";
    $sql .= "FROM `download_counting` ";
    $sql .= "WHERE datetime > (NOW() - INTERVAL 3 MONTH) ";
    $sql .= "GROUP BY date ";
    $sql .= "ORDER BY date";
    $result = mysqli_query($conn, $sql);
    $all_data["daily-downloads"] = [array(), array(), array(), array()];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($all_data["daily-downloads"][0], $row['date']);
            array_push($all_data["daily-downloads"][1], $row['numu']);
            array_push($all_data["daily-downloads"][2], $row['num']);
            array_push($all_data["daily-downloads"][3], $row['users']);
        }
    }

    $sql = "SELECT date_format(datetime, \"%Y-%m\") as date, count(*) as num, count(DISTINCT ip, hdri_id) as numu, count(DISTINCT ip) as users ";
    $sql .= "FROM `download_counting` ";
    $sql .= "GROUP BY date ";
    $sql .= "ORDER BY date";
    $result = mysqli_query($conn, $sql);
    $all_data["monthly-downloads"] = [array(), array(), array(), array()];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($all_data["monthly-downloads"][0], $row['date']);
            array_push($all_data["monthly-downloads"][1], $row['numu']);
            array_push($all_data["monthly-downloads"][2], $row['num']);
            array_push($all_data["monthly-downloads"][3], $row['users']);
        }
    }

    $sql = "SELECT dayname(datetime) as dayname, count(*) as num ";
    $sql .= "FROM `download_counting` ";
    $sql .= "GROUP BY dayname ";
    $sql .= "ORDER BY dayofweek(datetime)";
    $result = mysqli_query($conn, $sql);
    $all_data["dayname"] = [array(), array()];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($all_data["dayname"][0], $row['dayname']);
            array_push($all_data["dayname"][1], $row['num']);
        }
    }
    $max = max($all_data["dayname"][1]);
    foreach ($all_data["dayname"][1] as $k => $n){
        $all_data["dayname"][1][$k] = round($n / $max * 100, 2);
    }

    $sql = "SELECT hour(datetime) as hour, count(*) as num ";  // TODO get as GMT and convert to user TZ
    $sql .= "FROM `download_counting` ";
    $sql .= "WHERE datetime > (NOW() - INTERVAL 3 MONTH) ";
    $sql .= "GROUP BY hour ";
    $sql .= "ORDER BY hour";
    $result = mysqli_query($conn, $sql);
    $all_data["hour"] = [array(), array()];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($all_data["hour"][0], $row['hour']);
            array_push($all_data["hour"][1], $row['num']);
        }
    }
    $max = max($all_data["hour"][1]);
    foreach ($all_data["hour"][1] as $k => $n){
        $all_data["hour"][1][$k] = round($n / $max * 100, 2);
    }

    echo "<div id='all_data' class='hidden'>".json_encode($all_data)."</div>"
    ?>

<script>
var all_data = JSON.parse($('#all_data').html());

// Shared options:
var opt_tooltip_percentage = {
    mode: 'label',
    callbacks: {
        label: function(tooltipItem, data) {
            return data['datasets'][0]['data'][tooltipItem['index']] + '%';
        }
    }
}

// Colors:
var col_blue = 'rgb(65, 187, 217)';
var col_yellow = 'rgb(242, 191, 56)';
var col_purple = 'rgb(190, 111, 255)';

// Chart: daily-downloads
var ctx = document.getElementById('chart-daily-downloads').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: all_data["daily-downloads"][0].slice(1, -1),
        datasets: [{
            label: "Unique downloads",
            data: all_data["daily-downloads"][1].slice(1, -1),
            borderColor: col_yellow,
            backgroundColor: col_yellow,
            fill: false,
        },
        {
            label: "Total downloads",
            data: all_data["daily-downloads"][2].slice(1, -1),
            borderColor: col_blue,
            backgroundColor: col_blue,
            fill: false,
        },
        {
            label: "Users",
            data: all_data["daily-downloads"][3].slice(1, -1),
            borderColor: col_purple,
            backgroundColor: col_purple,
            fill: false,
        }]
    },
    options: {
        layout: {
            padding: 16
        },
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'Daily downloads in the last 3 months'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                }
            }]
        },
        tooltips: {
            mode: 'x',
            intersect: false
        }
    }
});

// Chart: monthly-downloads
var ctx = document.getElementById('chart-monthly-downloads').getContext('2d');
var chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: all_data["monthly-downloads"][0],
        datasets: [{
            label: "Unique downloads",
            data: all_data["monthly-downloads"][1],
            borderColor: col_yellow,
            backgroundColor: col_yellow,
            fill: false,
		    yAxisID: 'A',
        },
        {
            label: "Total downloads",
            data: all_data["monthly-downloads"][2],
            borderColor: col_blue,
            backgroundColor: col_blue,
            fill: false,
		    yAxisID: 'A',
        },
        {
            label: "Users",
            data: all_data["monthly-downloads"][3],
            borderColor: col_purple,
            backgroundColor: col_purple,
            fill: false,
		    yAxisID: 'A',
        }]
    },
    options: {
        layout: {
            padding: 16
        },
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'Monthly downloads over all time'
        },
        scales: {
            yAxes: [{
                id: 'A',
                type: 'linear',
                position: 'left',
                ticks: {
                    beginAtZero: true,
                }
            }, {
                id: 'B',
                type: 'linear',
                position: 'right',
                ticks: {
                    beginAtZero: true,
                },
                gridLines: {
                    drawOnChartArea: false,
                },
            }]
        },
        tooltips: {
            mode: 'x',
            intersect: false
        }
    }
});

// Chart: dayname
var ctx = document.getElementById('chart-dayname').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: all_data["dayname"][0],
        datasets: [{
            backgroundColor: col_blue,
            data: all_data["dayname"][1]
        }]
    },
    options: {
        layout: {
            padding: 16
        },
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'Downloads per weekday'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 100,
                    callback: function(value) {
                        return value + "%"
                    }
                }
            }],
            xAxes: [{
                ticks: {
                    callback: function(value) {
                        return value.substring(0, 3)
                    }
                }
            }]
        },
        tooltips: opt_tooltip_percentage
    }
});

// Chart: hour
var ctx = document.getElementById('chart-hour').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: all_data["hour"][0],
        datasets: [{
            backgroundColor: col_yellow,
            data: all_data["hour"][1]
        }]
    },
    options: {
        layout: {
            padding: 16
        },
        legend: {
            display: false
        },
        title: {
            display: true,
            text: 'Downloads per hour'
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 100,
                    callback: function(value) {
                        return value + "%"
                    }
                }
            }],
            xAxes: [{
                ticks: {
                    display: false
                },
                scaleLabel: {
                    display: true,
                    labelString: "Timezone: <?php echo date_default_timezone_get(); ?>"
                }
            }]
        },
        tooltips: opt_tooltip_percentage
    }
});
</script>

</div>

<?php
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/footer.php');
include ($_SERVER['DOCUMENT_ROOT'].'/php/html/end_html.php');
?>
