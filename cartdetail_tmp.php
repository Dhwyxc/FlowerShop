<?php 
include 'config.php';

$id_user = $id;

$getcart="SELECT cart_details.*,products.name_prd,products.image_prd,products.price_prd,products.amount_prd,products.discount_prd,carts.*
FROM cart_details
INNER JOIN carts ON cart_details.id_cart=carts.id_cart
INNER JOIN products ON cart_details.id_prd=products.id_prd
WHERE carts.id_user = ".$id_user."";


$data = $db->getData($getcart);
header('Content-Type: application/json');
echo json_encode($data);

?> 
