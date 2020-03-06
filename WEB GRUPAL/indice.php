<html>
<body>
<?php	
	$filas2 = consultaArticulos($conexion);
	foreach($filas2 as $fila2) {
?>
<div style='float:right;width:20%;'>
	<ul>
		<li>
			<div id="<?php echo "articulo" . $fila2['idArticulo'] ?>" name="indice"><a href='<?php echo "#articulo" . $fila2["IDARTICULO"] ?>'><?php echo  $fila2['NOMBREARTICULO'];?></a>
			</div>
		</li>
	</ul>
</div>
<?php
	}
?>
</body>
</html>