<?php 
include_once './classes/database.php';
include_once './classes/session.php';
$db = new database();
$ss = new session();
$noidung =$_POST['noidung'];
$id = $_POST['idprd'];
$id_user = $_POST['iduser'];
$vote =$_POST['vote'];
$db -> statement("INSERT INTO comments (`id_prd`, `id_user`, `detail_cmt`, `vote_prd`) VALUES ($id, $id_user, '$noidung', $vote)");
 ?>
