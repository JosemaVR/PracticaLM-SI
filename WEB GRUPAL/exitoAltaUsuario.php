<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarUsuarios.php");
		
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["formulario"])) {
		$nuevoUsuario = $_SESSION["formulario"];
		$_SESSION["formulario"] = null;
		$_SESSION["errores"] = null;
	}
	else 
		Header("Location: formAltaUsuario.php");	

	$conexion = crearConexionBD(); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <title>VIVENZiA Inmobiliaria: Alta de Usuario realizada con éxito</title>
</head>

<body>

	<main id="altaUsuario">
		<?php if (altaUsuario($conexion, $nuevoUsuario)) { 
				header("Location: consultaArticulos.php");
		} else { ?>
				<h1>Ha ocurrido un error.</h1>
				<div>	
					Pulsa <a href="formAltaUsuario.php">aquí</a> para volver al formulario.
				</div>
		<?php } ?>			
	</main>

</body>
</html>
<?php
	cerrarConexionBD($conexion);
?>