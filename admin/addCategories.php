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
    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/choices.js/choices.min.css" />
    <link rel="stylesheet" href="<?php echo $base;?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/simple-datatables/style.css" />
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
                    <div class="row mt-4 mb-2">
                    <div class="col-12 col-md-6 mt-2">
                    <div class="card p-3">
                        <h5>Tạo danh mục</h5>
                        <form action="addCategories.php" method="post">
                        <div class="form-group">
                            <br><label>Tên danh mục</label>
                            <input required class="form-control" type="text" name="name_cate">
                            <br><label>Danh mục cha</label>
                            <script>
                               $(document).ready(function(){
                                    $("input[type='radio']").click(function(){
                                        var radioValue = $("input[name='flexRadioDefault']:checked").val();
                                        if(radioValue==1){
                                            $("#cateFather").show();
                                        }else
                                        $("#cateFather").hide();
                                    });
                                });
                                
                            </script>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Có
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Không
                                </label>
                            </div>
                            <div class="cateFather mt-3" id="cateFather">
                                <label>Chọn danh mục cha</label>
                                <div class="form-group">
                                    <select class="choices form-select" name="id_parentcate">
                                    <?php 
                                    foreach ($db->getData("select * from categories") as $key => $v) {
                                        echo '<option value="'.$v['id_cate'].'">'.$v['name_cate'].'</option>';}
                                    ?>
                                    </select>
                                </div>
                            </div>
                           
                        </div>
                        <input type="submit" class="btn btn-info" name="create_cate" value="Tạo danh mục">
                        </form>
                        <?php
                         $nameCate=''; 
                        if (isset($_POST['create_cate'])) {
                            $nameCate = $db->getRow('SELECT * FROM categories WHERE name_cate = "'.$_POST['name_cate'].'"');
                            if(!isset($nameCate['name_cate']))
                            {  
                                  if($_POST['flexRadioDefault']==1)
                                {
                                    $idpr = $db->getRow('SELECT id_parentcate from categories where id_cate ='.$_POST['id_parentcate'].'');
                                    if($idpr['id_parentcate']==0)
                                    {
                                        $db->insertCate($_POST['name_cate'],$_POST['id_parentcate'],$_SESSION['id_user']);
                                    }else{
                                        $message="Hệ thống chỉ cho phép tối đa 2 tầng danh mục";
                                        echo "<script type='text/javascript'>alert('$message');</script>";
                                        }
                                }
                                else
                                {
                                    $db->insertCate($_POST['name_cate'],'',$_SESSION['id_user']);
                                }
                            }else{
                                    $message="Danh mục đã tồn tại";
                                    echo "<script type='text/javascript'>alert('$message');</script>";
                                 }    
                        }
                        ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mt-2">
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
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                                                $sql = 'SELECT * from categories';
                                                foreach ($db->getData($sql) as $key => $v): ?>
                                                <tr>    
                                                    <td>
                                                        <?php
                                                        if($v['id_parentcate']==0)
                                                        echo'';
                                                        else {
                                                        $name_cate = $db->getRow('select name_cate from categories where id_cate ='.$v['id_parentcate'].'');
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
                                                </tr>    
                                                <?php endforeach ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </section>
                    </div>
                    </div>
                </section>
            </div>
        </div>
</div>
    <script src="<?php echo $base;?>assets/js/feather-icons/feather.min.js"></script>
    <script src="<?php echo $base;?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $base;?>assets/js/app.js"></script>
    
    <script src="<?php echo $base;?>assets/vendors/chartjs/Chart.min.js"></script>
    <script src="<?php echo $base;?>assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo $base;?>assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $base;?>assets/vendors/choices.js/choices.min.js"></script>
    <script src="<?php echo $base;?>assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="<?php echo $base;?>assets/js/vendors.js"></script>
    <script src="<?php echo $base;?>assets/js/main.js"></script>
</body>
</html>
