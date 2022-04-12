<?php 
include_once 'classes/database.php';
include_once 'classes/session.php';
$db = new database();
session_start();

$row = $db->getRow('SELECT amount_prd from products where id_prd = '.$_GET['item'].'');
if($row['amount_prd']>0){
$id = $_GET['item'];
$iduser = $_SESSION['id_user']; 
if(isset($_SESSION['cart'][$id])) 
{ 
 $qty = $_SESSION['cart'][$id] + 1; 
} 
else 
	{ 
	 $qty=1; 
	} 
$_SESSION['cart'][$id]=$qty; 
$_SESSION['qty']= $qty;
header("location:".$_SERVER["HTTP_REFERER"]); 
exit(); 
}else{

echo '<script type="text/javascript">alert("Hết Hàng!!!!")</script>';
header("location:".$_SERVER["HTTP_REFERER"]); 

exit(); 
}


?> 
