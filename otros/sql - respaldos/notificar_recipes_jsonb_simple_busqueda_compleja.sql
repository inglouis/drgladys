select
	tabla.id_recipe
from jsonb_to_recordset(
	(SELECT 
		jsonb_agg(
			jsonb_build_object(
				'id_recipe', x.id_recipe
			)
		) as recipes
	FROM (select jsonb_array_elements_text(notificacion_recipes) as id_recipe from miscelaneos.usuarios where id_usuario = 2) AS x)
) as tabla (id_recipe bigint)




SELECT 
	r.*
FROM (select jsonb_array_elements_text(notificacion_recipes) as id_recipe from miscelaneos.usuarios where id_usuario = 2) AS x
INNER JOIN principales.recipes as r on x.id_recipe::bigint = r.id_recipe