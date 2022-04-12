<div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <div class="sidebar__categories">
                            <div class="section-title">
                                <h4>Danh mục</h4>
                            </div>
                            <?php foreach ($db->getData("SELECT * from categories where status_cate = 0") as $key => $v): ?>
                            <div class="categories__accordion">
                                <div class="accordion" id="accordionExample">
                                <?php
                                $cou = $db->getRow("SELECT COUNT(id_prd) as cout FROM products WHERE id_cate =".$v['id_cate']."");
                                foreach ($db->getData("SELECT id_cate from categories where id_parentcate = ".$v['id_cate']."") as $key => $d) {
                                    $co = $db->getRow("SELECT COUNT(id_prd) as cout FROM products WHERE id_cate =".$d['id_cate']." and status_prd = 0");
                                    $cou['cout'] += $co['cout'];
                                    
                                }
                                ?>
                                
                                    <div class="card">
                                        <div class="card-heading">
                                            <a href="<?php echo $base.'index.php?id_cate='.$v['id_cate']?>">
                                            <?php if($v['id_parentcate']==0) 
                                            {
                                                $cou = $db->getRow("SELECT COUNT(id_prd) as cout FROM products WHERE id_cate =".$v['id_cate']." and status_prd = 0");
                                                foreach ($db->getData("SELECT id_cate from categories where id_parentcate = ".$v['id_cate']."") as $key => $d) {
                                                    $co = $db->getRow("SELECT COUNT(id_prd) as cout FROM products WHERE id_cate =".$d['id_cate']." and status_prd = 0");
                                                    $cou['cout'] += $co['cout'];
                                                    
                                                }
                                                echo $v['name_cate']."(".$cou['cout'].")";
                                            }
                                            ?></a>
                                        </div>
                                        <div id="collapse" class="collapse show" >
                                            <div class="card-body">
                                            <ul>
                                                <?php
                                                if($v['id_parentcate']==0)
                                                foreach ($db->getData('SELECT * from categories where id_parentcate='.$v['id_cate'].' and status_cate = 0') as $key => $p):
                                                ?>
                                                    <?php $cout = $db->getRow("SELECT COUNT(id_prd) as cout FROM products WHERE id_cate =".$p['id_cate']." and status_prd = 0");?>
                                                    <li><a href="<?php echo $base.'index.php?id_cate='.$p['id_cate']?>"><?php echo $p['name_cate']?>(<?php echo $cout['cout']?>)</a></li>
                                                <?php endforeach?>    
                                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                 
                                </div>
                            </div>
                            <?php endforeach?>
                        </div>
                        <div class="sidebar__filter">
                            <div class="section-title">
                                <h4>Số sản phẩm mỗi trang</h4>
                            </div>
                            <div class="cart__quantity">
                                <div class="pro-qty">
                                    <form action="" method="get">
                                    <input type="text" name="limit" id="limit"  value="<?php if(isset($_SESSION['limit']))echo $_SESSION['limit'];
                                                                                             else echo '9';?>">
                                    </form>
                                </div>
                            </div>
                            </form>
                          
                        </div>
                        <div class="sidebar__filter">
                            <div class="section-title">
                                <h4>Tìm theo giá</h4>
                            </div>
                                <span style="color: #939597; font-weight: 600; margin-left: 5px; font-size: 18px;">*Nhập mệnh giá VND</span>
                            <form name="form" action="" method="get">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-xs-6 mb-3 mt-2">
                                    <span style="color: black; font-weight: 600; margin-left: 5px; font-size: 18px;">TỪ</span>
                                    <br><input type="number" name="min" id="min" style="width: 100%; height: 30px; border: 2px solid black;" >
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-6 col-xs-6 mb-3 mt-2">
                                    <span style="color: black; font-weight: 600; margin-left: 5px; font-size: 18px;">ĐẾN</span>
                                    <br><input type="number" name="max" id="max" style="width: 100%; height: 30px; border: 2px solid black;" >
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <button type="submit" style="background-color: #F5DF4D; border: 2px solid black; color: black; font-weight: 600;font-size: 15px; height: 30px; width: 100%;">TÌM</button>
                                    </div>
                                </div>
                                
                               
                            </form>
                          
                        </div>
                    </div>
                </div>