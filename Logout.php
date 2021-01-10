<?php 
include_once 'classes/session.php';
$ss = new session();
$ss->StartSession();
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
if(isset($_SESSION['username']) && $_SESSION['username'] != NULL){
    unset($_SESSION['username']);
}
header('Location:'.$base);
 ?>