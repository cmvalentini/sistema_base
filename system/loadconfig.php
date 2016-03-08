<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require BASEPATH.'autoload.php';
require BASEPATH.'config/config.php';

# Set start microtime
$service_microtime = microtime();
$service_time = time();

#data mail config
define('RMAIL', 'noreply@algo.com');
define('RMAIL_NAME', 'algo');
define('URL_SYSTEM', 'http://www.google.com.ar');

/*
*	Levantamos las clases de manera manual mientras probamos las cosas
*/
//echo require BASEPATH.'controllers/';
require BASEPATH.'controllers/Database.class.php';
//require BASEPATH.'controllers/Accesslogin.class.php';
require BASEPATH.'controllers/UpLoad.class.php';
require BASEPATH.'controllers/Watimage.class.php';
require BASEPATH.'controllers/phpmailer.class.php';
require BASEPATH.'controllers/pop3.class.php';
require BASEPATH.'controllers/smtp.class.php';
require BASEPATH.'controllers/template.class.php';

##


/*
*	Levantamos las clases de manera manual mientras probamos las cosas
*/
//require FCPATH.'controller/loginClass.php';
require BASEPATH.'controllers/loginClass.class.php';
##
require BASEPATH.'generalfunctions/consults.inc.php';
require BASEPATH.'generalfunctions/functions.inc.php';

#$db = new Database();
/*
$sql = "select * from type_users;";

$db->query($sql);

while($row = $db->fetchAssoc())
{
	$data[] = $row;
}
 var_dump($data);*/
?>
