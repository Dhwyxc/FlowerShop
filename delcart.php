<?php
session_start();
$cart=$_SESSION['cart'];
$id=$_GET['id_prd'];
if($id == 0)
{
unset($_SESSION['cart']);
}
else
{
unset($_SESSION['cart'][$id]);
}
header("location:".$_SERVER["HTTP_REFERER"]);
exit();
?>