<?php	
	session_start();
	
	if (isset($_REQUEST["IDUSUARIO"])) {
		$usuario["IDUSUARIO"] = $_REQUEST["IDUSUARIO"];
		$usuario["CORREOPERSONA"] = $_REQUEST["CORREOPERSONA"];
		$usuario["NOMBRETIPOUSUARIO"] = $_REQUEST["NOMBRETIPOUSUARIO"];
		$usuario["IDTIPOUSUARIO"] = $_REQUEST["IDTIPOUSUARIO"];
		$usuario["NOMBREUSUARIO"] = $_REQUEST["NOMBREUSUARIO"];
		$usuario["IDTIPONUEVO"] = $_REQUEST["IDTIPONUEVO"];

		$_SESSION["usuario"] = $usuario;
			
		if (isset($_REQUEST["editar"])) Header("Location: consultaUsuarios.php"); 
		else if (isset($_REQUEST["grabar"])) Header("Location: accionModificarUsuario.php");
		else if (isset($_REQUEST["borrar"])) Header("Location: accionBorrarUsuario.php");
	}
	else 
		Header("Location: consultausuarios.php");
	
?>
