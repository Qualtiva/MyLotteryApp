<?php session_start();
include ('sistema/configuracion.php');
$usuario->LoginCuentaConsulta();
$usuario->VerificacionCuenta();
if(isset($_POST['RegistrarCompra'])){
	$id		= filter_var($_POST['IdNumero'], FILTER_VALIDATE_INT);
	$cliente= filter_var($_POST['nombrecliente'], FILTER_SANITIZE_STRING);
	$total	= filter_var($_POST['total'], FILTER_SANITIZE_STRING);
	$fecha	= FechaActual();
	$hora	= HoraActual();
	$FH		= $fecha.' '.$hora;
	$vendedor	= $usuarioApp['id'];
	// Agrego los datos para generar la factura
	$facturaSql	= $db->Conectar()->query("INSERT INTO `factura` (`total`, `fecha`, `nombre`, `usuario`) VALUES ('{$total}', '{$FH}', '{$cliente}', '{$usuarioApp['id']}')");
	// Copiando Datos de la caja temporal a la caja principal
	$registrarSql = $db->Conectar()->query("INSERT INTO `ventas` (idventa, numero, cantidad, fecha, hora, tipo, vendedor)
	SELECT
	  idventa, numero, cantidad, fecha, hora, tipo, vendedor
	FROM   `cajatmp`
	WHERE  vendedor='{$vendedor}'");

	// Eliminando numeros de caja temporal
	$EliminarCajaTmp = $db->Conectar()->query("DELETE FROM `cajatmp` WHERE `idventa` = '{$id}'");
}
$localSql	= $db->Conectar()->query("SELECT establecimiento, telefono, canton, distrito, direccion FROM `vendedores` WHERE id='{$usuarioApp['id']}'");
$local		= $localSql->fetch_array();
$ventaSql	= $db->Conectar()->query("SELECT `total`, `fecha`, `nombre` FROM `factura` WHERE id='1'");
$venta		= $ventaSql->fetch_array();
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
					<h1>StockAPP</h1>
					<p class="lead">Desarrollo para aplicaciones web</p>
				</div>
			</div>
		</div>
<div class="row">
                	<div class="col-lg-4">
                    	<table class="table table-bordered">
                          <tbody><tr>
                            <td>
                                <h2 align="center">
                                    <strong>Valor Recibido: </strong><br>
                                    <pre style="font-size:24px">$ 448.000,00</pre><br>
                                    <strong>Total Factura: </strong><br>
                                    <pre style="font-size:24px">$ 448.000,00</pre><br>
                                    <strong>Vueltas: </strong><br>
                                    <pre style="font-size:24px">$ 0,00</pre>
                                </h2>                                 
                            </td>
                          </tr>
                        </tbody></table>
                    </div>
                	<div class="col-lg-8">
                    	<table class="table table-bordered">
                          	<tbody><tr>
                            	<td>
                                	<center>
                                   	<button onclick="imprimir();" class="btn btn-default"><i class="fa fa-print"></i> <strong>IMPRIMIR</strong></button><br><br>
                                	<div id="imprimeme">
                                    	<center><strong>Gracias por su Compra</strong></center>
                                    	<table width="95%">
                                        	<tbody>
												<tr>
													<td><br>
														<strong><?php echo $local['establecimiento']; ?><br>
														<strong>Factura: </strong><?php echo $id; ?><br>
														<strong>Fecha: </strong><?php echo $venta['fecha']; ?><br>
														<strong>Cliente: </strong><?php echo $venta['nombre']; ?>
													</td>
												</tr>
											</tbody>
										</table>
										<br>
                                        <table width="95%" rules="all" border="1">
											<tbody>
												<tr>
													<td align="center"><strong>N&uacute;mero</strong></td>
													<td align="center"><strong>Valor</strong></td>
												</tr>
												<?php
												$cajaSql	= $db->Conectar()->query("SELECT * FROM ventas WHERE idventa='{$id}'");
												while($caja	= $cajaSql->fetch_array()){
												?>
												<tr>
													<td align="center"><?php echo $caja['numero']; ?></td>
													<td align="center"><?php echo $caja['cantidad']; ?></td>
												</tr>
												<?php
												}
												?>
												<tr>
													<td colspan="1"><div align="center"><strong>Total a Pagar</strong></div></td>
													<?php
													$netoSql= $db->Conectar()->query("SELECT SUM(cantidad) AS deudatotal FROM ventas WHERE idventa='{$id}'");
													$neto	= $netoSql->fetch_array();
													?>
													<td><div align="center"><strong>&cent; <?php echo $Vendedor->FormatoSaldo($neto['deudatotal']); ?></strong></div></td>
												</tr>
											</tbody>
										</table>
										<br>
                                        <center>
                                        	<?php echo $local['establecimiento']; ?><br>
                                            <?php echo $local['telefono']; ?><br>
                                            <?php echo $local['direccion']; ?><br>
                                        </center>
                                    </div>
                                    </center>
                                </td>
                        	</tr>
                    	</tbody></table>
                    </div>
                </div>
	<?php PiePagina(); ?>
    </div>
    <script src="<?php echo ESTATICO ?>js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo ESTATICO ?>js/bootstrap.min.js"></script>
    <script src="<?php echo ESTATICO ?>js/bootswatch.js"></script>
  	<script type="text/javascript">
		function imprimir(){
		  var objeto=document.getElementById('imprimeme');  //obtenemos el objeto a imprimir
		  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
		  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
		  ventana.document.close();  //cerramos el documento
		  ventana.print();  //imprimimos la ventana
		  ventana.close();  //cerramos la ventana
		}
	</script>
</body>
</html>
