CREATE TABLE historias.historias
(
  id_historia bigserial NOT NULL,
  id_ocupacion bigint not null default 0,
  nombres character varying(150) not null default '',
  apellidos character varying(150) not null default '',
  direccion character varying (300) not null default '', 
  cedula character varying(14) NOT NULL DEFAULT ''::bpchar,
  sexo character varying NOT NULL DEFAULT ''::bpchar,
  talla numeric(3,2) not null default 0.00,
  peso numeric(5,2) not null default 0.00, 
  fecha_nacimiento date NOT NULL DEFAULT '1900-01-01'::date,
  antecedentes_patologicos jsonb not null default '[]'::jsonb,
  telefonos jsonb not null default '[]'::jsonb,
  correos jsonb not null default '[]'::jsonb,
  otros jsonb not null default '[]'::jsonb,
  fecha_cons date NOT NULL DEFAULT '1900-01-01'::date,
  status character varying(1) NOT NULL DEFAULT ''::bpchar,

  CONSTRAINT pk_id_historia_dermatologia PRIMARY KEY (id_historia)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE historias.historias
  OWNER TO postgres;