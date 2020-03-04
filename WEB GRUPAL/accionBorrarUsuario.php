<?php	
	session_start();	
	
	if (isset($_SESSION["usuario"])) {
		$usuario = $_SESSION["usuario"];
		unset($_SESSION["usuario"]);
	
		require_once("gestionBD.php");
		require_once("gestionarUsuarios.php");
		
		$conexion = crearConexionBD();		
		$excepcion = eliminarusuario($conexion,$usuario["IDUSUARIO"]);
		cerrarConexionBD($conexion);
		
		if ($excepcion<>"") {
			$_SESSION["excepcion"] = $excepcion;
			$_SESSION["destino"] = "consultaUsuarios.php";
			Header("Location: excepcion.php");
		}
		else Header("Location: consultaUsuarios.php");
	}
	else Header("Location: consultaUsuarios.php");
?>
