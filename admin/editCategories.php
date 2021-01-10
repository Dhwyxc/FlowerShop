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
                    <h3>Danh mục</h3>
                </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
               Danh mục
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>Danh mục cha</th>
                            <th>Tên danh mục</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            if($_SESSION['role']==1)
                            $sql = 'SELECT * from categories';
                            else
                            $sql = 'SELECT * from categories where id_user='.$_SESSION['id_user'].'';
                            foreach ($db->getData($sql) as $key => $v): ?>
                            <tr>    
                                <td>
                                    <?php
                                    if($v['id_parentcate']==0)
                                    echo'';
                                    else {
                                    $name_cate = $db->getRow('SELECT name_cate from categories where id_cate ='.$v['id_parentcate'].'');
                                    echo $name_cate['name_cate'];
                                    }
                                    ?>
                                </td>
                                <td><?php echo $v['name_cate']?></td>
                                <td>
                                    <?php
                                        if($v['status_cate']==0)
                                        echo'<span class="badge bg-success">Available</span>';
                                        else
                                        echo' <span class="badge bg-danger">Unavailable</span>';
                                    ?>
                                </td>
                                <td>
                                <form action="editCategories.php" method="get">
                                <a href="statusCate.php?id_cate=<?php echo $v['id_cate']?>" name="disable" class="btn icon btn-sm round"><i class="fas fa-eye-slash"></i></a>
                                <a href="delCate.php?id_cate=<?php echo $v['id_cate']?>" name="delete" class="btn icon btn-sm round"><i class="fas fa-trash"></i></a>
                                <a href="editCate.php?id_cate=<?php echo $v['id_cate']?>" name="edit" class="btn icon btn-sm round"><i class="fas fa-edit"></i></a>
                                </form>
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
