<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
    	
        public function insertarParche($args) {
            
            $version = $args[1];
            unset($args[1]);

            $args = array_values($args);

            $sql = "insert into miscelaneos.parches values(default, ?, ?, CURRENT_DATE)";
            
            $resultado = $this->insertar($sql, $args);

            if(trim($resultado) == 'exito') {
                $sql = "update miscelaneos.version set version = ? where id_version = 1";

                return $this->actualizar($sql, [$version]);
            }
        }

        public function actualizarParches($args) {
            
            $sql = "update miscelaneos.parches set titulo = ?, descripcion = ? where id_parche = ?";
            $resultado = $this->actualizar($sql, $args); 

            if(trim($resultado) == 'exito') {
                return 'exito';
            } else {
                return "ERROR".$resultado;
            }  
        }


        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function confirmarUsuario($args) {

            $clave = $args[0];

            if (trim($clave) == 'ld34465867ab') {
                return 'exito';
            } else {
                return 'falso';
            }

        }

        public function comboRoles($args) {
  
            $sql = "select id_rol, concat(id_rol,' || ', rol) from miscelaneos.usuarios_roles";
            return $this->combos($args, [$sql, 'rol', 'id_rol']);
    
        }

        public function comboFormularios($args) {
  
            $sql = "select id_formulario, concat(id_formulario,' || ', upper(nombre)) from miscelaneos.sistema_formularios";
            return $this->combos($args, [$sql, 'nombre', 'id_formulario']);
    
        }

        public function registrarUsuario ($args){

            //print_r($args);

            $nombre     = $args[0];
            $apellido   = $args[1];
            $usuario    = $args[2];
            $telefono   = $args[3];
            $correo     = $args[4];
            $contrasena = $args[5];
            $rol        = $args[6];      
            
            if (!preg_match("/^[a-zA-Z0-9]*$/", $usuario)) {

                echo "iusuario";

            } else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

                echo "icorreo";

            } else {

                $options = ['cost' => 12];
                $hashPassword = password_hash($contrasena, PASSWORD_BCRYPT, $options);
                
                $datos = [
                    $nombre,
                    $apellido,
                    $usuario,
                    $telefono,
                    $correo,
                    $hashPassword,
                    $rol
                ];
                
                $sql = "insert into miscelaneos.usuarios (nombre, apellido, usuario, telefono, correo, clave, id_rol) values (
                    trim(upper(?)), 
                    trim(upper(?)), 
                    trim(upper(?)), 
                    trim(?),
                    trim(upper(?)), 
                    trim(?), 
                    ?)";

                $resultado = $this->i_pdo($sql, $datos, false);

                if ($resultado) {

                    $sql = 'select ppal.procesar_consistencia_formularios_banderas()';

                    if ($this->i_pdo($sql, [], false)) {

                        return 'exito';

                    } else {

                        return 'ERROR';

                    }

                } else {

                    return "ERROR".$resultado;

                }
              
            }   
       
        }

        public function insertarFormulario($args) {

            $sql = "insert into miscelaneos.sistema_formularios(nombre, status) values(lower(trim(?)), 'A')";

            $resultado = $this->insertar($sql, $args);

            if (trim($resultado) == 'exito') {

                $sql = 'select ppal.procesar_consistencia_formularios_banderas()';

                if ($this->i_pdo($sql, [], false)) {

                    return 'exito';

                } else {

                    return 'ERROR';

                }

            }

        }

        public function insertarBanderas($args) {

            $sql = "
                insert into miscelaneos.usuarios_banderas(nombre, formulario, descripcion, status)
                values(
                    lower(trim(?)),
                    ?,
                    upper(trim(?)), 
                    'A'
                )
            ";

            return  $this->insertar($sql, $args);

        }

        public function insertarMenuOpciones($args) {

            $args[0] = trim(strtolower($args[0]));
            $args[1] = trim(strtolower($args[1]));

            if ($args[2] == 'X') {$args[2] = 1;} else {$args[2] = 0;}
            if ($args[3] == 'X') {$args[3] = 1;} else {$args[3] = 0;}
                
            $lista = array(

                "ruta" => $args[0],
                "nombre" => $args[1],
                "bloquear" => $args[2],
                "editable" => $args[3]

            );

            $lista = json_encode($lista, JSON_UNESCAPED_UNICODE);
            //echo json_last_error_msg();

            $sql = "
                update miscelaneos.usuarios set
                    menu = jsonb_set(
                        menu::jsonb, 
                        concat('{', jsonb_array_length(menu::jsonb), '}')::text[], 
                        ?::jsonb, 
                        true
                    )
                where id_usuario = id_usuario
            ";

            $resultado = $this->i_pdo($sql, [$lista], false);

            if ($resultado) {

                $sql = "
                    update miscelaneos.usuarios_roles set
                        menu = jsonb_set(
                            menu::jsonb, 
                            concat('{', jsonb_array_length(menu::jsonb), '}')::text[], 
                            ?::jsonb, 
                            true
                        )
                    where id_rol = id_rol
                ";

                if ($this->i_pdo($sql, [$lista], false)) {

                    return 'exito';

                }

            }

        }
    }
?>