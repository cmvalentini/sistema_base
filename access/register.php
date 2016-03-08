<?php
if(isset($_GET['errorreg']) && $_GET['errorreg'] == 'si'){
	$html = '<script src="js/controladmin.js"></script>
	</head>	
	<body onload="badreg();">';
}elseif(isset($_GET['send']) && $_GET['send'] == 'si'){
	$html = '<script src="js/controladmin.js"></script>
	</head>	
	<body onload="oksend();">';
}else{
	$html = '</head>
	<body>';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    
    <title>Register</title>

    <!--jquery-->
    <script src="../globals/js/jquery.min.js"></script>
    <script src="js/sweet-alert.min.js"></script>
    
    <!--bootsrap-->
    <link href="css/bootstrap.css" rel="stylesheet">
     <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
    <link href="css/sweet-alert.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php echo $html; ?>
 
  
  	<div id="ionic-header"> <!--Just released! Check out--> </div>
	<div class="site-wrapper">
	<div class="container centerFile">
	  <h2>Registrar usuario</h2>
	  <p>Gracias por tu interes en registrarte. Para hacerlo, solo debes llenar
	    los siguientes campos y pulsar el boton <b>Registrarme</b>. Para hacer mas rapido el registro y
	    asi tu puedas acceder al contenido, tu cuenta se activa inmediatamente.<br /><br /></p>
	  <form class="form-horizontal" method="post" id="formregister" >
	  <table width="90%">
	    <tbody>
	      <tr>
	        <td width="5%"> </td>
	        <td width="30%"> </td>
	        <td> </td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td><label>Nombre(s)</label></td>
	        <td><div><input type="username" class="form-control" name="name" id="name" placeholder="Nombre(s)"></div></td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td><label>Apellido(s)</label></td>
	        <td><div><input type="username" class="form-control" name="surname" id="surname" placeholder="Apellido(s)"></div></td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td><label>Correo electronico</label></td>
	        <td><div><input type="email" class="form-control" name="email" id="email" placeholder="Correo electronico"></div></td>
	      </tr>
	       <tr>
	      	<td> </td>
	        <td><label>Telefono</label></td>
	        <td><div><input type="email" class="form-control" name="telefono" id="telefono" placeholder="Telefono"></div></td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td><label>Nombre de usuario</label></td>
	        <td><div><input type="username" class="form-control" name="username" id="username" placeholder="Nombre de usuario"></div></td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td><label>Contraseña</label></td>
	        <td><div><input class="form-control" name="password" id="password" placeholder="Contraseña" type="password" required></div></td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td><label>Confirme la contraseña</label></td> 
	        <td><div><input class="form-control" name="password2" id="password2" placeholder="Confirme la contraseña" type="password" required></div></td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td><label>Tipo de usuario</label></td>
	        <td><div><input type="hidden" name="tipousuario" id="tipousuario" value="2"   />
            <input type="radio" name="rad_TipoUsuario" id="rad_TipoUsuario" disabled value="2" checked="checked"  /> Profesor &nbsp;&nbsp;&nbsp;
            <input type="radio" name="rad_TipoUsuario" id="rad_TipoUsuario" disabled value="1"  /> Administrador</div></td>
	      </tr>
	      <tr>
	      	<td> </td> <td> </td> <td> </td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td> </td>
	        <td>
            <button id="register_bttn" class="btn btn-primary" type="button">Registrarme</button>
            <input type="button" class="btn btn-cancel" onClick="javascript: location.href='index.php'" name="cancelar" value="Cancelar" >
	      </tr>
	    </tbody>
	  </table>
	  </form>
	</div>
    </div>
    <script type="text/javascript" />
		$(function(){
			
			$('#password2').keyup(function(){
				var pass_1 = $('#password').val();
				var pass_2 = $('#password2').val();
				var _this = $('#password2');
				_this.attr('style', 'background:#FFFFFF');
				if(pass_1 != pass_2 && pass_2 != ''){
					_this.attr('style', 'background:#F4ADC1');
				}
			});
			
			
			$('#email').keyup(function(){
				var _this = $('#email');
				var _email = $('#email').val();
				var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
				var valid = re.test(_email);
				if(valid){
					_this.attr('style', 'background:white');
				} else {
					_this.attr('style', 'background:#F4ADC1');
				}
			});	
				
		});
	</script>
	<script src="js/functions.js"></script>
</body>