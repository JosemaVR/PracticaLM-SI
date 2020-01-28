<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarNoticias.php");
	
	if (isset($_SESSION["articulo"])){
		$articulo = $_SESSION["articulo"];
		unset($_SESSION["articulo"]);
	}
	$conexion = crearConexionBD();
	$filas = consultaArticulos($conexion);
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
<article class="articulo">
	<form method="post" action="controladorArticulos.php">
		<div class="filaArticulo">
			<div class="datosArticulo">
				<input id="IDARTICULO" name="IDARTICULO"
					type="hidden" value="<?php echo $fila["IDARTICULO"]; ?>"/>
				
				<?php if (isset($articulo) and ($articulo["IDARTICULO"] == $fila["IDARTICULO"])) { ?>
					<div class="Info"><?php echo $fila["NOMBREARTICULO"] .", de ". $fila["NOMBREUSUARIO"] ." - ". $fila["CONTENIDOARTICULO"] ." - A fecha de ". $fila["FECHAARTICULO"]; ?> 
					</div>
				<?php }	else { ?>
					<div class="Info"><?php echo $fila["NOMBREARTICULO"] .", de ". $fila["NOMBREUSUARIO"] ." - ". $fila["CONTENIDOARTICULO"] ." - A fecha de ". $fila["FECHAARTICULO"]; ?> 
					</div>
				<?php } ?>
			</div>
			<div id="botones_fila">
				<?php if (isset($articulo) and ($articulo["IDARTICULO"] == $fila["IDARTICULO"])) { ?>
					<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación" onclick="return confirm('¿Está seguro de modificar?');">
					</button>
				<?php } else { ?>
					<button id="editar" name="editar" type="submit" class="editar_fila" >
						<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar precio">
					</button>
				<?php } ?>
					<button id="borrar" name="borrar" type="submit" class="editar_fila">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar inmueble"  onclick="return confirm('¿Está seguro de eliminar?');">
					</button>
			</div>
		</div>
	</form>
</article>
	<?php } ?>
</main>
</body>
</html>