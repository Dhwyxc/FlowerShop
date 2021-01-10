<?php
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();

    $sql='SELECT COUNT(id_cate) FROM categories WHERE id_parentcate ='.$_GET['id_cate'].'';
    $row = $db->getRow($sql);
    $rsp = $row['COUNT(id_cate)'];
    if($rsp>0)
    {
        foreach ($db->getData('SELECT id_cate from categories where id_parentcate ='.$_GET['id_cate'].'') as $key => $v) {
            
                $db->statement("DELETE from categories where id_cate=".$v['id_cate']."");
        }
        $db->statement("DELETE from categories where id_cate=".$_GET['id_cate']."");
        header('Location:'.$base.'admin/editCategories.php');
    }else
    {
        $db->statement("DELETE from categories where id_cate=".$_GET['id_cate']."");
        header('Location:'.$base.'admin/editCategories.php');
    }
?>