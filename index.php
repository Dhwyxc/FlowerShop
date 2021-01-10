<?php
include_once 'classes/database.php';
include_once 'classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FlowerShop</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Css Styles -->
    
    <link rel="stylesheet" href="<?php echo $base?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $base?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $base?>css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $base?>css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $base?>css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $base?>css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $base?>css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo $base?>css/style.css" type="text/css">
</head>

<body>
<?php include 'header_nav.php';?>
    <?php
         if(!isset($_GET['id_prd'])){
    ?>
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
<?php
         }
    if(isset($_GET['id_prd']))
    require_once 'product_detail.php';
    else{   
?>
    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                
                <?php
                require_once 'Cate.php';
                if(isset($_GET['id_cate'])){
                    require_once 'index_cate.php';     
                   }else{
                    require_once 'products.php';
                   }
                ?>
                
            </div>
        </div>
    </section>
<?php } ?>   
    <!-- Shop Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <div class="footer__copyright__text">
                        <p>Copyright &copy; dh.wyxc</p>
                    </div>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

 
    <!-- Js Plugins -->

    <script src="<?php echo $base?>js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo $base?>js/bootstrap.min.js"></script>
    <script src="<?php echo $base?>js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo $base?>js/jquery-ui.min.js"></script>
    <script src="<?php echo $base?>js/mixitup.min.js"></script>
    <script src="<?php echo $base?>js/jquery.countdown.min.js"></script>
    <script src="<?php echo $base?>js/jquery.slicknav.js"></script>
    <script src="<?php echo $base?>js/owl.carousel.min.js"></script>
    <script src="<?php echo $base?>js/jquery.nicescroll.min.js"></script>
    <script src="<?php echo $base?>js/main.js"></script>
    <script src="<?php echo $base?>assets/js/feather-icons/feather.min.js"></script>
    <script src="<?php echo $base?>assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $base?>assets/js/app.js"></script>
    <script src="<?php echo $base?>assets/js/main.js"></script>
    
</body>

</html>