<?php
header('Content-Type: application/json');
include_once '../classes/database.php';
include_once '../classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
$conn = mysqli_connect("localhost","root","","flowershop");

foreach($db->getData("SELECT id_prd from products where id_user = ".$_SESSION['id_user']."") as $key => $v){
	foreach($db->getData("SELECT id_bill from bill_details where id_prd = ".$v['id_prd']."") as $key => $v){
		$idb[] = $v['id_bill'];
	}    
}
$str = implode(",",$idb);
if($_SESSION['role']!=1){
	$sqlQuery = "SELECT
	DATE(time_order) AS saledate,
	SUM(price_total) AS sumtt
	FROM
	bills
	WHERE
	id_bill in (".$str.")
	GROUP BY
	saledate";
}else{
	$sqlQuery = "SELECT
	DATE(time_order) AS saledate,
	SUM(price_total) AS sumtt
	FROM
	bills
	GROUP BY
	saledate";
}
$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>