<?php
	session_start();
	require_once("gestionBD.php");
	require_once("gestionarArticulo.php");
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formArticulo
	if (isset($_SESSION["formArticulo"])) {
		$nuevoArticulo = $_SESSION["formArticulo"];
		$_SESSION["formArticulo"] = null;
		$_SESSION["errores"] = null;
	} else Header("Location: formAltaArticulo.php");	
	$conexion = crearConexionBD(); 
	//esto es practicamente un copia y pega de exitoaltausuario
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/styleArticulo.css" />
  <title>Gestión de artículos: Nuevo artículo añadido con éxito</title>
</head>
<body>
	<main id="insertarArticulo">
		<?php if (insertarArticulo($conexion, $nuevoArticulo)) { ?>
			<h1>Ha ocurrido un error.</h1>
				<div>	
					Pulsa <a href="formAltaArticulo.php">aquí</a> para volver al formArticulo.
				</div>
		<?php } else {
			header("Location: consultaArticulos.php");
		} ?>			
	</main>
</body>
</html>
<?php
	cerrarConexionBD($conexion);
?>