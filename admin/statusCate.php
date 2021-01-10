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
        $status_cate = $db->getRow('SELECT status_cate from categories where id_cate ='.$_GET['id_cate'].'');
        if($status_cate['status_cate']==0)
        {
        foreach ($db->getData('SELECT id_cate from categories where id_parentcate ='.$_GET['id_cate'].'') as $key => $v) {
            
            $db->statement("UPDATE `categories` SET `status_cate`= 1 WHERE `id_cate`= ".$v['id_cate']."");
            foreach ($db->getData('SELECT id_prd from products where id_cate ='.$v['id_cate'].'') as $key => $v) {
            
                $db->statement("UPDATE `products` SET `status_prd`= 1 WHERE `id_prd`= ".$v['id_prd']."");
            }
        }
        $db->statement("UPDATE `categories` SET `status_cate`= 1 WHERE `id_cate`= ".$_GET['id_cate']."");
        foreach ($db->getData('SELECT id_prd from products where id_cate ='.$_GET['id_cate'].'') as $key => $v) {
            
            $db->statement("UPDATE `products` SET `status_prd`= 1 WHERE `id_prd`= ".$v['id_prd']."");
        }
        header('Location:'.$base.'admin/editCategories.php');
        }elseif($status_cate['status_cate']==1)
            {
                foreach ($db->getData('SELECT id_cate from categories where id_parentcate ='.$_GET['id_cate'].'') as $key => $v) {
            
                    $db->statement("UPDATE `categories` SET `status_cate`= 0 WHERE `id_cate`= ".$v['id_cate']."");
                    foreach ($db->getData('SELECT id_prd from products where id_cate ='.$v['id_cate'].'') as $key => $v) {
            
                        $db->statement("UPDATE `products` SET `status_prd`= 0 WHERE `id_prd`= ".$v['id_prd']."");
                    }
                }
                $db->statement("UPDATE `categories` SET `status_cate`= 0 WHERE `id_cate`= ".$_GET['id_cate']."");
                foreach ($db->getData('SELECT id_prd from products where id_cate ='.$_GET['id_cate'].'') as $key => $v) {
            
                    $db->statement("UPDATE `products` SET `status_prd`= 0 WHERE `id_prd`= ".$v['id_prd']."");
                }
                header('Location:'.$base.'admin/editCategories.php');
            }
    }else
        {
            $id_parentcate = $db->getRow('SELECT id_parentcate from categories where id_cate ='.$_GET['id_cate'].'');
            if($id_parentcate['id_parentcate']!=0){
                $status_cate = $db->getRow('SELECT status_cate from categories where id_cate ='.$id_parentcate['id_parentcate'].'');
                if($status_cate['status_cate']==0)
                {   
                    $status_cateChill = $db->getRow('SELECT status_cate from categories where id_cate ='.$_GET['id_cate'].'');
                    if($status_cateChill['status_cate']==0)
                    {
                        $sql="UPDATE `categories` SET `status_cate`= 1 WHERE `id_cate`= ".$_GET['id_cate']."";
                        $db->statement($sql);
                        foreach ($db->getData('SELECT id_prd from products where id_cate ='.$_GET['id_cate'].'') as $key => $v) {
            
                            $db->statement("UPDATE `products` SET `status_prd`= 1 WHERE `id_prd`= ".$v['id_prd']."");
                        }
                        header('Location:'.$base.'admin/editCategories.php');
                    }elseif($status_cateChill['status_cate']==1)
                        {
                            $sql="UPDATE `categories` SET `status_cate`= 0 WHERE `id_cate`= ".$_GET['id_cate']."";
                            $db->statement($sql);
                            foreach ($db->getData('SELECT id_prd from products where id_cate ='.$_GET['id_cate'].'') as $key => $v) {
            
                                $db->statement("UPDATE `products` SET `status_prd`= 0 WHERE `id_prd`= ".$v['id_prd']."");
                            }
                            header('Location:'.$base.'admin/editCategories.php');
                        }
                    
                }elseif($status_cate['status_cate']==1){
                        header('Location:'.$base.'admin/editCategories.php');
                }
            }else
                {
                    $status_cate = $db->getRow('select status_cate from categories where id_cate ='.$_GET['id_cate'].'');
                    if($status_cate['status_cate']==0)
                    {   $sql="UPDATE `categories` SET `status_cate`= 1 WHERE `id_cate`= ".$_GET['id_cate']."";
                        $db->statement($sql);
                        foreach ($db->getData('SELECT id_prd from products where id_cate ='.$_GET['id_cate'].'') as $key => $v) {
            
                            $db->statement("UPDATE `products` SET `status_prd`= 1 WHERE `id_prd`= ".$v['id_prd']."");
                        }
                        header('Location:'.$base.'admin/editCategories.php');
                    }elseif($status_cate['status_cate']==1){
                            $sql="UPDATE `categories` SET `status_cate`= 0 WHERE `id_cate`= ".$_GET['id_cate']."";
                            $db->statement($sql);
                            foreach ($db->getData('SELECT id_prd from products where id_cate ='.$_GET['id_cate'].'') as $key => $v) {
            
                                $db->statement("UPDATE `products` SET `status_prd`= 0 WHERE `id_prd`= ".$v['id_prd']."");
                            }
                            header('Location:'.$base.'admin/editCategories.php');
                    }
                }
            
        }
?>