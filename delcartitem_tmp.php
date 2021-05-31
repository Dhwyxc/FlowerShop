<?php 
include 'config.php';

$id_user = $id;

$delitem="DELETE FROM `cart_details` WHERE id_cart=".$_GET['id_cart']." AND id_prd=".$_GET['id_prd']."";
$db->statement($delitem);

header('Content-Type: application/json');
http_response_code(200);
    $array = [
      "mess"=>"del success",
    ];
    echo json_encode($array);
?> 
