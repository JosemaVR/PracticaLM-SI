<?php
function altaUsuario($conexion,$usuario) {
    $tipo = implode('', $usuario["IDTIPOUSUARIO"]);
    $hash = password_hash($usuario["PASSUSUARIO"], PASSWORD_DEFAULT);
    try {
        $consulta = "CALL insertarUsuario(:NOMBREUSUARIO, :PASSUSUARIO, :IDTIPOUSUARIO, :DNIPERSONA, :NOMBREPERSONA, :APELLIDO1PERSONA, :APELLIDO2PERSONA, :CORREOPERSONA)";
        $stmt=$conexion->prepare($consulta);
        $stmt->bindParam(':NOMBREUSUARIO',$usuario["NOMBREUSUARIO"]);
        $stmt->bindParam(':PASSUSUARIO',$hash);
        $stmt->bindParam(':IDTIPOUSUARIO',$tipo);        
        $stmt->bindParam(':DNIPERSONA',$usuario["DNIPERSONA"]);
        $stmt->bindParam(':NOMBREPERSONA',$usuario["NOMBREPERSONA"]);
        $stmt->bindParam(':APELLIDO1PERSONA',$usuario["APELLIDO1PERSONA"]);
        $stmt->bindParam(':APELLIDO2PERSONA',$usuario["APELLIDO2PERSONA"]);
        $stmt->bindParam(':CORREOPERSONA',$usuario["CORREOPERSONA"]);

        $stmt->execute();
    } catch(PDOException $e) {
        return $e->getMessage();
        // Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}
    
    function listarTipoUsuario($conexion){
    try{
        $consulta = "SELECT * FROM TIPOSUSUARIO";
        $stmt = $conexion->query($consulta);
        return $stmt;
    }catch(PDOException $e) {
        return $e->getMessage();
    }
}

    function listarUsuarios($conexion){
    try{
        $consulta = "SELECT * from usuarios, personas, tiposUsuario where idPersona = idPersonaFK and idTipoUsuario = idTipoUsuarioFK";
        $stmt = $conexion->query($consulta);
        return $stmt;
    }catch(PDOException $e) {
        return $e->getMessage();
    }
}

    function consultarUsuario($conexion,$NOMBREUSUARIO) {
    $consulta = 'SELECT PASSUSUARIO FROM USUARIOS WHERE NOMBREUSUARIO = :NOMBREUSUARIO';
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':NOMBREUSUARIO',$NOMBREUSUARIO);
    $stmt->execute();
    return $stmt->fetchColumn();
}

?>