<?php
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
$role = $db->getRow("SELECT `role` from accounts where id_user = ".$_SESSION['id_user']."");
if (!isset($_SESSION['username'])) {
	header('Location:'.$base.'Login.php');
}
if ($role['role']==0) {
	header('Location:'.$base);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FlowerShop Admin Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $base;?>assets/js/Chart.min.js"></script>
    <link rel="stylesheet" href="<?php echo $base;?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?php echo $base;?>assets/css/app.css">
    <link rel="shortcut icon" href="<?php echo $base;?>assets/images/favicon.svg" type="image/x-icon">
</head>
<style type="text/css">
.chart {
    width: 100%;
}

#chart-container {
    width: 100%;
    height: auto;
}
</style>
<body>
<div id="app">
    <div id="sidebar" class='active'>
            <?php include'sidebar_header.php' ?>       
    </div>
        <div id="main">
            <?php include'nav_header.php' ?>
            
            <div class="main-content container-fluid">
                <div class="page-title">
                    <h3>Doanh thu</h3>
                    
                </div>
                <section class="section">
<div class="container">
    <div class="chart">
                    <div id="chart-container">
                        <canvas id="graphCanvas"></canvas>
                    </div>

                    <script>
                        $(document).ready(function () {
                            showGraph();
                        });


                        function showGraph()
                        {
                            {
                                $.post("data.php",
                                function (data)
                                {
                                    console.log(data);
                                    var date = [];
                                    var money = [];

                                    for (var i in data) {
                                        date.push(data[i].saledate);
                                        money.push(data[i].sumtt);
                                    }

                                    var chartdata = {
                                        labels: date,
                                        datasets: [
                                            {
                                                label: 'Doanh thu(VNĐ)',
                                                backgroundColor: '#F5DF4D',
                                                borderColor: '#46d5f1',
                                                hoverBackgroundColor: '#CCCCCC',
                                                hoverBorderColor: '#666666',
                                                data: money
                                            }
                                        ]
                                    };

                                    var graphTarget = $("#graphCanvas");

                                    var barGraph = new Chart(graphTarget, {
                                        type: 'bar',
                                        data: chartdata
                                    });
                                });
                            }
                        }
                        </script>

                </div>
</div>
                
                </section>
            </div>
            <footer>
             
            </footer>
        </div>
</div>
    <script src="<?php echo $base;?>assets/js/feather-icons/feather.min.js"></script>
    <script src="<?php echo $base;?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $base;?>assets/js/app.js"></script>
    <script src="<?php echo $base;?>assets/vendors/chartjs/Chart.min.js"></script>
    <script src="<?php echo $base;?>assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo $base;?>assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $base;?>assets/js/main.js"></script>
</body>
</html>
