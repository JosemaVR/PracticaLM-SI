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

function idTipoUsuarioNuevo($conexion){
    try{
        $consulta = "SELECT IDTIPOUSUARIO FROM TIPOSUSUARIO WHERE NOMBRETIPOUSUARIO = 'Registrado'";
        $stmt = $conexion->query($consulta);
        return $stmt;
    }catch(PDOException $e) {
        return $e->getMessage();
    }
}

function altaUsuarioNuevo($conexion,$usuario) {
    $tipo = 3;
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

function consultarIdUsuario($conexion,$NOMBREUSUARIO) {
    $consulta = 'SELECT IDUSUARIO FROM USUARIOS WHERE NOMBREUSUARIO = :NOMBREUSUARIO';
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':NOMBREUSUARIO',$NOMBREUSUARIO);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function consultarTipoUsuario($conexion,$NOMBREUSUARIO) {
    $consulta = 'SELECT IDTIPOUSUARIOFK FROM USUARIOS WHERE NOMBREUSUARIO = :NOMBREUSUARIO';
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':NOMBREUSUARIO',$NOMBREUSUARIO);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function consultarNombreTipoUsuario($conexion,$NOMBREUSUARIO) {
    $consulta = 'SELECT NOMBRETIPOUSUARIO FROM TIPOSUSUARIO JOIN USUARIOS ON IDTIPOUSUARIOFK=IDTIPOUSUARIO WHERE NOMBREUSUARIO = :NOMBREUSUARIO';
    $stmt = $conexion->prepare($consulta);
    $stmt->bindParam(':NOMBREUSUARIO',$NOMBREUSUARIO);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function eliminarUsuario($conexion,$usuario) {
    try {
        $stmt=$conexion->prepare('CALL eliminarUsuario(:IDUSUARIO)');
        $stmt->bindParam(':IDUSUARIO',$usuario);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function modificarUsuario($conexion, $usuario, $idTipo) {
    try {
        $stmt=$conexion->prepare('CALL modificarUsuario(:IDUSUARIO,:IDTIPOUSUARIO)');
        $stmt->bindParam(':IDUSUARIO',$usuario);
        $stmt->bindParam(':IDTIPOUSUARIO',$idTipo);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

?>