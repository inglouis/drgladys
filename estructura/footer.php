<?php 
	include_once('../clases/ppal.class.php');
  	$obj = new Model();

  	$version = $obj->version();
?>
<footer>
  <p>Dra. Gladys Chaparro, Oftalmología  © <?=date('Y')?> - Luis Alfonso Carvajal Rojas & Luis Daniel Carvajal Chacón © <?=date('Y')?> [BETA <?php echo $version?>]</p>
</footer>
</html>