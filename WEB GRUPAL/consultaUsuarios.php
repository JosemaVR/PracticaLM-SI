<?php
	session_start();
	require_once("gestionBD.php");
	require_once ("gestionarUsuarios.php");
if (isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];
		unset($_SESSION["usuario"]);
	}

	$conexion = crearConexionBD();
	$filas = listarUsuarios($conexion);
	cerrarConexionBD($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio</title>
</head>
<body>
	<?php
include_once ("menu.php");
?>
<main>
	<?php
		foreach($filas as $fila) {
	?>
<article class="usuario" id="articleUsuario">
	<form method="post" action="controladorUsuarios.php">
		<div class="filaUsuario">
			<div class="datosUsuario">
				<input id="IDUSUARIO" name="IDUSUARIO"
					type="hidden" value="<?php echo $fila["IDUSUARIO"]; ?>"/>
				<input id="NOMBRETIPOUSUARIO" name="NOMBRETIPOUSUARIO"
					type="hidden" value="<?php echo $fila["NOMBRETIPOUSUARIO"]; ?>"/>
				<input id="NOMBREUSUARIO" name="NOMBREUSUARIO"
					type="hidden" value="<?php echo $fila["NOMBREUSUARIO"]; ?>"/>
				<input id="IDTIPOUSUARIO" name="IDTIPOUSUARIO"
					type="hidden" value="<?php echo $fila["IDTIPOUSUARIO"]; ?>"/>
				<input id="CORREOPERSONA" name="CORREOPERSONA"
					type="hidden" value="<?php echo $fila["CORREOPERSONA"]; ?>"/>

				<?php if (isset($usuario) and ($usuario["IDUSUARIO"] == $fila["IDUSUARIO"])) { ?>
						<!-- Editando título -->
						<div class="Info">
							<b><?php echo "Cargo: " ?></b>
							<em>
								<input id='IDTIPONUEVO' name='IDTIPONUEVO' style="display:none" type='text' value='1' />
								<script>
									function myFunction(e) {
    									document.getElementById("IDTIPONUEVO").value = e.target.value
									}
								</script>
								<select name="" id="IDTIPO" onchange="myFunction(event)" required>
									<?php	$tipos = listarTipoUsuario($conexion);
										foreach ($tipos as $tipo) {
											if(in_array($tipo["IDTIPOUSUARIO"], $fila['IDTIPOUSUARIO'])){
												echo "<option value='" . $tipo["IDTIPOUSUARIO"] . "' label='" . $tipo["NOMBRETIPOUSUARIO"] . "' selected/>";
											} else {
												echo "<option value='" . $tipo["IDTIPOUSUARIO"] . "' label='" . $tipo["NOMBRETIPOUSUARIO"] . "'/>";
											}
										} 
									?>
								</select>
							</em>
							<b><?php echo " - Nick: " . $fila["NOMBREUSUARIO"] . " - Nivel: ". $fila["IDTIPOUSUARIO"] ." - Email: ". $fila["CORREOPERSONA"]; ?></b>
						</div>	
				<?php }	else { ?>
						<!-- mostrando título -->
						<div class="Info">
							<b><?php echo "Cargo: ". $fila["NOMBRETIPOUSUARIO"] . " - Nick: " . $fila["NOMBREUSUARIO"] . " - Nivel: ". $fila["IDTIPOUSUARIO"] ." - Email: ". $fila["CORREOPERSONA"]; ?></b>
						</div>
				<?php } ?>
			</div>
			<div id="botones_fila">
				<?php if (isset($usuario) and ($usuario["IDUSUARIO"] == $fila["IDUSUARIO"])) { ?>
					<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación" onclick="return confirm('¿Está seguro de modificar?');">
					</button>
				<?php } else { ?>
					<button id="editar" name="editar" type="submit" class="editar_fila" >
						<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar usuario">
					</button>
				<?php } ?>
					<button id="borrar" name="borrar" type="submit" class="editar_fila" onclick="return confirm('¿Está seguro de eliminar?');">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar usuario"  >
					</button>
			</div>
		</div>
	</form>
</article>
	<?php } ?>
</main>
</body>
</html>