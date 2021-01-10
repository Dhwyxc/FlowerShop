 <!-- Breadcrumb Begin -->
 <?php
 $prd = $db->getRow("SELECT * from products where id_prd =".$_GET['id_prd'].""); 
 ?>
 <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="<?php echo $base?>"><i class="fa fa-home"></i> Home</a>
                        <?php $nameCate = $db->getRow("SELECT name_cate from categories where id_cate =".$prd['id_cate'].""); ?>
                        <a href="<?php echo $base."index.php?id_cate=".$prd['id_cate']?>"><?php echo $nameCate['name_cate'] ?></a>
                        <span><?php echo $prd['name_prd']?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                <img class="product__big__img" src="<?php echo $prd['image_prd']?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3><?php echo $prd['name_prd']?><span>Loại: <?php echo $nameCate['name_cate']?></span></h3>
                        <div class="rating">
                            <?php $vs = $db->getRow("SELECT AVG(vote_prd) AS star 
                                                    FROM comments where id_prd=".$prd['id_prd']." and id_prcmt=0");
                            echo '<u>'.round($vs['star'],1).'</u> ';
                            for ($i = 1; $i <= round($vs['star']); $i++) {
                                echo '<i class="fa fa-star"></i> ';
                            }
                            ?>
                            
                            <span>
                            <?php  $ttcmt = $db->getRow("SELECT count(id_cmt) as total 
                                                         from comments where id_prd = ".$prd['id_prd']." and id_prcmt=0");?>    
                            ( <?php echo $ttcmt['total']?> Đánh giá )</span>
                        </div>
                        <?php  $price = $prd['price_prd']*doubleval((100-$prd['discount_prd'])/100); 
                        if($prd['discount_prd']!=0){
                        ?>
                        <div class="product__details__price"><?php echo number_format($price)?> ₫<span><?php echo number_format($prd['price_prd'])?> ₫</span></div>
                        <?php }else{ ?>
                            <div class="product__details__price"><?php echo number_format($prd['price_prd'])?> ₫</div>
                        <?php } ?>
                        <?php if($prd['amount_prd']>0){?>
                        <div class="product__details__button">
                            <?php if(isset($_SESSION['username'])){?>
                                <a href="addcart.php?item=<?php echo($prd['id_prd'])?>" class="cart-btn"><span class="icon_bag_alt"></span> Thêm vào giỏ hàng</a>
                            <?php }else{?>
                                <a href="Login.php" class="cart-btn"><span class="icon_bag_alt"></span> Thêm vào giỏ hàng</a>
                            <?php }?>
                        </div>
                        <?php }else{?>
                            <div class="product__details__button">
                            <a href="" class="cart-btn">Hết hàng</a>
                        </div>
                        <?php }?>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Có sẵn:</span>
                                    <p><?php echo $prd['amount_prd']?> sản phẩm</p>
                                   
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Mô tả</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Đánh giá sản phẩm</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Mô tả</h6>
                                <?php echo $prd['desc_prd']?>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
<!-- /////////////////// -->
<input type="hidden"id="id_user" value="<?php echo $_SESSION['id_user']?>">
<input type="hidden"id="username" value="<?php echo $_SESSION['username']?>">
<input type="hidden"id="id_prd" value="<?php echo $prd['id_prd']?>">
<script>
    $(document).ready(function(){
        $("#sendcm").click(function(){
            var idprd = $('#id_prd').val();
            var txt = $("#comment").val();
            var iduser = $('#id_user').val();
            var usname = $('#username').val();
            var vote = $('#star_rating').val();
            var star = "";
            for (i = 1; i <= vote; i++) {
                star +=  '<i style="color: #f5df4d;" class="fa fa-star"></i>';
                }
            var month = new Array();
            month[0] = "January";
            month[1] = "February";
            month[2] = "March";
            month[3] = "April";
            month[4] = "May";
            month[5] = "June";
            month[6] = "July";
            month[7] = "August";
            month[8] = "September";
            month[9] = "October";
            month[10] = "November";
            month[11] = "December";

            var d = new Date();
            var n = month[d.getMonth()];
            $.post("addcomment.php", {noidung: txt, idprd: idprd, iduser: iduser, vote: vote}, function(result){
              $("#comments").append(
                
                '<div class="blog__comment__item"><div class="blog__comment__item__pic"><img src="img/blog/details/comment.jfif" width="90px" height="90px" alt=""></div><div class="blog__comment__item__text"><h6>'+usname+'</h6><p>'+txt+'</p>'+star+'<ul><li><i class="fa fa-clock-o"></i>'+n+' '+d.getDate()+', '+d.getFullYear()+', '+d.toLocaleTimeString()+'</li></ul></div></div>'

                // '<div class="row"><div class="col-lg-1"><label style="font-size: 18px;"><span style="font-size: 17px;">'+usname+'</span></label></div><div class="col-lg-11"><span style="font-size: 17px;">'+txt+'</span><hr></div>'
              );  
            })
        })
    })
</script>  
<!-- ////////////////// -->
                                <h6>Đánh giá sản phẩm</h6>
                               <div class="row">
                                   <div class="col-12">
                                       <?php if(isset($_SESSION['username'])){?>
                                    <div class="blog__comment__item">
                                            <div class="blog__comment__item__pic">
                                                <img src="img/blog/details/comment.jfif" alt=""  height="90px" width="90px">
                                            </div>
                                            <div class="blog__comment__item__text">
                                                <h6><?php echo $_SESSION['username']?></h6>
                                                <div class="row">
                                                    <div class="col-10">
                                                    <input id="comment" placeholder="Đánh giá của bạn..." style="width: 100%;  height: 40px; border-radius: 3px; border: 2px solid #939597;" type="text">
                                                    <span>
                                                    <i style="color: #f5df4d;" class="fa fa-star"></i>
                                                    <i style="color: #f5df4d;" class="fa fa-star"></i>
                                                    <i style="color: #f5df4d;" class="fa fa-star"></i>
                                                    <i style="color: #f5df4d;" class="fa fa-star"></i>
                                                    <i style="color: #f5df4d;" class="fa fa-star"></i>
                                                    <select style="font-weight: 500 ;width: 100px; height: 30px; margin: 10px; border-radius: 3px; border: 2px solid #939597;" name="star_rating" id="star_rating">
                                                        <option value="1">1 sao</option>
                                                        <option value="2">2 sao</option>
                                                        <option value="3">3 sao</option>
                                                        <option value="4">4 sao</option>
                                                        <option value="5">5 sao</option>
                                                    </select>   
                                                    </span>
                                                    </div>
                                                    <div class="col-2">
                                                    <button style="width: 100%; height: 40px; font-size: 18px;" class="btn btn-danger" id="sendcm"><i class="fa fa-paper-plane"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       <?php }else{
                                           echo "<span>Vui lòng đăng nhập để bình luận!!!</span>";
                                       }?>
                                        <hr>
                                    <div id="comments">
                                    <?php foreach ($db->getData("SELECT * from comments WHERE id_prd =".$prd['id_prd']."") as $key => $v): ?>    
                                    <?php if($v['id_prcmt']==0)
                                    {?>
                                    <div class="blog__comment__item">
                                        <div class="blog__comment__item__pic">
                                            <img src="img/blog/details/comment.jfif" alt="" height="90px" width="90px">
                                        </div>
                                        <div class="blog__comment__item__text">
                                            <h6><?php $usn = $db->getRow("SELECT username from accounts where id_user =".$v['id_user']."");
                                            echo $usn['username'];
                                            ?>
                                            </h6>
                                            <p><?php echo $v['detail_cmt']?></p>
                                            <?php
                                            for ($i = 1; $i <= $v['vote_prd']; $i++) {
                                                echo '<i style="color: #f5df4d;" class="fa fa-star"></i>';}
                                            ?>
                                            <ul>
                                                <li><i class="fa fa-clock-o"></i><?php  $date = date_create($v['created_at']);
                                                                                        echo date_format($date, 'F j, Y, g:i:s a');?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                        <?php
                                        $repcm = $db->getRow("SELECT count(id_cmt) as total from comments where id_prcmt = ".$v['id_cmt']."");
                                        if($repcm['total']!=0)
                                        {?>
                                            <?php foreach ($db->getData("SELECT * from comments WHERE id_prcmt =".$v['id_cmt']."") as $key => $vc): ?>    
                                                <div class="blog__comment__item blog__comment__item--reply">
                                                <div class="blog__comment__item__pic">
                                                    <img src="img/blog/details/ad.jpg" alt=""  height="90px" width="90px">
                                                </div>
                                                <div class="blog__comment__item__text">
                                                    <h6><?php $usnm = $db->getRow("SELECT username from accounts where id_user =".$vc['id_user']."");
                                                    echo $usnm['username'];
                                                    ?>
                                                    </h6>
                                                    <p><?php echo $vc['detail_cmt']?></p>
                                                    <ul>
                                                        <li><i class="fa fa-clock-o"></i><?php  $datec = date_create($vc['created_at']);
                                                                                                echo date_format($datec, 'F j, Y, g:i:s a ');?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                </div>
                                            <?php endforeach; } ?>
                                            <hr>
                                    <?php } endforeach?>
                                    </div>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
    </section>
    <!-- Product Details Section End -->