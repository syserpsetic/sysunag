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
--5. Crear tabla egresados.egre_experiencia_laboral
CREATE TABLE egresados.egre_experiencia_laboral
(
    id serial,
    puesto text,
    numero_registro_asignado text,
	empleador text,
	departamento text,
	lugar text,
	fecha_inicio timestamp(0) without time zone,
    fecha_fin timestamp(0) without time zone,
	descripcion text,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT egre_experiencia_laboral_pkey PRIMARY KEY (id)
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE egresados.egre_experiencia_laboral TO erpunag;
GRANT SELECT ON TABLE egresados.egre_experiencia_laboral TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON egresados.egre_experiencia_laboral TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
-----Ejecutado

--6. Crear tabla egresados.egre_categoria_habilidades_tecnicas
CREATE TABLE egresados.egre_categoria_habilidades_tecnicas
(
    id serial,
    nombre text,
    descripcion text,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT egre_categoria_habilidades_tecnicas_pkey PRIMARY KEY (id)
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE egresados.egre_categoria_habilidades_tecnicas TO erpunag;
GRANT SELECT ON TABLE egresados.egre_categoria_habilidades_tecnicas TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON egresados.egre_categoria_habilidades_tecnicas_id_seq TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

INSERT INTO egresados.egre_categoria_habilidades_tecnicas (nombre, descripcion) VALUES
('Informática y tecnología', 'Categoría relacionada con conocimientos y destrezas en informática, software y hardware.'),
('Administración y negocios', 'Categoría orientada a gestión empresarial, finanzas y administración de organizaciones.'),
('Agropecuarias y ambientales', 'Categoría enfocada en actividades agropecuarias, medio ambiente y sostenibilidad.'),
('Educación y formación', 'Categoría sobre enseñanza, capacitación y desarrollo académico.'),
('Idiomas', 'Categoría relacionada con el aprendizaje y uso de diferentes lenguas.'),
('Habilidades blandas', 'Categoría de competencias interpersonales, comunicación y liderazgo.'),
('Habilidades digitales', 'Categoría sobre competencias en el uso de herramientas y entornos digitales.'),
('Habilidades técnicas específicas', 'Categoría de conocimientos técnicos especializados en áreas concretas.');


--7. Crear tabla egresados.egre_cat_habilidades_tecnicas
CREATE TABLE egresados.egre_cat_habilidades_tecnicas
(
    id serial,
    nombre text,
    descripcion text,
	id_categoria_habilidades_tecnicas bigint,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT egre_cat_habilidades_tecnicas_pkey PRIMARY KEY (id),
	CONSTRAINT id_categoria_habilidades_tecnicas_foreign FOREIGN KEY (id_categoria_habilidades_tecnicas)
        REFERENCES egresados.egre_categoria_habilidades_tecnicas (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE egresados.egre_cat_habilidades_tecnicas TO erpunag;
GRANT SELECT ON TABLE egresados.egre_cat_habilidades_tecnicas TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON egresados.egre_cat_habilidades_tecnicas_id_seq TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

INSERT INTO egresados.egre_cat_habilidades_tecnicas (nombre, descripcion, id_categoria_habilidades_tecnicas) VALUES
('Microsoft Excel (avanzado)', NULL, 1),
('Programación en Python', NULL, 1),
('Mantenimiento de hardware', NULL, 1),
('Redes informáticas', NULL, 1),
('Desarrollo web (HTML, CSS, JS)', NULL, 1),
('Diseño gráfico (Photoshop, Illustrator)', NULL, 1),
('Bases de datos (SQL, PostgreSQL)', NULL, 1),
('Inteligencia Artificial aplicada', NULL, 1),
('Soporte técnico', NULL, 1),
('Seguridad informática', NULL, 1),

('Contabilidad básica', NULL, 2),
('Elaboración de presupuestos', NULL, 2),
('Gestión de proyectos', NULL, 2),
('Atención al cliente', NULL, 2),
('Manejo de caja y facturación', NULL, 2),
('Ventas y comercialización', NULL, 2),
('Gestión de talento humano', NULL, 2),
('Logística y cadena de suministro', NULL, 2),

('Manejo de ganado', NULL, 3),
('Técnicas de inseminación artificial', NULL, 3),
('Agricultura sostenible', NULL, 3),
('Uso de GPS agrícola', NULL, 3),
('Control de plagas', NULL, 3),
('Producción de hortalizas', NULL, 3),
('Análisis de suelos', NULL, 3),
('Buenas prácticas agrícolas', NULL, 3),

('Tutorías académicas', NULL, 4),
('Diseño instruccional', NULL, 4),
('Uso de plataformas virtuales (Moodle, Classroom)', NULL, 4),
('Elaboración de material educativo', NULL, 4),
('Evaluación del aprendizaje', NULL, 4),

('Inglés básico / intermedio / avanzado', NULL, 5),
('Francés básico', NULL, 5),
('Lenguaje de señas hondureño', NULL, 5),

('Comunicación asertiva', NULL, 6),
('Trabajo en equipo', NULL, 6),
('Liderazgo', NULL, 6),
('Resolución de conflictos', NULL, 6),
('Pensamiento crítico', NULL, 6),
('Adaptabilidad', NULL, 6),
('Ética profesional', NULL, 6),
('Creatividad', NULL, 6),
('Gestión del tiempo', NULL, 6),
('Orientación al logro', NULL, 6),
('Empatía', NULL, 6),
('Proactividad', NULL, 6),
('Toma de decisiones', NULL, 6),
('Capacidad de aprendizaje', NULL, 6),
('Inteligencia emocional', NULL, 6),

('Manejo de Canva', NULL, 7),
('Uso de Google Workspace', NULL, 7),
('Edición de video (CapCut, Camtasia)', NULL, 7),
('Redes sociales (Facebook, Instagram, TikTok)', NULL, 7),
('Marketing digital', NULL, 7),

('Soldadura', NULL, 8),
('Electricidad residencial', NULL, 8),
('Topografía', NULL, 8),
('Carpintería', NULL, 8),
('Panadería / repostería', NULL, 8),
('Cocina básica', NULL, 8);

--8. Crear tabla egresados.egre_habilidades_tecnicas
CREATE TABLE egresados.egre_habilidades_tecnicas
(
    id serial,
    numero_registro_asignado text,
    id_habilidad_tecnica bigint,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT egre_habilidades_tecnicas_pkey PRIMARY KEY (id),
	CONSTRAINT id_habilidad_tecnica_foreign FOREIGN KEY (id_habilidad_tecnica)
        REFERENCES egresados.egre_cat_habilidades_tecnicas (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE egresados.egre_habilidades_tecnicas TO erpunag;
GRANT SELECT ON TABLE egresados.egre_habilidades_tecnicas TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON egresados.egre_habilidades_tecnicas_id_seq TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

----Ejecutado 20250805_1613