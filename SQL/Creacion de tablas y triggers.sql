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
    idPersona INT NOT NULL CONSTRAINT persona_pk PRIMARY KEY,
    dniPersona VARCHAR(9),
    nombrePersona VARCHAR(50) NOT NULL,
    apellido1Persona VARCHAR(50) NOT NULL,
    apellido2Persona VARCHAR(50) NOT NULL,
    correoPersona VARCHAR(150) NOT NULL
);
/

CREATE TABLE usuarios (
	idUsuario INT NOT NULL CONSTRAINT usuario_pk PRIMARY KEY,
	nombreUsuario VARCHAR(50) NOT NULL,
	passUsuario VARCHAR(150) NOT NULL,
    idTipoUsuarioFK INT NOT NULL,
    idPersonaFK INT NOT NULL,
    CONSTRAINT tipoUsuarioFK FOREIGN KEY (idTipoUsuarioFK) REFERENCES TIPOSUSUARIO(idTipoUsuario),
    CONSTRAINT personaFK FOREIGN KEY (idPersonaFK) REFERENCES PERSONAS(idPersona)
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
drop SEQUENCE secPersonas;
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

CREATE SEQUENCE secPersonas;

CREATE OR REPLACE TRIGGER creaIdPersona
BEFORE INSERT ON personas
FOR EACH ROW
BEGIN
  SELECT secPersonas.nextval INTO :NEW.idPersona from DUAL;
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

-- CREACION DE TRIGGERS

CREATE OR REPLACE TRIGGER usuarioRepetido
	BEFORE INSERT ON USUARIOS
    FOR EACH ROW
    DECLARE
        nombreUser int;
        nombreUsuario varchar(50);
        passUsuario varchar(50);
	BEGIN
		SELECT count(*) INTO nombreUser FROM USUARIOS WHERE nombreUsuario = :NEW.nombreUsuario;
        IF (nombreUser>0) 
            THEN raise_application_error (-20600, :NEW.nombreUsuario||'. Este usuario ya existe.');
		END IF;
		IF (:NEW.nombreUsuario is null or :NEW.nombreUsuario = '') 
            THEN raise_application_error (-20600, 'El nombre de usuario no puede estar vacío');
		END IF;
        IF (:NEW.passUsuario is null or :NEW.passUsuario = '') 
            THEN raise_application_error (-20600, 'La contraseña no puede estar vacía');
		END IF; 
	END;
/

CREATE OR REPLACE TRIGGER articuloRepetido
	BEFORE INSERT ON ARTICULOS
    FOR EACH ROW
    DECLARE
        articulo1 int;
        articulo2 int;
        nombreArticulo varchar(250);
        contenidoArticulo varchar(4000);
	BEGIN
		SELECT count(*) INTO articulo1 FROM ARTICULOS WHERE nombreArticulo = :NEW.nombreArticulo;
        SELECT count(*) INTO articulo2 FROM ARTICULOS WHERE contenidoArticulo = :NEW.contenidoArticulo;

        IF (articulo1>0) 
            THEN raise_application_error (-20600, :NEW.nombreArticulo||'. El titulo del articulo no puede ser repetido.');
		END IF;
        IF (articulo2>0) 
            THEN raise_application_error (-20600, :NEW.nombreArticulo||'. El contenido del articulo no puede ser repetido.');
		END IF;
        IF (:NEW.nombreArticulo is null or :NEW.nombreArticulo = '') 
            THEN raise_application_error (-20600, 'El título del artículo no puede estar vacío');
		END IF;
        IF (:NEW.contenidoArticulo is null or :NEW.contenidoArticulo = '') 
            THEN raise_application_error (-20600, 'El artículo no puede estar vacío');
		END IF; 
	END;
/

CREATE OR REPLACE TRIGGER personaRepetida
	BEFORE INSERT ON PERSONAS
    FOR EACH ROW
    DECLARE
        persona1 int;
        persona2 int;
        dniPersona varchar(9);
        correoPersona varchar(150);
	BEGIN
		SELECT count(*) INTO persona1 FROM PERSONAS WHERE dniPersona = :NEW.dniPersona;
        SELECT count(*) INTO persona2 FROM PERSONAS WHERE correoPersona = :NEW.correoPersona;
        
        IF (persona1>0) 
            THEN raise_application_error (-20600, :NEW.dniPersona||'. El dni no puede ser repetido.');
		END IF;
        IF (persona2>0) 
            THEN raise_application_error (-20600, :NEW.correoPersona||'. El correo no puede ser repetido.');
		END IF;
        IF (:NEW.dniPersona is null or :NEW.dniPersona = '') 
            THEN raise_application_error (-20600, 'El título del artículo no puede estar vacío');
		END IF;
        IF (:NEW.correoPersona is null or :NEW.correoPersona = '') 
            THEN raise_application_error (-20600, 'El artículo no puede estar vacío');
		END IF; 
	END;
/

-- CREACION DE USUARIO ADMINISTRADOR INICIAL

insert into tiposUsuario values (null, 'Administrador Jefe');
insert into tiposUsuario values (null, 'Administrador');
insert into tiposUsuario values (null, 'Colaborador');
insert into tiposUsuario values (null, 'Registrado');

insert into personas values (null, '30220056B', 'José María', 'Villalón', 'Rivero', 'josevillalon93@gmail.com');

insert into usuarios values (null, 'admin', '12345', 1, 1);
insert into usuarios values (null, 'admin', '12345', 1, 1);
insert into usuarios values (null, '', '12345', 1, 1);
insert into usuarios values (null, 'admin2', '', 1, 1);

insert into articulos values (null, 'Articulo de prueba', 'Probando que conecta con la base de datos y se ve correcto <img border=0 src=https://disenowebakus.net/imagenes/imagenes-varios/enlace-texto.jpg width=200 height=200>Y continua el texto', TO_DATE('17/12/2015', 'DD/MM/YYYY'), 1);
insert into articulos values (null, 'Articulo de prueba 2', 'Probando que muestra los enlaces: <a href=http://marca.com target=_blank>marca.com</a>', TO_DATE('18/11/2016', 'DD/MM/YYYY'), 1);
insert into articulos values (null, 'Articulo de prueba 2', 'Probando que muestra los enlaces: <a href=http://marca.com target=_blank>marca.com</a>', TO_DATE('18/11/2016', 'DD/MM/YYYY'), 1);
insert into articulos values (null, '', 'a href=http://marca.com target=_blank>marca.com</a>', TO_DATE('18/11/2016', 'DD/MM/YYYY'), 1);
insert into articulos values (null, 'Articulo de prueba 3', 'Probando que muestra los enlaces: <a href=http://marca.com target=_blank>marca.com</a>', TO_DATE('18/11/2016', 'DD/MM/YYYY'), 1);
insert into articulos values (null, 'Articulo de prueba 4', '', TO_DATE('18/11/2016', 'DD/MM/YYYY'), 1);
update articulos set nombreArticulo = 'Articulo de prueba 2' WHERE idArticulo = 1;

select * from usuarios, personas, tiposUsuario where idPersona = idPersonaFK and idTipoUsuario = idTipoUsuarioFK;
SELECT IDTIPOUSUARIO, NOMBRETIPOUSUARIO FROM TIPOSUSUARIO;
SELECT count(*) FROM ARTICULOS, USUARIOS, TIPOSUSUARIO, PERSONAS where PERSONAS.idPersona=USUARIOS.idPersonaFK AND ARTICULOS.idUsuarioFK=USUARIOS.idUsuario and USUARIOS.idTipoUsuarioFK=TIPOSUSUARIO.idTipoUsuario;