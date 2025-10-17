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
	solicitud_vista boolean,
    created_at timestamp(0) without time zone default now(),
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone,
    CONSTRAINT gs_trazabilidad_pkey PRIMARY KEY (id),
    CONSTRAINT id_solicitud_foreign FOREIGN KEY (id_solicitud)
        REFERENCES gs_solicitudes (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT id_departamento_remitente_foreign FOREIGN KEY (id_departamento_remitente)
        REFERENCES per_departamento (id_departamento) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT id_departamento_destinatario_foreign FOREIGN KEY (id_departamento_destinatario)
        REFERENCES per_departamento (id_departamento) MATCH SIMPLE
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
