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
    <link rel="shortcut icon" href="<?php echo $base;?>assets/images/favicon.svg" type="image/x-icon">
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
                <img src="<?php echo $base;?>assets/images/logo.svg" alt="" srcset="">
            </div>
            <?php include'sidebar_header.php' ?>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
        </div>
    </div>
        <div id="main">
            <?php include'nav_header.php' ?>
            
            <div class="main-content container-fluid">
                <div class="page-title">
                    <h3>Bình luận</h3>
                </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Danh sách bình luận
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Sản phẩm</th>
                            <th>Nội dung</th>
                            <th>Trả lời</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            if($_SESSION['role']==1) {
                            ?>
                            <?php foreach ($db->getData('SELECT * from products') as $key => $v): ?>
                            <?php foreach ($db->getData('SELECT * from comments where id_prd='.$v['id_prd'].' and id_prcmt = 0') as $key => $c): ?>
                            <tr>    
                                <td><?php 
                                    $usn = $db->getRow('SELECT username from accounts where id_user ='.$c['id_user'].'');
                                    echo $usn['username'];
                                ?>
                                </td>
                                <td>
                                    <img src="<?php echo $v['image_prd']?>" alt="" srcset="" height="50px" >
                                    <?php echo $v['name_prd'];?>
                                </td>
                               
                                <td>
                                    <?php
                                       echo $c['detail_cmt'];
                                    ?>
                                    <br>
                                    <?php
                                    for ($i = 1; $i <= $c['vote_prd']; $i++) {
                                        echo '<i style="color: #f5df4d;" class="fa fa-star"></i>';}
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $rep = $db->getRow("SELECT detail_cmt from comments where id_prcmt = ".$c['id_cmt']."");
                                    if(isset($rep['detail_cmt']))
                                    echo $rep['detail_cmt'];
                                    ?>
                                </td>
                                <td>
                                <?php
                                    $count = $db->getRow("SELECT count(id_cmt) as total from comments where id_prcmt = ".$c['id_cmt']."");
                                    if($count['total'] > 0){
                                        echo'<span class="badge bg-success">Đã trả lời</span>';
                                    }else{
                                        echo' <span class="badge bg-danger">Chưa trả lời</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                <a href="reply.php?id_cmt=<?php echo $c['id_cmt']?>" name="edit" class="btn icon btn-sm round"><i class="fas fa-reply"></i></a>
                                </td>
                            </tr>    
                            <?php endforeach ?>
                            <?php endforeach ?>
                            <?php }else{?>
                                <?php foreach ($db->getData('SELECT * from products where id_user='.$_SESSION['id_user'].'') as $key => $v): ?>
                            <?php foreach ($db->getData('SELECT * from comments where id_prd='.$v['id_prd'].' and id_prcmt = 0') as $key => $c): ?>
                            <tr>    
                                <td><?php 
                                    $usn = $db->getRow('SELECT username from accounts where id_user ='.$c['id_user'].'');
                                    echo $usn['username'];
                                ?>
                                </td>
                                <td>
                                    <img src="<?php echo $v['image_prd']?>" alt="" srcset="" height="50px" >
                                    <?php echo $v['name_prd'];?>
                                </td>
                               
                                <td>
                                    <?php
                                       echo $c['detail_cmt'];
                                    ?>
                                    <br>
                                    <?php
                                    for ($i = 1; $i <= $c['vote_prd']; $i++) {
                                        echo '<i style="color: #f5df4d;" class="fa fa-star"></i>';}
                                    ?>
                                </td>
                                
                                <td>
                                    <?php
                                    $rep = $db->getRow("SELECT detail_cmt from comments where id_prcmt = ".$c['id_cmt']."");
                                    if(isset($rep['detail_cmt']))
                                    echo $rep['detail_cmt'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $count = $db->getRow("SELECT count(id_cmt) as total from comments where id_prcmt = ".$c['id_cmt']."");
                                    if($count['total'] > 0){
                                        echo'<span class="badge bg-success">Đã trả lời</span>';
                                    }else{
                                        echo' <span class="badge bg-danger">Chưa trả lời</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                <a href="reply.php?id_cmt=<?php echo $c['id_cmt']?>" name="edit" class="btn icon btn-sm round"><i class="fas fa-reply"></i></a>
                                </td>
                            </tr>    
                            <?php endforeach ?>
                            <?php endforeach ?>
                            <?php }?>    
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
