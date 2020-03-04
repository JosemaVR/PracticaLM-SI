<?php
	session_start();
	require_once("gestionBD.php");
	require_once ("gestionarUsuarios.php");
	require_once ("paginacion_consulta.php");
if (isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];
		unset($_SESSION["usuario"]);
	}
	// ¿Venimos simplemente de cambiar página o de haber seleccionado un registro ?
	// ¿Hay una sesión activa?
	if (isset($_SESSION["paginacion"])) $paginacion = $_SESSION["paginacion"];
	$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
	$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);
	if ($pagina_seleccionada < 1) 		$pagina_seleccionada = 1;
	if ($pag_tam < 1) 		$pag_tam = 5;
	// Antes de seguir, borramos las variables de sección para no confundirnos más adelante
	unset($_SESSION["paginacion"]);
	$conexion = crearConexionBD();
	// La consulta que ha de paginarse
	$query = "SELECT * FROM USUARIOS, TIPOSUSUARIO, PERSONAS where USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario and PERSONAS.idPersona=USUARIOS.idPersonaFK";
	// Se comprueba que el tamaño de página, página seleccionada y total de registros son conformes.
	// En caso de que no, se asume el tamaño de página propuesto, pero desde la página 1
	$total_registros = total_consulta($conexion, $query);
	$total_paginas = (int)($total_registros / $pag_tam);
	if ($total_registros % $pag_tam > 0)		$total_paginas++;
	if ($pagina_seleccionada > $total_paginas)		$pagina_seleccionada = $total_paginas;
	// Generamos los valores de sesión para página e intervalo para volver a ella después de una operación
	$paginacion["PAG_NUM"] = $pagina_seleccionada;
	$paginacion["PAG_TAM"] = $pag_tam;
	$_SESSION["paginacion"] = $paginacion;
	$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);
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