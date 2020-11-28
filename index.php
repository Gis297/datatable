<!DOCTYPE html>
<html>
<head>
	<title>Giselle</title>
	<?php 

	require_once "scripts.php";
	?>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card text-left">
					<div class="card-header">
						Tablas dinamicas con datatable y php
					</div>
					<div class="card-body">
						<button type="button"class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
							Agregar nuevo <span class="fa fa-plus-circle"></span></button>
							<hr>
							<div id="tablaDatatable"></div>
						</div>
						<div class="card-footer text-muted">
							By Giselle Romero
						</div>
					</div>
				</div> 
			</div>
		</div>


		<!-- Modal -->
		<div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Agrega un juego</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="frmnuevo">
							<label>Nombre</label>
							<input type="text" class="form-control input-sm" id="nombre" name="nombre">
							<label>Año</label>
							<input type="text" class="form-control input-sm" id="anio" name="anio">
							<label>Empresa</label>
							<input type="text" class="form-control input-sm" id="empresa" name="empresa">
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
						<button type="button" id="btnAgregarnuevo" class="btn btn-primary">Agregar nuevo</button>
					</div>
				</div>
			</div>
		</div>

			<!-- Modal -->
			<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Actualiza un juego</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="frmnuevoU">
								<input type="text" hidden = "" id= "idjuego" name="idjuego">
								<label>Nombre</label>
								<input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
								<label>Año</label>
								<input type="text" class="form-control input-sm" id="anioU" name="anioU">
								<label>Empresa</label>
								<input type="text" class="form-control input-sm" id="empresaU" name="empresaU">
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							<button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
						</div>
					</div>
				</div>
			</div>
		</body>
		</html>

		<script type="text/javascript">
			$(document).ready(function(){
				$('#btnAgregarnuevo').click(function(){
					datos=$('#frmnuevo').serialize();

					$.ajax({

						type:"POST",
						data: datos, 
						url:"procesos/agregar.php",
						success:function(r){
							if(r==1){
								$('#tablaDatatable').load('tabla.php'); 
								alertify.success("Agregado con exito :D");
							}else{
								alertify.error("Fallo al agregar:("); 
							}

						}
					}); 
				}); 

				$('#btnActualizar').click(function(){
					datos=$('#frmnuevoU').serialize();

					$.ajax({

						type:"POST",
						data: datos, 
						url:"procesos/actualizar.php",
						success:function(r){
							if(r==1){
								$('#tablaDatatable').load('tabla.php'); 
								alertify.success("Actualizado con exito :D");
							}else{
								alertify.error("Fallo al agregar:("); 
							}

						}
					}); 
				});	
			}); 

		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#tablaDatatable').load('tabla.php');

			});
		</script>

		<script type="text/javascript">

			function agregaFrmActualizar(idjuego){

				$.ajax({

					type: "POST",
					data: "idjuego=" + idjuego,
					url: "procesos/obtenDatos.php",
					success:function(r){
						datos=jQuery.parseJSON(r); 
						$('#idjuego').val(datos['id_juego']); 
						$('#nombreU').val(datos['nombre']);
						$('#anioU').val(datos['anio']);
						$('#empresaU').val(datos['empresa']);
					}
				});
			}

			function eliminarDatos(idjuego){
				alertify.confirm('Eliminar un juego','¿Seguro de eliminar este juego de pros :c,?', function(){
					

					$.ajax({

						type: "POST",
						data: "idjuego=" + idjuego,
						url: "procesos/eliminar.php",
						success:function(r){
						 if(r==1){
						 	$('#tablaDatatable').load('tabla.php');
						 	alertify.success("¡Eliminado con éxito!");
						 }else{
						 	alertify.error("No se pudo eliminar");
						 }
						}
					});

			}
			, function(){
			 });
			}
		</script>