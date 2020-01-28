-- Funciones para la pagina web–-

CREATE OR REPLACE PROCEDURE insertarArticulo
    (w_tituloArticulo IN ARTICULOS.NOMBREARTICULO%TYPE,
    w_contenidoArticulo IN ARTICULOS.CONTENIDOARTICULO%TYPE,
    w_idAutor IN ARTICULOS.IDUSUARIOFK%TYPE)
    IS
BEGIN
    INSERT INTO ARTICULOS (IDARTICULO, NOMBREARTICULO, CONTENIDOARTICULO, FECHAARTICULO, IDUSUARIOFK) 
    VALUES (null, w_tituloArticulo, w_contenidoArticulo, current_date, w_idAutor);
COMMIT WORK;
END insertarArticulo;
/

CREATE OR REPLACE PROCEDURE eliminarArticulo
    (w_IdArticulo IN ARTICULOS.IDARTICULO%TYPE)
    IS
BEGIN
    DELETE FROM ARTICULOS WHERE w_IdArticulo = IDARTICULO;
COMMIT WORK;
END;
/

CREATE OR REPLACE PROCEDURE modificarArticulo
    (w_IdArticulo IN ARTICULOS.IDARTICULO%TYPE)
    IS
BEGIN
    DELETE FROM ARTICULOS WHERE w_IdArticulo = IDARTICULO;
COMMIT WORK;
END eliminarArticulo;
/

CREATE OR REPLACE PROCEDURE insertarUsuario
    (w_nombreUsuario IN USUARIOS.NOMBREUSUARIO%TYPE,
    w_passUsuario IN USUARIOS.PASSUSUARIO%TYPE,
    w_idTipo IN USUARIOS.IDTIPOUSUARIOFK%TYPE)
    IS
BEGIN
    INSERT INTO USUARIOS (IDUSUARIO, NOMBREUSUARIO, PASSUSUARIO, IDTIPOUSUARIOFK) 
    VALUES (null, w_nombreUsuario, w_passUsuario, w_idTipo);
COMMIT WORK;
END insertarUsuario;
/

CREATE OR REPLACE PROCEDURE eliminarUsuario
    (w_IdUsuario IN USUARIOS.IDUSUARIO%TYPE)
    IS
BEGIN
    DELETE FROM USUARIOS WHERE w_IdUsuario = IDUSUARIO;
COMMIT WORK;
END eliminarUsuario;
/

SET SERVEROUTPUT ON;

/*    Prueba Requisito funcional nº05 'alta oferta' */

BEGIN
  DBMS_OUTPUT.PUT_LINE('Prueba nuevo articulo:');
END;
/
EXECUTE insertarArticulo('Es una pruba', 'Probando que funcionan las funciones', 1);

SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

SELECT count(*) FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

CALL eliminarArticulo(3);

SELECT count(*) FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

EXECUTE insertarUsuario('Pepe', 'contraseña', 3);

SELECT * FROM USUARIOS;

SELECT count(*) FROM USUARIOS;

CALL eliminarUsuario(3);

SELECT count(*) FROM USUARIOS;

/