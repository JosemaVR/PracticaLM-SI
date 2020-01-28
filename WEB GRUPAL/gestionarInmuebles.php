<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión     			 
     * #	de libros de la capa de acceso a datos 		
     * #==========================================================#
     */

function consultarInmueblesVenta($conexion) {
    $consulta = "SELECT O.OID_OFERTA, O.PRECIOMINIMO, O.OID_INMUEBLE, I.FECHACONTRUCCION, I.METROSCONSTRUIDOS, I.METROSUTILES, D.NOMBRE_CALLE, D.NUMERO, D.BLOQUE, D.PLANTA, D.CODIGOPOSTAL, Z.NOMBRE_ZONA, T.NOMBRE_VIA, K.NOMBRE_TIPO FROM OFERTAS O, INMUEBLES I, DIRECCIONES D, ZONAS Z, TIPOSDEVIA T, TIPOINMUEBLES K "
        . "WHERE (O.OID_INMUEBLE=I.OID_INMUEBLE AND I.OID_DIRECCION=D.OID_DIRECCION AND D.OID_ZONA=Z.OID_ZONA AND D.OID_TIPODEVIA=T.OID_TIPODEVIA AND K.OID_TIPOINMUEBLE=I.OID_TIPOINMUEBLE)"
        . " ORDER BY Z.OID_ZONA";   
        return $conexion->query($consulta);
}

