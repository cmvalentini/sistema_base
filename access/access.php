<?php

$system_path = 'system';

// ensure there's a trailing slash
$system_path = rtrim($system_path, '/').'/';

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME)); 

// The PHP file extension
// this global constant is deprecated.
define('EXT', '.php');
define('EXTCONF', '.ini');

// Path to the system folder
define('BASEPATH', str_replace("access", $system_path, dirname(__FILE__)));
define('FCPATH', str_replace("access", '', dirname(__FILE__)));

require_once(BASEPATH.'loadconfig'.EXT);

$admin = new loginClass();
//$test = $admin->post;
//var_dump('$admin->post');die();


if(isset($_GET['ac']) && $_GET['ac']== 'logout'){
	$admin->logoutaction();
}elseif ($_GET['ac']== 'register'){
	# $_SERVER['DOCUMENT_ROOT'] y $_SERVER['HTTP_HOST'].
	$admin->loginregister();
}elseif ($_GET['ac']== 'forgot') {
	$admin->checkmail();
}else{
	$admin->loginaction();
}


?>