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
DROP PROCEDURE modificarArticulo;
CREATE OR REPLACE PROCEDURE modificarArticulo
    (w_idArticulo IN ARTICULOS.IDARTICULO%TYPE,
    w_nombreArticulo IN ARTICULOS.NOMBREARTICULO%TYPE,
    w_contenidoArticulo IN ARTICULOS.CONTENIDOARTICULO%TYPE)
    IS
    articulo int;
    contenido int;
BEGIN
    SELECT COUNT(*) INTO articulo FROM ARTICULOS WHERE w_nombreArticulo=NOMBREARTICULO and idArticulo!=w_idArticulo;
    SELECT COUNT(*) INTO contenido FROM ARTICULOS WHERE w_contenidoArticulo=CONTENIDOARTICULO and idArticulo!=w_idArticulo;
    
    IF (articulo>0 or contenido>0)
        THEN raise_application_error (-20600, w_nombreArticulo||'. El titulo o el contenido no puede ser repetido.');
    END IF;      
    IF (articulo<1 and contenido<1) THEN
        UPDATE ARTICULOS SET nombreArticulo=w_nombreArticulo WHERE IDARTICULO=w_idArticulo;
        UPDATE ARTICULOS SET CONTENIDOARTICULO=w_contenidoArticulo WHERE IDARTICULO=w_idArticulo;
    END IF;
    
COMMIT WORK;
END modificarArticulo;
/

CREATE OR REPLACE PROCEDURE eliminarArticulo
    (w_IdArticulo IN ARTICULOS.IDARTICULO%TYPE)
    IS
BEGIN
    DELETE FROM ARTICULOS WHERE w_IdArticulo = IDARTICULO;
COMMIT WORK;
END eliminarArticulo;
/
DROP PROCEDURE insertarUsuario;
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
    INSERT INTO PERSONAS (IDPERSONA, DNIPERSONA, NOMBREPERSONA, APELLIDO1PERSONA, APELLIDO2PERSONA, CORREOPERSONA) 
    values (null, w_dniPersona, w_nombrePersona, w_apellido1Persona, w_apellido2Persona, w_correoPersona);
    SELECT idPersona INTO w_idPersona FROM PERSONAS WHERE w_dniPersona = dniPersona;
    INSERT INTO USUARIOS (IDUSUARIO, NOMBREUSUARIO, PASSUSUARIO, IDTIPOUSUARIOFK, IDPERSONAFK) 
    VALUES (null, w_nombreUsuario, w_passUsuario, w_idTipo, w_idPersona);
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

EXECUTE insertarArticulo('Es una prueba', 'Probando que funcionan las funciones', 1);

SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

SELECT count(*) FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

CALL eliminarArticulo(3);

SELECT count(*) FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;

call insertarUsuario('Pepe', 'contraseña', 3, '30220055B', 'José', 'Villalón', 'Rivero', 'josevillalon95@gmail.com');

SELECT * FROM USUARIOS;

SELECT count(*) FROM USUARIOS;

CALL eliminarUsuario(3);

SELECT count(*) FROM USUARIOS;

EXECUTE modificarArticulo(1, 'Modificando nombre', 'Modificando contenido 2');
EXECUTE modificarArticulo(2, 'Modificando nombre', 'Modificando contenido 3');

select nombreArticulo, contenidoArticulo from articulos;
/