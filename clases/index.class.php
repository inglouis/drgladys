<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public function monedas() {
        	$monedas = json_encode($this->e_pdo("select * from miscelaneos.monedas order by id_moneda asc")->fetchAll(PDO::FETCH_ASSOC));
        	return $monedas;
        }

        public function impuestos($args) {
            return json_encode($this->i_pdo("select * from miscelaneos.impuestos", [], true)->fetch(PDO::FETCH_ASSOC));
        }

        public function ivas() {
            $ivas = json_encode($this->e_pdo("select id_iva, porcentaje from miscelaneos.iva order by defecto desc")->fetchAll(PDO::FETCH_ASSOC));
            return $ivas;
        }

        public function editarMonedas($args) {
            $procesado = true;

            $resultado = $this->actualizar("select ppal.actualizacion_monedas(?)", [json_encode($args)]);
            if($resultado !== 'exito') {$procesado = false;}

            if ($procesado) {
                return 'exito';
            } else {
                return 'error';
            }
        }


        public function editarImpuestos($args) {

            $sql = "
                update miscelaneos.impuestos 
                set
                    valor1 = ?::numeric(14,2),
                    valor2 = ?::numeric(14,2),
                    valor3 = ?::numeric(14,2),
                    limite = ?::numeric(14,2),
                    deducible = ?::numeric(14,2),
                    cantidad_unidades = ?::numeric(14,2),
                    cantidad_mes = ?::numeric(14,2),
                    unidad_tributaria = ?::numeric(14,2),
                    iva = ?::numeric(14,2)
                where id_impuesto = 1
            ";

            $resultado = $this->actualizar($sql, $args);

            if ($resultado == 'exito') {
                return 'exito';
            } else {
                return 'error';
            }

        }

        public function editarIva($args) {

            $datos = $this->i_pdo("select porcentaje::numeric(14,2), defecto, status, id_iva from miscelaneos.iva where id_iva = ?", $args, true)->fetchAll(PDO::FETCH_NUM)[0];
            $datos[1] = 1;

            $sql = "select ppal.editar_iva(?, ?, ? , ?)";
            $resultado = $this->i_pdo($sql, $datos, true)->fetchColumn();

            if($resultado == 1) {
                return 'exito';
            } else {
                return 'ERROR:'.$resultado;
            }

        }

        public function insertarIva($args) {

        	$resultado = ($this->i_pdo("select id_iva from miscelaneos.iva where porcentaje = $args[0] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {

            	array_push($args, 0);

                $sql = "select ppal.insertar_iva(?, ?)";
                $resultado = $this->i_pdo($sql, $args, true)->fetchColumn();

                if($resultado == 1) {
                    return 'exito';
                } else {
                    return 'ERROR:'.$resultado;
                }
            } else {
                return "repetido";
            }

        }

        public function actualizar_cambio_nuevo($args) {

            $cambio = $args['USD']['promedio'];
            $fecha  = $args['_timestamp']['fecha'];
            $procesado = true;

            $resultado = $this->actualizar("select ppal.actualizacion_monedas_automatico(?, ?)", [$cambio, $fecha]);
            
            if($resultado !== 'exito') {$procesado = false;}

            if ($procesado) {

                return 'exito';

            } else {

                return 'error';

            }

        }

        public function actualizar_cambio_igual($args) {
            
            $this->actualizar("
                update miscelaneos.control_cambiario_auditoria set 
                    fecha_consulta = current_date, 
                    hora_consulta = current_time
                where id_control = (select max(a.id_control) from miscelaneos.control_cambiario_auditoria as a)
            ", []);

        }

        public function test4($args) {
            
            $this->actualizar("
                update ppal.test4 set 
                    numero = numero + 1
                where id_test4 = 1
            ", []);

        }

        public function test4dato($args) {
            
            return $this->i_pdo("
                select numero from ppal.test4 where id_test4 = 1
            ", [], true)->fetchColumn();

        }

        public function generarMenu(&$lista) { 

            //forzar_bloqueo es para el test de el metodo como iterador

            $llaves_asociativas_grupo = array_keys($lista);

            $listas = '';

            foreach ($llaves_asociativas_grupo as &$elemento) {

                if (!$lista[$elemento]['bloquear']) {

                    $li = '';

                    // echo "<pre>";
                    // print_r($lista);
                    // echo "</pre>";

                    $li_atributos = $lista[$elemento]['atributos'];
                    
                    /////////////////////////////////////////////////
                    $li .= "<li $li_atributos>";
                    /////////////////////////////////////////////////

                    //GENERA ES SPAN SI LO TIENE
                    /////////////////////////////////////////////////
                    if (gettype($lista[$elemento]['span']) == 'array') {

                        $span_atributos = $lista[$elemento]['span']['atributos'];
                        $span_titulo    = $lista[$elemento]['span']['titulo'];

                        /////////////////////////////////////////////////
                        $li .= "<span $span_atributos>$span_titulo</span>";
                        /////////////////////////////////////////////////

                    }

                    //GENERA LA REDIRECCION CON LA TAG A
                    /////////////////////////////////////////////////
                    $a_href = $lista[$elemento]['a']['href'];
                    $a_titulo    = $lista[$elemento]['a']['titulo'];

                    if (gettype($a_titulo) == 'array') {

                        $a_arr_ruta      = $a_titulo[0];
                        $a_arr_atributos = $a_titulo[1];
                        $a_arr_titulo    = $a_titulo[2];

                        $svg = $_SESSION['svgs'][$a_arr_ruta];
                        $svg = str_replace('remp_class', $a_arr_atributos, $svg);
                        $svg .= $a_arr_titulo;

                        $a_titulo = $svg;

                    }

                    /////////////////////////////////////////////////
                    $li .= "<a href='$a_href'>$a_titulo</a>";
                    /////////////////////////////////////////////////

                    $ul = $lista[$elemento]['ul'];

                    if ($ul != '') {


                        $ul_atributos = $ul['atributos'];
                        $ul_lista     = $ul['lista']; 

                        $ul_tag = "<ul $ul_atributos>";
                        $ul_tag .= $this->generarMenu($ul_lista);
                        $ul_tag .= '</ul>';

                        $li .= $ul_tag;

                    }


                    $li .= "</li>";

                    $listas .= $li;

                }

            }

            return $listas;
        }

    }
?>