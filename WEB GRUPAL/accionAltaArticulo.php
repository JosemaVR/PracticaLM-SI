<?php
	session_start();
	 
	require_once("gestionBD.php");
	require_once("gestionarArticulos.php");
	
	if (isset($_SESSION['formArticulo'])) {
		$nuevoArticulo["NOMBREARTICULO"] = $_REQUEST["NOMBREARTICULO"];
		$nuevoArticulo["CONTENIDOARTICULO"] = $_REQUEST["CONTENIDOARTICULO"];
		$nuevoArticulo["IDAUTOR"] = $_REQUEST["CONTENIDOARTICULO"];;
		//safri del futuro decidió poner aquí idarticulo e idautor pero no sabe que poner
		
	} else
		Header("Location: formAltaArticulo.php");
	
	$_SESSION["formArticulo"] = $nuevoArticulo;
	
	try{
		$conexion = crearConexionBD();
		$errores = validarDatosArticulo($conexion, $nuevoArticulo);
	} catch(PDOException $e) {
		$_SESSION["errores"] = $errores;
		Header ('Location: formAltaArticulo.php');
	}
	
	if(count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header('Location: formAltaArticulo.php');
	} else 
		Header('Location: exitoAltaArticulo.php');
		
		
function validarDatosArticulo($conexion, $nuevoArticulo) {
	$errores=array();
	
	if($nuevoArticulo["NOMBREARTICULO"]=="")  {
		$errores[] = "<p>El título no puede estar vacío</p>";
	} else if (strlen($nuevoArticulo["NOMBREARTICULO"]) > 50 ){
		$errores[] = "<p>El título no puede ser mayor de 50 carácteres.</p>";
	}
	
	if($nuevoArticulo["CONTENIDOARTICULO"]=="") 
		$errores[] = "<p>El Articulo debe contener información para ser publicado</p>";
	}
	
	
	$error = validarNOMBREARTICULO($conexion, $nuevoArticulo["NOMBREARTICULO"]);
	if($error!="")
		$errores[] = $error;	
	
	$error = validarContenidoArticulo($conexion, $nuevoArticulo["CONTENIDOARTICULO"]);
	if($error!="")
		$errores[] = $error;	
	
function validarNOMBREARTICULO($conexion, $articulos) {	
	$error="";
	$db = array();
	$db = listarArticulo($conexion);
	$IDARTICULO_php = explode(', ', "".$usuario."");
	foreach ($db as $IDARTICULOs_db){
		$IDARTICULOs_db[] = $IDARTICULOs_db["NOMBREARTICULO"];
	}
	if(count(array_unique(array_intersect($IDARTICULOs_db, $IDARTICULO_php))) > 0) {
		$error = $error ."<p>Ya existe un árticulo con este título.</p>";
	}
	return $error;
}
	
function validarCONTENIDOARTICULO($conexion, $usuario) {	
	$error="";
	$db = array();
	$db = listarArticulo($conexion);
	$IDARTICULO_php = explode(', ', "".$usuario."");
	foreach ($db as $IDARTICULOs_db){
		$IDARTICULOs_db[] = $IDARTICULOs_db["CONTENIDOARTICULO"];
	}
	if(count(array_unique(array_intersect($IDARTICULOs_db, $IDARTICULO_php))) > 0) {
		$error = $error ."<p>Ya existe un árticulo con este contenido.</p>";
	}
	return $error;
}

?>