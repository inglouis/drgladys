select
    row_number() over () as id,
    t.*,
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

------------------------------------------------------------
select
    diagnosticos
FROM (
    SELECT x.*
    from 
     jsonb_array_elements(
    (select informes_medicos from historias.historias where id_historia = 1)
     ) AS t(doc),
     jsonb_to_record(t.doc) as x (nombres character varying(150), apellidos character varying(150), direccion character varying(300), cedula character varying(14), fecha date, fecha_nacimiento date, hora time without time zone, peso numeric(5,2), talla numeric(3,2), motivo text, enfermedad text, plan text, diagnosticos jsonb)
) as t
order by t.fecha desc, t.hora desc