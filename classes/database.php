<?php 
class database
	{
		public $con;
		private $localhost="localhost";
		private $pass="";
		private $user="root";
		private $data="flowershop";
		private $result=null;
		function __construct()
		{
			$this->con= new mysqli($this->localhost,$this->user,$this->pass,$this->data) or die("connect failed"); 

			$this->con->query("SET NAMES UTF8");
		}
		public function numrow($sql)
		{
			$query = mysqli_query($this->con, $sql);
			if ($query) {
				$row = mysqli_num_rows($query);
				return $row;
			}
		}
		public function insertCate($name, $id_parent, $id_user)
		{
			$this->con->query("INSERT into categories values('','".$name."','".$id_parent."','".$id_user."','')");
		}
		public function insertPrd($id_cate, $name, $price, $discount, $image, $desc, $amount,$id_user)
		{
			$this->con->query("INSERT into products values('','".$id_cate."','".$name."','".$price."','".$discount."','".$image."','".$desc."','".$amount."','','".$id_user."')");
		}
		public function updateCate($name, $id_parent, $id_user, $id_cate)
		{
			$this->con->query("UPDATE `categories` SET `name_cate`='".$name."', `id_parentcate`='".$id_parent."', `id_user`='".$id_user."' WHERE id_cate='".$id_cate."'");
		}
		public function updatePrd($id_cate, $name, $price, $discount, $image, $desc, $amount,$id_user,$id_prd)
		{
			$this->con->query("UPDATE `products` SET `id_cate`='".$id_cate."',`name_prd`='".$name."', `price_prd`='".$price."', `discount_prd`='".$discount."', `image_prd`='".$image."', `desc_prd`='".$desc."', `amount_prd`='".$amount."', `id_user`='".$id_user."' WHERE id_prd='".$id_prd."'");
		}
		public function insertId(){
        if ($this->con)
        {
            $count = mysqli_insert_id($this->con);
            if ($count == '0')
            {
                $count = '1';
            }
            else
            {
                $count = $count;
            }
            return $count;
       	 }
		}
		public function last_id()
		{
			return $this->con->insert_id;
		}
		public function getData($sql)
		{
			$arr  = array();
			$this->result = mysqli_query($this->con,$sql);
			while ($row = mysqli_fetch_assoc($this->result)) {
				$arr[]=$row;
			}
			return $arr;
		}
		public function getRow($sql)
		{
			$result = mysqli_query($this->con,$sql);
			$row = mysqli_fetch_assoc($result);
			return $row;

		}
		public function statement($sql)
		{
			$this->con->query($sql);
		}
		public function slug($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}
	}

 ?>