<?php 

 session_start(); 
  
 if (isset($_SESSION["articulo"])) {
  $modificarArticulo = $_SESSION["articulo"];
  unset($_SESSION["articulo"]);

  require_once("gestionBD.php");
  require_once("gestionarArticulos.php");  

   
  
  try{ 
		$conexion = crearConexionBD(); 
		$errores = validarModificacion($conexion, $modificarArticulo);
		cerrarConexionBD($conexion);
	}catch(PDOException $e){
		// Mensaje de depuración
		$_SESSION["errores"] = "<p>ERROR en la validación: fallo en el acceso a la base de datos.</p><p>" . $e->getMessage() . "</p>";
		Header('Location: consultaArticulos.php');
	}


  	if (count($errores)>0) {
		$_SESSION["errores"] = $errores;
		Header('Location: consultaArticulos.php');
  	} else {
  		$conexion = crearConexionBD();
   		$excepcion = modificarArticulo($conexion, $modificarArticulo["IDARTICULO"], $modificarArticulo["NOMBREARTICULO"], $modificarArticulo["CONTENIDOARTICULO"]);
   		cerrarConexionBD($conexion);
	} if ($excepcion<>"") {
   		$_SESSION["excepcion"] = $excepcion;
   		$_SESSION["destino"] = "consultaArticulos.php";
   		Header("Location: excepcion.php");
  	} else
   		Header("Location: consultaArticulos.php");
 	} 
 else Header("Location: consultaArticulos.php"); // Se ha tratado de acceder directamente a este PHP
 function validarModificacion($conexion, $modificarArticulo){
            $errores=array();
            // Validación del NIF
            if($modificarArticulo["CONTENIDOARTICULO"]=="" && $modificarArticulo["NOMBREARTICULO"]=="")  {
                $errores[] = "<p>No puede estar vacío</p>";
            }
    return $errores;
    }
?>