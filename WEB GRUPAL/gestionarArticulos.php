<?php
require_once("gestionarUsuarios.php");

function consultaArticulos($conexion) {
    $consulta = "SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario order by ARTICULOS.FECHAARTICULO DESC";
    return $conexion->query($consulta);
}

function verArticulo($conexion, $idArticulo) {
    $consulta = "SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario and ARTICULOS.idArticulo = $idArticulo order by ARTICULOS.FECHAARTICULO DESC";
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

function modificarArticulo($conexion,$IDARTICULO, $NOMBREARTICULO) {
    try {
        $stmt=$conexion->prepare('CALL modificarArticulo(:IDARTICULO,:NOMBREARTICULO)');
        $stmt->bindParam(':IDARTICULO',$IDARTICULO);
        $stmt->bindParam(':NOMBREARTICULO',$NOMBREARTICULO);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function insertarArticulo($conexion,$articulo) {
    $idAutor = consultarIdUsuario($conexion, $_SESSION['login']);
    try {
        $consulta = "CALL insertarArticulo(:NOMBREARTICULO,:CONTENIDOARTICULO,:IDAUTOR)";
        $stmt=$conexion->prepare($consulta);
        $stmt->bindParam(':IDAUTOR',$idAutor);       
        $stmt->bindParam(':NOMBREARTICULO',$articulo["NOMBREARTICULO"]);
        $stmt->bindParam(':CONTENIDOARTICULO',$articulo["CONTENIDOARTICULO"]);

        $stmt->execute();
    } catch(PDOException $e) {
        return $e->getMessage();
        // Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}

?>