<?php
	session_start();

	require_once("gestionBD.php");
	require_once("gestionarNoticias.php");
	
	if (isset($_SESSION["noticias"])){
		$libro = $_SESSION["noticias"];
		unset($_SESSION["noticias"]);
	}
	$conexion = crearConexionBD();
	$filas = consultaNoticias($conexion);
	cerrarConexionBD($conexion);

?>

<!DOCTYPE html>
<html lang="es">
<head>
                     
	<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

  <!-- Hay que indicar el fichero externo de estilos -->
    <link rel="stylesheet" type="text/css" href="css/biblio.css" />
	<script type="text/javascript" src="./js/boton.js"></script>
  <title>VIVENZiA Inmobiliaria</title>
</head>

<body>
     
<?php

include_once ("cabecera.php");

include_once ("menu.php");
?>

<main>

	<?php

		foreach($filas as $fila) {

	?>

	<article class="noticias" id="articlenoticias">

		<form method="post" action="controladorNoticias.php">

			<div class="fila_noticias">
					
				<div class="datos_noticias">

					<input id="idArticulo" name="idArticulo"

						type="hidden" value="<?php echo $fila["idArticulo"]; ?>"/>

					<input id="idPublicacion" name="idPublicacion"

						type="hidden" value="<?php echo $fila["idPublicacion"]; ?>"/>

					<input id="nombreArticulo" name="nombreArticulo"

						type="hidden" value="<?php echo $fila["nombreArticulo"]; ?>"/>

					<input id="contenidoArticulo" name="contenidoArticulo"

						type="hidden" value="<?php echo $fila["contenidoArticulo"]; ?>"/>

					<input id="fechaPublicacion" name="fechaPublicacion"

						type="hidden" value="<?php echo $fila["fechaPublicacion"]; ?>"/>

					<input id="nombreUsuario" name="nombreUsuario"

						type="hidden" value="<?php echo $fila["nombreUsuario"]; ?>"/>

					<input id="nombreArticulo" name="nombreArticulo" type="hidden" value=<?php echo $fila["nombreArticulo"]; ?>/>

						<div class="Info"><b><?php echo $fila["nombreArticulo"] . 
						" - " . $fila["contenidoArticulo"] . " - " . $fila["fechaPublicacion"] . 
						" - ". $fila["nombreUsuario"]; ?></b></div>
						
						<img width="350" height="500" src="images/<?php echo $fila["NOMBRE_TIPO"]?>.jpg">

				</div>

				

				<div id="botones_fila">

				<?php if (isset($noticias) and ($noticias["idArticulo"] == $fila["idArticulo"])) { ?>

						<button id="grabar" name="grabar" type="submit" class="editar_fila">

							<img src="images/bag_menuito.bmp" class="editar_fila" alt="Guardar modificación" onclick="return confirm('¿Está seguro de modificar?');">

						</button>

				<?php } else { ?>

						<button id="editar" name="editar" type="submit" class="editar_fila" >

							<img src="images/pencil_menuito.bmp" class="editar_fila" alt="Editar precio">

						</button>

				<?php } ?>

					<button id="borrar" name="borrar" type="submit" class="editar_fila">

						<img src="images/remove_menuito.bmp" class="editar_fila" alt="Borrar noticias"  onclick="return confirm('¿Está seguro de eliminar?');">

					</button>

				</div>

			</div>

		</form>

	</article>

	<?php } ?>

</main>

<?php

include_once ("pie.php");

?>

</body>

</html>