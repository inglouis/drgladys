<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='principales';
        public $tabla = 'recipes';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        /*--------------------------------------------------------*/
        public function cargar_medicamentos($args) {

            $sql = "
                select 
                    a.id_medicamento, 
                    a.nombre, 
                    a.genericos,
                    coalesce(b.genericos_nombres::text, null, '[]')::json as genericos_nombres,
                    a.status, 
                    ''::character varying(500) as presentacion, 
                    ''::character varying(500) as tratamiento,''::character varying(1) as marcador, 
                    ''::character varying(1) as marcador_nueva_presentacion, 
                    ''::character varying(1) as marcador_nuevo_tratamiento,
                    coalesce(concat(b.genericos_texto, ' - ')::character varying(300), null, '')::character varying(300) as medicamentos_genericos
                from basicas.medicamentos as a
                left join (
                    select 
                    b.id_medicamento,
                    json_agg(a.nombre)::json as genericos_nombres,
                    string_agg(a.nombre, ' - ') AS genericos_texto
                    from basicas.genericos as a
                    inner join (
                    select id_medicamento, trim(json_array_elements_text(genericos::json))::bigint as id_generico from basicas.medicamentos where id_medicamento = id_medicamento order by id_medicamento asc
                    ) as b using(id_generico)
                    group by id_medicamento
                ) as b USING (id_medicamento)
                where a.status = 'A'
                order by a.id_medicamento asc
            ";

            return $this->seleccionar($sql, []);
        }

        /*--------------------------------------------------------*/
        public function cargar_medicamentos_especificos($args) {

            $sql = "
                select 
                    a.id_medicamento, 
                    a.nombre, 
                    a.genericos,
                    coalesce(b.genericos_nombres::text, null, '[]')::json as genericos_nombres,
                    a.status, 
                    ''::character varying(500) as presentacion, 
                    ''::character varying(500) as tratamiento,''::character varying(1) as marcador, 
                    ''::character varying(1) as marcador_nueva_presentacion, 
                    ''::character varying(1) as marcador_nuevo_tratamiento,
                    coalesce(concat(b.genericos_texto, ' - ')::character varying(300), null, '')::character varying(300) as medicamentos_genericos
                from basicas.medicamentos as a
                left join (
                    select 
                    b.id_medicamento,
                    json_agg(a.nombre)::json as genericos_nombres,
                    string_agg(a.nombre, ' - ') AS genericos_texto
                    from basicas.genericos as a
                    inner join (
                    select id_medicamento, trim(json_array_elements_text(genericos::json))::bigint as id_generico from basicas.medicamentos where id_medicamento = id_medicamento order by id_medicamento asc
                    ) as b using(id_generico)
                    group by id_medicamento
                ) as b USING (id_medicamento)
                where a.status = 'A' and id_medicamento not in ($args[0])
                order by a.id_medicamento asc
            ";

            return $this->seleccionar($sql, []);
        }

        /*--------------------------------------------------------*/
        public function traer_tratamientos($args) {

            $sql = "select * from basicas.tratamientos where id_medicamento = ?";
            $resultado = json_decode($this->seleccionar($sql, $args), true);

            if(count($resultado) > 0) {

                $tratamientos = json_decode($resultado[0]['tratamientos'], true);

                foreach ($tratamientos as &$r) {
                    $r = array("tratamiento" => $r);
                }

                return json_encode($tratamientos);
            } else {
                return json_encode([]);
            }
        }

        /*--------------------------------------------------------*/
        public function traer_presentaciones($args) {

            $sql = "select * from basicas.presentaciones where id_medicamento = ?";
            $resultado = json_decode($this->seleccionar($sql, $args), true);

            if(count($resultado) > 0) {

                $presentaciones = json_decode($resultado[0]['presentaciones'], true);

                foreach ($presentaciones as &$r) {
                    $r = array("presentacion" => $r);
                }

                return json_encode($presentaciones);
            } else {
                return json_encode([]);
            }
        }

        /*--------------------------------------------------------*/
        public function crear_recipe($args) {

            $nombre       = &$args[0];
            $cedula       = &$args[1];
            $id_historia  = &$args[2];
            $medicamentos = &$args[3];

            $pValido = 1;
            $tValido = 1;

            // echo "<pre>";
            // print_r($args);
            // echo "</pre>";

            $conn = $this->init_transaction();

            try {

                foreach($medicamentos as $r) {

                    if ($r['marcador_nueva_presentacion'] == 'X') {

                        $resultado = $this->e_pdo("select id_presentacion, presentaciones from basicas.presentaciones where id_medicamento = $r[id_medicamento]")->fetch(PDO::FETCH_ASSOC);

                        if ($resultado) {
                            
                            $resultado = json_decode($resultado['presentaciones'], true);
                            $query = "update basicas.presentaciones set presentaciones = ?::json where id_medicamento = ?";

                        } else if (!$resultado) {
                            
                            $resultado = [];
                            $query = "insert into basicas.presentaciones(id_presentacion, presentaciones, id_medicamento, status) values(default, ?::json, ?, 'A')";

                        }

                        $presentacion = trim(strtoupper($r['presentacion']));

                        if (count($resultado) < 12) {

                            if(!empty($presentacion)) {

                                if (in_array($presentacion, $resultado, false) == false) {

                                    array_push($resultado, $presentacion);

                                    $this->handle_transaction($conn, $query, [json_encode($resultado), $r['id_medicamento']], false);

                                }

                            }

                            $pValido = 1;
                        
                        } else {

                            $pValido = 0;

                        }     
                        
                    }

                    if($r['marcador_nuevo_tratamiento'] == 'X') {

                        $resultado = $this->e_pdo("select id_tratamiento, tratamientos from basicas.tratamientos where id_medicamento = $r[id_medicamento]")->fetch(PDO::FETCH_ASSOC);

                        if ($resultado) {

                            $resultado = json_decode($resultado['tratamientos']);
                            $query = "update basicas.tratamientos set tratamientos = ?::json where id_medicamento = ?";


                        } else if (!$resultado) {
                            
                            $resultado = [];
                            $query = "insert into basicas.tratamientos(id_tratamiento, tratamientos, id_medicamento, status) values(default, ?::json, ?, 'A')";

                        }

                        $tratamiento = trim(strtoupper($r['tratamiento']));

                        if(count($resultado) < 12) {

                            if(!empty($tratamiento)) {

                                if (in_array($tratamiento, $resultado, false) == false) {

                                    array_push($resultado, $tratamiento);

                                    $this->handle_transaction($conn, $query, [json_encode($resultado), $r['id_medicamento']], false);

                                }

                            }

                            $tValido = 1;

                        } else {

                            $tValido = 0;

                        }

                    }
                }

                foreach ($medicamentos as &$r) {
                    $r = array(
                        "id_medicamento" => $r['id_medicamento'],
                        "nombre" => $r['nombre'],
                        "genericos" => $r['genericos'],
                        "genericos_nombres" => $r['genericos_nombres'],
                        "presentacion" => $r['presentacion'],
                        "tratamiento" => $r['tratamiento'],
                        "marcador" => $r['marcador'],
                        "marcador_nueva_presentacion" => '',
                        "marcador_nuevo_tratamiento" => '',
                        "medicamentos_genericos" => $r['medicamentos_genericos']
                    );
                }

                $medicamentos = json_encode($medicamentos);
                $dia = $this->fechaHora('America/Caracas','Y-m-d');

                $sql = "insert into principales.recipes(id_historia, nombres, cedula, medicamentos, fecha, status) values(
                    ?,
                    trim(upper(?)),
                    trim(?),
                    ?::json,
                    ?::date,
                    'A'
                ) returning id_recipe";

                $args = [
                    $id_historia,
                    $nombre,
                    $cedula,
                    $medicamentos,
                    $dia
                ];

                $resultado = $this->handle_transaction($conn, $sql, $args, true)->fetch(PDO::FETCH_ASSOC)['id_recipe'];
                $conn->commit();

                if(is_numeric($resultado)) {

                    return json_encode([$resultado, $pValido, $tValido]);

                } else {

                    throw new Exception('Error al finalizar el procesamiento de informacion');

                }

            } catch (PDOException $e) {

                $conn->rollBack();

                echo 'Error en la ejecución: ' . $e->getMessage();

            }

            $conn = null; 
            
        }
        
        /*-----------------------------------------------------------------------------------*/
        public function cargar_recipes($args) {

            $sql = "select * from principales.recipes where id_historia = ? order by id_recipe desc";

            return $this->seleccionar($sql, $args);

        }

        /*-----------------------------------------------------------------------------------*/
        public function notificar_recipe($args) {

            $id_historia  = &$args[0];

            $sql = "
                update miscelaneos.usuarios
                SET 
                    notificacion_recipes = jsonb_insert(
                        notificacion_recipes, 
                        '{0}', 
                        ?::jsonb
                        , false
                    )
                WHERE id_usuario = ?;
            ";

            $resultado = $this->actualizar($sql, [$id_historia, $_SESSION['usuario']['notificar_usuario']]);

            if ($resultado == 'exito') {

                $this->controlador_cambios_activar([]);

                return json_encode($lista);

            } else {

                return 'ERROR'.$resultado;

            }

        }

        public function eliminar_recipes($args) {

            $sql = "delete from principales.recipes where id_recipe = ?";

            return $this->eliminar($sql, $args);

        }

        public function notificacion_recipes_cantidad($args) {

            $sql = "select notificacion_recipes from miscelaneos.usuarios where id_usuario = ?";

            $lista = json_decode($this->i_pdo($sql, [$_SESSION['usuario']['id_usuario']], true)->fetchColumn(), true);

            return count($lista);

        }

        /*-----------------------------------------------------------------------------------*/
        public function notificaciones_recipes_consultar($args) {

            $sql = "
                    select 
                        r.*
                    FROM (select jsonb_array_elements_text(notificacion_recipes) as id_recipe from miscelaneos.usuarios where id_usuario = ?) AS x
                    INNER JOIN principales.recipes as r on x.id_recipe::bigint = r.id_recipe
            ";

            return $this->seleccionar($sql, [$_SESSION['usuario']['id_usuario']]);

        }

        public function notificaciones_recipes_revisado($args) {

            $id_recipe = $args[0];

            $sql = "  
                update miscelaneos.usuarios
                SET 
                    notificacion_recipes = (
                        select 
                            coalesce(NULLIF(JSONB_AGG(j) , null), '[]'::jsonb)    
                        AS recipes
                        FROM miscelaneos.usuarios as a
                        CROSS JOIN JSONB_ARRAY_ELEMENTS(a.notificacion_recipes) 
                        WITH ORDINALITY arr(j,idx)
                        WHERE (select  cast(to_jsonb(j::text) #>> '{}' as integer)) != ? and a.id_usuario = ?
                    )::jsonb
                WHERE id_usuario = ?
            ";

            return $this->actualizar($sql, [$id_recipe, $_SESSION['usuario']['id_usuario'], $_SESSION['usuario']['id_usuario']]);

        }

        public function reusar_recipes($args) {

            $recipes_cargados = json_decode($args[0], true);

            $ids = '';

            foreach ($recipes_cargados as $r) {
                
                $ids .= $r['id_medicamento'].',';

            }

            $ids = substr($ids, 0, strlen($ids) - 1);

            $recipes_bases = json_decode($this->cargar_medicamentos_especificos([$ids]), true);

            


            foreach ($recipes_cargados as $r) {
                
                $r = array(
                    "id_medicamento" => $r['id_medicamento'],
                    "nombre" => $r['nombre'],
                    "genericos" => $r['genericos'],
                    "genericos_nombres" => $r['genericos_nombres'],
                    "status" => 'A',
                    "presentacion" => $r['presentacion'],
                    "tratamiento" => $r['tratamiento'],
                    "marcador" => $r['marcador'],
                    "marcador_nueva_presentacion" => $r['marcador_nueva_presentacion'],
                    "marcador_nuevo_tratamiento" => $r['marcador_nuevo_tratamiento'],
                    "medicamentos_genericos" => $r['medicamentos_genericos']    
                );

                array_push($recipes_bases, $r);

            }

            // echo "<pre>";
            // print_r($recipes_cargados);
            // echo "</pre>";

            return json_encode($recipes_bases);
        }

        /*-----------------------------------------------------------------------------------*/
        /*-----------------------------------------------------------------------------------*/
        public function mostrar_medicamentos_dados_pacientes($args) { //recipes_cargar
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
                FROM 
                    $this->schema.$this->tabla as a, 
                    jsonb_array_elements(medicamentos::jsonb) AS t(doc),
                    jsonb_to_record(t.doc) as x (
                        id_medicamento bigint , 
                        genericos json, 
                        tratamiento character varying(500), 
                        presentacion character varying(500), 
                        medicamentos_genericos character varying(300)
                    )
                left join basicas.medicamentos as b using (id_medicamento)
                left join (
                    select 
                        id_medicamento,
                        json_agg(a.nombre)::json as genericos_nombres
                        from historias.genericos as a
                        left join (
                        select id_medicamento, trim(json_array_elements_text(genericos::json))::bigint as id_generico from historias.medicamentos where id_medicamento = id_medicamento order by id_medicamento asc) as b using(id_generico)
                    group by id_medicamento
                ) as c 
                using(id_medicamento) 
                where a.id_historia = ?
                order by a.fecha desc limit 8000
            ";

            return $this->seleccionar($sql, $args);
        }

        /*-----------------------------------------------------------------------------------*/
        public function cargar_medicamentos_dados_pacientes($args) {

            $sql = "
                select 
                    a.id_historia, 
                    trim(a.nume_cedu) as nume_cedu, 
                    trim(a.nume_hijo) as nume_hijo, 
                    a.nume_hist, trim(a.apel_nomb) as apel_nomb, 
                    trim(a.status) as status 
                from historias.entradas aS A 
                where a.status='A' 
                order by a.id_historia 
                desc 
                limit 8000
            ";

            return $this->seleccionar($sql, $args);
        }

        /*-----------------------------------------------------------------------------------*/
        public function buscar_medicamentos_dados_pacientes($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $hist = "or a.id_historia  = ".(int)$busqueda;
            } else {
                $hist = '';
            }

            $sql = "select a.id_historia, trim(a.nume_cedu) as nume_cedu, trim(a.nume_hijo) as nume_hijo, a.nume_hist, trim(a.apel_nomb) as apel_nomb, trim(a.status) as status from historias.entradas aS A where a.status='A' and apel_nomb like '%'|| UPPER('$busqueda') ||'%' $orden order by id_historia DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

    }
?>

