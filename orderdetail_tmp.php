<?php
header('Access-Control-Allow-Origin: http://localhost:19006/');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
include_once 'classes/database.php';
include_once 'classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
$sql ="SELECT bill_details.*,products.name_prd,products.image_prd,bills.*
FROM bill_details
INNER JOIN bills ON bill_details.id_bill=bills.id_bill
INNER JOIN products ON bill_details.id_prd=products.id_prd
WHERE bill_details.id_bill = ".$_GET['id_bill']."";
$data = $db->getData($sql);
header('Content-Type: application/json');
echo json_encode((object)$data);

 ?>