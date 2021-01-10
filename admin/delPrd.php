<?php
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();

        $db->statement("DELETE from products where id_prd=".$_GET['id_prd']."");
        header('Location:'.$base.'admin/editProducts.php');
    
?>