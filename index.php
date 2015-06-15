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
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="<?php echo ESTATICO ?>html5shiv.js"></script>
		  <script src="<?php echo ESTATICO ?>respond.min.js"></script>
		<![endif]-->
	</head>
<body>
	<?php Menu(); ?>
    <div class="container">
		<div class="page-header" id="banner"></div>
		<div class="row">
			<h1 class="modal-title" id="myModalLabel">Venta de N&uacute;meros</h1>
			<br/>
			<?php
			if(isset($_POST['cajatmp'])){
				$numero		= filter_var($_POST['numero'], FILTER_VALIDATE_INT);
				$cantidad	= filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);
				$vendedor	= filter_var($_POST['vendedor'], FILTER_VALIDATE_INT);
				$tipo		= filter_var($_POST['tipo'], FILTER_VALIDATE_INT);
				$fecha		= FechaActual();
				$hora		= HoraActual();
				$vendedor	= $usuarioApp['id'];
				$IdVentaSQL = $db->Conectar()->query("SELECT
				  MAX(`id`)+1 AS idfactura
				FROM
				  `factura`");
				$IdVenta	= $IdVentaSQL->fetch_array();
				$IdFactura	= $IdVenta['idfactura']+1;

				$CrearCajaTmpSql= $db->Conectar()->query("INSERT INTO `cajatmp` (`idventa`, `numero`, `cantidad`, `fecha`, `hora`, `tipo`, `vendedor`) VALUES ('{$IdFactura}', '{$numero}', '{$cantidad}', '{$fecha}', '{$hora}', '{$tipo}', '{$vendedor}')");
				if($CrearCajaTmpSql == true){
					echo'
					<div class="alert alert-dismissible alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>&iexcl;Bien hecho!</strong> Haz un agregado n&uacute;mero con exito.
					</div>
					<meta http-equiv="refresh" content="2;url='.URLBASE.'"/>';
				}else{
					echo'
					<div class="alert alert-dismissible alert-danger">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>&iexcl;Lo Sentimos!</strong> A ocurrido un error al agregado n&uacute;mero, intentalo de nuevo.
					</div>
					<meta http-equiv="refresh" content="2;url='.URLBASE.'"/>';
				}
			}
			if(isset($_POST['ActualizarCantidad'])){
				// Variables
				$IdCantidad	= filter_var($_POST['IdApuesta'], FILTER_VALIDATE_INT);
				$Cantidad	= filter_var($_POST['NuevaApuesta'], FILTER_VALIDATE_INT);
				// Query Para Actulizar La Cantidad Apuesta
				$ActulizarCantidadSql = $db->Conectar()->query("UPDATE `cajatmp` SET `cantidad` = '{$Cantidad}' WHERE `id` = '{$IdCantidad}'; ");
				// Mensaje De Comprobacion
				if($ActulizarCantidadSql==true){
					echo'
					<div class="alert alert-dismissible alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>&iexcl;Bien hecho!</strong> Se ha actualizado la cantidad Apuesta con exito.
					</div>
					<meta http-equiv="refresh" content="2;url='.URLBASE.'"/>';
				}else{
					echo'
					<div class="alert alert-dismissible alert-danger">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>&iexcl;Lo Sentimos!</strong> A ocurrido un error al actualizar la cantidad Apuesta, intentalo de nuevo.
					</div>
					<meta http-equiv="refresh" content="2;url='.URLBASE.'"/>';
				}
			}
			if(isset($_POST['EliminarNumero'])){
				// Variables
				$IdCantidad	= filter_var($_POST['IdNumero'], FILTER_VALIDATE_INT);
				// Query Para Actulizar La Cantidad Apuesta
				$EliminarNumeroSql = $db->Conectar()->query("DELETE FROM `cajatmp` WHERE `id` = '{$IdCantidad}'");
				// Mensaje De Comprobacion
				if($EliminarNumeroSql==true){
					echo'
					<div class="alert alert-dismissible alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>&iexcl;Bien hecho!</strong> Se ha eliminado el n&uacute;mero con exito.
					</div>
					<meta http-equiv="refresh" content="2;url='.URLBASE.'"/>';
				}else{
					echo'
					<div class="alert alert-dismissible alert-danger">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<strong>&iexcl;Lo Sentimos!</strong> A ocurrido un error al eliminar el n&uacute;mero, intentalo de nuevo.
					</div>
					<meta http-equiv="refresh" content="2;url='.URLBASE.'"/>';
				}
			}
			?>
			
			<form role="form" id="contact-form" method="post" action="" class="contact-form">
				<!-- Campos Ocultos Inicio-->
				<input type="hidden" name="vendedor" value="<?php echo $usuarioApp['usuario']; ?>" required disabled>
				<!-- Campos Ocultos Fin-->
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><strong>#</strong></span>
								<input type="text" maxlength="2" class="form-control" name="numero" id="inputEmail3" placeholder="Ingrese un N&uacute;mero" onkeypress="return justNumbers(event);" autofocus required />
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><strong>&cent;</strong></span>
								<input type="text" maxlength="5" class="form-control" name="cantidad" id="inputEmail3" placeholder="Cantidad de la Apuesta" onkeypress="return justNumbers(event);" autofocus required />
							</div>
						</div>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" name="tipo" id="SorteoMedioDia" value="0" checked="">
									Mediod&iacute;a
								</label>
							</div>
						</div>
					</div>
					<div class="col-md-1">
						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" name="tipo" id="SorteoNocturno" value="1">
									Nocturno
								</label>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" class="form-control" name="fecha" id="inputEmail3" value="<?php echo FechaActual(); ?>" autofocus required disabled>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<div class="input-group">
								<button type="submit" name="cajatmp" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Agregar N&uacute;mero</button>
							</div>
						</div>
					</div>
				</div>
				<br/>
			</form>
		
			<div class="row">
				<div class="col-md-8">
					<div style="width:100%; height:300px; overflow: auto;">
					<table class="table table-bordered">
						<tr class="well">
							<td><strong>N&uacute;mero</strong></td>
							<td><strong>Cantidad</strong></td>
							<td><strong>Sorteo</strong></td>
							<td><strong></strong></td>
						</tr>
						<?php
						$cajatmpSql = $db->Conectar()->query("SELECT * FROM cajatmp WHERE vendedor='{$usuarioApp['id']}'");
						while($cajatmp	= $cajatmpSql->fetch_array()){
						?>
						<tr>
							<td> <?php echo $cajatmp['numero']; ?></td>
							<td>
								<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ActualizarApuesta<?php echo $cajatmp['id']; ?>">&cent; <?php echo $Vendedor->FormatoSaldo($cajatmp['cantidad']); ?> </button>
								<!-- Modal -->
								<div class="modal fade" id="ActualizarApuesta<?php echo $cajatmp['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Actualizar Apuesta al <?php echo $cajatmp['numero']; ?></h4>
									  </div>
									  <div class="modal-body">
										<form class="form-horizontal" method="post" action="">
											<input type="hidden" name="IdApuesta" value="<?php echo $cajatmp['id']; ?>">
											<div class="form-group">
												<label  class="control-label">&nbsp;&nbsp;&nbsp;Cantidad Apuesta Actual</label>
												<div class="col-sm-12">
													<div class="input-group">
														<span class="input-group-addon"><strong>&cent;</strong></span>
														<input type="text" class="form-control" value="<?php echo $cajatmp['cantidad']; ?>" autofocus required disabled>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label  class="control-label">&nbsp;&nbsp;&nbsp;Cantidad Apuestada Actual</label>
												<div class="col-sm-12">
													<div class="input-group">
														<span class="input-group-addon"><strong>&cent;</strong></span>
														<input type="text" class="form-control" name="NuevaApuesta" placeholder="Escriba la nueva cantidad Apuesta" autofocus required>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
												   <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
													<button type="submit" name="ActualizarCantidad" class="btn btn-primary">Actualizar Apuesta</button>
												</div>
											</div>
										</form>
									  </div>
									</div>
								  </div>
								</div>
								<!-- Modal Final -->
							</td>
							<td>
								<?php
								if($cajatmp['tipo'] == 0){
									echo'Sorteo Mediod&iacute;a';
								}else if($cajatmp['tipo'] == 1){
									echo'Sorteo Nocturno';
								}else{
									echo'no existe un tipo de sorteo disponible';
								}
								?>
							</td>
							<td>
								<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#EliminarApuesta<?php echo $cajatmp['id']; ?>"><i class="fa fa-trash-o"></i></button>
								<!-- Modal -->
								<div class="modal fade" id="EliminarApuesta<?php echo $cajatmp['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title" id="myModalLabel">Eliminar Apuesta al <?php echo $cajatmp['numero']; ?></h4>
									  </div>
									  <div class="modal-body">
										<form class="form-horizontal" method="post" action="">
											<input type="hidden" name="IdNumero" value="<?php echo $cajatmp['id']; ?>">
											<div class="form-group">
												<div class="col-sm-12">
													<div class="input-group">
														¿Est&aacute; seguro que desea eliminar el n&uacute;mero?
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
												   <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
													<button type="submit" name="EliminarNumero" class="btn btn-primary">Si, Eliminar</button>
												</div>
											</div>
										</form>
									  </div>
									</div>
								  </div>
								</div>
								<!-- Modal Final -->
							</td>
						</tr>
						<?php
						}
						?>
					</table>
					</div>
				</div>
				<div class="col-md-4">
					<table class="table table-bordered">
						<tr>
							<td>
								<center><strong>Neto a Pagar</strong>
								<?php
								$netoSql= $db->Conectar()->query("SELECT SUM(cantidad) AS deudatotal FROM cajatmp WHERE vendedor='{$usuarioApp['id']}'");
								$neto	= $netoSql->fetch_array();
								?>
								<pre><h2 class="text-success" align="center">&cent; <?php echo $Vendedor->FormatoSaldo($neto['deudatotal']); ?></h2></pre>
								<?php
								$numerosTotalSql= $db->Conectar()->query("SELECT COUNT(id) FROM cajatmp WHERE vendedor='{$usuarioApp['id']}'");
								$numerosTotal	= MysqliResultQualtiva($numerosTotalSql);
								?>
								<strong>Cantidad de N&uacute;meros: <br><span class="badge badge-success"><?php echo $numerosTotal; ?></span></strong></center>
							</td>
						</tr>
					</table>
					<?php
					if($numerosTotal <= 0){
						echo'
						<button type="button" class="btn btn-default btn-lg btn-block" data-toggle="modal" disabled>
							<i class="fa fa-shopping-cart"></i> Comprar Numero
						</button>';
					}else if($numerosTotal == 1){
							echo'
							<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#ComprarNumeros">
								<i class="fa fa-shopping-cart"></i> Comprar N&uacute;mero
							</button>';
					}else if($numerosTotal>1){
							echo'
							<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#ComprarNumeros">
								<i class="fa fa-shopping-cart"></i> Comprar N&uacute;meros
							</button>';
					}else{
					}
					?>
					<!-- Modal -->
					<div class="modal fade" id="ComprarNumeros" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Registrar Compra Actual</h4>
						  </div>
						  <div class="modal-body">
							<form class="form-horizontal" method="post" action="">
								<input type="hidden" name="IdNumero" value="<?php echo $cajatmp['id']; ?>">
								<div class="form-group">
									<div class="col-sm-12">
										<h2>Neto a Pagar: &cent; <?php echo $Vendedor->FormatoSaldo($neto['deudatotal']); ?></strong></h2>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" name="nombrecliente" placeholder="Escriba Nombre del Cliente Completo" autofocus required>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
									   <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
										<button type="submit" name="EliminarNumero" class="btn btn-primary">Registrar Compra</button>
									</div>
								</div>
							</form>
						  </div>
						</div>
					  </div>
					</div>
					<!-- Modal Final -->
				</div>
			</div>

		</div>
		<hr/>
	<?php PiePagina(); ?>
    </div>
	<!-- Cargado archivos javascript al final para que la pagina cargue mas rapido -->
    <script src="<?php echo ESTATICO ?>js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo ESTATICO ?>js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="<?php echo ESTATICO ?>js/dataTables.bootstrap.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$('#example').dataTable();
		} );
	</script>
	<script type="text/javascript">
function justNumbers(e)
{
var keynum = window.event ? window.event.keyCode : e.which;
if ((keynum == 8) || (keynum == 46))
return true;
 
return /\d/.test(String.fromCharCode(keynum));
}
	</script>
    <script src="<?php echo ESTATICO ?>js/bootstrap.min.js"></script>
    <script src="<?php echo ESTATICO ?>js/bootswatch.js"></script>
</body>
</html>