function alta_oferta($conexion,$inmueble) {
    $fechaInmueble = date('d/m/Y', strtotime($inmueble["FECHACONSTRUCCION"]));
    $NOMBRE_VIA_PHP = implode('', $inmueble["NOMBRE_VIA"]);
    $NOMBRE_TIPO_PHP = implode('', $inmueble["NOMBRE_TIPO"]);
    $NOMBRE_ZONA_PHP = implode('', $inmueble["NOMBRE_ZONA"]);
    try {
        $consulta = "CALL insertar_inmueble(:DNI, :NOMBRE, :APELLIDO1, :APELLIDO2, :NUMERO_TELEFONO, :NOMBRE_ZONA, :NOMBRE_VIA, :NOMBRE_CALLE, :NUMERO, :BLOQUE, :PLANTA, :CODIGOPOSTAL, :NOMBRE_TIPO, :FECHACONSTRUCCION, :METROSCONSTRUIDOS, :METROSUTILES, :PRECIOMINIMO)";
        $stmt=$conexion->prepare($consulta);
        $stmt->bindParam(':DNI',$inmueble["DNI"]);
        $stmt->bindParam(':NOMBRE',$inmueble["NOMBRE"]);
        $stmt->bindParam(':APELLIDO1',$inmueble["APELLIDO1"]);
        $stmt->bindParam(':APELLIDO2',$inmueble["APELLIDO2"]);
        $stmt->bindParam(':NUMERO_TELEFONO',$inmueble["NUMERO_TELEFONO"]);
        $stmt->bindParam(':NOMBRE_ZONA',$NOMBRE_ZONA_PHP);
        $stmt->bindParam(':NOMBRE_VIA',$NOMBRE_VIA_PHP);
        $stmt->bindParam(':NOMBRE_CALLE',$inmueble["NOMBRE_CALLE"]);
        $stmt->bindParam(':NUMERO',$inmueble["NUMERO"]);
        $stmt->bindParam(':BLOQUE',$inmueble["BLOQUE"]);
        $stmt->bindParam(':PLANTA',$inmueble["PLANTA"]);
        $stmt->bindParam(':CODIGOPOSTAL',$inmueble["CODIGOPOSTAL"]);
        $stmt->bindParam(':NOMBRE_TIPO',$NOMBRE_TIPO_PHP);
        $stmt->bindParam(':FECHACONSTRUCCION',$fechaInmueble);
        $stmt->bindParam(':METROSCONSTRUIDOS',$inmueble["METROSCONSTRUIDOS"]);
        $stmt->bindParam(':METROSUTILES',$inmueble["METROSUTILES"]);
        $stmt->bindParam(':PRECIOMINIMO',$inmueble["PRECIOMINIMO"]);

        $stmt->execute();
    } catch(PDOException $e) {
        return $e->getMessage();
        // Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}

function alta_solo_oferta($conexion,$inmueble) {
    $fechaInmueble = date('d/m/Y', strtotime($inmueble["FECHACONSTRUCCION"]));
    $NOMBRE_VIA_PHP = implode('', $inmueble["NOMBRE_VIA"]);
    $NOMBRE_TIPO_PHP = implode('', $inmueble["NOMBRE_TIPO"]);
    $NOMBRE_ZONA_PHP = implode('', $inmueble["NOMBRE_ZONA"]);
    $CLIENTE_PHP = implode('', $inmueble["OID_CLIENTE"]);
    try {
        $consulta = "CALL insertar_solo_inmueble(:OID_CLIENTE, :NOMBRE_ZONA, :NOMBRE_VIA, :NOMBRE_CALLE, :NUMERO, :BLOQUE, :PLANTA, :CODIGOPOSTAL, :NOMBRE_TIPO, :FECHACONSTRUCCION, :METROSCONSTRUIDOS, :METROSUTILES, :PRECIOMINIMO)";
        $stmt=$conexion->prepare($consulta);
        $stmt->bindParam(':OID_CLIENTE',$CLIENTE_PHP);
        $stmt->bindParam(':NOMBRE_ZONA',$NOMBRE_ZONA_PHP);
        $stmt->bindParam(':NOMBRE_VIA',$NOMBRE_VIA_PHP);
        $stmt->bindParam(':NOMBRE_CALLE',$inmueble["NOMBRE_CALLE"]);
        $stmt->bindParam(':NUMERO',$inmueble["NUMERO"]);
        $stmt->bindParam(':BLOQUE',$inmueble["BLOQUE"]);
        $stmt->bindParam(':PLANTA',$inmueble["PLANTA"]);
        $stmt->bindParam(':CODIGOPOSTAL',$inmueble["CODIGOPOSTAL"]);
        $stmt->bindParam(':NOMBRE_TIPO',$NOMBRE_TIPO_PHP);
        $stmt->bindParam(':FECHACONSTRUCCION',$fechaInmueble);
        $stmt->bindParam(':METROSCONSTRUIDOS',$inmueble["METROSCONSTRUIDOS"]);
        $stmt->bindParam(':METROSUTILES',$inmueble["METROSUTILES"]);
        $stmt->bindParam(':PRECIOMINIMO',$inmueble["PRECIOMINIMO"]);

        $stmt->execute();
    } catch(PDOException $e) {
        return $e->getMessage();
        // Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}

function quitar_inmueble($conexion,$OidInmueble) {
    try {
        $stmt=$conexion->prepare('CALL QUITAR_INMUEBLE(:OID_INMUEBLE)');
        $stmt->bindParam(':OID_INMUEBLE',$OidInmueble);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function modificar_precio($conexion,$OID_OFERTA,$PRECIOMINIMO) {
    try {
        $stmt=$conexion->prepare('CALL mod_precio_inmueble(:OID_OFERTA,:PRECIOMINIMO)');
        $stmt->bindParam(':OID_OFERTA',$OID_OFERTA);
        $stmt->bindParam(':PRECIOMINIMO',$PRECIOMINIMO);
        $stmt->execute();
        return "";
    } catch(PDOException $e) {
        return $e->getMessage();
    }
}

function inmueblesVenta($conexion, $oid_cliente) {
    try{
        $consulta = "SELECT count(OID_OFERTA) FROM OFERTAS WHERE OID_CLIENTE='$oid_cliente' AND OID_OFERTA!=' '";   
        $return = $conexion->query($consulta);
        $data = $return->fetch();
        return $data;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}

?>