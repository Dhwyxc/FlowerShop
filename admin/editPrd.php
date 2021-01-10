<?php
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
require 'vendor/autoload.php';
require 'config-cloud.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FlowerShop Admin Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/choices.js/choices.min.css" />
    <link rel="stylesheet" href="<?php echo $base;?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/simple-datatables/style.css" />
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/chartjs/Chart.min.css">
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?php echo $base;?>assets/css/app.css">
    <link rel="shortcut icon" href="<?php echo $base;?>assets/images/favicon.svg" type="image/x-icon">
   
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
                    <h3>Sản phẩm</h3>
                </div>
                <section class="section">
                    <div class="row mt-4 mb-2">
                    <div class="col-12 col-md-6 mt-2">
                    <div class="card p-3">
                        <h5>Sửa sản phẩm</h5>
                        <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                        <?php foreach ($db->getData('select * from products where id_prd='.$_GET['id_prd'].'') as $key => $v): ?>
                            
                            <br><label>Tên sản phẩm</label>
                            <input required class="form-control" type="text" name="name_prd" value="<?php echo $v['name_prd'];?>">
                            <br><label>Giá</label>
                            <input required class="form-control" type="number" name="price_prd" value="<?php echo $v['price_prd'];?>">
                            <br><label>Số lượng</label>
                            <input required class="form-control" type="number" name="amount_prd" value="<?php echo $v['amount_prd'];?>">
                            <br><label>Mô tả</label>
                            <textarea required id="editor" name="desc_prd"><?php echo $v['desc_prd'];?></textarea>
                            <br><label>Giảm giá</label>
                            <input class="form-control" type="number" name="discount_prd" value="<?php echo $v['discount_prd'];?>">
                            <br><label>Ảnh</label>
                            <br><input required type="file" name="image_prd">
                            <br><br><label>Danh mục</label>
                                <div class="form-group">
                                    <select class="choices form-select" name="id_cate">
                                    <?php 
                                    foreach ($db->getData("SELECT * from categories") as $key => $p) {
                                        $select='';
                                        if($p['id_cate']==$v['id_cate']) $select='selected';
                                        echo '<option value="'.$p['id_cate'].'"'.$select.'>'.$p['name_cate'].'</option>';}
                                    ?>
                                    </select>
                                </div>
                                
                        <?php endforeach ?>
                        </div>
                        <input type="submit" class="btn btn-info" name="update_prd" value="Lưu lại sản phẩm">
                        </form>
                            
                        <?php
                      
                        if (isset($_POST['update_prd'])) {
                                
                            $filename = $_FILES["image_prd"]["name"];
                            $tempfile = $_FILES["image_prd"]["tmp_name"];
                            $slug = $db->slug($filename);
                            // $filenameWithDirectory = "image/".$filename;
                            $id_cate = $_POST['id_cate'];
                            $name_prd = $_POST['name_prd'];
                            $price_prd = $_POST['price_prd'];
                            $discount_prd = $_POST['discount_prd'];
                            // $image_prd = $filenameWithDirectory;
                            $desc_prd = $_POST['desc_prd'];
                            $amount_prd = $_POST['amount_prd'];
                            $id_user = $_SESSION['id_user'];
                            $id_prd = $_GET['id_prd'];
                            if($price_prd<0 || $amount_prd<0){
                                $message="Vui lòng kiểm tra lại số lượng và giá của sản phẩm!";
                                echo "<script type='text/javascript'>alert('$message');</script>";
                            }else{
                                \Cloudinary\Uploader::upload($tempfile, array("public_id"=> $slug));
                                $img = cloudinary_url($slug);
                                // move_uploaded_file($tempfile, $filenameWithDirectory);
                                $db->updatePrd($id_cate,$name_prd,$price_prd,$discount_prd,$img,$desc_prd,$amount_prd,$id_user,$id_prd);
                                $message="Đã lưu lại sản phẩm!";
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
                                Danh sách sản phẩm
                                </div>
                                <div class="card-body">
                                <table class='table table-striped' id="table1">
                                        <thead>
                                            <tr>
                                                <th>Danh mục</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Hình ảnh</th>
                                                <th>Giá</th>
                                                <th>Số lượng</th>
                                                <th>Giảm giá</th>
                                                <th>Trạng thái</th>
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
    <script>
            CKEDITOR.replace( 'editor' );
    </script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.12.5/js/vendor/jquery.ui.widget.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.12.5/js/jquery.iframe-transport.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.12.5/js/jquery.fileupload.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cloudinary-jquery-file-upload/2.1.2/cloudinary-jquery-file-upload.js"></script>
</body>
</html>
