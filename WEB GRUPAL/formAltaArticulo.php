<<<<<<< HEAD
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
=======
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
	<script type="text/javascript">
	function contarCaracteresDelTexto(obj){
		document.getElementById("charNum").innerHTML = obj.value.length+' de 4000';
	}
	function myFunction(e) {
		document.getElementById("CONTENIDOARTICULO").value = e.target.value
	}
	function addText(event) {
		var targ = event.target || event.srcElement;
		document.getElementById("CONTENIDOARTICULO").value+= targ.textContent || targ.innerText;
		var x = document.getElementById("CONTENIDOARTICULO");
		contarCaracteresDelTexto(x);
	}	
	 
    function enlace() { 
    	var x = document.getElementById("enlaceFinal"); 
	    var y = document.getElementById("enlaceInput"); 
        y.setAttribute('value', 'defaultValue'); 
        var z = new URL(y.value).hostname;
        x.innerHTML =" <a href='"+ y.value +"' target='_blank'>"+ z +"</a> ";
        document.getElementById("enlaceFinal").click();
        document.getElementById("enlaceInput").value = '';
    }

	function imagen() { 
    	var x = document.getElementById("imagenFinal"); 
	    var y = document.getElementById("imagenInput"); 
        y.setAttribute('value', 'defaultValue'); 
        var z = new URL(y.value).hostname;
        x.innerHTML =" <br/><img name='fotoArticulo' src='"+ y.value +"' alt='"+ z +"''></img><br/> ";
        document.getElementById("imagenFinal").click();  
        document.getElementById("imagenInput").value = '';  
    }

	</script>
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
			<div>
				<label for="NOMBREARTICULO">Títutlo: </label>
				<input type="text" name="NOMBREARTICULO" id="NOMBREARTICULO" size="50" value="<?php echo $formArticulo['NOMBREARTICULO'];?>" required />
			</div>
			<div>
				<label for="CONTENIDOARTICULO">Contenido: </label>
				<textarea type="text" name="CONTENIDOARTICULO" id="CONTENIDOARTICULO" cols="150" rows="10" value="<?php $formArticulo['CONTENIDOARTICULO'];?>" onchange="contarCaracteresDelTexto(this);" onkeypress="contarCaracteresDelTexto(this);" required></textarea>
				<p id="charNum">0 de 4000</p>		
			</div>
			<div>
				<input type="submit" value="Enviar" />
			</div>
			<div>
				<label>Enlace externo</label>
				<xmp onclick="addText(event)" style="display:none" id="enlaceFinal"></xmp>
				<input type="text" size="50" id="enlaceInput"></input> 
    			<label onclick="enlace()"> 
        			Añadir Enlace
    			</label>
    			<br>
				<label>Imagen</label>
				<xmp onclick="addText(event)" style="display:none" id="imagenFinal"></xmp>
				<input type="text" size="50" id="imagenInput"></input> 
    			<label onclick="imagen()"> 
        			Añadir Imagen
    			</label>
    			
			</div>
		</fieldset>
	</form>
</body>
>>>>>>> master
