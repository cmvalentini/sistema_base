<?php
session_start();

if (isset($_SESSION) && $_SESSION['admin_login'] != '') {
	# code...
	var_dump($_SESSION);
}else{
	header("location: login.php");
}


?>
#<a href="access.php?ac=logout">Salir</a>