<?php
	start session();
	
	require_once("gestionBD.php");
	require_once("gestionarArticulos.php");
	
	if (!isset($_SESSION['formulario'])) {
		$formulario['NOMBREARTICULO'] = "";
		$formulario['CONTENIDOARTICULO'] = "";
		$formulario['IDUSUARIOFK'] = "";
		
		$_SESSION['formulario'] = $formulario;
	}
	
	else
		$formulario = $_SESSION['formulario'];
	
	if (isset($_SESSION["errores"])){
		$errores = $_SESSION["errores"];
		unset($_SESSION["errores"]);
	}
	
	$conexion = crearConexionBD();
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>
  <title>Gestión de Articulos: Nuevo articulo</title>
</head>

<body>
	<?php 
		// Mostrar los erroes de validación (Si los hay)
		if (isset($errores) && count($errores)>0) { 
	    	echo "<div id=\"div_errores\" class=\"error\">";
			echo "<h4> Errores en el formulario:</h4>";
    		foreach($errores as $error){
    			echo $error;
			} 
    		echo "</div>";
  		}
	?>
	
	<form id="altaArticulo" method="get" action="accionAltaArticulo.php" onsubmit="return validateForm()">