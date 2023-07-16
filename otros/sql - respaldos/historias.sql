
id_proveniencia bigint NOT NULL DEFAULT 0,
id_parentesco bigint NOT NULL DEFAULT 0,
id_estado_civil bigint NOT NULL DEFAULT 0,
id_religion bigint NOT NULL DEFAULT 0,
cedula character varying(14) NOT NULL DEFAULT ''::bpchar,
nombres character varying(100) NOT NULL DEFAULT ''::bpchar,
apellidos character varying(100) NOT NULL DEFAULT 'A'::bpchar,
fecha_naci date NOT NULL DEFAULT '1900-01-01'::date,
lugar_naci character varying(200) NOT NULL DEFAULT ''::bpchar,
direccion character varying(200) NOT NULL DEFAULT ''::bpchar,
sexo character varying(1) NOT NULL DEFAULT ''::bpchar, 
emergencia_persona character varying(100) NOT NULL DEFAULT ''::bpchar,
emergencia_cedula character varying(14) NOT NULL DEFAULT ''::bpchar,
emergencia_contacto character varying(12) NOT NULL DEFAULT ''::bpchar,
telefonos jsonb NOT NULL DEFAULT '[]'::jsonb,
otros jsonb NOT NULL DEFAULT '[]'::jsonb,
fecha_consulta date NOT NULL DEFAULT '1900-01-01'::date,
fecha date NOT NULL DEFAULT '1900-01-01'::date,



insert into principales.historias_nuevas (
	id_correlativo,
	id_ocupacion,
	id_medico_referido,
	id_proveniencia,
	id_parentesco,
	id_estado_civil,
	id_religion,
	cedula,
	nombres,
	apellidos,
	fecha_naci,
	lugar_naci,
	direccion,
	sexo,
	emergencia_persona,
	emergencia_informacion,
	emergencia_contacto,
	telefonos,
	otros,
	fecha_consulta
)
select 
	correlativo,
	id_ocupacion,
	id_medico,
	id_proveniencia,
	id_parentesco,
	id_estado_civil,
	id_religion,
	cedula,
	nombres,
	apellidos,
	fecha_naci,
	lugar_naci,
	direccion,
	sexo,
	emergencia_persona,
	emergencia_cedula,
	emergencia_contacto,
	telefonos,
	otros, 
	fecha_consulta
from principales.historias
order by correlativo asc




update principales.historias set correlativo = 1 where correlativo = 0


	