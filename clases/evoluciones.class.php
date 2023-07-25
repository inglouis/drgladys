<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='primarias';
        public $tabla = 'evolucion';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_evoluciones($args) {

        	$sql ="select a.id_evolucion,trim(a.cedula) as cedula, trim(a.nhist) as nhist, trim(b.nombres) as nombres,trim(b.apellidos) as apellidos, trim(a.diag1) as diag1, trim(a.diag2) as diag2, trim(a.fecha) as fecha, trim(a.avod) as avod, trim(a.avoi) as avoi, trim(a.rxod) as rxod, trim(a.rxoi) as rxoi, trim(a.plan) as plan, trim(a.evo) as evo, trim(a.status) as status
				from principales.evolucion as a
				left join principales.historias as b ON a.nhist = b.id_correlativo::character varying(100) order by a.nhist desc limit 800";
                return $this->seleccionar($sql, $args);
        }

        public function buscar_evoluciones($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $conc = "or id_evolucion = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select a.id_evolucion,a.cedula,a.nhist,trim(b.nombres),trim(b.apellidos),trim(a.diag1),trim(a.diag2),trim(a.fecha),trim(a.avod),trim(a.avoi),trim(a.rxod),trim(a.rxoi),trim(a.plan),trim(a.evo),trim(a.status)
				from principales.evolucion as a
				left join principales.historias as b ON a.nhist = b.id_correlativo::character varying(100) where a.status='A' and nombres like '%'|| UPPER('$busqueda') ||'%' $conc order by id_evolucion order by a.nhist DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_evoluciones($args){

            $resultado = ($this->i_pdo("select id_evolucion from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_evolucion, nombre, status) VALUES(default, trim(upper(?)), 'A')";
                return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }
        }

        public function actualizar_evoluciones($args) { 

            $resultado = ($this->i_pdo("select id_evolucion from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_evolucion != $args[2] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), status =trim(upper(?)) where id_evolucion = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function elimina_evolucion($args){    
           $sql ="delete from $this->schema.$this->tabla where id_evolucion = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traer_evolucion($args){     
            $sql = "select * from $this->schema.$this->tabla where id_evolucion = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select a.id_evolucion,a.cedula,a.nhist,trim(b.nombres),trim(b.apellidos),trim(a.diag1),trim(a.diag2),trim(a.fecha),trim(a.avod),trim(a.avoi),trim(a.rxod),trim(a.rxoi),trim(a.plan),trim(a.evo),trim(a.status)
				from principales.evolucion as a
				left join principales.historias as b ON a.nhist = b.id_correlativo::character varying(100) where a.status='A'  where trim(status='A' order by a.nhist desc limit 800";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }
    }
?>

