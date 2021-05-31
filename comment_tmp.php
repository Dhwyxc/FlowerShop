<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
include_once 'classes/database.php';
include_once 'classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';

$sql="SELECT comments.*,accounts.username
FROM comments
INNER JOIN accounts
ON comments.id_user=accounts.id_user
WHERE id_prd =".$_GET['id_prd']." and id_prcmt = 0";

 $cmt_parent = $db->getData($sql); 
 $arr = array();
 foreach ($cmt_parent as $k=>$v){
    $id_prcmt = $v['id_cmt'];
    $arr[$id_prcmt] = $v;
        $sql1="SELECT comments.*,accounts.username
        FROM comments
        INNER JOIN accounts
        ON comments.id_user=accounts.id_user
        WHERE id_prcmt =".$id_prcmt."";
    $arr[$id_prcmt]['cmt_child'] = $db->getData($sql1); 
 }
 header('Content-Type: application/json');
 // echo json_encode(["flower"=> $db->getData($sql)]);
 echo json_encode($arr);
 // echo "from PHP";
    
 ?>