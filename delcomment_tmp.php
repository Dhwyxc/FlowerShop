<?php
include 'config.php';
if($id!=''){

    $sql ="DELETE FROM `comments` WHERE id_cmt = ".$_GET['id_cmt']." OR id_prcmt = ".$_GET['id_cmt']."";
    $db->statement($sql);
}

?>