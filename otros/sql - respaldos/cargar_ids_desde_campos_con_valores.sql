--ESTADOS
update principales.historias p set id_estado = (
	SELECT 
		coalesce(NULLIF(b.id_estado, null), 0) AS idx
	from principales.historias as a
	left join basicas.estados as b on TRIM(a.estado) = b.nombre
	where a.id_historia = p.id_historia
)

update basicas.estados set nombre = trim(nombre) where id_estado = id_estado;
update principales.historias set estado = upper(trim(estado)) where id_historia = id_historia

--MUNICIPIOS
update principales.historias p set id_municipio = (
	SELECT 
		coalesce(NULLIF(b.id_municipio, null), 0) AS idx
	from principales.historias as a
	left join basicas.municipios as b on TRIM(a.municipio) = b.nombre
	where a.id_historia = p.id_historia
)

update basicas.municipios set nombre = trim(nombre) where id_municipio = id_municipio;
update principales.historias set estado = upper(trim(municipio)) where id_historia = --MEDICOS

update principales.historias p set id_medico = (
	SELECT 
		coalesce(NULLIF(b.id_medico, null), 0) AS idx
	from principales.historias as a
	left join basicas.medicos as b on TRIM(a.medico_familia) = b.nombres_apellidos
	where a.id_historia = p.id_historia
)

update basicas.medicos set nombres_apellidos = trim(nombres_apellidos) where id_medico = id_medico;
update principales.historias set medico_familia = upper(trim(medico_familia)) where id_historia = id_historia


--OCUPACION
update principales.historias p set id_ocupacion = (
	SELECT 
		coalesce(NULLIF(b.id_ocupacion, null), 0) AS idx
	from principales.historias as a
	left join basicas.ocupaciones as b on TRIM(a.ocupacion) = b.nombre
	where a.id_historia = p.id_historia
)

update basicas.ocupaciones set nombre = trim(nombre) where id_ocupacion = id_ocupacion;
update principales.historias set ocupacion = upper(trim(ocupacion)) where id_historia = id_historia

--PARENTESCO
update principales.historias p set id_parentesco = (
	SELECT 
		coalesce(NULLIF(b.id_parentesco, null), 0) AS idx
	from principales.historias as a
	left join basicas.parentescos as b on TRIM(a.parentesco) = b.nombre
	where a.id_historia = p.id_historia
)

update basicas.estado_civil set nombre = upper(trim(nombre)) where id_estado_civil = id_estado_civil;
update principales.historias set parentesco = upper(trim(parentesco)) where id_historia = id_historia

--ESTADO_CIVIL
update principales.historias p set id_estado_civil = (
	SELECT 
		coalesce(NULLIF(b.id_estado_civil, null), 0) AS idx
	from principales.historias as a
	left join basicas.estado_civil as b on TRIM(a.estado_civil) = b.nombre
	where a.id_historia = p.id_historia
)

update basicas.estado_civil set nombre = upper(trim(nombre)) where id_estado_civil = id_estado_civil;
update principales.historias set estado_civil = upper(trim(estado_civil)) where id_historia = id_historia


--RELIGION
update principales.historias p set id_religion = (
	SELECT 
		coalesce(NULLIF(b.id_religion, null), 0) AS idx
	from principales.historias as a
	left join basicas.religiones as b on TRIM(a.religion) = b.nombre
	where a.id_historia = p.id_historia
)

update basicas.religiones set nombre = upper(trim(nombre)) where id_religion = id_religion;
update principales.historias set religion = upper(trim(religion)) where id_historia = id_historia

----------------------------------------------------------------------------------------
select id_medico from basicas.medicos where nombres_apellidos like 'DR BENJAMIN ARAUJO'
----------------------------------------------------------------------------------------
delete from basicas.medicos where id_medico in (
	select id_medico from (
	  SELECT id_medico,
	  ROW_NUMBER() OVER(PARTITION BY nombres_apellidos ORDER BY id_medico asc) AS Row
	  FROM basicas.medicos
	) dups
	where 
	dups.Row > 1
)

