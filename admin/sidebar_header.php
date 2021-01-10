<div class="sidebar-wrapper active">
            <div class="sidebar-header">
                <img src="<?php echo $base;?>assets/images/lg.png" width="90%" alt="" srcset="">
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    
                        <li class='sidebar-title'>Main Menu</li>
                    
                        <li class="sidebar-item active ">
                            <a href="index.php" class='sidebar-link'>
                                <i data-feather="home" width="20"></i> 
                                <span>Dashboard</span>
                            </a>
                            
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="triangle" width="20"></i> 
                                <span>Danh mục</span>
                            </a>
                            
                            <ul class="submenu ">
                                
                                <li>
                                    <a href="addCategories.php">Thêm danh mục</a>
                                </li>
                                
                                <li>
                                    <a href="editCategories.php">Chỉnh sửa danh mục</a>
                                </li>
                            </ul>
                            
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="triangle" width="20"></i> 
                                <span>Sản phẩm</span>
                            </a>
                            
                            <ul class="submenu ">
                                
                                <li>
                                    <a href="addProducts.php">Thêm sản phẩm</a>
                                </li>
                                
                                <li>
                                    <a href="editProducts.php">Chỉnh sửa sản phẩm</a>
                                </li>
                                
                            </ul>
                            
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="triangle" width="20"></i> 
                                <span>Trả lời bình luận</span>
                            </a>
                            
                            <ul class="submenu ">
                                
                                <li>
                                    <a href="repCmt.php">Trả lời bình luận</a>
                                </li>
                                
                            </ul>
                            
                        </li>
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="triangle" width="20"></i> 
                                <span>Quản lí đơn hàng</span>
                            </a>
                            
                            <ul class="submenu ">
                                
                                <li>
                                    <a href="billDetails.php">Chi tiết đơn hàng</a>
                                </li>
                                
                            </ul>
                            
                        </li>
                        <?php
                        if($_SESSION['role']==1){
                        ?> 
                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="triangle" width="20"></i> 
                                <span>Người dùng</span>
                            </a>
                            
                            <ul class="submenu ">
                                
                                <li>
                                    <a href="editUser.php">Xem người dùng</a>
                                </li>
                                
                            </ul>
                            
                        </li>
                        <?php
                    }?>
                </ul>
            </div>
<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>