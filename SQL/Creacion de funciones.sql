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
END eliminarArticulo;
/
CREATE OR REPLACE PROCEDURE modificarArticulo
    (w_IdArticulo IN ARTICULOS.IDARTICULO%TYPE,
    w_nombreArticulo IN ARTICULOS.NOMBREARTICULO%TYPE)
    IS
BEGIN
    UPDATE ARTICULOS SET NOMBREARTICULO = w_nombreArticulo WHERE w_IdArticulo = IDARTICULO;
COMMIT WORK;
END modificarArticulo;
/
CREATE OR REPLACE PROCEDURE insertarUsuario
    (w_nombreUsuario IN USUARIOS.NOMBREUSUARIO%TYPE,
    w_passUsuario IN USUARIOS.PASSUSUARIO%TYPE,
    w_idTipo IN USUARIOS.IDTIPOUSUARIOFK%TYPE,
    w_dniPersona IN PERSONAS.DNIPERSONA%TYPE,
    w_nombrePersona IN PERSONAS.NOMBREPERSONA%TYPE,
    w_apellido1Persona IN PERSONAS.APELLIDO1PERSONA%TYPE,
    w_apellido2Persona IN PERSONAS.APELLIDO2PERSONA%TYPE,
    w_correoPersona IN PERSONAS.CORREOPERSONA%TYPE)
    IS
    w_idPersona PERSONAS.IDPERSONA%TYPE;
BEGIN
    INSERT INTO PERSONAS values (null, w_dniPersona, w_nombrePersona, w_apellido1Persona, w_apellido2Persona, w_correoPersona);
    SELECT IDPERSONA INTO w_idPersona FROM PERSONAS WHERE DNIPERSONA = w_dniPersona;
    INSERT INTO USUARIOS VALUES (null, w_nombreUsuario, w_passUsuario, w_idTipo, w_idPersona);
COMMIT WORK;
END insertarUsuario;
/
CREATE OR REPLACE PROCEDURE modificarUsuario
    (w_IdUsuario IN USUARIOS.IDUSUARIO%TYPE,
    w_idTipo IN USUARIOS.IDTIPOUSUARIOFK%TYPE)
    IS
BEGIN
    UPDATE USUARIOS SET IDTIPOUSUARIOFK = w_idTipo WHERE w_IdUsuario = IDUSUARIO;
COMMIT WORK;
END modificarUsuario;
/
CREATE OR REPLACE PROCEDURE eliminarUsuario
    (w_IdUsuario IN USUARIOS.IDUSUARIO%TYPE)
    IS
    w_idPersona PERSONAS.IDPERSONA%TYPE;
BEGIN
    DELETE FROM ARTICULOS WHERE w_idUsuario = IDUSUARIOFK;
    SELECT IDPERSONAFK INTO w_idPersona FROM USUARIOS WHERE IDUSUARIO = w_idUsuario;
    DELETE FROM USUARIOS WHERE w_IdUsuario = IDUSUARIO;
    DELETE FROM PERSONAS WHERE w_idPersona = IDPERSONA;
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

SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and 
USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

SELECT count(*) FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and 
USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

CALL eliminarArticulo(3);

SELECT count(*) FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and 
USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

EXECUTE insertarUsuario('Pepe', 'contraseña', 3, '30220057A', 'Pepe', 'Mari', '2', 'pepe@mari.com');

SELECT * FROM USUARIOS;

SELECT count(*) FROM USUARIOS;

CALL eliminarUsuario(3);

SELECT count(*) FROM USUARIOS;
/

SELECT IDTIPOUSUARIO FROM TIPOSUSUARIO WHERE NOMBRETIPOUSUARIO = 'Invitado';