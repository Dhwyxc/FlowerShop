<?php 
include 'config.php';

$id_prd = $_GET['id_prd'];
$id_user = $id;
$getiduser="SELECT * FROM carts WHERE id_user = ".$id_user."";
$haveid= $db->getRow($getiduser);
if(!isset($haveid['id_user']))
	{
		$sql="INSERT INTO `carts`(`id_user`) VALUES (".$id_user.")";
		$db->statement($sql);
		$last_id_cart= $db->last_id();
		$ins_cartdt = "INSERT INTO `cart_details`(`id_cart`, `id_prd`, `prd_qty`) VALUES (".$last_id_cart.",".$id_prd.",'1')";
		$db->statement($ins_cartdt);
	}
else
	{	
		$slprd="SELECT * FROM cart_details where id_prd=".$id_prd." AND id_cart=".$haveid['id_cart']."";
		$haveidprd=$db->getRow($slprd);
		$sl = $haveidprd['prd_qty'];
		if(isset($haveidprd['id_prd'])){
			$sl += 1;
			$update = "UPDATE `cart_details` 
					SET `prd_qty`=".$sl." 
					WHERE `id_cartdt`=".$haveidprd['id_cartdt']."";
			$db->statement($update);
		}else{
			$ins_cartdt = "INSERT INTO `cart_details`(`id_cart`, `id_prd`, `prd_qty`) VALUES (".$haveid['id_cart'].",".$id_prd.",'1')";
			$db->statement($ins_cartdt);
		}
	}
?> 
