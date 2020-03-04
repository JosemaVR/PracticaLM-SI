-- BORRAR TODAS LAS TABLAS
DROP TABLE tiposUsuario CASCADE CONSTRAINTS;
DROP TABLE personas CASCADE CONSTRAINTS;
DROP TABLE usuarios CASCADE CONSTRAINTS;
DROP TABLE articulos CASCADE CONSTRAINTS;

-- CREACION DE TODAS LAS TABLAS
CREATE TABLE tiposUsuario (
    idTipoUsuario INT NOT NULL CONSTRAINT tipoUsuario_pk PRIMARY KEY,
    nombreTipoUsuario VARCHAR(50) NOT NULL
);
/
CREATE TABLE personas (
	idPersona INT NOT NULL CONSTRAINT persona_pk PRIMARY KEY,
	dniPersona VARCHAR(9) NOT NULL,
	nombrePersona VARCHAR(50) NOT NULL,
    apellido1Persona VARCHAR(50) NOT NULL,
    apellido2Persona VARCHAR(50),
    correoPersona varchar(100) NOT NULL
);
/
CREATE TABLE usuarios (
	idUsuario INT NOT NULL CONSTRAINT usuario_pk PRIMARY KEY,
	nombreUsuario VARCHAR(50) NOT NULL,
	passUsuario VARCHAR(260) NOT NULL,
    idTipoUsuarioFK INT NOT NULL,
    idPersonaFK INT NOT NULL,
    CONSTRAINT idPersonaFK FOREIGN KEY (idPersonaFK) REFERENCES PERSONAS (idPersona),
    CONSTRAINT tipoUsuarioFK FOREIGN KEY (idTipoUsuarioFK) REFERENCES TIPOSUSUARIO(idTipoUsuario)
);
/

CREATE TABLE articulos (
	idArticulo INT NOT NULL CONSTRAINT articulo_pk PRIMARY KEY,
	nombreArticulo VARCHAR(50) NOT NULL,
	contenidoArticulo VARCHAR(4000) NOT NULL,
	fechaArticulo DATE,
	idUsuarioFK INT NOT NULL,
	CONSTRAINT articuloUsuarioFK FOREIGN KEY (idUsuarioFK) REFERENCES USUARIOS(idUsuario)
);
/

-- BORRAR TODAS LAS SECUENCIAS
drop SEQUENCE secTiposUsuario;
drop SEQUENCE secUsuarios;
drop SEQUENCE secArticulos;
drop SEQUENCE secPersonas;

-- CREACION DE SECUENCIAS
CREATE SEQUENCE secTiposUsuario;

CREATE OR REPLACE TRIGGER creaIdTipoUsuario
BEFORE INSERT ON tiposUsuario
FOR EACH ROW
BEGIN
  SELECT secTiposUsuario.nextval INTO :NEW.idTipoUsuario from DUAL;
END;
/
CREATE SEQUENCE secUsuarios;

CREATE OR REPLACE TRIGGER creaIdUsuario
BEFORE INSERT ON usuarios
FOR EACH ROW
BEGIN
  SELECT secUsuarios.nextval INTO :NEW.idUsuario from DUAL;
END;
/
CREATE SEQUENCE secArticulos;

CREATE OR REPLACE TRIGGER creaIdArticulos
BEFORE INSERT ON articulos
FOR EACH ROW
BEGIN
  SELECT secArticulos.nextval INTO :NEW.idArticulo from DUAL;
END;
/

CREATE SEQUENCE secPersonas;

CREATE OR REPLACE TRIGGER creaIdPersonas
BEFORE INSERT ON personas
FOR EACH ROW
BEGIN
  SELECT secPersonas.nextval INTO :NEW.idPersona from DUAL;
END;
/
-- TRIGGER PARA IDs
CREATE OR REPLACE
FUNCTION ASSERT_EQUALS (salida BOOLEAN, salida_esperada BOOLEAN) RETURN VARCHAR2 AS
BEGIN
  IF (salida = salida_esperada) THEN
    RETURN 'EXITO';
  ELSE
    RETURN 'FALLO';
  END IF;

END ASSERT_EQUALS;
/

-- CREACION DE USUARIO ADMINISTRADOR INICIAL
insert into tiposUsuario values (null, 'Administrador');
insert into tiposUsuario values (null, 'Colaborador');
insert into tiposUsuario values (null, 'Invitado');

insert into personas values (null, '30220056B', 'José', 'Villalón', 'Rivero', 'josevillalon93@gmail.com');
insert into personas values (null, '12345678A', 'PruebaNombre', 'PruebaApellido1', 'PruebaApellido2', 'prueba@prueba.com');

insert into usuarios values (null, 'admin', '12345', 1, 1);
insert into usuarios values (null, 'admin2', '12345', 2, 2);

insert into articulos values (null, 'Articulo de prueba', 'Probando que conecta con la base de datos y se ve correcto 
<br><img border="0" src="https://disenowebakus.net/imagenes/imagenes-varios/enlace-texto.jpg" width="200" height="200"><br> 
Y continua el texto', TO_DATE('17/12/2015', 'DD/MM/YYYY'), 1);

insert into articulos values (null, 'Articulo de prueba 2', 'Probando que muestra los enlaces: <a href="http://marca.com" 
target="_blank">marca.com</a>', TO_DATE('18/11/2016', 'DD/MM/YYYY'), 2);

SELECT * FROM ARTICULOS, USUARIOS, TIPOSUSUARIO where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and 
USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;