<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
function altaArticulo($conexion,$articulo) {
    $tipo = implode('', $articulo["IDTIPOUSUARIO"]);
    try {
        $consulta = "CALL InsertarArticulos(:NOMBREARTICULO, :CONTENIDOARTICULO, :IDUSUARIOFK)";
        $stmt=$conexion->prepare($consulta);
        $stmt->bindParam(':NOMBREARTICULO',$usuario["NOMBREARTICULO"]);
		$stmt->bindParam(':CONTENIDOARTICULO',$usuario["CONTENIDOARTICULO"]);
        $stmt->bindParam(':IDUSUARIOFK',$tipo);        

        $stmt->execute();
    } catch(PDOException $e) {
        return $e->getMessage();
        
    }
}
	 
     
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