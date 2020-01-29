-- BORRAR TODAS LAS TABLAS

DROP TABLE tiposUsuario CASCADE CONSTRAINTS;
DROP TABLE usuarios CASCADE CONSTRAINTS;
DROP TABLE articulos CASCADE CONSTRAINTS;
DROP TABLE personas CASCADE CONSTRAINTS;

-- CREACION DE TODAS LAS TABLAS

CREATE TABLE tiposUsuario (
    idTipoUsuario INT NOT NULL CONSTRAINT tipoUsuario_pk PRIMARY KEY,
    nombreTipoUsuario VARCHAR(50) NOT NULL
);

CREATE TABLE personas (
    dniPersona VARCHAR(9) NOT NULL CONSTRAINT persona_pk PRIMARY KEY,
    nombrePersona VARCHAR(50) NOT NULL,
    apellido1Persona VARCHAR(50) NOT NULL,
    apellido2Persona VARCHAR(50) NOT NULL,
    correoPersona VARCHAR(150) NOT NULL
);
/

CREATE TABLE usuarios (
	idUsuario INT NOT NULL CONSTRAINT usuario_pk PRIMARY KEY,
	nombreUsuario VARCHAR(50) NOT NULL,
	passUsuario VARCHAR(50) NOT NULL,
    idTipoUsuarioFK INT NOT NULL,
    dniPersonaFK VARCHAR(9) NOT NULL,
    CONSTRAINT tipoUsuarioFK FOREIGN KEY (idTipoUsuarioFK) REFERENCES TIPOSUSUARIO(idTipoUsuario),
    CONSTRAINT personaFK FOREIGN KEY (dniPersonaFK) REFERENCES PERSONAS(dniPersona)
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

insert into tiposUsuario values (null, 'Administrador Jefe');
insert into tiposUsuario values (null, 'Administrador');
insert into tiposUsuario values (null, 'Colaborador');
insert into tiposUsuario values (null, 'Registrado');

insert into personas values ('30220056B', 'José María', 'Villalón', 'Rivero', 'josevillalon93@gmail.com');

insert into usuarios values (null, 'admin', '12345', 1, '30220056B');

insert into articulos values (null, 'Articulo de prueba', 'Probando que conecta con la base de datos y se ve correcto <img border=0 src=https://disenowebakus.net/imagenes/imagenes-varios/enlace-texto.jpg width=200 height=200>Y continua el texto', TO_DATE('17/12/2015', 'DD/MM/YYYY'), 1);
insert into articulos values (null, 'Articulo de prueba 2', 'Probando que muestra los enlaces: <a href=http://marca.com target=_blank>marca.com</a>', TO_DATE('18/11/2016', 'DD/MM/YYYY'), 1);

SELECT count(*) FROM ARTICULOS, USUARIOS, TIPOSUSUARIO, PERSONAS where PERSONAS.dniPersona=USUARIOS.dniPersonaFK AND ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;