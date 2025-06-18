--1. Crear esquema egresados
CREATE SCHEMA egresados
    AUTHORIZATION erpunag;

GRANT ALL ON SCHEMA egresados TO erpunag;
GRANT SELECT ON SCHEMA egresados TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;


--2. Crear tabla egresados.egre_tipos_grados_academicos
CREATE TABLE egresados.egre_tipos_grados_academicos
(
    id serial,
    nombre text,
	descripcion text,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT egre_tipos_grados_academicos_pkey PRIMARY KEY (id)
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE egresados.egre_tipos_grados_academicos TO erpunag;
GRANT SELECT ON TABLE egresados.egre_tipos_grados_academicos TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON egresados.egre_tipos_grados_academicos TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

INSERT INTO egresados.egre_tipos_grados_academicos (nombre, descripcion) VALUES
('Nivel medio', 'Estudios de educación secundaria o bachillerato.'),
('Técnico', 'Carreras técnicas o tecnológicas de nivel superior o medio.'),
('Pregrado', 'Carreras universitarias de grado como licenciaturas e ingenierías.'),
('Maestría', 'Estudios de posgrado avanzados, académicos o profesionales.'),
('Doctorado', 'Máximo grado académico, centrado en la investigación.');


--3. Crear tabla egresados.egre_estados
CREATE TABLE egresados.egre_estados
(
    id serial,
    nombre text,
	descripcion text,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT egre_estados_pkey PRIMARY KEY (id)
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE egresados.egre_estados TO erpunag;
GRANT SELECT ON TABLE egresados.egre_estados TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON egresados.egre_estados TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

INSERT INTO egresados.egre_estados (nombre, descripcion) VALUES
('En curso', 'Estudios actualmente en proceso.'),
('Finalizado', 'Estudios completados satisfactoriamente.'),
('Incompleto', 'Estudios iniciados pero no finalizados.');

--4. Crear tabla egresados.egre_datos_academicos
CREATE TABLE egresados.egre_datos_academicos
(
    id serial,
    nombre text,
    numero_registro_asignado text,
	institucion text,
	id_pais bigint,
	id_tipo_grado_academico bigint,
	fecha_inicio timestamp(0) without time zone,
    fecha_fin timestamp(0) without time zone,
	descripcion text,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT egre_datos_academicos_pkey PRIMARY KEY (id),
    CONSTRAINT id_pais_foreign FOREIGN KEY (id_pais)
        REFERENCES AUX_pais (id_pais) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT id_tipo_grado_academico_foreign FOREIGN KEY (id_tipo_grado_academico)
        REFERENCES egresados.egre_tipos_grados_academicos (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE egresados.egre_datos_academicos TO erpunag;
GRANT SELECT ON TABLE egresados.egre_datos_academicos TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON egresados.egre_datos_academicos TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
--ejecutado 20250618_1014
--
--
--
--
