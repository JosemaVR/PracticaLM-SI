<aside>
	<nav>
		<ul class="topnav" id="myTopnav">
			<li><a href="index.php">Libros</a></li>
		  	<li><a href="about.php">Sobre nosotros</a></li>
		  	
			<li>	<?php if (isset($_SESSION['login'])) {	?>
						<a href="logout.php">Desconectar</a>
					<?php } ?>
			</li>
		</ul>
	</nav>
</aside>
