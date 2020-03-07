<header class="">
	<div class="wrapper">
		<div class="logo">LOGO.EXE</div>
		<nav>
			<?php if (isset($_SESSION['login'])) {	?>

			<a href="consultaArticulos.php">Inicio</a>
			<?php } else { ?>
			<a style="display:none"/>

			<?php } ?>

			<a href="about.php">Sobre nosotros</a>

			<?php if (isset($_SESSION['login'])) { 
			if ((consultarTipoUsuario($conexion, $_SESSION['login'])) != 3) { ?>				
			<div class="container"><a>Formularios de alta</a>
			<ul>
				<li>
					<a href="formAltaArticulo.php">Nuevos Articulos</a>
				</li>
				<?php if ((consultarTipoUsuario($conexion, $_SESSION['login'])) == 1) { ?>				
				<li>
					<a href="formAltaUsuario.php">Nuevos Usuarios</a>
				</li>
				<?php } } ?>
			</ul></div>


			<?php } else { ?>
			<a style="display:none"/>
			<?php } ?>

			<?php if (!isset($_SESSION['login'])) {	?>

			<a href="login.php">Login</a>                   
			<?php } else { ?>
			<a style="display:none"/>

			<?php } ?>

			<?php if (isset($_SESSION['login'])) { ?>	
			<?php if ((consultarTipoUsuario($conexion, $_SESSION['login'])) == 1) { ?>

			<a href="consultaUsuarios.php">Listado de Usuarios</a>
			<?php } else { ?>
			<a style="display:none"/>

			<?php } } ?>		

			<?php if (isset($_SESSION['login'])) {	?>

			<a href="logout.php">Desconectar - <?php echo $_SESSION['login']; ?> - <?php echo consultarNombreTipoUsuario($conexion, $_SESSION['login']); ?>
			</a>
			<?php } else { ?>
			<a style="display:none"/>

			<?php } ?>
		</nav>
	</div>
</header>
</body>
</html>