<?php
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
    
        $sql ="DELETE FROM `comments` WHERE id_cmt = ".$_GET['id_cmt']." OR id_prcmt = ".$_GET['id_cmt']."";
        $db->statement($sql);
        header('Location:'.$base.'admin/repCmt.php');
?>