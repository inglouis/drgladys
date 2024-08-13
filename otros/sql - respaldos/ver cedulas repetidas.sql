/*select REPLACE(t.valor, '.', '')
from (
	select '1.1.1.1.1'::text as valor
	union
	select '2.2.1.1.1'::text as valor
	union
	select '2.2.1.3.1'::text as valor
	union
	select '2.2.1.4.1'::text as valor
) as t
*/

/*
select id_historia, trim(REPLACE(cedula, '.', '')) as cedula from principales.historias where cedula like '%.%'
select distinct id_historia, trim(REPLACE(cedula, '.', '')) as cedula from principales.historias where cedula like '%.%'
*/
select t.*, z.* from (
	select trim(REPLACE(cedula, '.', '')) as cedula from principales.historias group by trim(REPLACE(cedula, '.', ''))
) as t
full join ( 
	select count(trim(REPLACE(cedula, '.', ''))) as contador from principales.historias group by trim(REPLACE(cedula, '.', ''))
) as z;

/*
select * from principales.historias where trim(cedula) in (
	select trim(REPLACE(cedula, '.', '')) as cedula from principales.historias where cedula like '%.%'
)

select id_historia, trim(REPLACE(cedula, '.', '')) as cedula from principales.historias where trim(REPLACE(cedula, '.', '')) like '16229903'
*/

select * from principales.historias where trim(cedula) in (
	select trim(REPLACE(cedula, '.', '')) as cedula from principales.historias where cedula like '%.%'
)


/*
53  - "14002226"
291 - "26684551"
300 - "27114223"
312 - "28346971"
*/
