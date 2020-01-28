
<?php
	session_start();
	
	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("gestionBD.php");
	require_once("gestionar_direcciones.php");
	require_once("gestionarUsuarios.php");
	
	// Si no existen datos del formulario en la sesión, se crea una entrada con valores por defecto
	if (!isset($_SESSION['formulario'])) {
		$formulario['DNI'] = "";
		$formulario['NOMBRE'] = "";
		$formulario['APELLIDO1'] = "";
		$formulario['APELLIDO2'] = "";
		$formulario['EMAIL'] = "";
		$formulario['NOMBREUSUARIO'] = "";
		$formulario['PASS'] = "";
		$formulario['confirmpass'] = "";
		$formulario['NUMEROSS'] = "";
		$formulario['NOMBRE_DEPARTAMENTO'] = "";
		$formulario['NOMBRE_ROL'] = "";

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
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>
  <title>Gestión de Usuarios: Nuevo usuario</title>
</head>

<body>
	<script>
		// Inicialización de elementos y eventos cuando el documento se carga completamente
		$(document).ready(function() {

			$("#PASS").on("keyup", function() {
				passwordColor();
			});
		});
	</script>

	
	<?php
		include_once("cabecera.php");
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
	
	<form id="altaUsuario" method="get" action="accion_alta_usuario.php" onsubmit="return validateForm()">
		<p><i>¡¡¡TODOS LOS CAMPOS SON OBLIGATORIOS!!!</i>		
			<fieldset>
			<div></div><label for="DNI">DNI</label>
			<input id="DNI" name="DNI" type="text" placeholder="12345678X" pattern="^[0-9]{8}[A-Z]" title="Ocho dígitos seguidos de una letra mayúscula" value="<?php echo $formulario['DNI'];?>" required>
			</div>

			<div><label for="NOMBRE">Nombre:</label>
			<input id="NOMBRE" name="NOMBRE" type="text" size="40" value="<?php echo $formulario['NOMBRE'];?>" required/>
			</div>

			<div><label for="APELLIDO1">Primer apellido:</label>
			<input id="APELLIDO1" name="APELLIDO1" type="text" size="80" value="<?php echo $formulario['APELLIDO1'];?>"/>
			</div>
			
			<div><label for="APELLIDO2">Segundo apellido:</label>
			<input id="APELLIDO2" name="APELLIDO2" type="text" size="80" value="<?php echo $formulario['APELLIDO2'];?>"/>
			</div>

			<div><label for="EMAIL">Email:</label>
			<input id="EMAIL" name="EMAIL"  type="email" placeholder="usuario@dominio.extension" value="<?php echo $formulario['EMAIL'];?>" required/><br>
			</div>
					
			<div><label for="NOMBREUSUARIO">Usuario:</label>
				<input id="NOMBREUSUARIO" name="NOMBREUSUARIO" type="text" size="40" value="<?php echo $formulario['NOMBREUSUARIO'];?>" />
			</div>
			<div><label for="PASS">Contraseña:</label>
                <input type="password" name="PASS" id="PASS" placeholder="Mínimo 8 caracteres entre letras y dígitos" oninput="passwordValidation();" required/>
			</div>
			<div><label for="confirmpass">Confirmar contraseña: </label>
				<input type="password" name="confirmpass" id="confirmpass" placeholder="Confirmación de contraseña"  oninput="passwordConfirmation();" required"/>
			</div>
			
			<div><label for="NUMEROSS">Número de la Seguridad Social:</label>
			<input id="NUMEROSS" name="NUMEROSS" type="text" size="80" value="<?php echo $formulario['NUMEROSS'];?>"/>
			</div>
			<div><label for="NOMBRE_DEPARTAMENTO">Departamento:</label>
				<select name="NOMBRE_DEPARTAMENTO[]" id="NOMBRE_DEPARTAMENTO" required>
					<?php	$depar = listarDepartamento($conexion);
						foreach ($depar as $dep) {
						if(in_array($dep["OID_DEPARTAMENTO"], $formulario['NOMBRE_DEPARTAMENTO'])){
								echo "<option value='".$dep["OID_DEPARTAMENTO"]."' label='".$dep["NOMBRE_DEPARTAMENTO"]."' selected/>";
						} else {
								echo "<option value='".$dep["OID_DEPARTAMENTO"]."' label='".$dep["NOMBRE_DEPARTAMENTO"]."'/>";
							}
						}
					?>
				</select>
			</div>
			<div><label for="NOMBRE_ROL">Rol:</label>
				<select name="NOMBRE_ROL[]" id="NOMBRE_ROL" required>
					<?php	$roles = listarRoles($conexion);
						foreach ($roles as $rol) {
						if(in_array($rol["OID_ROLL"], $formulario['NOMBRE_ROL'])){
								echo "<option value='".$rol["OID_ROLL"]."' label='".$rol["NOMBRE_ROL"]."' selected/>";
						} else {
								echo "<option value='".$rol["OID_ROLL"]."' label='".$rol["NOMBRE_ROL"]."'/>";
							}
						}
					?>
				</select>
			</div>
		</fieldset>
		<p><i>¡¡¡TODOS LOS CAMPOS SON OBLIGATORIOS!!!</i>		

		<div><input type="submit" value="Enviar" /></div>
	</form>
	
	<?php
		include_once("pie.php");
		cerrarConexionBD($conexion);
	?>
	
	</body>
</html>
