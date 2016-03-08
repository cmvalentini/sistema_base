<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////
//
// Functions File
//
// Package: Generic site 
// Author: Ivan Mera <ivan.mera13@gmail.com>
//
//////////////////////////////////////////////////////////////////////////////////////////////////////

function sostenedor_error($error){
	$templ=new template("error");
	$templ->asigna_variables(array(
		'ERROR' => $error)
	);
	return $templ->muestra();
}

/**/

function arbol($arbol,$identificador="DUMPEO de VALORES",$ancho="50%",$colapsado=false)
{	
	$style = '<style>
	.div_debug {padding: 0px;margin: 0px;height: 100%;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px;}
	.arbol-titulo {border: 1px solid #231f20;padding: 8px 4px 4px 10px;font-weight: bold;font-size: 12px;color: #e9e8e8;background-color: #231f20;	text-align: left;}
	.arbol-cuerpo {border: 1px solid #231f20;padding: 1px;color: #e9e8e8;background-color: #4f4c4d;text-align: center;font-size: 12px;}
	.arbol-etiqueta1 {border-right: #231f20 4px solid;border-top: #000000 2px solid;border-left: #231f20 1px solid;	border-bottom: #231f20 1px solid;padding: 0px 5px 2px 5px;font-weight: bold;color: #231f20;background-color: #10A4FF;text-align: left;font-size: 12px;}
	.arbol-etiqueta2 {border-right: #231f20 4px solid;border-top: #000000 2px solid;border-left: #231f20 1px solid;	border-bottom: #231f20 1px solid;padding: 0px 5px 2px 5px;font-weight: bold;color: #000000;background-color: #10A4FF;text-align: left;font-size: 12px;}
	.arbol-valor {border: 1px solid #231f20;padding: 0px 3px 0px 3px;color: #000000;background-color: #ffffff;text-align: left;font-size: 12px;}
	.arbol-valor-array {border: 1px solid #231f20;padding: 1px 3px 0px 3px;color: #000000;background-color: #FF7400;text-align: left;font-size: 12px;}
	.arbol-valor-objeto {border: 1px solid #231f20;padding: 0px 3px 0px 3px;color: #000000;background-color: #ffffff;text-align: left;font-size: 12px;}
	.arbol-valor-null {border: 1px solid #231f20;padding: 0px 3px 0px 3px;color: #ffffff;background-color: #555555;text-align: left;font-size: 12px;}
	.tabla-0 {padding: 0;margin: 0;	BORDER-COLLAPSE: collapse;empty-cells: hide;}
	</style>';
	echo $style;
	//Javascript de colapsado de niveles (esto no es bello, pero funciona)
	static $js = 0; // Para que entre una sola vez
	if($js==0){
		echo "<script language='javascript'>function arbol_colapsar_nivel(id, img){
				nodo = document.getElementById(id);
				if(nodo.style.display == 'none'){
					//Abrir
					nodo.style.display = '';
					img.src = '".DIR_WS_DEBUG_IMAGES."/contraer.gif';
				}else{
					//Cerrar
					nodo.style.display = 'none';
					img.src = '".DIR_WS_DEBUG_IMAGES."/expandir.gif';
				}
			}</script>";
	}
	$js++;
	
	//Es un array?
	if(is_array($arbol)){
		echo "<div  class='div_debug' align='center'><br>";
		echo "<table class='tabla-0' width='$ancho'>";
		echo "<tr><td class='arbol-titulo'><b>$identificador</b></td></tr>\n";		
		echo "<tr><td class='arbol-valor-array'>\n";
		arbol_nivel($arbol, $colapsado);
		echo "</td></tr>\n";
		echo "</table>\n";
		echo "</div><br>";
	}elseif(is_object($arbol)){
		//echo ei_mensaje("CLASE&nbsp;<b>" . get_class($arbol) ."</b>",null,$identificador);
		echo ("CLASE&nbsp;<b>".__CLASS__."</b>");
	}else{
		echo ($arbol . ' - ' . $identificador);
	}
}

function arbol_nivel($nivel, $colapsado) 
{
	$estilo="";
	static $n = 0;
	static $id = 0;
	$id++;
	$display = ($colapsado)? "style='display:none'" : '';//Mostrar el arbol colapsado de entrada?
	if($colapsado){
		$imagen = DIR_WS_DEBUG_IMAGES.'/expandir.gif';
	}else{
		$imagen = DIR_WS_DEBUG_IMAGES.'/contraer.gif'; 
	}
	echo "<table width='100%' class='tabla-0'>\n";
	foreach( $nivel as $valor => $contenido )
	{
		if($estilo=="arbol-etiqueta1"){
			$estilo="arbol-etiqueta2";
		}else{
			$estilo="arbol-etiqueta1";
		}
		echo "<tr><td class='$estilo' width='5%'><b>$valor</b></td>\n";
		if (is_array($contenido))
		{
			echo "<td class='arbol-valor-array'>
			<img src='$imagen' onclick='arbol_colapsar_nivel(\"ei-arbol-$id\", this)'>
			[". count($contenido) ."]
			<div id='ei-arbol-$id' $display>";
			$n++;
			arbol_nivel($contenido, $colapsado);
			$n--;
			echo "</div></td>\n";
		} else {
			if(is_object($contenido)){
				//El elemento es un objeto.
				echo "<td class='arbol-valor-objeto'>objeto&nbsp;(CLASE&nbsp;<b>" . get_class($contenido) ."</b>)</td>\n";
			}elseif(is_null($contenido)){
				echo "<td class='arbol-valor-null'>null</td>\n";
			}else{
				echo "<td class='arbol-valor'>" . str_replace("\n","<br>",$contenido) ."</td>\n";
			}
		}
		echo "</tr>\n";
		
	}
	echo "</table>\n";	
}


/*
 *	Function to return the countries
 * 	Params:
 * 			- Null
 *  Return
 * 		$data (array): Contain CountryId, Title Country
 */
  
function country_list(){
	# get id & country 
	$campos[] = 'CountryId';
	$campos[] = 'Title';
	$data = get_countries_register($campos,null);
	
	return $data;	
}

/*
 *	Function to return the regions of countries
 * 	Params:
 * 			- id: of country
 *  Return
 * 		$data (array): Contain RegionId, Region
 */
 
function regions_by_country($id = null)
{
	if(!isset($id))
	{
		$filtro = null;
	}else{
		$filtro['CountryId'] = $id;
	}
	
	$campos[]= 'RegionId';
	$campos[]= 'Region';
	
	$data = get_load_regions($campos,$filtro);
	
	return $data;
}

/*
 *	Function to return the city of region
 * 	Params:
 * 			- id: of Region
 *  Return
 * 		$data (array): CityId City, Country
 */

function city_by_region($id)
{
	if(!isset($id))
	{
		$filtro = null;
	}else{
		$filtro['RegionId'] = $id;
	}
	
	$campos[]= 'CityId';
	$campos[]= 'City';
	
	$data = get_city($campos,$filtro);
	
	return $data;
}

/*
 *	Function to return the form contact
 * 	Params:
 * 			- $options (array): contain parametres of style or diferent
 *  Return
 * 		$data (string): with the code for form contact
 */
function form_contact($options = null)
{
	
}

/*
 *  Function to return the user valid
 * 	Params:
 * 			- $options (array): contain parametres to obtain the user
 * 	Return
 * 		$data (array)
 */
 
function user_login($options = null){
	
	if(!isset($options))
	{
		$filtro = null;
	}else{
		$filtro['username_login'] = $options['username'];
		$filtro['password_login'] = $options['password'];
	}
	
	$campos[]= 'username_login';
	$campos[]= 'name_user';
	$campos[]= 'surname_user';
	$campos[]= 'id_type_user';
	
	$data = get_users_register($campos,$filtro);
	
	return $data;
} 

/**/

function verify_user($user, $password){
	if(valid_user($user,$password)){
		return TRUE;
	}
	return FALSE;
}

/**/

function verify_mail($mail){
	if(valid_mail($mail)){
		return TRUE;
	}
	return FALSE;
}

/**/

function reset_pass($mail, $password){

	if(resetpass($mail, $password)){
		return TRUE;
	}
	return FALSE;
}

/**/
function user_login_only($options = null){
	
	if(!isset($options))
	{
		$filtro = null;
	}else{
		$filtro['username_login'] = $options;
	}
	
	$campos[]= 'name_user';
	
	$data = get_users_register($campos,$filtro);
	if(isset($data) ){
		return $data;	
	}else{
		return FALSE;
	}
	
} 

/**/
function mail_login_only($options = null){
	
	if(!isset($options))
	{
		$filtro = null;
	}else{
		$filtro['username_login'] = $options;
	}
	
	$campos[]= 'email_user';
	
	$data = get_users_register($campos,$filtro);
	
	return $data;
} 

/**/

function resetpassmail($data){
	if(isset($data) && is_array($data)){
		$mail = new PHPMailer(true);
		
		try{
			$mail->AddAddress($data['addressUser']);
		    $mail->SetFrom($data['addressSend']);
		    $mail->AddReplyTo($data['addressSend']);
		    $mail->Subject = $data['subject'];
		    $mail->AltBody = $data['body']; // optional - MsgHTML will create an alternate automatically
			if(isset($data['msjHtml']) && $data['msjHtml'] != ''){
				$mail->MsgHTML(file_get_contents($data['msjHtml']));
			}
			foreach($data['atach'] as $var => $foo){
					//$mail->AddAttachment($foo);      // attachment
			}
			if($_SERVER['SERVER_NAME'] == 'localhost'){
				//arbol($data); die();
				echo '<script> swal("Good job!", "You clicked the button!", "success"); </script>';
			}else{
				$mail->Send();
				echo "Message Sent OK</p>\n";
			}
		} catch (phpmailerException $e) {
		  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
		  echo $e->getMessage(); //Boring error messages from anything else!
		}
	
	}else{
		return FALSE;
	}
}

?>