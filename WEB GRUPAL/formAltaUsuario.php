
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
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
  <script src="js/validacion_cliente_alta_usuario.js" type="text/javascript"></script>
  <title>Gestión de Usuarios: Nuevo usuario</title>
</head>

<body>
	<script>
		// Inicialización de elementos y eventos cuando el documento se carga completamente
		$(document).ready(function() {

			$("#PASSUSUARIO").on("keyup", function() {
				passwordColor();
			});
		});
	</script>
	
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
	
	<form id="altaUsuario" method="get" action="accionAltaUsuario.php" onsubmit="return validateForm()">
		<p><i>¡¡¡TODOS LOS CAMPOS SON OBLIGATORIOS!!!</i>		
			<fieldset>
			<div><label for="DNIPERSONA">DNI</label>
			<input id="DNIPERSONA" name="DNIPERSONA" type="text" placeholder="12345678X" pattern="^[0-9]{8}[A-Z]" title="Ocho dígitos seguidos de una letra mayúscula" value="<?php echo $formulario['DNIPERSONA'];?>" required>
			</div>

			<div><label for="NOMBREPERSONA">Nombre:</label>
			<input id="NOMBREPERSONA" name="NOMBREPERSONA" type="text" size="40" value="<?php echo $formulario['NOMBREPERSONA'];?>" required/>
			</div>

			<div><label for="APELLIDO1PERSONA">Primer apellido:</label>
			<input id="APELLIDO1PERSONA" name="APELLIDO1PERSONA" type="text" size="80" value="<?php echo $formulario['APELLIDO1PERSONA'];?>"/>
			</div>
			
			<div><label for="APELLIDO2PERSONA">Segundo apellido:</label>
			<input id="APELLIDO2PERSONA" name="APELLIDO2PERSONA" type="text" size="80" value="<?php echo $formulario['APELLIDO2PERSONA'];?>"/>
			</div>

			<div><label for="CORREOPERSONA">Email:</label>
			<input id="CORREOPERSONA" name="CORREOPERSONA"  type="email" placeholder="usuario@dominio.extension" value="<?php echo $formulario['CORREOPERSONA'];?>" required/><br>
			</div>
					
			<div><label for="NOMBREUSUARIO">Usuario:</label>
				<input id="NOMBREUSUARIO" name="NOMBREUSUARIO" type="text" size="40" value="<?php echo $formulario['NOMBREUSUARIO'];?>" />
			</div>
			<div><label for="PASSUSUARIO">Contraseña:</label>
                <input type="password" name="PASSUSUARIO" id="PASSUSUARIO" placeholder="Mínimo 8 caracteres entre letras y dígitos" oninput="passwordValidation();" required/>
			</div>
			<div><label for="confirmpass">Confirmar contraseña: </label>
				<input type="password" name="confirmpass" id="confirmpass" placeholder="Confirmación de contraseña"  oninput="passwordConfirmation();" required/>
			</div>
			
			<div><label for="IDTIPOUSUARIO">Rol:</label>
				<select name="IDTIPOUSUARIO[]" id="IDTIPOUSUARIO" required>
					<?php	$tipos = listarTipoUsuario($conexion);
						foreach ($tipos as $tipo) {
						if(in_array($tipo["IDTIPOUSUARIO"], $formulario['IDTIPOUSUARIO'])){
								echo "<option value='" . $tipo["IDTIPOUSUARIO"] . "' label='" . $tipo["NOMBRETIPOUSUARIO"] . "' selected/>";
						} else {
								echo "<option value='" . $tipo["IDTIPOUSUARIO"] . "' label='" . $tipo["NOMBRETIPOUSUARIO"] . "'/>";
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
		cerrarConexionBD($conexion);
	?>
	
	</body>
</html>
