<?php
  /*
     * #===========================================================#
     * #    Este fichero contiene las funciones de gestión
     * #    de usuarios de la capa de acceso a datos
     * #==========================================================#
     */

    function consultarUsuario($conexion,$email) {
    $consulta = 'SELECT passUsuario FROM USUARIOS WHERE NOMBREUSUARIO = :email';
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':email',$email);
    $stmt->execute();
    return $stmt->fetchColumn();
}

?>