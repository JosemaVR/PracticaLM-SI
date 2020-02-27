<?php
	session_start();
	require_once("gestionBD.php");
	require_once("gestionarArticulos.php");
	require_once ("paginacion_consulta.php");
if (isset($_SESSION["articulo"])) {
		$articulo = $_SESSION["articulo"];
		unset($_SESSION["articulo"]);
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
	$query = "SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario";
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
<main>
	<?php
		foreach($filas as $fila) {
	?>
<article class="articulo" id="articleArticulo">
	<form method="post" action="controladorArticulos.php">
		<div class="filaArticulo">
			<div class="datosArticulo">
				<input id="IDARTICULO" name="IDARTICULO"
					type="hidden" value="<?php echo $fila["IDARTICULO"]; ?>"/>
				<input id="NOMBREARTICULO" name="NOMBREARTICULO"
					type="hidden" value="<?php echo $fila["NOMBREARTICULO"]; ?>"/>
				<input id="NOMBREUSUARIO" name="NOMBREUSUARIO"
					type="hidden" value="<?php echo $fila["NOMBREUSUARIO"]; ?>"/>
				<input id="FECHAARTICULO" name="FECHAARTICULO"
					type="hidden" value="<?php echo $fila["FECHAARTICULO"]; ?>"/>
				<?php if (isset($articulo) and ($articulo["IDARTICULO"] == $fila["IDARTICULO"])) { ?>
						<!-- Editando título -->
						<input id="NOMBREARTICULO" name="NOMBREARTICULO" type="hidden" value=<?php echo $fila["NOMBREARTICULO"]; ?>/>
						<div class="Info">
							<em><input id="NOMBREARTICULO" name="NOMBREARTICULO" type="text" value="<?php echo  $fila["NOMBREARTICULO"];?>"/></em>
							<b><?php echo  ", de " . $fila["NOMBREUSUARIO"] . ", el ". $fila["FECHAARTICULO"]; ?></b>
						</div>
						<div class="Contenido">
							Contenido: <em><input id="CONTENIDOARTICULO" name="CONTENIDOARTICULO" type="text" value="<?php echo  $fila['CONTENIDOARTICULO'];?>"/></em>
						</div>
				<?php }	else { ?>
						<!-- mostrando título -->
						<input id="NOMBREARTICULO" name="NOMBREARTICULO" type="hidden" value=<?php echo $fila["NOMBREARTICULO"]; ?>/>
						<div class="Info">
							<b><?php echo $fila["NOMBREARTICULO"] . ", de " . $fila["NOMBREUSUARIO"] . ", el ". $fila["FECHAARTICULO"]; ?></b>
						</div>
						<div class="Contenido">Contenido: <?php echo  $fila['CONTENIDOARTICULO'];?></div>
				<?php } ?>
			</div>
			<div id="botones_fila">
				<?php if (isset($articulo) and ($articulo["IDARTICULO"] == $fila["IDARTICULO"])) { ?>
					<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación" onclick="return confirm('¿Está seguro de modificar?');">
					</button>
				<?php } else { ?>
					<button id="editar" name="editar" type="submit" class="editar_fila" >
						<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar articulo">
					</button>
				<?php } ?>
					<button id="borrar" name="borrar" type="submit" class="editar_fila" onclick="return confirm('¿Está seguro de eliminar?');">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar articulo"  >
					</button>
			</div>
		</div>
	</form>
</article>
	<?php } ?>
</main>
</body>
</html>