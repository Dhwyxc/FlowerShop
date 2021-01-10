<?php 
session_start();
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
?> 
