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
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <?php if(isset($_GET['checkout'])){?>
                        <a href="<?php echo $base?>"><i class="fa fa-home"></i> Home</a>
                        <a href="<?php echo $base?>shop-cart.php">Shopping cart</a>
                        <span>Check out</span>
                        <?php  }else{?>
                        <a href="<?php echo $base?>"><i class="fa fa-home"></i> Home</a>
                        <span>Shopping cart</span>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
<?php if(!isset($_GET['checkout'])){
?>
<!-- Shop Section Start -->
    <?php
$ok=1;
if(isset($_SESSION['cart']))
    {
        foreach($_SESSION['cart'] as $k => $v)
            {
                if(isset($k))
                {
                    $ok=2;
                }
            }
    }
if($ok == 2)
    { ?>
        <form action='shop-cart.php' method='post'>
          <?php  foreach($_SESSION['cart'] as $key=>$value)
             {
                $item[]=$key;
             }
                 $str = implode(",",$item);	
                 ?>
                 <?php foreach ($db->getData('SELECT amount_prd from products where id_prd in ('.$str.')') as $key => $v): ?>
                <?php
                    if(isset($_POST['submit']))
                    {
                        foreach($_POST['sl'] as $k=>$value)
                            {
                                if(($value == 0) && (is_numeric($value)))
                                {   
                                    @header("Location:shop-cart.php");
                                    unset($_SESSION['cart'][$k]);
                                   
                                }
                                else if(($value > 0) && (is_numeric($value)) && $value < $v['amount_prd'])
                                {
                                    $_SESSION['cart'][$k]=$value;
                                }
                            }
                        @header("Location:shop-cart.php");
                    }
                    ?>
           <?php endforeach ?>
            <section class="shop-cart spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shop__cart__table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Đơn giá</th>
                                            <th>Số lượng</th>
                                            <th>Tổng</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                        <?php $total=0;?>
                        <?php foreach ($db->getData('SELECT * from products where id_prd in ('.$str.')') as $key => $v): ?>
                                    <tbody>
                                        <tr>
                                            <td class="cart__product__item">
                                                <a href="index.php?id_prd=<?php echo $v['id_prd']?>"><img src="<?php echo $v['image_prd']?>" alt="" width="90px" height="90px"></a>
                                                <div class="cart__product__item__title">
                                                    <a href="index.php?id_prd=<?php echo $v['id_prd']?>"><h6><?php echo $v['name_prd']?></h6></a>
                                                </div>
                                            </td>
                                            <?php  $price = $v['price_prd']*doubleval((100-$v['discount_prd'])/100);?>
                                            <td class="cart__price"><?php echo @number_format($price)?>₫</td>
                                            <td class="cart__quantity">
                                                <div class="pro-qty">
                                                    <input type="text" name="sl[<?php echo $v['id_prd']?>]" value="<?php echo @$_SESSION['cart'][$v['id_prd']];?>">
                                                </div>
                                            </td>
                                            <td class="cart__total"><?php echo @number_format($_SESSION['cart'][$v['id_prd']]*$price);?>₫</td>
                                            <?php  @$total += $_SESSION['cart'][$v['id_prd']]*$price;?>
                                            <td class="cart__close"><a href="delcart.php?id_prd=<?php echo($v['id_prd']) ?>"><span class="icon_close"></span></a></td>
                                        </tr>
                                    </tbody>
                        <?php endforeach?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="cart__btn">
                                <button style="border: 0;"><a href="delcart.php?id_prd=0">Xóa giỏ hàng </a></button>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="cart__btn update__btn">
                                <button style="border: 0;" type="submit" name="submit">
                                <a><span class="icon_loading"></span> Cập nhật giỏ hàng</a>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-4 offset-lg-2">
                            <div class="cart__total__procced">
                                <h6>Tổng giỏ hàng</h6>
                                <ul>
                                    <li>Tổng tiền <span><?php echo number_format($total)?>₫</span></li>
                                </ul>
                                <a href="?checkout" class="primary-btn">Đặt hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
    <?php }else{?>
        <section><div class="container">
        <div class="row">
        <div class="col-12">
        <br><br><br>
        <h4>Bạn không có món hàng nào trong giỏ hàng</h4>
        </div>
        </div>
        </div></section>
    <?php }?>
    <?php }else{?>
        <section class="checkout spad">
        <div class="container">
            <form class="checkout__form" id="form_cart" onsubmit="return false">
                <div class="row">
                    <div class="col-lg-8">
                        <h5>Chi tiết hóa đơn</h5>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="checkout__form__input">
                                    <p>Họ & Tên <span>*</span></p>
                                    <input type="text" id="fullname">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <div class="row">
                                        <div class="col-lg-6">
                                        <p>Tỉnh/Thành phố <span>*</span></p>
                                            <select name="calc_shipping_provinces" required="" style="height: 50px; font-size: 14px; width: 100%;border-radius: 3px; border: 1px solid #e1e1e1; padding-left: 20px;">
                                            <option value="">Tỉnh/Thành phố</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                        <p>Quận/Huyện<span>*</span></p>
                                        <select name="calc_shipping_district" required="" style="height: 50px; font-size: 14px; width: 100%;border-radius: 3px; border: 1px solid #e1e1e1; padding-left: 20px;">
                                        <option value="">Quận/Huyện</option>
                                        </select>
                                        </div>
                                    </div>
                                <input class="billing_address_1" id="addressb" type="hidden" value="">
                                <input class="billing_address_2" id="addressc" type="hidden" value="">
                                </div>
                                <br>
                                <div class="checkout__form__input">
                                    <p>Địa chỉ <span>*</span></p>
                                    <input type="text" placeholder="Toàn Nhà, Tên Đường..." id="addressa">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Số điện thoại <span>*</span></p>
                                    <input type="text" id="phonenum">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Email <span>*</span></p>
                                    <input type="text" id="email">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                    <div class="checkout__form__input">
                                        <p>Ghi chú </p>
                                        <input type="text" id="notes" placeholder="Ghi chú...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="checkout__order">
                                <h5>Đơn hàng của bạn</h5>
                                <div class="checkout__order__product">
                                    <ul>
                                        <li>
                                            <span class="top__text">Sản phẩm</span>
                                            <span class="top__text__right">Tổng</span>
                                        </li>
                                        <?php if(isset($_SESSION['cart']))
                                        foreach($_SESSION['cart'] as $key=>$value)
                                        {
                                           $item[]=$key;
                                        }
                                        if(isset($item))
                                            $str = implode(",",$item);	
                                        $total=0;
                                        if(isset($str))
                                        foreach ($db->getData('SELECT * from products where id_prd in ('.$str.')') as $key => $v): ?>
                                        <?php  $price = $v['price_prd']*doubleval((100-$v['discount_prd'])/100);?>
                                        <input class="all_id" type="hidden" value="<?php echo $v['id_prd'].','.$_SESSION['cart'][$v['id_prd']].','.$price ?>">
                                        <li><?php echo $v['name_prd']?>(SL: <?php echo @$_SESSION['cart'][$v['id_prd']];?>)<span><?php echo @number_format($_SESSION['cart'][$v['id_prd']]*$price);?>₫</span></li>
                                        <?php  @$total += $_SESSION['cart'][$v['id_prd']]*$price;?>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                                <div class="checkout__order__total">
                                    <ul>
                                        <input type="hidden" id="price_total" value="<?php echo $total?>">
                                        <li>Tổng tiền <span><?php echo number_format($total)?>₫</span></li>
                                    </ul>
                                </div>
                                <div class="checkout__order__widget">
                                    
                                    <label for="COD">
                                        Thanh toán khi nhận hàng
                                    </label>
                                </div>
                                <button class="site-btn" type="submit" id="payment">Thanh toán</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
<input type="hidden" id="id_user" value="<?php echo $_SESSION['id_user']?>">
<script>
$("#payment").click(function(){
    $arrid=[];
    $('.all_id').each(function(key, value ){
        $arrid.push(value.value);
    })
    $name = $('#fullname').val();
    $phone = $('#phonenum').val();
    $add = ""+$('#addressb').val()+', '+$('#addressc').val()+', '+$('#addressa').val()+"";
    $email = $('#email').val();
    $iduser = $('#id_user').val();
    $price_total = $('#price_total').val();
    $notes = $('#notes').val();
    $.post("payment.php", {arrid: $arrid, name: $name, phone : $phone, add: $add, email: $email, iduser : $iduser, notes : $notes, price_total:$price_total}, function(result){
        location.assign('shop-cart.php');
     
    })
        })
</script>
<script src="<?php echo $base?>js/jquery-3.3.1.min.js"></script>
<script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>
<script>//<![CDATA[
if (address_2 = localStorage.getItem('address_2_saved')) {
  $('select[name="calc_shipping_district"] option').each(function() {
    if ($(this).text() == address_2) {
      $(this).attr('selected', '')
    }
  })
  $('input.billing_address_2').attr('value', address_2)
}
if (district = localStorage.getItem('district')) {
  $('select[name="calc_shipping_district"]').html(district)
  $('select[name="calc_shipping_district"]').on('change', function() {
    var target = $(this).children('option:selected')
    target.attr('selected', '')
    $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
    address_2 = target.text()
    $('input.billing_address_2').attr('value', address_2)
    district = $('select[name="calc_shipping_district"]').html()
    localStorage.setItem('district', district)
    localStorage.setItem('address_2_saved', address_2)
  })
}
$('select[name="calc_shipping_provinces"]').each(function() {
  var $this = $(this),
    stc = ''
  c.forEach(function(i, e) {
    e += +1
    stc += '<option value=' + e + '>' + i + '</option>'
    $this.html('<option value="">Tỉnh / Thành phố</option>' + stc)
    if (address_1 = localStorage.getItem('address_1_saved')) {
      $('select[name="calc_shipping_provinces"] option').each(function() {
        if ($(this).text() == address_1) {
          $(this).attr('selected', '')
        }
      })
      $('input.billing_address_1').attr('value', address_1)
    }
    $this.on('change', function(i) {
      i = $this.children('option:selected').index() - 1
      var str = '',
        r = $this.val()
      if (r != '') {
        arr[i].forEach(function(el) {
          str += '<option value="' + el + '">' + el + '</option>'
          $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>' + str)
        })
        var address_1 = $this.children('option:selected').text()
        var district = $('select[name="calc_shipping_district"]').html()
        localStorage.setItem('address_1_saved', address_1)
        localStorage.setItem('district', district)
        $('select[name="calc_shipping_district"]').on('change', function() {
          var target = $(this).children('option:selected')
          target.attr('selected', '')
          $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
          var address_2 = target.text()
          $('input.billing_address_2').attr('value', address_2)
          district = $('select[name="calc_shipping_district"]').html()
          localStorage.setItem('district', district)
          localStorage.setItem('address_2_saved', address_2)
        })
      } else {
        $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>')
        district = $('select[name="calc_shipping_district"]').html()
        localStorage.setItem('district', district)
        localStorage.removeItem('address_1_saved', address_1)
      }
    })
  })
})
//]]></script>




    <?php }?>   
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
    <script src="<?php echo $base?>assets/js/main.js"></script>
    
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
    
    
</body>

</html>