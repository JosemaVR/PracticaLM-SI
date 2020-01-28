<?php	
	session_start();	
	
	require_once("gestionBD.php");
	require_once("gestionarNoticias.php");
		
	$conexion = crearConexionBD();		
	$excepcion = eliminarArticulo($conexion,$articulo["IDARTICULO"]);
	cerrarConexionBD($conexion);
		
	if ($excepcion<>"") {
		$_SESSION["excepcion"] = $excepcion;
		$_SESSION["destino"] = "consultaArticulos.php";
		Header("Location: excepcion.php");
	}
	else Header("Location: consultaArticulos.php");
?>
