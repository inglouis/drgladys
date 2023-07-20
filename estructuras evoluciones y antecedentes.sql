
CREATE TABLE principales.antecedentes
(
  id_antecedente bigserial NOT NULL,
  nhist numeric(10,0) NOT NULL DEFAULT 0,
  fecha date NOT NULL DEFAULT '1900-01-01'::date,
  descripcion character varying(400) NOT NULL DEFAULT ''::bpchar,
  status character varying(1) NOT NULL DEFAULT 'A'::bpchar
)
WITH (
  OIDS=FALSE
);
ALTER TABLE principales.antecedentes
  OWNER TO postgres;


CREATE TABLE principales.evolucion
(
  id_evolucion bigserial NOT NULL,
  cedula character varying(12) NOT NULL DEFAULT ''::bpchar,
  nhist character varying(10) NOT NULL DEFAULT ''::bpchar,
  diag1 character varying(100) NOT NULL DEFAULT ''::bpchar,
  diag2 character varying(100) NOT NULL DEFAULT ''::bpchar,
  fecha character varying(10) NOT NULL DEFAULT '01-01-1900'::character varying,
  avod character varying(100) NOT NULL DEFAULT ''::bpchar,
  avoi character varying(100) NOT NULL DEFAULT ''::bpchar,
  rxod character varying(100) NOT NULL DEFAULT ''::bpchar,
  rxoi character varying(100) NOT NULL DEFAULT ''::bpchar,
  ct1 character varying(100) NOT NULL DEFAULT ''::bpchar,
  ct2 character varying(100) NOT NULL DEFAULT ''::bpchar,
  ct3 character varying(100) NOT NULL DEFAULT ''::bpchar,
  ct4 character varying(100) NOT NULL DEFAULT ''::bpchar,
  ct5 character varying(100) NOT NULL DEFAULT ''::bpchar,
  ct6 character varying(100) NOT NULL DEFAULT ''::bpchar,
  ct7 character varying(100) NOT NULL DEFAULT ''::bpchar,
  ct8 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motod1 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motod2 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motod3 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motod4 character varying(100) DEFAULT ''::bpchar,
  motod5 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motod6 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motoi1 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motoi2 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motoi3 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motoi4 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motoi5 character varying(100) NOT NULL DEFAULT ''::bpchar,
  motoi6 character varying(100) NOT NULL DEFAULT ''::bpchar,
  otros character varying(150) NOT NULL DEFAULT ''::bpchar,
  rxciod character varying(100) NOT NULL DEFAULT ''::bpchar,
  rxcioi character varying(100) DEFAULT ''::bpchar,
  dip character varying(100) NOT NULL DEFAULT ''::bpchar,
  biom character varying(300) NOT NULL DEFAULT ''::bpchar,
  stflte character varying(100) NOT NULL DEFAULT ''::bpchar,
  ishiha character varying(100) NOT NULL DEFAULT ''::bpchar,
  tarwor character varying(100) NOT NULL DEFAULT ''::bpchar,
  fo character varying(100) NOT NULL DEFAULT ''::bpchar,
  piood character varying(100) NOT NULL DEFAULT ''::bpchar,
  piooi character varying(100) NOT NULL DEFAULT ''::bpchar,
  recood character varying(100) NOT NULL DEFAULT ''::bpchar,
  recooi character varying(100) NOT NULL DEFAULT ''::bpchar,
  pd character varying(100) NOT NULL DEFAULT ''::bpchar,
  kerod character varying(100) NOT NULL DEFAULT ''::bpchar,
  keroi character varying(100) NOT NULL DEFAULT ''::bpchar,
  reanod character varying(100) DEFAULT ''::bpchar,
  reanoi character varying(100) NOT NULL DEFAULT ''::bpchar,
  plan character varying(300) NOT NULL DEFAULT ''::bpchar,
  evo character varying(300) NOT NULL DEFAULT ''::bpchar,
  status character varying(1) NOT NULL DEFAULT 'A'::bpchar
)
WITH (
  OIDS=FALSE
);
ALTER TABLE principales.evolucion
  OWNER TO postgres;
