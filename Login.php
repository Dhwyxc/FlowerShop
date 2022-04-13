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
    <title>Sign in - FlowerShop</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<?php
$username=$password="";
$usernameErr=$passwordErr="";
if (isset($_POST['signin'])) {
    if (empty($_POST["username"])) {
        $usernameErr = "Tài khoản không được để trống";
      } else {
        $username = $_POST["username"];
        if (!preg_match("/^[A-Za-z0-9_.]+$/",$username)) {
          $usernameErr = "Tài khoản chỉ nhận a-z, 0-9";
        }
      }
      if (empty($_POST["password"])) {
        $passwordErr = "Mật khẩu không được để trống";
      } else {
        $password = $_POST["password"];
        }
        if($db->numrow("SELECT * from accounts where username='".$username."' and password='".md5($password)."'")){
            $data = $db->getRow("SELECT * from accounts where username='".$username."'");
          $ss->save($data['username']);
          $ss->saveID($data['id_user']);
          $ss->saveRole($data['role']);
          if($data['role']==1){
          header('Location:'.$base.'admin');
        }else{
            header('Location:'.$base);
        }
        }else{
        $passwordErr="Tài khoản hoặc mật khẩu không chính xác";
        }
}
?>
<body>
    <div id="auth" >
        
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="assets/images/lg.png"  width="60%" class='mb-4'>
                        <h3>Sign In</h3>
                        <p>Please sign in to continue to FlowerShop.</p>
                    </div>
                    <form action="" method="POST">
                        <div class="form-group position-relative has-icon-left">
                            <label for="username">Username</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="username" name="username">
                                <div class="form-control-icon">
                                    <i data-feather="user"></i>
                                </div>
                            </div>
                            <label style="color: red;"><?php echo $usernameErr?></label>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix">
                                <label for="password">Password</label>
                            </div>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                            <label style="color: red;"><?php echo $passwordErr?></label>
                        </div>

                        <div class='form-check clearfix my-4'>
                            <div class="float-right">
                                <a href="Register.php">Don't have an account?</a>
                            </div>
                        </div>
                        <div class="clearfix">
                            <input class="btn btn-primary float-right" type="submit" value="Sign In" name="signin">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>
    
    <script src="assets/js/main.js"></script>
</body>

</html>
