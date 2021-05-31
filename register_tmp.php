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
$data = json_decode(file_get_contents("php://input"),true);

$username = $data["data"]["username"];
$password = $data["data"]["password"];
$add = $data["data"]["add"];
$pnum = $data["data"]["pnum"];
$fname = $data["data"]["fname"];

$Susername=$Spassword="";
$usernameErr=$passwordErr="";

        
            if (empty($username)) {
                $usernameErr = "Tài khoản không được để trống";
              } else {
                  $Susername = $username;
                if (!preg_match("/^[A-Za-z0-9_.]+$/",$Susername)) {
                  $usernameErr = "Tài khoản chỉ nhận a-z, 0-9";
                }
              }
              if (empty($password)) {
                $passwordErr = "Mật khẩu không được để trống";
              } else {
                $Spassword = $password;
                }
                if($db->numrow("SELECT * from accounts where username='".$Susername."'"))
                {
                    $usernameErr = "Tài khoản đã tồn tại";
                }else
                {
                  if(preg_match("/^[A-Za-z0-9_.]+$/",$Susername)&&!empty($password)){
                    
                    $sql="INSERT into accounts values ('','".$Susername."','".md5($Spassword)."','".$add."','".$pnum."','".$fname."','','')";
                    $db->statement($sql);

                    http_response_code(200);
                    $array = [
                        "mess"=>"DK susscccc",
                    ];
                    echo json_encode($array);
                   
                    }else{
                        http_response_code(401);
                            $array = [
                                "mess"=>"loi r",
                            ];
                            echo json_encode($array);
                    }
                } 
        
        ?>