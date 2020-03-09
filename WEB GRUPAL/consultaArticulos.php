<?php
	session_start();
	require_once("gestionBD.php");
	require_once("gestionarArticulos.php");
	require_once ("gestionarUsuarios.php");
if (isset($_SESSION["articulo"])) {
		$articulo = $_SESSION["articulo"];
		unset($_SESSION["articulo"]);
	}
	$conexion = crearConexionBD();
	// La consulta que ha de paginarse
	$filas = consultaArticulos($conexion);
	$filas2 = consultaArticulos($conexion);
	cerrarConexionBD($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Inicio</title>
  <link rel="stylesheet" type="text/css" href="css/biblio.css" />
  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="js/header.js"></script>
  <script type="text/javascript">
  	function funcionVer(idArticulo){
    	var x = document.getElementById(idArticulo);
		var y = document.getElementsByName("Contenido");
		if(x.style.display == "block"){
			for (var k = 0; k<y.length; k++) {
				y[k].style.display = "none";
			}
		} else {
			for (var k = 0; k<y.length; k++) {
				y[k].style.display = "none";
			}
	 		x.style.display = "block";
		}	
	}
	</script>
</head>
<body>
	<?php
		include_once ("menu.php");
	?>
<main>
	<div style="position:fixed;right:50px;clear:left; "
<ul >
<?php	
	$filas2 = consultaArticulos($conexion);
	foreach($filas2 as $fila2) {
?>
<li>
<div id="<?php echo "articulo" . $fila2['idArticulo'] ?>" style="text-align:left;position:relative;float:right;" name="indice"><a href='<?php echo "#articulo" . $fila2["IDARTICULO"] ?>'><?php echo  $fila2['NOMBREARTICULO'];?></a>
</div>
</li>

<?php
	}
?>
</ul>
</div>
	<?php
		foreach($filas as $fila) {
	?>

<div style="width:70%;">
<article class="articulo" id="<?php echo "articulo" .$fila['IDARTICULO'] ?>">
	<form method="post" action="controladorArticulos.php">
		<div class="filaArticulo">
			<div class="datosArticulo">
				<input id="IDARTICULO" name="IDARTICULO"
					type="hidden" value="<?php echo $fila["IDARTICULO"]; ?>"/>
				<input id="NOMBREARTICULO" name="NOMBREARTICULO"
					type="hidden" value="<?php echo $fila["NOMBREARTICULO"]; ?>"/>
				<input id="NOMBREUSUARIO" name="NOMBREUSUARIO"
					type="hidden" value="<?php echo $fila["NOMBREUSUARIO"]; ?>"/>
				<input id="FECHAARTICULO" name="FECHAARTICULO"
					type="hidden" value="<?php echo $fila["FECHAARTICULO"]; ?>"/>
				<input id="CONTENIDOARTICULO" name="CONTENIDOARTICULO"
					type="hidden" value="<?php $fila["CONTENIDOARTICULO"]; ?>"/>

				<?php if (isset($articulo) and ($articulo["IDARTICULO"] == $fila["IDARTICULO"])) { ?>
						<!-- Editando título -->
						<div class="Info">
							<em><input id="NOMBREARTICULO" name="NOMBREARTICULO" type="text" value="<?php echo  $fila["NOMBREARTICULO"];?>"/></em>
							<b><?php echo  ", de " . $fila["NOMBREUSUARIO"] . ", el ". $fila["FECHAARTICULO"]; ?></b>
						</div>
						<div id="<?php echo $fila['IDARTICULO'] ?>" style="display:none" name="Contenido">Contenido: <?php echo  $fila['CONTENIDOARTICULO'];?></div>
				<?php }	else { ?>
						<!-- mostrando título -->
						<div class="Info">
							<b><?php echo $fila["NOMBREARTICULO"] . ", de " . $fila["NOMBREUSUARIO"] . ", el ". $fila["FECHAARTICULO"]; ?></b>
						</div>
						<div>
							<label onclick="funcionVer(<?php echo $fila['IDARTICULO'] ?>)">Mostrar/Ocultar Artículo</label>
						</div>						
						<div id="<?php echo $fila['IDARTICULO'] ?>" id="CONTENIDOARTICULO" style="display:none" name="Contenido">Contenido: <?php echo  $fila['CONTENIDOARTICULO'];?></div>
				<?php } ?>
			</div>
			<?php if ((consultarTipoUsuario($conexion, $_SESSION['login'])) == 1) { ?>				
			<div id="botones_fila">
				<?php if (isset($articulo) and ($articulo["IDARTICULO"] == $fila["IDARTICULO"])) { ?>
					<button id="grabar" name="grabar" type="submit" class="editar_fila">
						<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación" onclick="return confirm('¿Está seguro de modificar?');">
					</button>
				<?php } else { ?>
					<button id="editar" name="editar" type="submit" class="editar_fila" >
						<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar articulo">
					</button>
				<?php } ?>
					<button id="borrar" name="borrar" type="submit" class="editar_fila" onclick="return confirm('¿Está seguro de eliminar?');">
						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar articulo"  >
					</button>
			</div>
			<?php } ?>
		</div>
	</form>
</article>
</div>
	<?php } ?>

</main>
</body>
</html>