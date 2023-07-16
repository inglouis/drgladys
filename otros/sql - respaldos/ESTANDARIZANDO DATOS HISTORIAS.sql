
--update principales.historias set ocupacion = 'FUNCIONARIO' where TRIM(ocupacion) = 'MADRE: FUNCIONARIO';

update principales.historias set ocupacion = upper(trim(replace(ocupacion, '9NO', 'ESTUDIANTE'))) where id_historia = id_historia;
--insert into basicas.medicos(nombres_apellidos)
select distinct(ocupacion) from principales.historias where ocupacion NOT IN (select nombre from basicas.ocupaciones);

/*
update basicas.medicos m 
set direccion = coalesce(NULLIF(
	(select distinct(direccion_medico) from principales.historias where medico_familia = m.nombres_apellidos and direccion_medico != '' limit 1
), null), '')
where id_medico = id_medico
*/


--select replace(ocupacion, 'MADRE', '') FROM principales.historias

