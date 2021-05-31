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
                    <h3>Đơn hàng</h3>
                </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
               Danh sách đơn hàng
               <br>
               <?php
               if($_SESSION['role']!=1){
                    foreach($db->getData("SELECT id_prd from products where id_user = ".$_SESSION['id_user']."") as $key => $v){
                        foreach($db->getData("SELECT id_bill from bill_details where id_prd = ".$v['id_prd']."") as $key => $v){
                            $idb[] = $v['id_bill'];
                        }    
                    }
                    $str = implode(",",$idb);	
                    $tongdon = $db->getRow("SELECT COUNT(id_bill) AS tong FROM bills where id_bill in (".$str.")");
                    echo "Tổng số đơn hàng: ".$tongdon['tong'];
                }else{
                    $tongdon = $db->getRow("SELECT COUNT(id_bill) AS tong FROM bills");
                    echo "Tổng số đơn hàng: ".$tongdon['tong'];
                }
                ?>
            </div>
            <div class="card-body table-responsive">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Địa chỉ nhận hàng</th>
                            <th>Tổng đơn</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            if($_SESSION['role']==1)
                            {
                                $sql = 'SELECT * from bills';
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
                                <form action="billDetails.php" method="get">
                                <a href="" class="btn icon btn-sm round" data-toggle="modal" data-target="#info<?php echo'MVD'.$v['id_bill'];?>"><i class="fas fa-eye"></i></a>
                                <a href="updateStt.php?id_bill=<?php echo $v['id_bill'];?>" class="btn icon btn-sm round" ><i class="fas fa-edit"></i></a>
                                </form>
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
                            <?php }else{
                                foreach($db->getData("SELECT id_prd from products where id_user = ".$_SESSION['id_user']."") as $key => $v){
                                    foreach($db->getData("SELECT id_bill from bill_details where id_prd = ".$v['id_prd']."") as $key => $v){
                                        $idb[] = $v['id_bill'];
                                    }    
                                }
                                $str = implode(",",$idb);	
                                foreach ($db->getData("SELECT * FROM bills where id_bill in (".$str.")") as $key => $v): 
                                ?>
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
                                <form action="billDetails.php" method="get">
                                <a href="" class="btn icon btn-sm round" data-toggle="modal" data-target="#info<?php echo'MVD'.$v['id_bill'];?>"><i class="fas fa-eye"></i></a>
                                <a href="updateStt.php?id_bill=<?php echo $v['id_bill'];?>" class="btn icon btn-sm round" ><i class="fas fa-edit"></i></a>
                                </form>
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
                            <?php endforeach?>
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
    <script src="<?php echo $base;?>assets/js/app.js"></script>
    <script src="<?php echo $base;?>assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $base;?>assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="<?php echo $base;?>assets/js/vendors.js"></script>
    <script src="<?php echo $base;?>assets/js/main.js"></script>
</body>
</html>
