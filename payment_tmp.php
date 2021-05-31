<?php
include 'config.php';
if($id!=''){
    header('Content-type: application/json');
    $data = json_decode(file_get_contents("php://input"),true);
    $fname = $data["data"]["fname"];
    $add = $data["data"]["add"];
    $pnum = $data["data"]["pnum"];
    $note = $data["data"]["note"];
    $cost = $data["cost"];
    $cart = $data["cart"];

    $sql_insert ="INSERT INTO `bills` (`id_user`, `full_name`, `phone_num`, `price_total`, `address_delivery`, `oder_notes`) VALUES ($id,'$fname','$pnum',$cost,'$add','$note')";
    $db->statement($sql_insert);
    $last_id_bill = $db->last_id();

    foreach($cart as $k => $v){
        $row = $db->getRow('SELECT `amount_prd` FROM `products` WHERE id_prd='.$v['id_prd'].'');
        $newamount = (int)$row['amount_prd']-$v['prd_qty'];
        $db->statement('UPDATE `products` SET `amount_prd`='.$newamount.' WHERE id_prd='.$v['id_prd'].'');
        $sql_del ="DELETE FROM cart_details WHERE id_cart=".$v['id_cart']." AND id_prd=".$v['id_prd']."";
        $db->statement($sql_del);
        $sql = "INSERT INTO bill_details (id_bill,id_prd,amount_prd,price_prd) VALUES ('$last_id_bill',".$v['id_prd'].",".$v['prd_qty'].",".($v['price_prd']*(100-$v['discount_prd'])/100).")";
        $db->statement($sql);
    }
    http_response_code(200);
    $array = [
        "mess"=>"add bill success",
     ];
    echo json_encode($array);
}
?>