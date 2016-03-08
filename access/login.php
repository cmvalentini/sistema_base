<?php
if(isset($_GET['errorusuario']) && $_GET['errorusuario'] == 'si'){
	$html = '<script src="js/controladmin.js"></script>
	</head>	
	<body onload="bad();">';
}elseif(isset($_GET['reset']) && $_GET['reset'] == 'ok'){
	$html = '<script src="js/controladmin.js"></script>
	</head>
	<body onload="ok();">';
}else{
	$html = '</head>
	<body>';
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    
    <title>Login</title>

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
		
      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="inner cover">
            <h2>Login</h2>
          	<div class="cover-center">
      
            	<!--form-->
				<form class="form-horizontal" method="post" id="formlogin" >
				  <div class="form-group">
				    <label for="inputUsername3" class="col-sm-2 control-label" id="labeluser">Usuario</label>
				    <div class="col-sm-10">
				      <input type="username" class="form-control" name="inputUsername3" id="inputUsername3" placeholder="Usuario" <?php if (isset($_COOKIE[$remember_crypt])){ echo 'value ='.$inputs[0]; } ?> >
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">Clave</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" name="inputPassword3" id="inputPassword3" placeholder="Clave" <?php if (isset($_COOKIE[$remember_crypt])){ echo 'value ='.$inputs[1]; } ?> >
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button id="login_bttn" class="btn btn-lg btn-primary btn-block" type="button">Login</button>
				    </div>
				    <div class="col-sm-offset-2 col-sm-10">
				      <div class="checkbox">
				        <label class="forgot"><a href="forgot.php">Olvide mi contraseña</a></label>
				        <label class="forgot"><a href="register.php">Deseo registrarme</label>
				      </div>
				    </div>
				  </div>
			</form>
			<!--form-->
			</div>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Acceso al Sistema</p>
            </div>
          </div>

        </div>

      </div>

    </div>
        
	<script src="js/functions.js"></script>
</body>