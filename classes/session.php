<?php 
class session
{
	function __construct(){

	}
	public function StartSession()
	{
		session_start();
	}
	public function save($value)
	{
		$_SESSION['username']=$value;
	}
	public function saveRole($value)
	{
		$_SESSION['role']=$value;
	}
	public function savelimit($value)
	{
		$_SESSION['limit']=$value;
	}
	
	public function saveID($value)
	{
		$_SESSION['id_user']=$value;
	}
	
	public function get()
	{
		if (isset($_SESSION['username'])) {
			$user = $_SESSION['username'];
			return $user;
		}else{
			$user ='';
			return $user;
		}
	}
	public function EndSession()
	{
		session_destroy();
	}
}
 ?>