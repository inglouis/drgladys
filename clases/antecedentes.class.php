<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='primarias';
        public $tabla = 'evolucion';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_antecedentes($args) {

        	$sql ="select a.id_antecedente,trim(b.cedula) as cedula, a.nhist as nhist, trim(b.nombres) as nombres,trim(b.apellidos) as apellidos, a.fecha as fecha, trim(a.descripcion) as descripcion,
                trim(a.status) as status
                from principales.antecedentes as a
                left join principales.historias as b ON a.nhist = b.id_historia order by a.nhist desc limit 800";
                return $this->seleccionar($sql, $args);
        }

        public function buscar_antecedentes($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $conc = "or a.id_antecedente = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select a.id_antecedente,trim(b.cedula) as cedula, a.nhist as nhist, trim(b.nombres) as nombres,trim(b.apellidos) as apellidos, a.fecha as fecha, trim(a.descripcion) as descripcion,
                trim(a.status) as status
                from principales.antecedentes as a
                left join principales.historias as b ON a.nhist = b.id_historia order by a.nhist  where a.status='A' and nombres like '%'|| UPPER('$busqueda') ||'%' $conc order by a.id_antecedente order by a.nhist DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_antecedentes($args){

            $resultado = ($this->i_pdo("select id_antecedente from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_antecedente, nombre, status) VALUES(default, trim(upper(?)), 'A')";
                return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }
        }

        public function actualizar_antecedentes($args) { 

            $resultado = ($this->i_pdo("select id_antecedente from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_antecedente != $args[2] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), status =trim(upper(?)) where id_antecedente = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function elimina_antecedente($args){    
           $sql ="delete from $this->schema.$this->tabla where id_antecedente = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traer_antecedente($args){     
            $sql = "select * from $this->schema.$this->tabla where id_antecedente = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select a.id_antecedente,trim(b.cedula) as cedula, a.nhist as nhist, trim(b.nombres) as nombres,trim(b.apellidos) as apellidos, a.fecha as fecha, trim(a.descripcion) as descripcion,
                trim(a.status) as status
                from principales.antecedentes as a
                left join principales.historias as b ON a.nhist = b.id_historia order by a.nhist desc limit 800";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }
    }
?>

