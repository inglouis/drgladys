﻿DROP TABLE principales.evoluciones;

CREATE TABLE principales.evoluciones
(
	id_evolucion bigserial NOT NULL,
	id_historia bigint not null default 0,
	problematico character varying(1) not null default ''::bpchar,
	nota jsonb not null default '{}'::jsonb,
	agudeza_od_4 character varying(10) not null default ''::bpchar,
	agudeza_oi_4 character varying(10) not null default ''::bpchar,
	correccion_4 character varying(1) not null default ''::bpchar,
	allen_4 character varying(1) not null default ''::bpchar,
	jagger_4 character varying(1) not null default ''::bpchar,
	e_direccional_4 character varying(1) not null default ''::bpchar,
	numeros_4 character varying(1) not null default ''::bpchar,
	decimales_4 character varying(1) not null default ''::bpchar,
	fracciones_4 character varying(1) not null default ''::bpchar,
	letras_4 character varying(1) not null default ''::bpchar,
	agudeza_od_1 character varying(10) not null default ''::bpchar,
	agudeza_oi_1 character varying(10) not null default ''::bpchar,
	correccion_1 character varying(1) not null default ''::bpchar,
	allen_1 character varying(1) not null default ''::bpchar,
	jagger_1 character varying(1) not null default ''::bpchar,
	e_direccional_1 character varying(1) not null default'',
	numeros_1 character varying(1) not null default ''::bpchar,
	decimales_1 character varying(1) not null default ''::bpchar,
	fracciones_1 character varying(1) not null default ''::bpchar,
	letras_1 character varying(1) not null default ''::bpchar,
	agudeza_od_lectura character varying(10) not null default ''::bpchar,
	agudeza_oi_lectura character varying(10) not null default ''::bpchar,
	correccion_lectura character varying(1) not null default ''::bpchar,
	allen_lectura character varying(1) not null default ''::bpchar,
	jagger_lectura character varying(1) not null default ''::bpchar,
	e_direccional_lectura character varying(1) not null default ''::bpchar,
	numeros_lectura character varying(1) not null default ''::bpchar,
	decimales_lectura character varying(1) not null default ''::bpchar,
	fracciones_lectura character varying(1) not null default ''::bpchar,
	letras_lectura character varying(1) not null default ''::bpchar,
	estereopsis character varying(30) not null default ''::bpchar,
	test character varying(30) not null default ''::bpchar,
	reflejo character varying(30) not null default ''::bpchar,
	pruebas character varying(10) not null default ''::bpchar,
	correccion_pruebas character varying(1) not null default ''::bpchar,
	pruebas_od_1 character varying(30) not null default ''::bpchar,
	pruebas_od_2 character varying(30) not null default ''::bpchar,
	pruebas_od_3 character varying(30) not null default ''::bpchar,
	pruebas_od_4 character varying(30) not null default ''::bpchar,
	pruebas_od_5 character varying(30) not null default ''::bpchar,
	pruebas_od_6 character varying(30) not null default ''::bpchar,
	pruebas_od_7 character varying(30) not null default ''::bpchar,
	pruebas_od_8 character varying(30) not null default ''::bpchar,
	pruebas_oi_1 character varying(30) not null default ''::bpchar,
	pruebas_oi_2 character varying(30) not null default ''::bpchar,
	pruebas_oi_3 character varying(30) not null default ''::bpchar,
	pruebas_oi_4 character varying(30) not null default ''::bpchar,
	pruebas_oi_5 character varying(30) not null default ''::bpchar,
	pruebas_oi_6 character varying(30) not null default ''::bpchar,
	pruebas_oi_7 character varying(30) not null default ''::bpchar,
	pruebas_oi_8 character varying(30) not null default ''::bpchar,
	pruebas_nota jsonb not null default '{}'::jsonb,
	motilidad_od_1 character varying(30) not null default ''::bpchar,
	motilidad_od_2 character varying(30) not null default ''::bpchar,
	motilidad_od_3 character varying(30) not null default ''::bpchar,
	motilidad_od_4 character varying(30) not null default ''::bpchar,
	motilidad_od_5 character varying(30) not null default ''::bpchar,
	motilidad_od_6 character varying(30) not null default ''::bpchar,
	motilidad_oi_1 character varying(30) not null default ''::bpchar,
	motilidad_oi_2 character varying(30) not null default ''::bpchar,
	motilidad_oi_3 character varying(30) not null default ''::bpchar,
	motilidad_oi_4 character varying(30) not null default ''::bpchar,
	motilidad_oi_5 character varying(30) not null default ''::bpchar,
	motilidad_oi_6 character varying(30) not null default ''::bpchar,
	motilidad_nota jsonb not null default '{}'::jsonb,
	rx_od_signo_1 character varying(1) not null default ''::bpchar,
	rx_od_valor_1 numeric(7,2) not null default 0.00,
	rx_od_signo_2 character varying(1) not null default ''::bpchar,
	rx_od_valor_2 numeric(7,2) not null default 0.00,
	rx_od_grados character varying(30) not null default ''::bpchar,
	rx_od_resultado character varying(30) not null default ''::bpchar,
	rx_oi_signo_1 character varying(1) not null default ''::bpchar,
	rx_oi_valor_1 numeric(7,2) not null default 0.00,
	rx_oi_signo_2 character varying(1) not null default ''::bpchar,
	rx_oi_valor_2 numeric(7,2) not null default 0.00,
	rx_oi_grados character varying(30) not null default ''::bpchar,
	rx_oi_resultado character varying(30) not null default ''::bpchar,
	rx_od_signo_1_ciclo character varying(1) not null default ''::bpchar,
	rx_od_valor_1_ciclo numeric(7,2) not null default 0.00,
	rx_od_signo_2_ciclo character varying(1) not null default ''::bpchar,
	rx_od_valor_2_ciclo numeric(7,2) not null default 0.00,
	rx_od_grados_ciclo character varying(30) not null default ''::bpchar,
	rx_od_resultado_ciclo character varying(30) not null default ''::bpchar,
	rx_oi_signo_1_ciclo character varying(1) not null default ''::bpchar,
	rx_oi_valor_1_ciclo numeric(7,2) not null default 0.00,
	rx_oi_signo_2_ciclo character varying(1) not null default ''::bpchar,
	rx_oi_valor_2_ciclo numeric(7,2) not null default 0.00,
	rx_oi_grados_ciclo character varying(30) not null default ''::bpchar,
	rx_oi_resultado_ciclo character varying(30) not null default ''::bpchar,
	nota_b_od jsonb not null default '{}'::jsonb,
	nota_b_oi jsonb not null default '{}'::jsonb,
	nota_f_od jsonb not null default '{}'::jsonb,
	nota_f_oi jsonb not null default '{}'::jsonb,
	pio_od numeric(7,2) not null default 0.00,
	pio_oi numeric(7,2) not null default 0.00,
	referencias jsonb not null default '[]'::jsonb,
	diagnosticos jsonb not null default '[]'::jsonb,
	formula_od_signo_1_ciclo character varying(1) not null default ''::bpchar,
	formula_od_valor_1_ciclo numeric(7,2) not null default 0.00,
	formula_od_signo_2_ciclo character varying(1) not null default ''::bpchar,
	formula_od_valor_2_ciclo numeric(7,2) not null default 0.00,
	formula_od_grados_ciclo character varying(30) not null default ''::bpchar,
	formula_oi_signo_1_ciclo character varying(1) not null default ''::bpchar,
	formula_oi_valor_1_ciclo numeric(7,2) not null default 0.00,
	formula_oi_signo_2_ciclo character varying(1) not null default ''::bpchar,
	formula_oi_valor_2_ciclo numeric(7,2) not null default 0.00,
	formula_oi_grados_ciclo character varying(30) not null default ''::bpchar,
	curva_od numeric(7,2) not null default 0.00,
	curva_oi numeric(7,2) not null default 0.00,
	distancia_intraocular_od character varying(30) not null default ''::bpchar,
	distancia_intraocular_oi character varying(30) not null default ''::bpchar,
	distancia_interpupilar_od character varying(30) not null default ''::bpchar,
	distancia_interpupilar_oi character varying(30) not null default ''::bpchar,
	distancia_interpupilar_add character varying(30) not null default ''::bpchar,
	dip character varying(30) not null default ''::bpchar,
	bifocal_kriptok character varying(1) not null default ''::bpchar,
	bifocal_flat_top character varying(1) not null default ''::bpchar,
	bifocal_ultex character varying(1) not null default ''::bpchar,
	multifocal character varying(1) not null default ''::bpchar,
	bifocal_ejecutivo character varying(1) not null default ''::bpchar,
	plan jsonb not null default '{}'::jsonb,
	anexos_antes_lentes character varying(1) not null default ''::bpchar,
	anexos_despues_lentes character varying(1) not null default ''::bpchar,
	fecha date not null default '1900-01-01'::date,
	hora time without time zone NOT NULL DEFAULT '00:00:00'::time without time zone,
	fecha_real date not null default '1900-01-01'::date,
	status character varying(1) not null default 'A'::bpchar,
  CONSTRAINT pk_id_evolucion PRIMARY KEY (id_evolucion)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE principales.evoluciones
  OWNER TO postgres;

  --valor numeric(7,2) NOT NULL DEFAULT 0.00,
  
  /*insert into ppal.pruebas(valor) values(
	coalesce(NULLIF('', ''), '0.00')::numeric(7,2)
  )



  select upper(('["a"]'::jsonb)::text)::jsonb*/