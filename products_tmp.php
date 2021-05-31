<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/FlowerShop/index.php";
?>
<?php
$searchRs="";
if(isset($_GET['search-value']))
{
    $searchRs = $_GET['search-value'];
}
?>
<?php
	$searchRs="";
	if(isset($_GET['search-value']))
	{
		$searchRs = $_GET['search-value'];
    }
    
	$row = $db->getRow("SELECT count(id_prd) as total from products where status_prd = 0");
	$total_records = $row['total'];
	$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
	if(isset($_GET['limit'])){
		$ss->savelimit($_GET['limit']);  
	}
	if(isset($_SESSION['limit'])){
		$limit = $_SESSION['limit'];
	}else{
		$limit=12;
	}
	$total_page = ceil($total_records / $limit);
	if ($current_page > $total_page)
		{
			$current_page = $total_page;
		}
	else if ($current_page < 1)
		{
			$current_page = 1;
		}
	$start = ((int)$current_page - 1) * $limit;
	
	?>
	<?php
	if(isset($_GET['min']) || isset($_GET['max'])){

	if($_GET['min']!='' && $_GET['max']!=''){
		$sql = "SELECT * from products 
                where status_prd = 0 
                and price_prd >= ".$_GET['min']." 
                and price_prd <= ".$_GET['max']."
                LIMIT $start, $limit";
	}else{
		if($_GET['max']!=''){
			$sql="SELECT * from products 
            where status_prd = 0 
            and price_prd <= ".$_GET['max']."
            LIMIT $start, $limit";
		}else
		if($_GET['min']!=''){
			$sql="SELECT * from products 
            where status_prd = 0 
            and price_prd >= ".$_GET['min']."
            LIMIT $start, $limit";
		}
	}
	}else{

		$sql="SELECT * from products 
        where status_prd = 0 
        AND name_prd like '%".$searchRs."%' 
        LIMIT $start, $limit";
		
    }
    header('Content-Type: application/json');
// echo json_encode(["flower"=> $db->getData($sql)]);
echo json_encode($db->getData($sql));

// echo "from PHP";
    ?>