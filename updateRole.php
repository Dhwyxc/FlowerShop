<?php 
include_once './classes/database.php';
include_once './classes/session.php';
$db = new database();
$ss = new session();
$roleCheck = $_POST['roleCheck'];
$iduser = $_POST['iduser'];
if($roleCheck == 1){
    $a = 2;
}else{
    $a = 0;
}
$db -> statement("UPDATE `accounts` SET `role`= $a WHERE id_user = $iduser ");
 ?>
