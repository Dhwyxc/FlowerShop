<?php
include 'config.php';
if($id!=''){
    $data = $db->getRow("SELECT * FROM accounts WHERE id_user =".$id."");
    header('Content-Type: application/json');
    $array = [
        "username"=> $data["username"],
        "full_name"=> $data["full_name"],
        "phone_num"=> $data["phone_num"],
        "address"=> $data["address"],
        "id_user"=> $data["id_user"],
      ];
      echo json_encode($array);
}

 ?>