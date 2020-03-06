<?php
	session_start();
	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("gestionBD.php");
	require_once("gestionarUsuarios.php");
	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["formulario"])) {
		// Recogemos los datos del formulario
		$nuevoUsuario["DNIPERSONA"] = $_REQUEST["DNIPERSONA"];
		$nuevoUsuario["NOMBREPERSONA"] = $_REQUEST["NOMBREPERSONA"];
		$nuevoUsuario["APELLIDO1PERSONA"] = $_REQUEST["APELLIDO1PERSONA"];
		$nuevoUsuario["APELLIDO2PERSONA"] = $_REQUEST["APELLIDO2PERSONA"];
		$nuevoUsuario["CORREOPERSONA"] = $_REQUEST["CORREOPERSONA"];
		$nuevoUsuario["NOMBREUSUARIO"] = $_REQUEST["NOMBREUSUARIO"];		
		$nuevoUsuario["PASSUSUARIO"] = $_REQUEST["PASSUSUARIO"];		
		$nuevoUsuario["confirmpass"] = $_REQUEST["confirmpass"];
		$nuevoUsuario["IDTIPOUSUARIO"] = "";
	
	} else // En caso contrario, vamos al formulario
		Header("Location: formAltaUsuario.php");
	// Guardar la variable local con los datos del formulario en la sesión.
	$_SESSION["formulario"] = $nuevoUsuario;
	// Validamos el formulario en servidor
	// Si se produce alguna excepción PDO en la validación, volvemos al formulario informando al usuario
	try{ 
		$conexion = crearConexionBD(); 
		$errores = validarDatosUsuario($conexion, $nuevoUsuario);
		cerrarConexionBD($conexion);
	}catch(PDOException $e){
		// Mensaje de depuración
		$_SESSION["errores"] = "<p>ERROR en la validación: fallo en el acceso a la base de datos.</p><p>" . $e->getMessage() . "</p>";
		Header('Location: formAltaUsuarioNuevo.php');
	}
		// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		Header('Location: formAltaUsuarioNuevo.php');
	} else
		// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
		Header('Location: exitoAltaUsuarioNuevo.php');
///////////////////////////////////////////////////////////
// Validación en servidor del formulario de alta de usuario
///////////////////////////////////////////////////////////
function validarDatosUsuario($conexion, $nuevoUsuario){
	$errores=array();
	// Validación del NIF
	if($nuevoUsuario["DNIPERSONA"]=="")  {
		$errores[] = "<p>El DNIPERSONA no puede estar vacío</p>";
	} else if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoUsuario["DNIPERSONA"])){
		$errores[] = "<p>El DNIPERSONA debe contener 8 números y una letra mayúscula: " . $nuevoUsuario["DNIPERSONA"]. "</p>";
	}

	// Validación del Nick
	if($nuevoUsuario["NOMBREUSUARIO"]=="") 
		$errores[] = "<p>El NOMBREPERSONA no puede estar vacío</p>";

	// Validación del NOMBREPERSONA			
	if($nuevoUsuario["NOMBREPERSONA"]=="") 
		$errores[] = "<p>El NOMBREPERSONA no puede estar vacío</p>";
	
	// Validación del Primer Apellido			
	if($nuevoUsuario["APELLIDO1PERSONA"]=="") 
		$errores[] = "<p>El primer apellido no puede estar vacío</p>";
	
	// Validación del Segundo Apellido			
	if($nuevoUsuario["APELLIDO2PERSONA"]=="") 
		$errores[] = "<p>El segundo apellido no puede estar vacío</p>";
	
	// Validación del CORREOPERSONA
	if($nuevoUsuario["CORREOPERSONA"]==""){ 
		$errores[] = "<p>El CORREOPERSONA no puede estar vacío</p>";
	}else if(!filter_var($nuevoUsuario["CORREOPERSONA"], FILTER_VALIDATE_EMAIL)){
		$errores[] = "<p>El CORREOPERSONA es incorrecto: " . $nuevoUsuario["CORREOPERSONA"]. "</p>";
	}

	// Validación de la contraseña
	if(!isset($nuevoUsuario["PASSUSUARIO"]) || strlen($nuevoUsuario["PASSUSUARIO"])<8){
		$errores [] = "<p>Contraseña no válida: debe tener al menos 8 caracteres</p>";
	}else if(!preg_match("/[a-z]+/", $nuevoUsuario["PASSUSUARIO"]) || 
		!preg_match("/[A-Z]+/", $nuevoUsuario["PASSUSUARIO"]) || !preg_match("/[0-9]+/", $nuevoUsuario["PASSUSUARIO"])){
		$errores[] = "<p>Contraseña no válida: debe contener letras mayúsculas y minúsculas y dígitos</p>";
	}else if($nuevoUsuario["PASSUSUARIO"] != $nuevoUsuario["confirmpass"]){
		$errores[] = "<p>La confirmación de contraseña no coincide con la contraseña</p>";
	}

		// Validar DNIPERSONA
	$error = validarDNIPERSONA($conexion, $nuevoUsuario["DNIPERSONA"]);
	if($error!="")
		$errores[] = $error;		

		// Validar NOMBREPERSONA de usuario
	$error = validarNOMBREUSUARIO($conexion, $nuevoUsuario["NOMBREUSUARIO"]);
	if($error!="")
		$errores[] = $error;		
		
		// Validar CORREOPERSONA
	$error = validarCORREOPERSONA($conexion, $nuevoUsuario["CORREOPERSONA"]);
	if($error!="")
		$errores[] = $error;
		
	return $errores;
}

function validarDNIPERSONA($conexion, $DNIPERSONA) {	
	$error="";
	$db = array();
	$db = listarUsuarios($conexion);
	$DNIPERSONA_php = explode(', ', "".$DNIPERSONA." ");
	foreach ($db as $DNIPERSONA_db){
		$DNIPERSONAs_db[] = $DNIPERSONA_db["DNIPERSONA"];
	}

	if(count(array_unique(array_intersect($DNIPERSONAs_db, $DNIPERSONA_php))) > 0) {
		$error = $error ."<p>El DNIPERSONA ya existe.</p>";
	}
	return $error;
}
function validarNOMBREUSUARIO($conexion, $usuario) {	
	$error="";
	$db = array();
	$db = listarUsuarios($conexion);
	$DNIPERSONA_php = explode(', ', "".$usuario."");
	foreach ($db as $DNIPERSONA_db){
		$DNIPERSONAs_db[] = $DNIPERSONA_db["NOMBREUSUARIO"];
	}

	if(count(array_unique(array_intersect($DNIPERSONAs_db, $DNIPERSONA_php))) > 0) {
		$error = $error ."<p>El NOMBREPERSONA de usuario ya existe.</p>";
	}
	return $error;
}

function validarCORREOPERSONA($conexion, $usuario) {	
	$error="";
	$db = array();
	$db = listarUsuarios($conexion);
	$DNIPERSONA_php = explode(', ', "".$usuario."");
	foreach ($db as $DNIPERSONA_db){
		$DNIPERSONAs_db[] = $DNIPERSONA_db["CORREOPERSONA"];
	}

	if(count(array_unique(array_intersect($DNIPERSONAs_db, $DNIPERSONA_php))) > 0) {
		$error = $error ."<p>El CORREOPERSONA ya existe.</p>";
	}
	return $error;
}

?>
