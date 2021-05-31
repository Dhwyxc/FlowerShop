<?php
 $prd = $db->getRow("SELECT * from products where id_prd =".$_GET['id_prd'].""); 
 
 header('Content-Type: application/json');
 // echo json_encode(["flower"=> $db->getData($sql)]);
 echo json_encode($prd);
 // echo "from PHP";
    
 ?>