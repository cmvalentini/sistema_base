<?php

/*
* Define file with data config conect
*/ 
$dirData = BASEPATH.'/config/';
$directory = opendir($dirData);
//$values = parse_ini_file(DIR_ROOT."/control/bases.ini", true);
//$dir = BASEPATH


while ($files = readdir($directory)){
    if (!is_dir($files)){
    	if(strpos($files, EXTCONF)){
    		$filedata = $files;
    	}
    }
}

$valsData = parse_ini_file($dirData.$filedata, true);

if(!$valsData){
	// redireccionamos a la instalacion 
	//header('Location: install.php');
		echo 'no existe el archivo.ini redireccionamos a la configuracion de los motores<br>';
}elseif($valsData){
	foreach ($valsData as $val => $info)
	{		
		if($val == 'desarrollo mysql')
		{
			define('DB_MOTOR', 'mysql'); 
			define('DB_MS_SERVER', $info['profile']); 
			define('DB_MS_SERVER_USERNAME', $info['usuario']);
			define('DB_MS_SERVER_PASSWORD', $info['clave']);
			define('DB_MS_DATABASE', $info['base']);
			define('DB_MS_DATABASE_PORT', $info['puerto']);
		}
	}
}

?>