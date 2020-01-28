<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
     
function consultaArticulos($conexion) {
	$consulta = "SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario";
    return $conexion->query($consulta);
}
	
function quitarArticulo($conexion,$IdArticulo) {
    try {
        $stmt=$conexion->prepare('CALL eliminarArticulo(:IDARTICULO)');
        $stmt->bindParam(':IDARTICULO',$IdArticulo);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

?>