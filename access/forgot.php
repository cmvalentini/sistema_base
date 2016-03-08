<?php
if(isset($_GET['errorforgot']) && $_GET['errorforgot'] == 'yes'){
	$html = '<script src="js/controladmin.js"></script>
	</head>	
	<body onload="badforgot();">';
}elseif (isset($_GET['errorforgot']) && $_GET['errorforgot'] == 'si') {
	$html = '<script src="js/controladmin.js"></script>
	</head>	
	<body onload="badforgot2();">';
}elseif (isset($_GET['vf']) && $_GET['vf'] == 'yes'){
	$html = '<script src="js/controladmin.js"></script>
	</head>	
	<body onload="okforg();">';
	header("location: login.php");
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
	  <h2>Recuperar Password</h2>
	  <p>Escriba su Correo electronico con el que se ha registrado, 
		se le enviara un nuevo password a su correo electronico:<br /><br /> </p>
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
	        <td><label>Correo electronico:</label></td>
	        <td><div><input type="email" class="form-control" name="email" id="email" placeholder="Correo electronico"></div></td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td><label>Confirme Correo electronico:</label></td>
	        <td><div><input type="email" class="form-control" name="email2" id="email2" placeholder="Confirme Correo electronico"></div></td>
	      </tr>
	      <tr>
	      	<td> </td> <td> </td> <td> </td>
	      </tr>
	      <tr>
	      	<td> </td>
	        <td> </td>
	        <td>
            <button id="forgot_bttn" class="btn btn-primary" type="button">Enviar</button>
            <input type="button" class="btn btn-cancel" onClick="javascript: location.href='index.php'" name="cancelar" value="Cancelar" >
	      </tr>
	    </tbody>
	  </table>
	  </form>
	</div>
    </div>
    <script type="text/javascript" />
		$(function(){
			
			$('#email2').keyup(function(){
				var email_1 = $('#email').val();
				var email_2 = $('#email2').val();
				var _this = $('#email2');
				_this.attr('style', 'background:#FFFFFF');
				if(email_1 != email_2 && email_2 != ''){
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
