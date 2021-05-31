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
                    <h3>Danh sách sản phẩm</h3>
                </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
               Sản phẩm
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>Danh mục</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Giảm giá</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            if($_SESSION['role']==1)
                            $sql = 'SELECT * from products';
                            else
                            $sql = 'SELECT * from products where id_user='.$_SESSION['id_user'].'';
                            foreach ($db->getData($sql) as $key => $v): ?>
                            <tr>    
                                <td>
                                    <?php
                                        $name_cate = $db->getRow('select name_cate from categories where id_cate ='.$v['id_cate'].'');
                                        echo $name_cate['name_cate'];
                                    ?>
                                </td>
                                <td><?php echo $v['name_prd']?></td>
                                <td>
                                    <img src="<?php echo $v['image_prd']?>" alt="" srcset="" height="50px" >
                                </td>
                                <td><?php echo $v['desc_prd']?></td>
                                <td><?php echo $v['price_prd']?></td>
                                <td><?php echo $v['amount_prd']?></td>
                                <td><?php echo $v['discount_prd']?></td>
                                <td>
                                    <?php
                                        if($v['status_prd']==0)
                                        echo'<span class="badge bg-success">Available</span>';
                                        else
                                        echo' <span class="badge bg-danger">Unavailable</span>';
                                    ?>
                                </td>
                                <td>
                                <form action="editProducts.php" method="get">
                                <a href="statusPrd.php?id_prd=<?php echo $v['id_prd']?>" name="disable" class="btn icon btn-sm  round"><i class="fas fa-eye-slash"></i></a>
                                <a href="delPrd.php?id_prd=<?php echo $v['id_prd']?>" name="delete" class="btn icon btn-sm  round"><i class="fas fa-trash"></i></a>
                                <a href="editPrd.php?id_prd=<?php echo $v['id_prd']?>" name="edit" class="btn icon btn-sm  round"><i class="fas fa-edit"></i></a>
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
