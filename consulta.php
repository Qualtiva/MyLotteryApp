<?php session_start();
include ('sistema/configuracion.php');
$usuario->LoginCuentaConsulta();
$usuario->VerificacionCuenta();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title><?php echo TITULO ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="shortcut icon" href="<?php echo ESTATICO ?>img/favicon.ico">
		<link rel="stylesheet" href="<?php echo ESTATICO ?>css/bootstrap.css" media="screen">
		<link rel="stylesheet" href="<?php echo ESTATICO ?>css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo ESTATICO ?>css/qualtiva.css">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="<?php echo ESTATICO ?>html5shiv.js"></script>
		  <script src="<?php echo ESTATICO ?>respond.min.js"></script>
		<![endif]-->
	</head>
<body>
	<?php Menu(); ?>
    <div class="container">

		<div class="page-header" id="banner">
			<div class="row">
				<div class="col-lg-8 col-md-7 col-sm-6">
					<h1><?php echo TITULO ?></h1>
					<p class="lead">Consulta Tu Estado De Cuenta</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div id="custom-search-input">
						<div class="input-group col-md-12">
							<input type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" class="form-control input-lg" placeholder="Digite su n&uacute;mero de cedula ejemplo: 501230456" />
							<span class="input-group-btn">
								<button class="btn btn-info btn-lg" type="submit">
									<i class="glyphicon glyphicon-search"></i>
								</button>
							</span>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div id="myDiv"></div>
				</div>
			</div>
		</div>
	<?php PiePagina(); ?>
    </div>
    <script src="<?php echo ESTATICO ?>js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo ESTATICO ?>js/bootstrap.min.js"></script>
    <script src="<?php echo ESTATICO ?>js/bootswatch.js"></script>
    <script src="<?php echo ESTATICO ?>js/bootswatch.js">
	function loadXMLDoc()
	{
	var xmlhttp;

	var n=document.getElementById('bus').value;

	if(n==''){
	document.getElementById("myDiv").innerHTML="";
	return;
	}

	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
	document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
	}
	}
	xmlhttp.open("POST","proc.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("q="+n);
	}
	</script>
</body>
</html>
