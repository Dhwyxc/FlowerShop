<?php
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
    
        $status_cate = $db->getRow('select status_prd from products where id_prd ='.$_GET['id_prd'].'');
        if($status_cate['status_prd']==0)
        {   $sql="UPDATE `products` SET `status_prd`= 1 WHERE `id_prd`= ".$_GET['id_prd']."";
            $db->statement($sql);
            header('Location:'.$base.'admin/editProducts.php');
        }elseif($status_cate['status_prd']==1){
                $sql="UPDATE `products` SET `status_prd`= 0 WHERE `id_prd`= ".$_GET['id_prd']."";
                $db->statement($sql);
                header('Location:'.$base.'admin/editProducts.php');
        }
               
?>