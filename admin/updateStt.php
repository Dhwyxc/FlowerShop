<?php 
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$stt = $db->getRow("SELECT status_delivery from bills where id_bill=".$_GET['id_bill']."");
if($stt['status_delivery'] == 0){
    $a = 1;
}elseif($stt['status_delivery'] == 1){
    $a = 2;
}else{
    $a = 0;
}
$db -> statement("UPDATE `bills` SET `status_delivery`= $a WHERE id_bill=".$_GET['id_bill']."");
header('Location:'.$base.'admin/billDetails.php');
// echo "UPDATE `bills` SET `status_delivery`= $a WHERE id_bill=$idBill ";
 ?>
