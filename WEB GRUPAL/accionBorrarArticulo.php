<?php	
	session_start();	
	
	if (isset($_SESSION["articulo"])) {
		$articulo = $_SESSION["articulo"];
		unset($_SESSION["articulo"]);
	
		require_once("gestionBD.php");
		require_once("gestionarArticulos.php");
		
		$conexion = crearConexionBD();		
		$excepcion = eliminarArticulo($conexion,$articulo["IDARTICULO"]);
		cerrarConexionBD($conexion);
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "consultaArticulos.php";
			Header("Location: excepcion.php");
		}
		else Header("Location: consultaArticulos.php");
	}
	else Header("Location: consultaArticulos.php");
?>
