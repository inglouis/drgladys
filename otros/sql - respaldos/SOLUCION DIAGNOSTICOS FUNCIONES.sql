

SELECT
    b.id_diagnostico,
    b.nombre::text
FROM (
    SELECT x.*
    FROM 
	jsonb_array_elements(
	    (select (
		select
		    t.*
		FROM (
		    SELECT x.*
		    FROM 
		     jsonb_array_elements(
			(SELECT informes FROM principales.reportes WHERE id_historia = 11371)
		     ) AS t(doc),
		     jsonb_to_record(t.doc) as x (

			diagnosticos jsonb
			
		     )
		) as t

	     )::jsonb) --codigo_historia
	) AS t(doc),
	jsonb_to_record(t.doc) as x (id bigint)
) AS t
left join basicas.diagnosticos as b on b.id_diagnostico = t.id;

DROP FUNCTION ppal.basicas_traer_nombres_diagnosticos_lista(jsonb);

CREATE OR REPLACE FUNCTION ppal.basicas_traer_nombres_diagnosticos_lista(IN lista jsonb)
  RETURNS TABLE(id_diagnostico bigint, nombre text) AS
$BODY$
    DECLARE 

    BEGIN

	return query

	SELECT
	    b.id_diagnostico,
	    b.nombre::text
	FROM (
	    SELECT x.*
	    FROM 
		     jsonb_array_elements(
		    (select lista::jsonb) --codigo_historia
		     ) AS t(doc),
		     jsonb_to_record(t.doc) as x (id bigint)
	) AS t
	left join basicas.diagnosticos on b.id_diagnostico = t.id;
	
    END; 
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION ppal.basicas_traer_nombres_diagnosticos_lista(jsonb)
  OWNER TO postgres;
