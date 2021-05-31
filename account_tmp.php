<?php
include 'config.php';
$sql ="SELECT * from bills 
where id_user=".$id."
ORDER BY id_bill DESC";
$data = $db->getData($sql);
header('Content-Type: application/json');
echo json_encode($data);

 ?>