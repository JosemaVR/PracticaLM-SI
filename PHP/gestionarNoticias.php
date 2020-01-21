<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */

function consultarNoticias($conexion) {
    $consulta = "select * from articulos a, esPublicado e, esRevisado k, publicaciones p, revisiones r, usuarios u where a.idArticulo=k.idArticuloFK and p.idPublicacion=e.idPublicacionFK and p.idRevisionFK=r.idRevision and a.idUsuario=r.idUsuarioFK order by a.fechaArticulo";   
        return $conexion->query($consulta);
}

?>