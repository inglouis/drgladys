<?php 

  include_once('../clases/index.class.php');
  $index = new Model();

  if (isset($_SESSION['id_usuario'])) {
    if(!empty($_SESSION['id_usuario'])) {
      echo "sesion activa";
      header("Location: ../paginas/index.php");
      exit(); 
    }
  }

  // echo $_SERVER['HTTP_HOST'];

  // if ($_SERVER["HTTPS"] != "on") {
  //     $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  //     header("Location: $redirect_url");
  //     exit();
  // }

?>

<!DOCTYPE html>
<html lang="es" style="font-family: monospace; min-height: 500px;">
<head>

  <meta charset="utf-8">
  <title>INICIAR SESIÓN</title><link rel="shortcut icon" href="../imagenes/ico-v2.ico">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0"/>
  <link rel="stylesheet" type="text/css" href="../css/login.css?<?php //echo time(); ?>"/>
  <script type="module" src="../js/login.js"></script>
  <link rel="stylesheet" type="text/css" href="../css/cdn.css" defer>

</head>
<body>
  <header></header>
  <div id="index-contenedor">
    
  
    <div class="container fcon" style="
      width: 250px;
      padding: 15px;
      border-radius: 15px;
    ">

        <div class="form-group">
          <label class="control-label" style="border-bottom: 1px dashed; font-weight: bold">INGRESAR USUARIO</label>
        </div>

        <div class="form-group">
          
          <div style="padding:2px; width: inherit; position: relative;">
            <input type="text" id="usuario" maxlength="100" class="form-control s_lec clinica-inputs login-valores lleno" placeholder="..." style="text-transform: uppercase;">
          </div>

        </div>

        <div class="form-group"style="margin: 0px">
          <button id="clinica-iniciar">
            CONFIRMAR
          </button>
        </div>
    </div>
  </div>
  <?php 
    require_once('../estructura/footer.php');
  ?>
  </body>
</html>