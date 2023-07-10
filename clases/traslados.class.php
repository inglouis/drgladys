<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='inventario';
        public $tabla = 'deposito_principal';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        public $depositos = [
            0 => "principal",
            1 => "quirofano"
        ];

        public function cargarTraslados($args) {
            $salida = $args[0];
            $entrada = $args[1];
            
            $sql = "
               select 
                    a.id_deposito_principal, 
                    a.id_articulo, 
                    b.descripcion, 
                    b.costo, 
                    b.precio, 
                    a.cantidad_seleccionada,  
                    b.stock_minimo_$entrada as stock_minimo_salida, 
                    b.stock_maximo_$entrada as stock_maximo_salida, 
                    b.stock_minimo_$salida as stock_minimo_entrada, 
                    b.stock_maximo_$salida as stock_maximo_entrada, 
                    a.porcentaje,
                    a.fecha_vence,
                    (b.cantidad_principal + b.cantidad_quirofano)::bigint as cantidad_totales,
                    a.status_seleccionado,
                    a.status_principal,
                    b.status as status_articulo,
                    b.id_familia,
                    c.descripcion as desc_fami,
                    c.htmlcolor,
                    c.htmlfuente,
                    b.expiracion
                from (
                    select 
                        b.id_deposito_principal, b.id_articulo, a.cantidad as cantidad_seleccionada, b.porcentaje, b.fecha_vence, a.status as status_seleccionado, b.status as status_principal
                    from $this->schema.deposito_$salida as a
                    inner join $this->schema.deposito_principal as b using (id_deposito_principal)
                ) as a 
                inner join $this->schema.articulos as b using (id_articulo)
                inner join inventario.familias as c using (id_familia)
                where a.status_seleccionado = 'A' and b.status = 'A'
                order by b.id_articulo limit 8000";
            return $this->seleccionar($sql, []);
            
        }
        
        public function cargarBaremos($args) {
            $sql = "select id_baremo, id_principal, id_auxiliar, trim(desc_bare) as desc_bare, trim(stat_bare) as stat_bare, trim(nucol) as nucol, trim(cedu) as cedu, trim(espe) as espe, trim(telf) as telf, trim(msas) as msas, trim(rif) as rif, trim(nit) as nit, trim(dir) as dir, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_baremo limit 8000";
                return $this->seleccionar($sql, $args);
        }

        public function buscarTraslados($args) {
            $busqueda = $args[0];

            if (count($args) > 1) {

                $entrada = $args[1][0];
                $salida  = $args[1][1];

            };

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $bare = "or id_articulo = ".(int)$busqueda." ";
            } else {
                $bare = '';
            }

            $sql = " select 
                    a.id_deposito_principal, 
                    a.id_articulo, 
                    b.descripcion, 
                    b.costo, 
                    b.precio, 
                    a.cantidad_seleccionada,  
                    b.stock_minimo_$entrada as stock_minimo_salida, 
                    b.stock_maximo_$entrada as stock_maximo_salida, 
                    b.stock_minimo_$salida as stock_minimo_entrada, 
                    b.stock_maximo_$salida as stock_maximo_entrada, 
                    a.porcentaje,
                    a.fecha_vence,
                    (b.cantidad_principal + b.cantidad_quirofano)::bigint as cantidad_totales,
                    a.status_seleccionado,
                    a.status_principal,
                    b.status as status_articulo,
                    b.id_familia,
                    c.descripcion as desc_fami,
                    c.htmlcolor,
                    c.htmlfuente,
                    b.expiracion
                from (
                    select 
                        b.id_deposito_principal, b.id_articulo, a.cantidad as cantidad_seleccionada, b.porcentaje, b.fecha_vence, a.status as status_seleccionado, b.status as status_principal
                    from $this->schema.deposito_$salida as a
                    inner join $this->schema.deposito_principal as b using (id_deposito_principal)
                ) as a 
                inner join $this->schema.articulos as b using (id_articulo)
                inner join inventario.familias as c using (id_familia)
                where a.status_seleccionado = 'A' and b.status = 'A'";
            return $this->seleccionar($sql, []);
        }

        public function crearBaremos($args) {

           $sql = "insert into $this->schema.$this->tabla(id_baremo, id_principal, id_auxiliar, desc_bare, stat_bare, nucol, cedu, espe, telf, msas, rif, nit, dir, status) 
                VALUES (default, (SELECT (max(id_principal)+1) FROM facturacion.baremos),(SELECT (max(id_auxiliar)+1) FROM facturacion.baremos), trim(upper(?)), trim(upper(?)),trim(upper(?)), trim(upper(?)), trim(upper(?)), trim(upper(?)), trim(upper(?)), trim(upper(?)), trim(upper(?)), trim(upper(?)), 'A')";
                    return $this->insertar($sql, $args);
        }

        public function actualizarTraslados($args) {

            $dia  = $this->fechaHora('America/Caracas','d-m-Y');
            $hora = $this->fechaHora('America/Caracas','H:i:s');

            $cantidad = $args['valores'][1];
            $id_deposito_principal = $args['valores'][6];
            $id_articulo = $args['valores'][7];

            $deposito_desde = $args['tablas'][0]['area'];
            $deposito_hasta = $args['tablas'][1]['area'];
            $id_desde = $args['tablas'][0]['id'];
            $id_hasta = $args['tablas'][1]['id'];

            $args = [
                $id_deposito_principal,
                $id_articulo,
                $deposito_desde,
                $deposito_hasta,
                $id_desde,
                $id_hasta,
                $dia,
                $hora,
                $args['valores']
            ];

            $sql = "select ppal.procesar_traslados(?)";
            $resultado = $this->i_pdo($sql, [json_encode($args)], true)->fetchColumn();

            if ($resultado) {
                
                return 'exito';
            
            } else {

                return 'ERROR'.$resultado;

            }   
    
        }

        public function eliminaBaremo($args){    
           $sql ="delete from $this->schema.$this->tabla where id_baremo = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traerBaremo($args){     
            $sql = "select * from $this->schema.$this->tabla where id_baremo = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_baremo, id_principal, id_auxiliar, trim(desc_bare) as desc_bare, trim(stat_bare) as stat_bare, trim(nucol) as nucol, trim(cedu) as cedu, trim(espe) as espe, trim(telf) as telf, trim(msas) as msas, trim(rif) as rif, trim(nit) as nit, trim(dir) as dir, trim(status) as status from $this->schema.$this->tabla";
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }

        public function comboBaremosPrincipal($args) {
            $sql = "select id_principal, concat(id_principal,' || ', desc_bare) from $this->schema.$this->tabla";
            return $this->combos($args, [$sql, 'nomb_medi', 'id_principal']);
        }
            
        public function comboBaremosAuxiliar($args) {
            $sql = "select id_auxiliar, concat(id_auxiliar,' || ', desc_bare) from $this->schema.$this->tabla";
            return $this->combos($args, [$sql, 'nomb_medi', 'id_auxiliar']);
        }

        public function existenciasHasta($args) {
            $sql = "
                select a.cantidad as existencia_hasta from $this->schema.deposito_$args[0] as a 
                    inner join inventario.deposito_principal as b using (id_deposito_principal)
                where b.id_deposito_principal = $args[1]";
            return $this->e_pdo($sql, [])->fetchColumn();
        }

    }
?>

