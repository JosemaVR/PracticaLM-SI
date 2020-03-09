<?php
	session_start();
	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("gestionBD.php");
	require_once("gestionarUsuarios.php");
	// Si no existen datos del formulario en la sesión, se crea una entrada con valores por defecto
	if (!isset($_SESSION['formulario'])) {
		$formulario['NOMBREUSUARIO'] = "";
		$formulario['PASSUSUARIO'] = "";
		$formulario['confirmpass'] = "";
		$formulario['IDTIPOUSUARIO'] = "";
		$formulario['DNIPERSONA'] = "";
		$formulario['NOMBREPERSONA'] = "";
		$formulario['APELLIDO1PERSONA'] = "";
		$formulario['APELLIDO2PERSONA'] = "";
		$formulario['CORREOPERSONA'] = "";
		
		$_SESSION['formulario'] = $formulario;
	}
	// Si ya existían valores, los cogemos para inicializar el formulario
	else
		$formulario = $_SESSION['formulario'];
			
	// Si hay errores de validación, hay que mostrarlos y marcar los campos (El estilo viene dado y ya se explicará)
	if (isset($_SESSION["errores"])){
		$errores = $_SESSION["errores"];
		unset($_SESSION["errores"]);
	}
	// Creamos una conexión con la BD
	$conexion = crearConexionBD();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style_David.css" />
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>
  <title>Gestión de Usuarios: Nuevo usuario</title>
</head>
<body>
	<?php
include_once ("menu.php");
?>

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
	<form id="altaUsuario" method="get" action="accionAltaUsuarioNuevo.php" onsubmit="return validateForm()">
		<p><i class="titulo">	FORMULARIO ALTA USUARIO	</i></p>		
			
			<p class="margen"><label for="DNIPERSONA">DNI(*)</label></p>
			<input class="field" id="DNIPERSONA" name="DNIPERSONA" type="text" size="40" placeholder="12345678X" pattern="^[0-9]{8}[A-Z]" title="Ocho dígitos seguidos de una letra mayúscula" value="<?php echo $formulario['DNIPERSONA'];?>" required><br/>
			

			<p><label for="NOMBREPERSONA">Nombre:(*)</label></p>
			<input class="field" id="NOMBREPERSONA" name="NOMBREPERSONA" type="text" size="40" value="<?php echo $formulario['NOMBREPERSONA'];?>" required><br/>
			

			<p><label for="APELLIDO1PERSONA">Primer apellido:(*)</label></p>
			<input class="field" id="APELLIDO1PERSONA" name="APELLIDO1PERSONA" type="text" size="40" value="<?php echo $formulario['APELLIDO1PERSONA'];?>"><br/>
			
			
			<p><label for="APELLIDO2PERSONA">Segundo apellido:(*)</label></p>
			<input class="field" id="APELLIDO2PERSONA" name="APELLIDO2PERSONA" type="text" size="40" value="<?php echo $formulario['APELLIDO2PERSONA'];?>"><br/>
			

			<p><label for="CORREOPERSONA">Email:(*)</label></p>
			<input class="field" id="CORREOPERSONA" name="CORREOPERSONA"  type="email" size="40" placeholder="usuario@dominio.extension" value="<?php echo $formulario['CORREOPERSONA'];?>" required><br/>
			
					
			<p><label for="NOMBREUSUARIO">Usuario:(*)</label></p>
				<input class="field" id="NOMBREUSUARIO" name="NOMBREUSUARIO" type="text" size="40" value="<?php echo $formulario['NOMBREUSUARIO'];?>"><br/>
			
			<p><label for="PASSUSUARIO">Contraseña:(*)</label></p>
                <input class="field" type="password" size="40" name="PASSUSUARIO" id="PASSUSUARIO" placeholder="Mínimo 8 caracteres entre letras y dígitos" oninput="passwordValidation();" required><br/>
			
			<p><label for="confirmpass">Confirmar contraseña:(*) </label></p>
				<input class="field" type="password" name="confirmpass" id="confirmpass" placeholder="Confirmación de contraseña" size="40" oninput="passwordConfirmation();" required><br/>
			
			<p>
				
		<p class="center-content"><input type="submit" class="btn btn-green" value="Enviar Datos"/></p>
	<p><i class="pie">Campos Obligatorios (*)</i></p>
	</form>
	<?php
		cerrarConexionBD($conexion);
	?>
	</body>
</html>
