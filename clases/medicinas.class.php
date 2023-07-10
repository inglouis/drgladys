<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='historias';
        public $tabla = 'entradas';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];


         public function mostrarMedicamentos_dados_pacientes($args) {
            $sql = "
                select 
                x.*,
                coalesce(c.genericos_nombres::text, null, '[]')::json as genericos_nombres,
                b.nombre, 
                TO_CHAR(a.fecha :: DATE, 'dd-mm-yyyy') as fecha,
                case when x.medicamentos_genericos != '' then 
                        x.medicamentos_genericos
                else 
                       b.nombre 
                end as medicinas
                from historias.recipes as a, 
                jsonb_array_elements(medicamentos::jsonb) AS t(doc),
                jsonb_to_record(t.doc) as x (id_medicamento bigint , genericos json, tratamiento character varying(500), presentacion character varying(500), medicamentos_genericos character varying(300))
                left join historias.medicamentos as b using (id_medicamento)
                left join (
                select 
                id_medicamento,
                json_agg(a.nombre)::json as genericos_nombres
                from historias.genericos as a
                left join (
                select id_medicamento, trim(json_array_elements_text(genericos::json))::bigint as id_generico from historias.medicamentos where id_medicamento = id_medicamento order by id_medicamento asc) as b using(id_generico)
                group by id_medicamento
                ) as c using(id_medicamento) where a.id_historia = ?
                order by a.fecha desc limit 8000
            ";
                return $this->seleccionar($sql, $args);
        }
            public function cargarMedicamentos_dados_pacientes($args) {
            $sql = "select a.id_historia, trim(a.nume_cedu) as nume_cedu, trim(a.nume_hijo) as nume_hijo, a.nume_hist, trim(a.apel_nomb) as apel_nomb, trim(a.status) as status from historias.entradas aS A where a.status='A' order by a.id_historia desc limit 8000";
                return $this->seleccionar($sql, $args);
        }


        public function buscarMedicamentos_dados_pacientes($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $hist = "or a.id_historia  = ".(int)$busqueda;
            } else {
                $hist = '';
            }

            $sql = "select a.id_historia, trim(a.nume_cedu) as nume_cedu, trim(a.nume_hijo) as nume_hijo, a.nume_hist, trim(a.apel_nomb) as apel_nomb, trim(a.status) as status from historias.entradas aS A where a.status='A' and apel_nomb like '%'|| UPPER('$busqueda') ||'%' $orden order by id_historia DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traerMedicamentos_dados_pacientes($args){     
            $sql = "select * from $this->schema.$this->tabla where id_servicio = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select a.id_historia, trim(a.nume_cedu) as nume_cedu, trim(a.nume_hijo) as nume_hijo, a.nume_hist, trim(a.apel_nomb) as apel_nomb, trim(a.status) as status from historias.entradas AS a
                WHERE a.status='A'";   
            $this->aplicar_filtros([$sql, $args, 0, false, 'DESC', '8000']);
        }
    }
?>

