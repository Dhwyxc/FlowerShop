<?php 
class redirect
{
	
	function __construct($url)
	{
		echo '<script>location.href="'.$url.'";</script>';
	}
}
 ?>