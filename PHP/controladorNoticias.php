<?php	
	session_start();
	
	if (isset($_REQUEST["idArticulo"])) {
		$libro["idArticulo"] = $_REQUEST["idArticulo"];
		$libro["idPublicacion"] = $_REQUEST["idPublicacion"];
		$libro["nombreArticulo"] = $_REQUEST["nombreArticulo"];
		$libro["contenidoArticulo"] = $_REQUEST["contenidoArticulo"];
		$libro["fechaPublicacion"] = $_REQUEST["fechaPublicacion"];
		$libro["nombreUsuario"] = $_REQUEST["nombreUsuario"];
		$libro["nombreArticulo"] = $_REQUEST["nombreArticulo"];

		$_SESSION["noticias"] = $libro;
			
		if (isset($_REQUEST["editar"])) Header("Location: consultaNoticas.php"); 
		
	}
	else 
		Header("Location: consultaNoticias.php");
	
?>
