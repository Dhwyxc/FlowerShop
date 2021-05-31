<?php
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FlowerShop Admin Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/simple-datatables/style.css" />
    <link rel="stylesheet" href="<?php echo $base;?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/chartjs/Chart.min.css">
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?php echo $base;?>assets/css/app.css">
   
    <style>
        #cateFather{
            display: none;
        }
    </style>
</head>
<body>
<div id="app">
    <div id="sidebar" class='active'>
        <div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <img src="<?php echo $base;?>assets/images/lg.png" alt="" srcset="">
            </div>
            <?php include'sidebar_header.php' ?>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
        <div id="main">
            <?php include'nav_header.php' ?>
            
            <div class="main-content container-fluid">
                <div class="page-title">
                    <h3>Danh sách người dùng</h3>
                </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
               Người dùng
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Họ tên</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Mail</th>
                            <th>Chức vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            
                            $sql = 'SELECT * from accounts where `role` != 1';
                            foreach ($db->getData($sql) as $key => $v): ?>
                            <tr>    
                                <td><?php echo $v['username'];?></td>
                                <td><?php echo $v['full_name']?></td>
                                <td><?php echo $v['address']?></td>
                                <td><?php echo $v['phone_num']?></td>
                                <td><?php echo $v['mail']?></td>
                                
                                <td>
                                    <?php
                                        if($v['role']==0)
                                        echo'<span class="badge bg-success">Khách hàng</span>';
                                        elseif($v['role']==2)
                                        echo' <span class="badge bg-info">Người bán hàng</span>';
                                        else
                                        echo' <span class="badge bg-danger">Admin</span>';
                                    ?>
                                </td>
                               
                            </tr>    
                            <?php endforeach ?>

                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
            </div>
        </div>
</div>
    <script src="<?php echo $base;?>assets/js/feather-icons/feather.min.js"></script>
    <script src="<?php echo $base;?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $base;?>assets/js/app.js"></script>
    
    <script src="<?php echo $base;?>assets/vendors/chartjs/Chart.min.js"></script>
    <script src="<?php echo $base;?>assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo $base;?>assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $base;?>assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="<?php echo $base;?>assets/js/vendors.js"></script>
    <script src="<?php echo $base;?>assets/js/main.js"></script>
</body>
</html>
