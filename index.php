<?php
$system_path = 'system';

// Set the current directory correctly for CLI requests
if (defined('STDIN'))
{
	chdir(dirname(__FILE__));
}

if (realpath($system_path) !== FALSE)
{
	$system_path = realpath($system_path).'/';
}

// ensure there's a trailing slash
$system_path = rtrim($system_path, '/').'/';

// Is the system path correct?
if ( ! is_dir($system_path))
{
	exit("Your system folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
}

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME)); 

// The PHP file extension
// this global constant is deprecated.
define('EXT', '.php');

define('EXTCONF', '.ini');

// Path to the system folder
define('BASEPATH', str_replace("\\", "/", $system_path));

// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));

// Name of the "system folder"
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));


//echo 'SELF:'.SELF.'<br>BASEPATH:'.BASEPATH.'<br>FCPATH:'.FCPATH.'<br>SYSDIR:'.SYSDIR;

// Incluimos el registro y lo instanciamos
require_once(BASEPATH.'/loadconfig'.EXT);

//arbol(array('hola'));

//$log = loginClass();

//echo $log->metodo1();


?>