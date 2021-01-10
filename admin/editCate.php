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
            display: block;
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
                        <h5>Sửa danh mục</h5>
                        <form action="" method="post">
                        <div class="form-group">
                        <?php foreach ($db->getData('select * from categories where id_cate='.$_GET['id_cate'].'') as $key => $v): ?>
                            <br><label>Tên danh mục</label>
                            <input required class="form-control" type="text" name="name_cate" value="<?php echo $v['name_cate'];?>">

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
                            <?php
                            if($v['id_parentcate']!=0)
                            {?>
                            <div class="cateFather mt-3" id="cateFather">
                                <label>Danh mục cha</label>
                                <div class="form-group">
                                    <select class="choices form-select" name="id_parentcate">
                                    <?php
                                    foreach ($db->getData("SELECT * from categories where id_parentcate =0") as $key => $p) {
                                        $select='';
                                        if($p['id_cate']==$v['id_parentcate']) $select='selected';
                                        echo '<option value="'.$p['id_cate'].'"'.$select.'>'.$p['name_cate'].'</option>';}
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <label for="">Danh mục cha có hay không ?</label>
                            <div class="form-check">
                                <input required class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Có
                                </label>
                            </div>
                            <div class="form-check">
                                <input required class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Không
                                </label>
                            </div>
                            <?php
                          
                            }?>
                            <?php endforeach ?>
                        </div>
                        <input type="submit" class="btn btn-info" name="update_cate" value="Lưu lại danh mục">
                        </form>
                        <?php
                         $nameCate=''; 
                        if (isset($_POST['update_cate'])) {
                            $nameCate = $db->getRow('SELECT * FROM categories WHERE name_cate = "'.$_POST['name_cate'].'"');
                            if(!isset($nameCate['name_cate']))
                            {  
                                if(isset($_POST['flexRadioDefault']))
                                  {
                                    if($_POST['flexRadioDefault']==1)
                                    {
                                        $db->updateCate($_POST['name_cate'],$_POST['id_parentcate'],$_SESSION['id_user'],$_GET['id_cate']);
                                        echo "<script type='text/javascript'>alert('Xong');</script>";
                                    }
                                    else
                                        {
                                            $db->updateCate($_POST['name_cate'],'',$_SESSION['id_user'],$_GET['id_cate']);
                                            echo "<script type='text/javascript'>alert('Xong');</script>";
                                        }
                                  }else
                                        {
                                            $db->updateCate($_POST['name_cate'],'',$_SESSION['id_user'],$_GET['id_cate']);
                                            echo "<script type='text/javascript'>alert('Xong');</script>";
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
