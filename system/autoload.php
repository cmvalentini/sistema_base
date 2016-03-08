<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ignore
 */



function load_system_class($file){
    $dir = BASEPATH.'/controllers/';
    if( file_exists($dir.$file.'.class.php')){
         echo $dir.$file.'.class.php';die();
        require($dir.$file.'.php');
    }
}
/*
function load_general_functions($file){
    $dir = BASEPATH.'generalfunctions/';
    if( file_exists($dir.$file.'.inc.php')){
        require($dir.$file.'.inc.php');
    }
}

function load_class($file){
    $dir = FCPATH.'controller/';
    if( file_exists($dir.$file.'.php')){
        echo $dir.$file.'.php';die();
        require($dir.$file.'.php');
    }

}*/

spl_autoload_register('load_system_class');
//spl_autoload_register('load_general_functions');
//spl_autoload_register('load_class');

?>
