<?php

//FALTA METER COMO SE RECOGERIA IDAUTOR...

	session_start();
	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("gestionBD.php");
	require_once("gestionarArticulos.php");
	require_once ("gestionarUsuarios.php");
	// Si no existen datos del formulario en la sesión, se crea una entrada con valores por defecto
	if (!isset($_SESSION['formArticulo'])) {
		$formArticulo['NOMBREARTICULO'] = "";
		$formArticulo['CONTENIDOARTICULO'] = "";
		$formArticulo['IDAUTOR'] = "";
		//el safri del futuro acabó decidiendo no escribir aquí nada sobre idarticulo ni idautor ya que no hay ninguna insercion
		
		
		$_SESSION['formArticulo'] = $formArticulo;
	}
	
	else
		$formArticulo = $_SESSION['formArticulo'];
	
	if (isset($_SESSION["errores"])){
		$errores =$_SESSION["errores"];
		unset($_SESSION["errores"]);
	}
	
	$conexion = crearConexionBD();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/styleArticulo.css"/>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
	<script src="js/validation_alta_articulo.js" type="text/javascript"></script>
	<title>Gestión de Artículos: Nuevo arttículo</title>
	</head>
	<body>
		<?php
			include_once ("menu.php");
		
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
		<fieldset>
		
		<div><label for="NOMBREARTICULO">Títutlo</label>
		<input type="text" name="NOMBREARTICULO" id="NOMBREARTICULO" size="50" value="<?php echo $formArticulo['NOMBREARTICULO'];?>" required />
		</div>
		<br/>
		<script>
			function myFunction(e) {
    			document.getElementById("CONTENIDOARTICULO").value = e.target.value
			}
		</script>
		<div><textarea type="text" name="CONTENIDOARTICULO" id="CONTENIDOARTICULO" cols="150" value="<?php $formArticulo['CONTENIDOARTICULO'];?>" required></textarea>
		</div>
		<div>
			<ul>
  				<li><label>Enlace externo</label><xmp onclick="addText(event)"><a href="direccionWeb" target="_blank">nombreMostrado</a></xmp></li>
 	 			<li><label>Imagen</label><xmp onclick="addText(event)"><img src="enlaceImagen" alt="nombreImagen"></xmp></li></li>
			</ul>
			<script>
    			function addText(event) {
    				var targ = event.target || event.srcElement;
    				document.getElementById("CONTENIDOARTICULO").value += targ.textContent || targ.innerText;
				}
			</script>
		</div>

		<div><input type="submit" value="Enviar" /></div>
		</form>
	</body>