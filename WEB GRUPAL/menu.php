<nav>
	<ul class="topnav" id="myTopnav">
		<?php if (isset($_SESSION['login'])) {	?>
			<li>
				<a href="consultaArticulos.php">Inicio</a>
		<?php } else { ?>
				<a style="display:none"></a>
			</li>
	  	<?php } ?>
		
		<li><a href="about.php">Sobre nosotros</a></li>
		
		<?php if (isset($_SESSION['login'])) { 
			if ((consultarTipoUsuario($conexion, $_SESSION['login'])) != 3) { ?>				
		<li><a>Formularios de alta</a>
			<ul>
				<li>
						<a href="formAltaArticulo.php">Nuevos Articulos</a>
				</li>
				<?php if ((consultarTipoUsuario($conexion, $_SESSION['login'])) == 1) { ?>				
				<li>
						<a href="formAltaUsuario.php">Nuevos Usuarios</a>
				</li>
				<?php } } ?>
			</ul>
			
		</li>
		<?php } else { ?>
			<a style="display:none"></a>
		<?php } ?>
		
		<?php if (!isset($_SESSION['login'])) {	?>
			<li>	
				<a href="login.php">Login</a>                   
		<?php } else { ?>
				<a style="display:none"></a>
			</li>		
		<?php } ?>
		
 		<?php if (isset($_SESSION['login'])) { ?>	
			<?php if ((consultarTipoUsuario($conexion, $_SESSION['login'])) == 1) { ?>
			<li>				
				<a href="consultaUsuarios.php">Listado de Usuarios</a>
			<?php } else { ?>
				<a style="display:none"></a>
			</li>	
		<?php } } ?>		

		<?php if (isset($_SESSION['login'])) {	?>
			<li>
				<a href="logout.php">Desconectar - <?php echo $_SESSION['login']; ?> - <?php echo consultarNombreTipoUsuario($conexion, $_SESSION['login']); ?></a>
		<?php } else { ?>
				<a style="display:none"></a>
			</li>
		<?php } ?>
	</ul>
</nav>
</body>
</html>