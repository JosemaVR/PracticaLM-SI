<?php
	session_start();

	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("gestionBD.php");
	require_once("gestionar_direcciones.php");
	require_once("gestionarUsuarios.php");


	// Comprobar que hemos llegado a esta página porque se ha rellenado el formulario
	if (isset($_SESSION["formulario"])) {
		// Recogemos los datos del formulario
		$nuevoUsuario["DNI"] = $_REQUEST["DNI"];
		$nuevoUsuario["NOMBRE"] = $_REQUEST["NOMBRE"];
		$nuevoUsuario["APELLIDO1"] = $_REQUEST["APELLIDO1"];
		$nuevoUsuario["APELLIDO2"] = $_REQUEST["APELLIDO2"];
		$nuevoUsuario["EMAIL"] = $_REQUEST["EMAIL"];
		$nuevoUsuario["NOMBREUSUARIO"] = $_REQUEST["NOMBREUSUARIO"];		
		$nuevoUsuario["PASS"] = $_REQUEST["PASS"];		
		$nuevoUsuario["confirmpass"] = $_REQUEST["confirmpass"];
		$nuevoUsuario["NUMEROSS"] = $_REQUEST["NUMEROSS"];
		$nuevoUsuario["NOMBRE_DEPARTAMENTO"] = $_REQUEST["NOMBRE_DEPARTAMENTO"];
		$nuevoUsuario["NOMBRE_ROL"] = $_REQUEST["NOMBRE_ROL"];
	
	} else // En caso contrario, vamos al formulario
		Header("Location: form_alta_usuario.php");


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
		Header('Location: form_alta_usuario.php');
	}
	
	// Si se han detectado errores
	if (count($errores)>0) {
		// Guardo en la sesión los mensajes de error y volvemos al formulario
		$_SESSION["errores"] = $errores;
		Header('Location: form_alta_usuario.php');
	} else
		// Si todo va bien, vamos a la página de éxito (inserción del usuario en la base de datos)
		Header('Location: exito_alta_usuario.php');

///////////////////////////////////////////////////////////
// Validación en servidor del formulario de alta de usuario
///////////////////////////////////////////////////////////
function validarDatosUsuario($conexion, $nuevoUsuario){
	$errores=array();
	// Validación del NIF
	if($nuevoUsuario["DNI"]=="")  {
		$errores[] = "<p>El DNI no puede estar vacío</p>";
	} else if(!preg_match("/^[0-9]{8}[A-Z]$/", $nuevoUsuario["DNI"])){
		$errores[] = "<p>El DNI debe contener 8 números y una letra mayúscula: " . $nuevoInmueble["DNI"]. "</p>";
	}

	// Validación del Nick
	if($nuevoUsuario["NOMBREUSUARIO"]=="") 
		$errores[] = "<p>El nombre no puede estar vacío</p>";

	// Validación del Nombre			
	if($nuevoUsuario["NOMBRE"]=="") 
		$errores[] = "<p>El nombre no puede estar vacío</p>";
	
	// Validación del Primer Apellido			
	if($nuevoUsuario["APELLIDO1"]=="") 
		$errores[] = "<p>El primer apellido no puede estar vacío</p>";
	
	// Validación del Segundo Apellido			
	if($nuevoUsuario["APELLIDO2"]=="") 
		$errores[] = "<p>El segundo apellido no puede estar vacío</p>";
	
	// Validación del email
	if($nuevoUsuario["EMAIL"]==""){ 
		$errores[] = "<p>El email no puede estar vacío</p>";
	}else if(!filter_var($nuevoUsuario["EMAIL"], FILTER_VALIDATE_EMAIL)){
		$errores[] = "<p>El email es incorrecto: " . $nuevoUsuario["EMAIL"]. "</p>";
	}

	// Validación de la contraseña
	if(!isset($nuevoUsuario["PASS"]) || strlen($nuevoUsuario["PASS"])<8){
		$errores [] = "<p>Contraseña no válida: debe tener al menos 8 caracteres</p>";
	}else if(!preg_match("/[a-z]+/", $nuevoUsuario["PASS"]) || 
		!preg_match("/[A-Z]+/", $nuevoUsuario["PASS"]) || !preg_match("/[0-9]+/", $nuevoUsuario["PASS"])){
		$errores[] = "<p>Contraseña no válida: debe contener letras mayúsculas y minúsculas y dígitos</p>";
	}else if($nuevoUsuario["PASS"] != $nuevoUsuario["confirmpass"]){
		$errores[] = "<p>La confirmación de contraseña no coincide con la contraseña</p>";
	}

	// Validar Nombre de la zona
	$error = validarDepartamento($conexion, $nuevoUsuario["NOMBRE_DEPARTAMENTO"]);
	if($error!="")
		$errores[] = $error;
	
	// Validar Tipo de inmueble
	$error = validarRol($conexion, $nuevoUsuario["NOMBRE_ROL"]);
	if($error!="")
		$errores[] = $error;

		// Validar DNI
	$error = validarDni($conexion, $nuevoUsuario["DNI"]);
	if($error!="")
		$errores[] = $error;		

		// Validar nombre de usuario
	$error = validarNombreUsuario($conexion, $nuevoUsuario["NOMBREUSUARIO"]);
	if($error!="")
		$errores[] = $error;
		
		// Validar numero SS
	$error = validarNumeroSS($conexion, $nuevoUsuario["NUMEROSS"]);
	if($error!="")
		$errores[] = $error;		
		
		// Validar email
	$error = validarEmail($conexion, $nuevoUsuario["EMAIL"]);
	if($error!="")
		$errores[] = $error;
		
	return $errores;
}

