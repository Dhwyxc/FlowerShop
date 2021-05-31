<?php

header('Access-Control-Allow-Origin: http://localhost:19006/'); 

header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
header("Access-Control-Allow-Credentials: true");
include_once 'classes/database.php';
include_once 'classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
header('Content-type: application/json');
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';

$username=$password="";
$usernameErr=$passwordErr="";

$data = json_decode(file_get_contents("php://input"),true);

$username = $data["data"]["username"];
$password = $data["data"]["password"];
// if(isset($_COOKIE['kk'])) echo json_encode($_COOKIE['kk']); 
    if (empty($username)) {
       echo "Tài khoản không được để trống";
      } else {
        $usernameA = $username ;
        if (!preg_match("/^[A-Za-z0-9_.]+$/",$usernameA)) {
            echo "Tài khoản chỉ nhận a-z, 0-9";
        }
      }
      if (empty($password)) {
        echo "Mật khẩu không được để trống";
      } else {
        $passwordA = $password;
        }
        if($db->numrow("SELECT * from accounts where username='".$usernameA."' and password='".md5($passwordA)."'")){
            $data = $db->getRow("SELECT * from accounts where username='".$usernameA."'");
          $ss->save($data['username']);
          $ss->saveID($data['id_user']);
          $ss->saveRole($data['role']);
          if($data['role']==1){
          // header('Location:'.$base.'admin');
        }else{
            // header('Location:'.$base);
            setcookie("auth",$data['id_user'] , time() + 3600*7, "/");
            http_response_code(200);
            header('Content-type: application/json');
            $array = [
              "mess"=>"Da dang nhap",
              "username"=>$data["username"],
              "id_user"=>$data["id_user"],
              "role"=>$data["role"],
            ];
            echo json_encode($array);
        }
        
        }else{
          http_response_code(401);
          $array = [
            "mess"=>"Tài khoản hoặc mật khẩu không chính xác",
          ];
          echo json_encode($array);
        }



?>