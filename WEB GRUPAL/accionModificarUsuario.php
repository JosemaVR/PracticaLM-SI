<?php 
 session_start(); 
  
 if (isset($_SESSION["usuario"])) {
  $modificarUsuario = $_SESSION["usuario"];
  unset($_SESSION["usuario"]);

  require_once("gestionBD.php");
  require_once("gestionarUsuarios.php");  

  try{ 
    $conexion = crearConexionBD(); 
    $errores = validarModificacion($conexion, $modificarUsuario);
    cerrarConexionBD($conexion);
  }catch(PDOException $e){
    // Mensaje de depuración
    $_SESSION["errores"] = "<p>ERROR en la validación: fallo en el acceso a la base de datos.</p><p>" . $e->getMessage() . "</p>";
    Header('Location: consultaUsuarios.php');
  }

  if (count($errores)>0) {
    $_SESSION["errores"] = $errores;
    Header('Location: consultaUsuarios.php');
    } else {
      $conexion = crearConexionBD();
      $excepcion = modificarUsuario($conexion, $modificarUsuario["IDUSUARIO"], $modificarUsuario["IDTIPONUEVO"]);
      cerrarConexionBD($conexion);
  } if ($excepcion<>"") {
      $_SESSION["excepcion"] = $excepcion;
      $_SESSION["destino"] = "consultaUsuarios.php";
      Header("Location: excepcion.php");
    } else
      Header("Location: consultaUsuarios.php");
 } else Header("Location: consultaUsuarios.php"); // Se ha tratado de acceder directamente a este PHP
 
 function validarModificacion($conexion, $modificarUsuario){
            $errores=array();
            // Validación del NIF
            if($modificarUsuario["IDTIPONUEVO"]>3 or $modificarUsuario["IDTIPONUEVO"]<1)  {
                $errores[] = "<p>No puede estar vacío</p>";
            }
    return $errores;
    }
?>