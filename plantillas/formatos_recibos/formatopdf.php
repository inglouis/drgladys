<page style="width:215mm" backtop="47mm" backbottom="0mm" backleft="4mm" backright="5mm">

  <!--<img src="../imagenes/comp.jpg" style="position: absolute; height: 152mm; width: 209.5mm;top: -170px; left: -15px">-->

  <div class="contenedor" style="position: absolute;">

    
      <div style="font-size: 14px; position: absolute; right: 96px; top: -116px;">
        <b>&nbsp;&nbsp;&nbsp;<?php echo date("d", $timestamp);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("m", $timestamp);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("Y", $timestamp);?></b>
      </div>
    
    <?php if ($formato == 3) {?>
    <div style="position: absolute; right: 96px; top: -55px; font-size: 20px; text-transform: uppercase;">
      <?php echo strtoupper($control)?>
    </div>
    <?php }?>

    <div style="position: absolute; left: 30px; top: 6px; font-size: 16px; text-transform: uppercase;">
      <?php echo strtoupper($nombrePersona)?>
    </div>
    
    <div style="position: absolute; left: 620px; top: 4px; font-size: 16px; text-transform: uppercase;">
      <?php echo strtoupper($rif)?>
    </div>

    <div style="position: absolute; left: 110px; top: 35px; font-size: 12px; text-transform: uppercase;">
      <?php
        echo strtoupper($telefono);
      ?>
    </div>

    <div style="position: absolute; left: 525px; top: 30px; font-size: 12px; text-transform: uppercase;">
     <?php echo strtoupper($pago)?>
    </div>

    <div class="" style="position: relative; top: 70px; width: 185mm; left: 30px; text-transform: uppercase;"></div>

    <div></div>

    <table style="width: 200mm; margin-left: 25px; padding: 0px; border: none">
      <thead>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 20mm; text-align: center">1</td>
          <td style="width: 105mm; text-align: center"><?php echo strtoupper($descripcion)?></td>
          <td style="width: 35mm">
            <?php
              if ($formato == 3) {
          
                echo number_format($total, 2, ',', '.');

              } else {

                echo number_format($subtotal, 2, ',', '.');

              }
            ?>
          </td>
          <td style="width: 25mm">
            <?php
              if ($formato == 3) {
          
                echo number_format($total, 2, ',', '.');

              } else {

                echo number_format($subtotal, 2, ',', '.');

              }
            ?>
          </td>
        </tr>
      </tbody>
    </table>

    <div></div>

    <div class="" style="position: relative; top: 40px; width: 185mm; left: 30px;"></div>
    
    <div style='font-size:18px; width:193mm; text-align:right; font-weight: bold; position: relative; top: 55px'> 
      <?php

        echo number_format($subtotal, 2, ',', '.');

      ?> 
    </div>

    <?php 
      if ($formato == 3) {
    ?>

      <div style="font-size:18px; width:193mm; text-align:right; font-weight: bold; position: relative; top: 5px">
        <?php echo number_format($iva, 2, ',', '.');?>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo number_format($total - $subtotal, 2, ',', '.');?>
      </div>

      <div style="font-size:18px; width:193mm; text-align:right; font-weight: bold; position: relative; top: 5px">
        <?php echo number_format($total, 2, ',', '.');?>
      </div>

    <?php 
      }
    ?>
    

  </div>  
</page>