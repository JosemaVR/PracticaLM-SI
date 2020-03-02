<?php
	require_once ("paginacion_consulta.php");

	$query2 = "SELECT NOMBREUSUARIO FROM USUARIOS U FULL JOIN TIPOSUSUARIO L ON L.IDTIPOUSUARIO=U.IDTIPOUSUARIOFK WHERE IDTIPOUSUARIO='1'";

	$total_registros2 = total_consulta($conexion, $query2);
	
	$filas2 = consulta_paginada($conexion, $query2, $pagina_seleccionada, $pag_tam);
?>

<nav>
	<ul class="topnav" id="myTopnav">
		<li><?php if (isset($_SESSION['login'])) {	?>
				<a href="consultaArticulos.php">Inicio</a>
			<?php } else { ?>
				<a href="login.php">Inicio</a>
			<?php } ?>
		</li>
	  	
	  	<li><a href="about.php">Sobre nosotros</a></li>
		
		<?php if (isset($_SESSION['login'])) {	?><li><a>Formularios de alta</a>
			<ul>
				<li>
						<a href="formAltaArticulo.php">Nuevos Articulos</a>
				</li>
				
				<li>
						<a href="formAltaUsuario.php">Nuevos Usuarios</a>
				</li>

			</ul>
			
		</li>
		<?php } else { ?>
			<a style="display:none"></a>
		<?php } ?>
		
		<li><?php if (!isset($_SESSION['login'])) {	?>
				<a href="login.php" onclick="return confirm('Zona exclusiva de empleados. ¿Acceder?');">Login</a>                     
			<?php } else { ?>
				<a style="display:none"></a>
			<?php } ?>
		</li>		

 		<li><?php if (!isset($_SESSION['login'])) { ?>	
				<a style="display:none"></a>
			<?php } else if (isset($_SESSION['login'])) { ?>
				<a href="consultaUsuarios.php">Listado de Clientes</a>	
			<?php } ?>		

		<li><?php if (isset($_SESSION['login'])) {	?>
				<a href="logout.php">Desconectar - <?php echo $_SESSION['login']; ?> - <?php echo consultarIdUsuario($conexion, $_SESSION['login']);
; ?></a>
			<?php } else { ?>
				<a style="display:none"></a>
			<?php } ?>
		</li>
           	
		<li class="icon">
			<a href="javascript:void(0);" onclick="myToggleMenu()">&#9776;</a>
		</li>	
	</ul>
</nav>
</body>
</html>