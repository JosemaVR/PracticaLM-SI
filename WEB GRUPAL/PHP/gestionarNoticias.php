<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */
     
function consultaArticulos($conexion) {
	$consulta = "SELECT * FROM ARTICULOS A, PUBLICACIONES P, USUARIOS U where (A.idUsuarioFK=U.idUsuario and P.idArticuloFK=A.idArticulo) ORDER BY P.FECHAPUBLICACION";
    return $conexion->query($consulta);
}
	
?>