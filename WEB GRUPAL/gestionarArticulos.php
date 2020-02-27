<?php
     
function consultaArticulos($conexion) {
	$consulta = "SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario";
    return $conexion->query($consulta);
}
	
function eliminarArticulo($conexion,$articulo) {
    try {
        $stmt=$conexion->prepare('CALL eliminarArticulo(:IDARTICULO)');
        $stmt->bindParam(':IDARTICULO',$articulo);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function modificarArticulo($conexion,$IDARTICULO, $NOMBREARTICULO, $CONTENIDOARTICULO) {
    try {
        $stmt=$conexion->prepare('CALL modificarArticulo(:IDARTICULO,:NOMBREARTICULO,:CONTENIDOARTICULO)');
        $stmt->bindParam(':IDARTICULO',$IDARTICULO);
        $stmt->bindParam(':NOMBREARTICULO',$NOMBREARTICULO);
        $stmt->bindParam(':CONTENIDOARTICULO',$CONTENIDOARTICULO);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

?>