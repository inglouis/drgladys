DROP TABLE miscelaneos.usuarios;

CREATE TABLE miscelaneos.usuarios
(
  id_usuario bigserial NOT NULL,
  usuario character varying(100) NOT NULL DEFAULT ''::bpchar,
  cookie character varying(100) NOT NULL DEFAULT ''::bpchar,
  notificacion_reportes jsonb NOT NULL DEFAULT '[]'::jsonb,
  notificar_usuario bigint NOT NULL DEFAULT 0,
  controlador_cambios boolean NOT NULL DEFAULT false,
  status character varying(1) not null default 'A'::bpchar,
  CONSTRAINT pk_id_usuario PRIMARY KEY (id_usuario)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE miscelaneos.usuarios
  OWNER TO postgres;
