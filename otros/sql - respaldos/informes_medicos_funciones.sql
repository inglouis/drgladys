
-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------

DROP FUNCTION ppal.historias_traer_nombres_diagnosticos(bigint);

CREATE OR REPLACE FUNCTION ppal.historias_traer_nombres_diagnosticos(codigo_historia bigint)
  RETURNS table (id_diagnostico bigint, nombre text) as
$BODY$
    DECLARE 

    BEGIN

	return query

	SELECT
	    t.id_diagnostico,
	    b.nombre::text
	FROM (
	    SELECT x.*
	    FROM 
		     jsonb_array_elements(
		    (select ppal.historias_extraer_diagnosticos(codigo_historia)) --codigo_historia
		     ) AS t(doc),
		     jsonb_to_record(t.doc) as x (id_diagnostico bigint)
	) AS t
	left join historias.diagnosticos as b using (id_diagnostico);
	
    END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION ppal.historias_traer_nombres_diagnosticos(bigint)
  OWNER TO postgres;

select * from ppal.historias_traer_nombres_diagnosticos(1)



-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION ppal.historias_extraer_diagnosticos(codigo_historia bigint)
  RETURNS jsonb AS
$BODY$
    DECLARE 
	 datos jsonb;
    BEGIN

	datos = (
		SELECT
		    diagnosticos
		FROM (
		    SELECT x.*
		    from 
		     jsonb_array_elements(
		    (select informes_medicos from historias.historias where id_historia = codigo_historia)
		     ) AS t(doc),
		     jsonb_to_record(t.doc) as x (nombres character varying(150), apellidos character varying(150), direccion character varying(300), cedula character varying(14), fecha date, fecha_nacimiento date, hora time without time zone, peso numeric(5,2), talla numeric(3,2), motivo text, enfermedad text, plan text, diagnosticos jsonb)
		) as t
		order by t.fecha desc, t.hora desc
	)::jsonb;

	return datos;
    END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION ppal.historias_extraer_diagnosticos(bigint)
  OWNER TO postgres;


-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------
DROP FUNCTION ppal.historias_traer_nombres_diagnosticos_lista(bigint);

CREATE OR REPLACE FUNCTION ppal.historias_traer_nombres_diagnosticos_lista(lista jsonb)
  RETURNS table (id_diagnostico bigint, nombre text) as
$BODY$
    DECLARE 

    BEGIN

	return query

	SELECT
	    t.id_diagnostico,
	    b.nombre::text
	FROM (
	    SELECT x.*
	    FROM 
		     jsonb_array_elements(
		    (select lista::jsonb) --codigo_historia
		     ) AS t(doc),
		     jsonb_to_record(t.doc) as x (id_diagnostico bigint)
	) AS t
	left join historias.diagnosticos as b using (id_diagnostico);
	
    END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION ppal.historias_traer_nombres_diagnosticos_lista(jsonb)
  OWNER TO postgres;

select * from ppal.historias_traer_nombres_diagnosticos_lista('[{"id_diagnostico": 4}, {"id_diagnostico": 2}]')

-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION ppal.historias_diagnosticos_armar_lista(lista jsonb)
  RETURNS jsonb AS
$BODY$
    DECLARE 
	 datos jsonb;
    BEGIN

	datos = (
		SELECT json_agg(t.diagnosticos) from (
			SELECT
			    json_build_object(
			      'id_diagnostico', id_diagnostico,
			      'nombre', nombre
			    ) as diagnosticos
			FROM ppal.historias_traer_nombres_diagnosticos_lista(lista)
		) as t
	)::jsonb;

	return datos;
    END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION ppal.historias_diagnosticos_armar_lista(jsonb)
  OWNER TO postgres;


select * from ppal.historias_diagnosticos_armar_lista('[{"id_diagnostico": 4}, {"id_diagnostico": 2}]')
-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------

SELECT
    row_number() over () as id,
    t.*,
    ppal.historias_diagnosticos_armar_lista(t.diagnosticos) as diagnosticos_procesados,
    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
FROM (
    SELECT x.*
    from 
     jsonb_array_elements(
    (select informes_medicos from historias.historias where id_historia = 1)
     ) AS t(doc),
     jsonb_to_record(t.doc) as x (nombres character varying(150), apellidos character varying(150), direccion character varying(300), cedula character varying(14), fecha date, fecha_nacimiento date, hora time without time zone, peso numeric(5,2), talla numeric(3,2), motivo text, enfermedad text, plan text, diagnosticos jsonb)
) as t
order by t.fecha desc, t.hora desc