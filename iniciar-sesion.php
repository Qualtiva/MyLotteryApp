<?php
include ('sistema/configuracion.php');
$usuario->LoginUsuario();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Iniciar Sesi&oacute;n | <?php echo TITULO ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="canonical" href="<?php echo URLBASE ?>">
    <link rel="shortcut icon" href="<?php echo ESTATICO ?>img/favicon.ico">
    <link href="<?php echo ESTATICO ?>css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="<?php echo ESTATICO ?>css/qualtiva.css" rel="stylesheet" id="bootstrap-css">
</head>
<body class="fondo-color">
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<center class="logo">
				<a href="<?php echo URLBASE ?>" title="Qualtiva" alt="Qualtiva">
					<img src="<?php echo ESTATICO ?>img/applogo.png" width="450"></img>
					<div class="nombre"><?php echo TITULO ?></div>
				</a>
			</center>
			<div class="well bs-component">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#iniciar-sesion" data-toggle="tab">Iniciar Sesi&oacute;n</a>
					</li>
					<li>
						<a href="#recuperar-contrasena" data-toggle="tab">Recuperar Contrase&ntilde;a</a>
					</li>
				</ul>
				<p></p>
				<div id="myTabContent" class="tab-content">
					<!-- Iniciar Sesion -->
					<div class="tab-pane fade active in" id="iniciar-sesion">
						<form id="iniciar-sesion" action="" method="post" role="form" style="display: block;">
							<div class="form-group">
								<input type="text" name="usuarioPost" id="usuarioPost" tabindex="1" class="form-control" placeholder="Usuario" autocomplete="off" required />
							</div>
							<div class="form-group">
								<input type="password" name="contrasenaPost" id="contrasenaPost" tabindex="2" class="form-control" placeholder="Contrase&ntilde;a" autocomplete="off" required />
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<input type="submit" name="sesionPost" id="sesion" tabindex="4" class="btn btn-primary" value="Iniciar Sesi&oacute;n">
									</div>
								</div>
							</div>
						</form>
					</div>
					<!-- Iniciar Sesion Fin -->
					<div class="tab-pane fade" id="recuperar-contrasena">
						<form id="recuperar-contrasena" action="" method="post" role="form">
							<div class="form-group">
								<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Cedula" value="">
							</div>
							<div class="form-group">
								<input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="PIN" value="">
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="btn btn-primary" value="Recuperar Contrase&ntilde;a">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<center>
			<font color="#fff">
				<?php PiePagina(); ?>
			</font>
		</center>
	</div>
</div>
<!-- Cargar JS al final para mas velocidad del sitio -->
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="<?php echo ESTATICO ?>js/bootstrap.min.js"></script>
</body>
</html>
