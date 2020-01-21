<?php
	session_start();
  	
  	include_once("gestionBD.php");
 	include_once("gestionarUsuarios.php");
	
	if (isset($_POST['submit'])){
		$email= $_POST['email'];
		$pass = $_POST['pass'];

		$conexion = crearConexionBD();
		$num_usuarios = consultarUsuario($conexion,$email);
		cerrarConexionBD($conexion);	
	
		if (password_verify($pass,$num_usuarios)){
			$_SESSION['login'] = $email;
			Header("Location: consultaNoticias.php");	
		} else if ($pass == $num_usuarios) {
			$_SESSION['login'] = $email;
			Header("Location: consultaNoticias.php");	
		} else {
			$login = "error";
		}	
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <title>VIVENZIA Empleados: Login</title>
</head>

<body>

<?php
	include_once("cabecera.php");
?>

<main>
	<?php if (isset($login)) {
		echo "<div class=\"error\">";
		echo "Error en la contraseña o no existe el usuario.";
		echo "</div>";
	}	
	?>
	
	<!-- The HTML login form -->
	<div class='background'>	
	<form action="login.php" method="post">
		<div><label for="email">Usuario: </label><input type="text" name="email" id="email" required/></div>
		<div><label for="pass">Contraseña: </label><input type="password" name="pass" id="pass" required/></div>
		<input type="submit" name="submit" value="submit" />
	</form>
	</div>	
		
</main>

<?php
	include_once("pie.php");
?>
</body>
</html>

