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
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="<?php echo $base;?>assets/vendors/simple-datatables/style.css" />
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
    
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href=""><i class="fa fa-home"></i> Tài khoản của tôi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
        <section class="section">
        <div class="card">
            <div class="card-header">
               Danh sách đơn hàng
            </div>
            <div class="card-body table-responsive">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Địa chỉ nhận hàng</th>
                            <th>Tổng đơn</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Xem chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $sql = "SELECT * from bills where id_user=".$_SESSION['id_user']."";
                            foreach ($db->getData($sql) as $key => $v): ?>
                            <tr>    
                                <td>
                                    <?php
                                        echo 'MVD'.$v['id_bill'];
                                    ?> 
                                    
                                </td>
                                <td>
                                    <?php echo $v['full_name']?>
                                    <br>
                                    (<?php echo $v['phone_num']?>)
                                    <br>
                                    <?php echo $v['address_delivery']?>
                                </td>
                                <td><?php echo number_format($v['price_total'])?>đ</td>
                                <td>
                                    <?php
                                        if($v['status_delivery']==0)
                                        echo'<span class="badge bg-light">Chờ xác nhận</span>';
                                        elseif($v['status_delivery']==1)
                                        echo' <span class="badge bg-info">Đang giao hàng</span>';
                                        else
                                        echo' <span class="badge bg-success">Đã giao hàng</span>';
                                    ?>
                                </td>
                                <td>
                                <a href="" class="btn icon btn-sm round" data-toggle="modal" data-target="#info<?php echo'MVD'.$v['id_bill'];?>"><i class="fas fa-eye"></i></a>
                                </td>
                                <div class="modal fade text-left" id="info<?php echo'MVD'.$v['id_bill'];?>" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel130" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info">
                                        <h5 class="modal-title white" id="myModalLabel130">Chi tiết đơn hàng <?php echo 'MVD'.$v['id_bill'];?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="row">
                                              <div class="col-3">Sản phẩm</div>
                                              <div class="col-3">Số lượng</div>
                                              <div class="col-3">Đơn giá</div>
                                              <div class="col-3">Tổng giá</div>
                                          </div>
                                          <hr>
                                          <?php foreach ($db->getData("SELECT * FROM bill_details where id_bill = ".$v['id_bill']."") as $key => $c): ?>
                                          <div class="row">
                                              <div class="col-3">
                                                  <?php $prd = $db->getRow("SELECT * from products where id_prd=".$c['id_prd']."");?>
                                                    <img style="border-radius: 5%;" src="<?php echo $prd['image_prd']?>" height="50px">
                                                    <br>
                                                    <?php  echo $prd['name_prd']; ?>
                                              </div>
                                              <div class="col-3"><?php echo $c['amount_prd']?></div>
                                              <div class="col-3"><?php echo number_format($c['price_prd'])?>đ</div>
                                              <div class="col-3"><?php echo number_format($c['amount_prd']*$c['price_prd'])?>đ</div>
                                          </div>
                                          <hr>
                                          <?php endforeach?>
                                          <div class="row">
                                                <div class="col-12">Ngày đặt hàng: 
                                                <?php $date = date_create($v['time_order']);
                                                      echo date_format($date, 'd/m/Y, g:i:s a'); ?></div>
                                              <div class="col-12">Ghi chú: <?php echo $v['oder_notes']?></div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Close</span>
                                        </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </tr>    
                            <?php endforeach ?>

                    </tbody>
                </table>
            </div>
        </div>

    </section>
        </div>
    </section> 
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
    
    <script src="<?php echo $base;?>assets/js/app.js"></script>
    <script src="<?php echo $base;?>assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $base;?>assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="<?php echo $base;?>assets/js/vendors.js"></script>
    <script src="<?php echo $base;?>assets/js/main.js"></script>
    
</body>

</html>