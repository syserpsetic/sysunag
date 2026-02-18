--1. Crear tabla gs_solicitudes
CREATE TABLE gs_solicitudes
(
    id serial,
    descripcion text,
    usuario_solicita text,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT gs_solicitudes_pkey PRIMARY KEY (id),
    CONSTRAINT usuario_solicita_foreign FOREIGN KEY (usuario_solicita)
        REFERENCES users (username) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE gs_solicitudes TO erpunag;
GRANT SELECT ON TABLE gs_solicitudes TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON gs_solicitudes_id_seq TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

--2. Crear tabla gs_trazabilidad
CREATE TABLE gs_trazabilidad
(
    id serial,
    id_solicitud bigint,
	descripcion text,
    id_departamento_remitente bigint,
    usuario_remitente text,
    id_departamento_destinatario bigint,
    usuario_destinatario text,
    fecha_hora_vencimiento timestamp(0) without time zone,
	solicitud_vista timestamp(0) without time zone,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT gs_trazabilidad_pkey PRIMARY KEY (id),
    CONSTRAINT id_solicitud_foreign FOREIGN KEY (id_solicitud)
        REFERENCES gs_solicitudes (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT id_departamento_remitente_foreign FOREIGN KEY (id_departamento_remitente)
        REFERENCES tbl_utic_departamentos (id_departamento) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT id_departamento_destinatario_foreign FOREIGN KEY (id_departamento_destinatario)
        REFERENCES tbl_utic_departamentos (id_departamento) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT usuario_remitente_foreign FOREIGN KEY (usuario_remitente)
        REFERENCES users (username) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT usuario_destinatario_foreign FOREIGN KEY (usuario_destinatario)
        REFERENCES users (username) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE gs_trazabilidad TO erpunag;
GRANT SELECT ON TABLE gs_trazabilidad TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON gs_trazabilidad_id_seq TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

--3. Crear tabla gs_adjuntos
CREATE TABLE gs_adjuntos
(
    id serial,
    id_trazabilidad bigint,
    archivo text,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT gs_adjuntos_pkey PRIMARY KEY (id),
    CONSTRAINT id_trazabilidad_foreign FOREIGN KEY (id_trazabilidad)
        REFERENCES gs_trazabilidad (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE gs_adjuntos TO erpunag;
GRANT SELECT ON TABLE gs_adjuntos TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON gs_adjuntos_id_seq TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

--4. Crear tabla gs_estados
CREATE TABLE gs_estados
(
    id serial,
    nombre text,
	descripcion text,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT gs_estados_pkey PRIMARY KEY (id)
);
GRANT UPDATE, INSERT, SELECT, DELETE ON TABLE gs_estados TO erpunag;
GRANT SELECT ON TABLE gs_estados TO cmatute, oacosta, cgarcia, gardonf, gdominguez, nsandoval;
GRANT USAGE ON gs_estados_id_seq TO erpunag, reports, cmatute, erpunag, oacosta, cgarcia, gardonf, gdominguez, nsandoval;

insert into gs_estados (nombre, descripcion) values ('Terminado', 'Este estado indica que la solicitud ha sido terminada departe del help desk, este estado deja el proceso en reposo.');
insert into gs_estados (nombre, descripcion) values ('Confirmado', 'Este estado indica que la solicitud ha sido terminada departe del help desk y confirmada departe del solicitande de origen, este estado termina definitivamente el proceoso.');
insert into gs_estados (nombre, descripcion) values ('Retornado', 'Este estado indica que la solicitud ha sido retornada departe del solicitande hacia el help dek, este estado reactiva el proceso.');
