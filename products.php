<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/FlowerShop/index.php";
?>
<?php
$searchRs="";
if(isset($_GET['search-value']))
{
    $searchRs = $_GET['search-value'];
}
?>
<?php
	$searchRs="";
	if(isset($_GET['search-value']))
	{
		$searchRs = $_GET['search-value'];
    }
    
	$row = $db->getRow("SELECT count(id_prd) as total from products where status_prd = 0");
	$total_records = $row['total'];
	$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
	if(isset($_GET['limit'])){
		$ss->savelimit($_GET['limit']);  
	}
	if(isset($_SESSION['limit'])){
		$limit = $_SESSION['limit'];
	}else{
		$limit=9;
	}
	$total_page = ceil($total_records / $limit);
	if ($current_page > $total_page)
		{
			$current_page = $total_page;
		}
	else if ($current_page < 1)
		{
			$current_page = 1;
		}
	$start = ((int)$current_page - 1) * $limit;
	
	?>
	<?php
	if(isset($_GET['min']) || isset($_GET['max'])){

	if($_GET['min']!='' && $_GET['max']!=''){
		$sql = "SELECT * from products 
                where status_prd = 0 
                and price_prd >= ".$_GET['min']." 
                and price_prd <= ".$_GET['max']."
                LIMIT $start, $limit";
	}else{
		if($_GET['max']!=''){
			$sql="SELECT * from products 
            where status_prd = 0 
            and price_prd <= ".$_GET['max']."
            LIMIT $start, $limit";
		}else
		if($_GET['min']!=''){
			$sql="SELECT * from products 
            where status_prd = 0 
            and price_prd >= ".$_GET['min']."
            LIMIT $start, $limit";
		}
	}
	}else{

		$sql="SELECT * from products 
        where status_prd = 0 
        AND name_prd like '%".$searchRs."%' 
        LIMIT $start, $limit";
    }
    ?>
<div class="col-lg-9 col-md-9">
                    <div class="row">
                        <?php foreach ($db->getData($sql) as $key => $v): ?>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                            <div class="product__item sale">
                                <div class="product__item__pic set-bg" data-setbg="<?php echo $v['image_prd']?>">
                                <?php if($v['discount_prd']!=0){?>
                                    <div class="label">Sale</div>
                                <?php } ?>    
                                    <ul class="product__hover">
                                        <li><a href="<?php echo $v['image_prd']?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                                       <?php
                                       $row = $db->getRow('SELECT amount_prd from products where id_prd = '.$v['id_prd'].'');
                                       if(isset($_SESSION['username'])){
                                           if($row['amount_prd']>0){?>
                                        <li><a href="addcart.php?item=<?php echo($v['id_prd']) ?>"><span class="icon_bag_alt"></span></a></li>
                                        <?php }}
                                        else{?>
                                            <li><a href="Login.php" class="cart-btn"><span class="icon_bag_alt"></span></a></li>
                                        <?php }?>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="?id_prd=<?php echo $v['id_prd']?>"><?php echo $v['name_prd'];
                                     $price = $v['price_prd']*doubleval((100-$v['discount_prd'])/100);
                                    ?></a></h6>
                                    <div class="rating">
                                    <?php $vs = $db->getRow("SELECT AVG(vote_prd) AS star 
                                                    FROM comments where id_prd=".$v['id_prd']." and id_prcmt=0");
                                        if(round($vs['star'])!=0)
                                            {
                                                for ($i = 1; $i <= round($vs['star']); $i++) {
                                                echo '<i class="fa fa-star"></i> ';}
                                            }else{
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo '<i style="color: gray" class="fa fa-star"></i> ';}
                                            }
                                        ?>
                                    </div>
                                    
                                    <?php if($v['discount_prd']==0)
                                    {?>
                                        <div class="product__price" style="color: black;"><?php echo number_format($v['price_prd']).' ₫'?></div>
                                    <?php }else{?>   
                                        <div class="product__price"><?php echo number_format($price).' ₫'?> <span><?php echo number_format($v['price_prd']).' ₫'?></span></div>
                                    <?php } ?> 
                                    
                                </div>
                            </div>
                        </div>
                        <?php endforeach?>
                        <div class="col-lg-12 text-center">
                            <?php
                            if(isset($v['id_prd'])){
                                echo '<div class="pagination__option">';
                            if ($current_page > 1 && $total_page > 1)
                            { 
                                $i="fa fa-angle-left";

                                echo '<a href="'.$actual_link.'?page='.($current_page-1).'"><i class="'.$i.'"></i></a>';
                                }
                                for ($i = 1; $i <= $total_page; $i++){
                                if ($i == $current_page)
                                    {
                                        echo '<a style="background-color: black;color:white;">'.$i.'</a>';
                                    }
                                    else
                                        {
                                            echo '<a  href="'.$actual_link.'?page='.$i.'">'.$i.'</a>';
                                        }
                                }
                                if ($current_page < $total_page && $total_page > 1)
                                {
                                    $i="fa fa-angle-right";
                                echo '<a href="'.$actual_link.'?page='.((int)$current_page+1).'"><i class="'.$i.'"></i></a>';
                                }
                            echo'</div>';}
                            else echo"Không có sản phẩm nào";
                            ?>
                        </div>
                    </div>
                </div>