<?php
session_start();
include_once 'classes/database.php';
$db = new database();
if(isset($_POST['iduser'])){
    // arrid: $arrid, name: $name, phone:$phone, add: $add, email: $email, iduser : $iduser, notes : $notes, price_total:$price_total
    $arr = $_POST['arrid'];
    $name = $_POST['name'];
    $phone = $_POST['phone']; 
    $add = $_POST['add'];
    $email = $_POST['email'];
    $iduser = $_POST['iduser'];
    $notes = $_POST['notes'];
    $price_total=$_POST['price_total'];
    unset($_SESSION['cart']);
    $insert_name = "UPDATE accounts SET `mail`='$email' WHERE id_user = $iduser";
    $db->statement($insert_name);
    // $sql_insert_id = "INSERT INTO bills (id_user,full_name,phone_num,price_total,address_delivery,order_notes) VALUES ($iduser,'$name','$phone',$price_total,'$add','$notes')";
    $sql_insert ="INSERT INTO `bills` (`id_user`, `full_name`, `phone_num`, `price_total`, `address_delivery`, `oder_notes`) VALUES ($iduser,'$name','$phone',$price_total,'$add','$notes')";
    echo $sql_insert;
    $db->statement($sql_insert);
    echo '<script type="text/javascript">alert("'.$sql_insert.'")</script>';
    echo $sql_insert;
    $last_id_bill= $db->last_id();
    for ($i=0; $i <count($arr) ; $i++) { 
       $arr1 = explode(",",$arr[$i]);
       $row = $db->getRow('SELECT `amount_prd` FROM `products` WHERE id_prd='.$arr1[0].'');
       $newamount = (int)$row['amount_prd']-$arr1[1];
       $db->statement('UPDATE `products` SET `amount_prd`='.$newamount.' WHERE id_prd='.$arr1[0].'');
       $sql = "INSERT INTO bill_details (id_bill,id_prd,amount_prd,price_prd) VALUES ('$last_id_bill','$arr1[0]','$arr1[1]','$arr1[2]')";
       $db->statement($sql);
    }
   
}

?>