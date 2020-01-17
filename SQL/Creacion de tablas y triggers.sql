-- BORRAR TODAS LAS TABLAS

DROP TABLE usuarios CASCADE CONSTRAINTS;
DROP TABLE articulos CASCADE CONSTRAINTS;
DROP TABLE fotos CASCADE CONSTRAINTS;
DROP TABLE revisiones CASCADE CONSTRAINTS;
DROP TABLE publicaciones CASCADE CONSTRAINTS;
DROP TABLE esRevisado CASCADE CONSTRAINTS;
DROP TABLE esPublicado CASCADE CONSTRAINTS;

-- CREACION DE TODAS LAS TABLAS

CREATE TABLE usuarios (
	idUsuario INT NOT NULL CONSTRAINT usuario_pk PRIMARY KEY,
	nombreUsuario VARCHAR(50) NOT NULL,
	passUsuario VARCHAR(50) NOT NULL
);
/

CREATE TABLE articulos (
	idArticulo INT NOT NULL CONSTRAINT articulo_pk PRIMARY KEY,
	nombreArticulo VARCHAR(50) NOT NULL,
	contenidoArticulo VARCHAR(1000) NOT NULL,
	fechaArticulo DATE,
	idUsuario INT NOT NULL,
	CONSTRAINT articuloUsuarioFK FOREIGN KEY (idUsuario) REFERENCES USUARIOS(idUsuario)
);
/

CREATE TABLE fotos (
	idFoto INT NOT NULL CONSTRAINT foto_pk PRIMARY KEY,
	nombreFoto VARCHAR(50),
	idArticuloFK INT,
    rutaFoto VARCHAR(150) NOT NULL,
	CONSTRAINT fotoArticuloFK FOREIGN KEY (idArticuloFK) REFERENCES ARTICULOS(idArticulo)
);

CREATE TABLE revisiones (
    idRevision INT NOT NULL CONSTRAINT revisionPK PRIMARY KEY,
    fechaRevision DATE NOT NULL,
    estadoRevision INT DEFAULT '0' NOT NULL,
    comentarioRevision VARCHAR(500),
    idUsuarioFK INT NOT NULL,
    CONSTRAINT revisionUuarioFK FOREIGN KEY (idUsuarioFK) REFERENCES USUARIOS(idUsuario)
);

CREATE TABLE publicaciones (
    idPublicacion INT NOT NULL CONSTRAINT publicacionPK PRIMARY KEY,
    fechaPublicacion DATE NOT NULL,
    idRevisionFK INT NOT NULL,
    CONSTRAINT publicacionRevisionFK FOREIGN KEY (idRevisionFK) REFERENCES REVISIONES(idRevision)
);

CREATE TABLE esRevisado (
    idEsRevisado INT NOT NULL CONSTRAINT esRevisadoPK PRIMARY KEY,
    idArticuloFK INT NOT NULL,
    idRevisionFK INT NOT NULL,
    CONSTRAINT esRevisadoArticuloFK FOREIGN KEY (idArticuloFK) REFERENCES ARTICULOS(idArticulo),
    CONSTRAINT esRevisadoRevisionFK FOREIGN KEY (idRevisionFK) REFERENCES REVISIONES(idRevision)
);

CREATE TABLE esPublicado (
    idEsPublicado INT NOT NULL CONSTRAINT esPublicadoPK PRIMARY KEY,
    idPublicacionFK INT NOT NULL,
    idRevisionFK INT NOT NULL,
    CONSTRAINT esRevisadoPublicacionFK FOREIGN KEY (idPublicacionFK) REFERENCES PUBLICACIONES(idPublicacion),
    CONSTRAINT esRevisadoRevisionFK2 FOREIGN KEY (idRevisionFK) REFERENCES REVISIONES(idRevision)
);

-- BORRAR TODAS LAS SECUENCIAS

drop SEQUENCE secUsuarios;
drop SEQUENCE secArticulos;
drop SEQUENCE secFotos;
drop SEQUENCE secRevisiones;
drop SEQUENCE secPublicaciones;
drop SEQUENCE secEsRevisado;
drop SEQUENCE secEsPublicado;
-- CREACION DE SECUENCIAS

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

CREATE SEQUENCE secRevisiones;

CREATE OR REPLACE TRIGGER creaIdRevision
BEFORE INSERT ON revisiones
FOR EACH ROW
BEGIN
  SELECT secRevisiones.nextval INTO :NEW.idRevision from DUAL;
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

CREATE SEQUENCE secEsRevisado;

CREATE OR REPLACE TRIGGER creaIdEsRevisado
BEFORE INSERT ON esRevisado
FOR EACH ROW
BEGIN
  SELECT secEsRevisado.nextval INTO :NEW.idEsRevisado from DUAL;
END;
/

CREATE SEQUENCE secEsPublicado;

CREATE OR REPLACE TRIGGER creaIdEsPublciado
BEFORE INSERT ON esPublicado
FOR EACH ROW
BEGIN
  SELECT secEsPublicado.nextval INTO :NEW.idEsPublicado from DUAL;
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