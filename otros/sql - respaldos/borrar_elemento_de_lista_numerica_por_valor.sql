

SELECT 
	coalesce(NULLIF(JSONB_AGG(j) , null), '[]'::jsonb)
	
AS recipes
FROM miscelaneos.usuarios as a
CROSS JOIN JSONB_ARRAY_ELEMENTS(a.notificacion_recipes) 
WITH ORDINALITY arr(j,idx)
WHERE (select  cast(to_jsonb(j::text) #>> '{}' as integer)) != 17 and a.id_usuario = 2

