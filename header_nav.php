<?php  if(isset($_SESSION['id_user']))
$role = $db->getRow("SELECT `role` from accounts where id_user = ".$_SESSION['id_user']."");?>
<body>

    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        
        
        <div class="offcanvas__logo">
            <a href="<?php echo $base?>index.php"><img src="<?php echo $base?>img/lg.png" alt=""  width="80%"></a>
        </div>
        <div class="offcanvas__close">+</div>
        <ul class="offcanvas__widget">
            <li><span class="icon_search search-switch"></span></li>
            <li><a href="<?php echo $base?>shop-cart.php"><span class="icon_bag_alt"></span>
            </a></li>
        </ul>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__auth">
        <?php
        if(!isset($_SESSION['username']))
        {echo'<a href="Login.php">Login</a>';}
        else{
            if($role['role']!=0){
                echo'<a href="admin">Quản lí</a><br>';
            }
        
        echo'<a data-toggle="modal" data-target="#exampleModalCenter">Tùy chọn</a><br>';
        echo'<a href="account.php">Tài khoản</a><br>';
        echo'<a href="Logout.php">Logout</a>';
        } 
        ?>
       </div>
    </div>

    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="header__logo">
                        <a href="<?php echo $base?>index.php"><img src="<?php echo $base?>img/lg.png" width="100%" height="50px" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-3">                
                    <div class="header__right">
                        <div class="row">
                            <div class="col-lg-8">
                                <ul class="header__right__widget mr-4">
                                    <li><span class="icon_search search-switch"></span>
                                    </li>
                                    <?php if(isset($_SESSION['username'])){?>
                                    <li>
                                    <a href="<?php echo $base?>shop-cart.php"><span class="icon_bag_alt"></span>
                                    </a>
                                    </li>
                                    <?php }?>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <!-- <div class="header__right__auth"> -->
                                <?php
                                if (!isset($_SESSION['username'])) { ?>
                                <a href="Login.php" style="color: black;">Login</a>
                               <?php
                                }else{ ?>
                                <div class="btn-group mb-1">
                                        <div class="dropdown" style="right: 55px; width: 120px;">
                                            <button class="btn dropdown-toggle ml-5" type="button" id="dropdownMenuButton2" data-toggle="dropdown">
                                              <?php echo $_SESSION['username']?>
                                            </button>
                                            <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton2" style="right: 10px;">
                                                <?php if($role['role']!= 0)  echo'<a class="dropdown-item" href="admin">Quản lí</a>';?>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#exampleModalCenter" href="">Tùy chọn</a>
                                            <a class="dropdown-item" href="account.php">Tài khoản</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="Logout.php">Logout</a>
                                            </div>
                                        </div>
                                </div>
                                <?php }?>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
</body>
<div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form" method="GET">
                <input type="search" id="search-input" placeholder="Tìm kiếm..." name="search-value">
            </form>
        </div>
</div>
<input type="hidden"  id="iduser" value="<?php if (isset($_SESSION['id_user'])) echo $_SESSION['id_user'] ?>">
<script>
    $(document).ready(function(){
        $("#updateRole").click(function(){
            var roleCheck = $("input[name='flexRadioDefault']:checked").val();
            var iduser = $('#iduser').val();
            $.post("updateRole.php", {roleCheck: roleCheck, iduser : iduser }, function(result){
                location.reload();
            })
        })
    })
</script>  
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
        role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Tùy chọn Quyền bán hàng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
            </button>
        </div>
        <div class="modal-body">
            <?php 
            $check = $check1 = "";
                if($role['role']==2)
                $check = "checked";
                else
                $check1 = "checked";
            ?>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1" <?php echo $check?>>
                <label class="form-check-label" for="flexRadioDefault1">
                    Có
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="0" <?php echo $check1?>>
                <label class="form-check-label" for="flexRadioDefault2">
                    Không
                </label>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Đóng</span>
            </button>
            <button type="button" class="btn btn-primary ml-1" data-dismiss="modal" id="updateRole">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Xác nhận</span>
            </button>
        </div>
        </div>
    </div>
    </div>
</html>

                   
                    