CREATE OR REPLACE FUNCTION ppal.basicas_traer_referencias_lista(IN lista jsonb)
  RETURNS TABLE(id_referencia bigint, nombre character varying(100), descripcion character varying(600)) AS
$BODY$
    DECLARE 

    BEGIN

	return query

	SELECT
	    b.id_referencia,
	    b.nombre::character varying(100),
	    b.descripcion::character varying(600)
	FROM (
	    SELECT x.*
	    FROM 
		     jsonb_array_elements(
		    (select lista::jsonb)
		     ) AS t(doc),
		     jsonb_to_record(t.doc) as x (id bigint)
	) AS t
	left join basicas.referencias as b on b.id_referencia = t.id;
	
    END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION ppal.basicas_traer_referencias_lista(jsonb)
  OWNER TO postgres;



CREATE OR REPLACE FUNCTION ppal.basicas_referencias_armar_lista(lista jsonb)
  RETURNS jsonb AS
$BODY$
    DECLARE 
	 datos jsonb;
    BEGIN

	datos = (
		SELECT json_agg(t.referencias) from (
			SELECT
			    json_build_object(
			      'id_referencia', id_referencia,
			      'nombre', nombre,
			      'descripcion', descripcion
			    ) as referencias
			FROM ppal.basicas_traer_referencias_lista(lista)
		) as t
	)::jsonb;

	return datos;
    END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION ppal.basicas_referencias_armar_lista(jsonb)
  OWNER TO postgres;
