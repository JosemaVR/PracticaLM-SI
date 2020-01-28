<?php	
	session_start();
	
	if (isset($_REQUEST["IDARTICULO"])) {
		$articulo["IDARTICULO"] = $_REQUEST["IDARTICULO"];
		$articulo["NOMBREARTICULO"] = $_REQUEST["NOMBREARTICULO"];
		$articulo["CONTENIDOARTICULO"] = $_REQUEST["CONTENIDOARTICULO"];
		$articulo["NOMBREUSUARIO"] = $_REQUEST["NOMBREUSUARIO"];

		$_SESSION["articulo"] = $articulo;
			
		if (isset($_REQUEST["editar"])) Header("Location: consultaArticulos.php"); 
		else if (isset($_REQUEST["borrar"])) Header("Location: accionBorrarArticulo.php");
	}
	else 
		Header("Location: consultaArticulos.php");
	
?>
