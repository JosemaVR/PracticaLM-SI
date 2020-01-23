-- BORRAR TODAS LAS TABLAS

DROP TABLE tiposUsuario CASCADE CONSTRAINTS;
DROP TABLE usuarios CASCADE CONSTRAINTS;
DROP TABLE articulos CASCADE CONSTRAINTS;
DROP TABLE fotos CASCADE CONSTRAINTS;
DROP TABLE revisiones CASCADE CONSTRAINTS;
DROP TABLE publicaciones CASCADE CONSTRAINTS;
DROP TABLE esRevisado CASCADE CONSTRAINTS;
DROP TABLE esPublicado CASCADE CONSTRAINTS;

-- CREACION DE TODAS LAS TABLAS

CREATE TABLE tiposUsuario (
    idTipoUsuario INT NOT NULL CONSTRAINT tipoUsuario_pk PRIMARY KEY,
    nombreTipoUsuario VARCHAR(50) NOT NULL
);

CREATE TABLE usuarios (
	idUsuario INT NOT NULL CONSTRAINT usuario_pk PRIMARY KEY,
	nombreUsuario VARCHAR(50) NOT NULL,
	passUsuario VARCHAR(50) NOT NULL,
    idTipoUsuarioFK INT NOT NULL,
    CONSTRAINT tipoUsuarioFK FOREIGN KEY (idTipoUsuarioFK) REFERENCES TIPOSUSUARIO(idTipoUsuario)
);
/

CREATE TABLE articulos (
	idArticulo INT NOT NULL CONSTRAINT articulo_pk PRIMARY KEY,
	nombreArticulo VARCHAR(50) NOT NULL,
	contenidoArticulo VARCHAR(100) NOT NULL,
	fechaArticulo DATE,
	idUsuarioFK INT NOT NULL,
	CONSTRAINT articuloUsuarioFK FOREIGN KEY (idUsuarioFK) REFERENCES USUARIOS(idUsuario)
);
/

CREATE TABLE fotos (
	idFoto INT NOT NULL CONSTRAINT foto_pk PRIMARY KEY,
	nombreFoto VARCHAR(50),
	idArticuloFK INT,
    rutaFoto VARCHAR(150) NOT NULL,
	CONSTRAINT fotoArticuloFK FOREIGN KEY (idArticuloFK) REFERENCES ARTICULOS(idArticulo)
);

CREATE TABLE publicaciones (
    idPublicacion INT NOT NULL CONSTRAINT publicacionPK PRIMARY KEY,
    fechaPublicacion DATE NOT NULL,
    idArticuloFK INT NOT NULL,
    CONSTRAINT publicacionArticuloFK FOREIGN KEY (idArticuloFK) REFERENCES ARTICULOS(idArticulo)
);

-- BORRAR TODAS LAS SECUENCIAS

drop SEQUENCE secTiposUsuario;
drop SEQUENCE secUsuarios;
drop SEQUENCE secArticulos;
drop SEQUENCE secFotos;
drop SEQUENCE secPublicaciones;
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

CREATE SEQUENCE secFotos;

CREATE OR REPLACE TRIGGER creaIdFotos
BEFORE INSERT ON fotos
FOR EACH ROW
BEGIN
  SELECT secFotos.nextval INTO :NEW.idFoto from DUAL;
END;

/

CREATE SEQUENCE secPublicaciones;

CREATE OR REPLACE TRIGGER creaIdPublicacion
BEFORE INSERT ON publicaciones
FOR EACH ROW
BEGIN
  SELECT secPublicaciones.nextval INTO :NEW.idPublicacion from DUAL;
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

insert into usuarios values (null, 'admin', '12345', 1);
insert into usuarios values (null, 'admin2', '12345', 2);

insert into articulos values (null, 'Articulo de prueba', 'Probando que conecta con la base de datos y se ve correcto', TO_DATE('17/12/2015', 'DD/MM/YYYY'), 1);
insert into articulos values (null, 'Articulo de prueba 2', 'Probando de nuevo que conecta con la base de datos y se ve correcto', TO_DATE('18/11/2016', 'DD/MM/YYYY'), 2);

insert into publicaciones values (null, TO_DATE('17/12/2015', 'DD/MM/YYYY'), 1);
insert into publicaciones values (null, TO_DATE('14/02/2014', 'DD/MM/YYYY'), 2);

SELECT * FROM ARTICULOS, PUBLICACIONES, USUARIOS where ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and PUBLICACIONES.idArticuloFK=ARTICULOS.idArticulo;