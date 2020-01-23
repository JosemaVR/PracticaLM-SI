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
	<div class="Info"><?php echo $fila["NOMBREARTICULO"] .", de ".$fila["NOMBREUSUARIO"] ." - ". $fila["CONTENIDOARTICULO"]; ?> 
	</div>
</article>

	<?php } ?>
</main>

</body>
</html>