function validarRol($conexion, $roles){
	$error="";
	$roles_db = array(); 
	$db = listarRoles($conexion);
	foreach ($db as $rol_db){
		$roles_db[] = $rol_db["OID_ROLL"];
	}
	
	if(count(array_intersect($roles_db, $roles)) < count($roles)){
		$error = $error ."<p>Los roles no son válidos</p>";
	}
	
	return $error;
}

// Comprueba si los tipos de inmueble pasados por el usuario están en la BD
function validarDepartamento($conexion, $departamento){
	$error="";
	$departamento_db = array(); 
	$db = listarDepartamento($conexion);
	foreach ($db as $depart_db){
		$departamento_db[] = $depart_db["OID_DEPARTAMENTO"];
	}
	
	if(count(array_intersect($departamento_db, $departamento)) < count($departamento)){
		$error = $error ."<p>Los departamentos no son válidos</p>";
	}
	
	return $error;
}

function validarDni($conexion, $dni) {	
	$error="";
	$db = array();
	$db = listarDni($conexion);
	$dni_php = explode(', ', "".$dni." ");
	foreach ($db as $dni_db){
		$dnis_db[] = $dni_db["DNI"];
	}

	if(count(array_unique(array_intersect($dnis_db, $dni_php))) > 0) {
		$error = $error ."<p>El DNI ya existe.</p>";
	}
	return $error;
}
function validarNombreUsuario($conexion, $usuario) {	
	$error="";
	$db = array();
	$db = listarNombreUsuario($conexion);
	$dni_php = explode(', ', "".$usuario."");
	foreach ($db as $dni_db){
		$dnis_db[] = $dni_db["NOMBREUSUARIO"];
	}

	if(count(array_unique(array_intersect($dnis_db, $dni_php))) > 0) {
		$error = $error ."<p>El nombre de usuario ya existe.</p>";
	}
	return $error;
}
function validarNumeroSS($conexion, $usuario) {	
	$error="";
	$db = array();
	$db = listarNumeroSS($conexion);
	$dni_php = explode(', ', "".$usuario."");
	foreach ($db as $dni_db){
		$dnis_db[] = $dni_db["NUMEROSS"];
	}

	if(count(array_unique(array_intersect($dnis_db, $dni_php))) > 0) {
		$error = $error ."<p>El numero de la Seguridad Social ya existe.</p>";
	}
	return $error;
}
function validarEmail($conexion, $usuario) {	
	$error="";
	$db = array();
	$db = listarEmail($conexion);
	$dni_php = explode(', ', "".$usuario."");
	foreach ($db as $dni_db){
		$dnis_db[] = $dni_db["EMAIL"];
	}

	if(count(array_unique(array_intersect($dnis_db, $dni_php))) > 0) {
		$error = $error ."<p>El email ya existe.</p>";
	}
	return $error;
}

?>
