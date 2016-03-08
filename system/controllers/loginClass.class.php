<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*****************************************************
*
*
******************************************************/

class loginClass{

	var $version = 'Login V. Lite';

	# Storage the value of post variables 
	var $post = array();
	
	# Storage and decoded value of get variables
	var $get = array();

	function loginClass(){
		session_start();

		// Initialize the post variable
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->post = $_POST;
			if(get_magic_quotes_gpc()){
				// Get rid of magic quotes and slashes if presente
				array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
			}
		}
		
		// Initialize the get variable
		$this->get = $_GET;
		
		// Decode the URl 
		array_walk_recursive($this->get, array($this, 'urldecode'));	
	}

	function authent(){
		#verificamos que no haya una session abierta
		if(isset($_SESSION['admin_login'])){
			$lastaccess = $_SESSION["last_access"];
			$nowtime = date("Y-n-j H:i:s");
			$timelapse = (strtotime($nowtime)-strtotime($lastaccess));
			
			if($timelapse >= 1200){// 1200 is equal to 20min
				// destroy the session
				session_destroy();
				#header("location: ".FCPATH."access/login.php");
				header("location: login.php");
			}else{
				$_SESSION["last_access"] = $nowtime;
			}
			#redirigimos a index
			#header("location: ".FCPATH."access/index.php"); # determinamos si va alguna variable 
		}else{
			#header("location: ".FCPATH."access/login.php");
			header("location: login.php");
		}
		//return $this->version;
	}

	function loginaction(){
		# Insuficient data Provided

		if(!isset($this->post['inputUsername3']) || $this->post['inputUsername3'] == ''
		|| !isset($this->post['inputPassword3']) || $this->post['inputPassword3'] == ''){
			#header("location: ".FCPATH."access/login.php?errorusuario=si");
			header("location: login.php?errorusuario=si");
		}

		
		# Get the Username and Password
		$username = $this->post['inputUsername3'];
		#sha1 for encript
		$password = sha1($this->post['inputPassword3']);
		

		# Check into database for user
		$checkuser = verify_user($username,$password);
		
		if($checkuser){
			$_SESSION['admin_login'] = $username;
			$_SESSION['token'] = md5(uniqid(mt_rand(), true));
			$_SESSION["last_access"] = date("Y-n-j H:i:s");
			$_SESSION['user_auth'] = $this->get_username();
			//$_SESSION['test_token'] = $this->getToken(12);

			#header("location: ".FCPATH."access/index.php");
			header("location: index.php");
		}else{
			#header("location: ".FCPATH."access/login.php?errorusuario=si");
			header("location: login.php?errorusuario=si");
		}
	}

	/*
	*	Check For logout in action file
	*	Return:
	*			(Void)
	*/
	
	function logoutaction(){
		$_SESSION = array();
		session_destroy();
		header("location: login.php");
	}

	/*
	*	Function to return the name of currently logged in admin
	*	Return:
	*			$username (String): with the name the user
	*/
	
	function get_username(){
		$user_login = $_SESSION['admin_login'];
		$username = user_login_only($user_login);
		if($username){
			return $username;	
		}else{
			return FALSE;
		}		
	}

	/**/
	function loginregister(){
		if (isset($this->post)) {
			$datos['name_user'] = $this->post['name'];
			$datos['surname_user'] = $this->post['surname'];
			$datos['email_user'] = $this->post['email'];
			$datos['phonenumber'] = $this->post['telefono'];
			$datos['username_login'] = $this->post['username'];
			$datos['password_login'] = sha1($this->post['password']);
			$datos['id_type_user'] = $this->post['tipousuario'];
			$datos['dt_register'] = date("Y-m-d H:i:s");

			#verify user

			$checkuser = userRegister($datos['username_login']);

			if($checkuser == TRUE){
				#si existe rechazamos la peticion
				header("location: register.php?errorreg=si");
			}
			setUser($datos);

			#cargamos la funcion mail siempre y cuando no sea localhost
			if($_SERVER['HTTP_HOST'] != 'localhost'){
				# funcion envio de mail
				$this->sendRegisterMail();
			}
			header("location: register.php?send=si");
			return TRUE;

		}
		
	}

	function sendRegisterMail(){

		$person = $this->post['name']." ".$this->post['surname'];

		$destinatario = $this->post['email'];
		$nomAdmin 			= RMAIL_NAME;
		$mailAdmin 		= RMAIL;
		
		$body = "";     
		$asunto = $person.", Gracias por registrarte!";		


		$body ='
			    <h2>.::Registrar usuarios::.</h2>
			    <p>Le damos la mas cordial bienvenida, desde ahora usted podra gozar de los beneficios de
			    haberse identificado y acceder a contenido exclusivo del sistema.</p>
			        <table border="0" >
			        <tr>
			            <td colspan="2" align="center" >Sus datos de acceso para <a href="'.URL_SYSTEM.'">'.URL_SYSTEM.'</a><br></td>
			        </tr>
			        <tr>
			            <td> Nombre </td>
			            <td> <b>'.$person.'</b> </td>
			        </tr>
			        <tr>
			            <td> Nombre de usuario </td>
			            <td> <b>'.$this->post['username'].'</b> </td>
			        </tr>
			        <tr>
			            <td> Password </td>
			            <td> <b>'.$this->post['password'].'</b> </td>
			        </tr>
			        </table> <br/><br/>
			    <p><b>Gracias por su preferencia, hasta pronto.</b></p> <br><br>';


		//Establecer cabeceras para la funcion mail()
		//version MIME
		$cabeceras = "MIME-Version: 1.0\r\n";
		//Tipo de info
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
		//direccion del remitente
		$cabeceras .= "From: ".$nomAdmin." <".$mailAdmin.">";
		$resEnvio = 0;
		if(mail($destinatario,$asunto,$body,$cabeceras)){
			return TRUE;
		}
	}

	/*
	*	Check For login in action file
	*	Return:
	*			(Void)
	*/
	
	function checkmail(){
		if(!isset($this->post['email']) || $this->post['email'] == ''){
			header("location: forgot.php?errorforgot=yes");
		}
		$email = $this->post['email'];
		
		$pwd_token = $this->getToken(12);
		$hashpwd = sha1($pwd_token);
				
		# Verify email
		$checkmail = verify_mail($email);
		if($checkmail){
			$var = hash('sha256', $email);
			$token = hash('sha256', $pwd);
			if($_SERVER['HTTP_HOST'] != 'localhost'){
				$this->sendForgotMail($pwd_token);
			}
			#actualizamos la clave
			resetpass($email, $hashpwd);
			header("location: forgot.php?ct=".$token."&vf=yes&tr=".$var);
		}else{
			unset($_POST['inputUsermail']);
			unset($this->post['inputUsermail']);
			header("location: forgot.php?errorforgot=si");
		}
	}

	function sendForgotMail($token){

		$filtro['email_user'] = $this->post['email'];
		$infoperson = get_users_register(null, $filtro);
		$person = $infoperson[0]['name_user']." ".$infoperson[0]['surname_user'];

		$destinatario = $this->post['email'];
		$nomAdmin 			= RMAIL_NAME;
		$mailAdmin 		= RMAIL;
		
		$body = "";     
		$asunto = $person.", Nueva contraseña!";
				

		$body ='
			    <h3>.::Recuperar Password::.</h3>
		<p>A peticion de usted; se le ha asignado un nuevo password, utilice los siguientes datos para acceder al sistema</p>
		  <table border="0" >
			<tr>
			  <td colspan="2" align="center" ><br> Nuevos datos de acceso para <a href="'.URL_SYSTEM.'">'.URL_SYSTEM.'</a><br></td>
			</tr>
			<tr>
			  <td> Nombre </td>
			  <td> '.$infoperson[0]['name_user'].' </td>
			</tr>
			<tr>
			  <td> Username </td>
			  <td> '.$infoperson[0]['username_login'].' </td>
			</tr>
			<tr>
			  <td> Password </td>
			  <td> '.$token.' </td>
			</tr>
		  </table> ';

		//Establecer cabeceras para la funcion mail()
		//version MIME
		$cabeceras = "MIME-Version: 1.0\r\n";
		//Tipo de info
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1\r\n";
		//direccion del remitente
		$cabeceras .= "From: ".$nomAdmin." <".$mailAdmin.">";
		$resEnvio = 0;
		if(mail($destinatario,$asunto,$body,$cabeceras)){
			return TRUE;
		}
	}


	#############################

	#token for forgot
	function getRandomChar($data){	
		$randomKey = array_rand($data, 1);//obten clave aleatoria
		return $data[$randomKey];//devolver item aleatorio
	}

	function getKeyMd5($data){
		$md5Car = md5($data.time());	//Codificar el caracter y el tiempo POSIX (timestamp) en md5
		$arrCar = str_split(strtoupper($md5Car));	//Convertir a array el md5
		$carToken = $this->getRandomChar($arrCar);	//obten un item aleatoriamente
		return $carToken;
	}

	function getToken($length){
		//crear alfabeto
		$alph = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!,$#/()%?¡@";
		#$alph = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$alphabet = str_split($alph);
		//crear array de numeros 0-9
		$nums = range(0,9);
		$symbols = "!$#/()%?¡@";
		//revolver arrays
		shuffle($alphabet);
		shuffle($nums);

		//Unir arrays
		$totalKey = array_merge($alphabet,$nums);
		
		$newToken = "";
		for($i=0;$i<=$length;$i++) {
				$miCar = $this->getRandomChar($totalKey);
				$newToken .= $this->getKeyMd5($miCar);
		}
		return $newToken;
	}






########################################### NO TOCAR ####################################
	/*
	* Destruimos la session 
	*/
	function destroy_sess(){
		session_destroy();
	}

	/*
	*	stripslash gpc
	*/
	
	protected function stripslash_gpc(&$value){
		$value = stripslashes($value);
	}
	
	/*
	 *	htmlspecialcarfy 
	 */
	 protected function htmlspecialcarfy(&$value){
		$value = htmlspecialchars($value);
	}

	/*
	 *	URL Decode 
	 */
	 protected function urldecode(&$value){
		$value = urldecode($value);
	}
}

?>