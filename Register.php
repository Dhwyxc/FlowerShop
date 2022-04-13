<?php
include_once 'classes/database.php';
include_once 'classes/session.php';
$db = new database();
$ss = new session();
$ss->StartSession();
if (isset($_SESSION['username'])) {
	header('Location: admin');
}
$httpProtocol = !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' ? 'http' : 'https';
$base = $httpProtocol.'://'.$_SERVER['HTTP_HOST']."/".'FlowerShop/';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - FlowerShop</title>
    <link rel="stylesheet" href="<?php echo $base?>assets/css/bootstrap.css">
    
    <link rel="shortcut icon" href="<?php echo $base?>assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo $base?>assets/css/app.css">
</head>

<body>
    <div id="auth">
        <?php
        $Susername=$Spassword="";
        $usernameErr=$passwordErr="";
        $check=0;
        if (isset($_POST['signup'])) {
            if (empty($_POST["username-column"])) {
                $usernameErr = "Tài khoản không được để trống";
              } else {
                  $Susername = $_POST["username-column"];
                if (!preg_match("/^[A-Za-z0-9_.]+$/",$Susername)) {
                  $usernameErr = "Tài khoản chỉ nhận a-z, 0-9";
                }
              }
              if (empty($_POST["password-column"])) {
                $passwordErr = "Mật khẩu không được để trống";
              } elseif($_POST["password-column"] != $_POST["cPassword-column"]){
                    $passwordErr = "Vui lòng xác nhận đúng mật khẩu!";
                    $check = 1;
                }else{
                     $Spassword = $_POST["cPassword-column"];
                }
                if($db->numrow("SELECT * from accounts where username='".$Susername."'"))
                {
                    $usernameErr = "Tài khoản đã tồn tại";
                }else
                {
                  if(preg_match("/^[A-Za-z0-9_.]+$/",$Susername)&&!empty($_POST["cPassword-column"])&&($check!=1)){
                    $fullname= $_POST["fname-column"]." ".$_POST["lname-column"];
                    $sql="INSERT into accounts values ('','".$Susername."','".md5($Spassword)."','".$_POST["address-column"]."','".$_POST["phonenum-column"]."','".$fullname."','','')";
                    $db->statement($sql);
                    header('Location: Login.php');
                    // echo $sql; 
                    }
                } 
        }
        ?>
<div class="container">
    <div class="row">
        <div class="col-md-7 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="<?php echo $base?>assets/images/lg.png" width="50%" class='mb-4'>
                        <h3>Sign Up</h3>
                        <p>Please fill the form to register.</p>
                    </div>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="first-name-column">First Name <span style="color:red; font-weight: bold; font-size: large;">*</span></label>
                                    <input type="text" id="first-name-column" class="form-control"  name="fname-column" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="last-name-column">Last Name <span style="color:red; font-weight: bold; font-size: large;">*</span></label>
                                    <input type="text" id="last-name-column" class="form-control"  name="lname-column" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="username-column">Username <span style="color:red; font-weight: bold; font-size: large;">*</span></label>
                                    <input type="text" id="username-column" class="form-control" name="username-column" required>
                                    <label style="color: red;"><?php echo $usernameErr?></label>
                                </div>
                            </div>
                             <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phonenum-column">Phone Number <span style="color:red; font-weight: bold; font-size: large;">*</span></label>
                                    <input type="text" id="phonenum-column" class="form-control" name="phonenum-column" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="password-column">Password <span style="color:red; font-weight: bold; font-size: large;">*</span></label>
                                    <input type="password" id="password-column" class="form-control" name="password-column" required>
                                    <label style="color: red;"><?php echo $passwordErr?></label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="cPassword-column">Confirm Password <span style="color:red; font-weight: bold; font-size: large;">*</span></label>
                                    <input type="password" id="cPassword-column" class="form-control" name="cPassword-column" required>
                                    <label style="color: red;"><?php echo $passwordErr?></label>
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="address-column">Address</label>
                                    <input type="address" id="address-column" class="form-control" name="address-column">
                                </div>
                            </div>
                        </diV>
                                <a href="Login.php">Have an account? Login</a>
                        <div class="clearfix">
                            <input class="btn btn-primary float-right" name="signup" type="submit" value="Sign Up">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <script src="<?php echo $base?>assets/js/feather-icons/feather.min.js"></script>
    <script src="<?php echo $base?>assets/js/app.js"></script>
    
    <script src="<?php echo $base?>assets/js/main.js"></script>
</body>

</html>
