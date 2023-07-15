
CREATE TABLE principales.historias
(
  id_historia bigserial NOT NULL,
  cedula character varying(14) NOT NULL DEFAULT ''::bpchar,
  nombres character varying(50) NOT NULL DEFAULT ''::bpchar,
  apellidos character varying(50) NOT NULL DEFAULT 'A'::bpchar,
  fecha_naci date NOT NULL DEFAULT '1900-01-01'::date,
  lugar_naci character varying(100) NOT NULL DEFAULT ''::bpchar,
  direccion_paciente character varying(150) NOT NULL DEFAULT ''::bpchar,
  estado character varying(100) NOT NULL DEFAULT ''::bpchar,
  municipio character varying(100) NOT NULL DEFAULT 'A'::bpchar,
  ocupacion character varying(100) NOT NULL DEFAULT ''::bpchar,
  sexo character varying(1) NOT NULL DEFAULT ''::bpchar,
  estado_civil character varying(20) NOT NULL DEFAULT ''::bpchar,
  religion character varying(40) NOT NULL DEFAULT ''::bpchar,
  telefono character varying(12) NOT NULL DEFAULT ''::bpchar,
  fecha_consulta date NOT NULL DEFAULT '1900-01-01'::date,
  emergencia_avisa character varying(100) NOT NULL DEFAULT ''::bpchar,
  parentesco character varying(50) NOT NULL DEFAULT ''::bpchar,
  direccion_persona character varying(200) NOT NULL DEFAULT ''::bpchar,
  telefono_avisa character varying(12) NOT NULL DEFAULT ''::bpchar,
  medico_familia character varying(100) NOT NULL DEFAULT ''::bpchar,
  direccion_medico character varying(200) NOT NULL DEFAULT ''::bpchar,
  hist numeric(10,0) NOT NULL DEFAULT 0,
  CONSTRAINT pk_id_historia_dermatologia PRIMARY KEY (id_historia)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE principales.historias
  OWNER TO postgres;
