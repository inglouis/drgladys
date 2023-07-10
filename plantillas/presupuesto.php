<?php
  ob_start();
  //extract(unserialize(file_get_contents('datas.txt')))
?>
<style>
      h5, h3 {
        padding:0px; 
        margin: 0px;
        text-align: center;
      }

      h1, h2 {
        padding:0px; 
        margin: 0px;
        text-align: center;
        font-size: 22px;
      }

      h4 {
        padding:0px; 
        margin: 0px;
        text-align: center;
        font-size: 10px;
      }


     .contenedor {
        width: 90%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        font-size: 18px;
      }
    
      .separador {
          width: 100%;
          height: 2px;
          border-top: 2px dashed #909090;
          border-bottom: 2px dashed #909090;
          margin: 2px 2px;
      }

      #cabecera h5 {
        width: 100%; 
        text-align: center;
        position:absolute;
        font-size: 16px;
      }

      .centro {
        text-align: left;
        font-size: 14px;
        width: 100%;
      }

      table {
        width:300px;
        color: #202020;
        border-bottom: 1px solid #ccc;
        border-left: 1px dashed #ccc;
        font-size: 12px;
      }

      table tbody tr td {
        width: fit-content;
        text-align:  left;
        padding: 3px 5px;
      }

      .derecha {
        text-align: right !important;
      }

      .small {
        font-size: 10px;
        padding-top: 2px;
        width: fit-content;
      }
</style>

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 10px;">
      <h2 style="top:25px">CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE</h2>
      <h2 style="top:40px">Y ASOCIADOS C.A.</h2>
      <h4 style="top:5px">Av. 19 DE ABRIL EDIFICIO CLINICA DE OJOS P.B SECTOR LA BERMEJA SAN CRISTÓBAL EDO TÁCHIRA TF: 0276-3560133 - 3560139 FAX 3558631</h4>
      <div class="separador"></div>



<!--
      <h5 style="top:60px; text-align:right; font-weight: 100; color:#5f5f5f">Fecha: 2021-8-29</h5>
      <h5 style="top:80px; text-align:right; font-weight: 100; color:#5f5f5f">Hora: 14:04:01</h5>
    -->
    </div> 
    <div class="separador"></div>
    <table>
      <tbody>
        <tr>
          <td>PRESUPUESTO N°: <div>[12321323]</div></td>
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td>MEDICO: 
            <div 
                class="small">[DR. CASTILLO INCIARTE]
            </div>
          </td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td>CODIGO NOMBRE DEL PACIENTE: 
            <div 
              class="small">[DR. CASTILLO INCIARTE]
            </div>
          </td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td>CODIGO DIAGNÓSTICO: 
            <div 
              class="small">[D005]
            </div>
          </td>
        </tr> 
      </tbody>    
    </table>


    <table>
      <tbody>
        <tr>
          <td>DIAGNÓSTICO
            <div 
                class="small">CATARATA POR FACOMULSIFICAIÓN E IMPLANTE DE LENTE INTRAOCULAR OJO IZQUIERDO
            </div>
          </td>  
        </tr> 
      </tbody>    
    </table>

    <div class="separador"></div>

    <table>
      <tbody>
        <tr>
          <td>RESPONSABLE:
            <div 
                class="small">CUENTAS PARTICULARES
            </div>
          </td>  
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td>FECHA:
            <div 
              class="small">31-08-2021
            </div>
          </td>  
        </tr> 
      </tbody>    
    </table>

    <div class="separador"></div>
    <div style="width:100%; height: 20px;"></div>
    <div style="width:fit-content; border-bottom: 1px solid black;font-size:12px">SERVICIOS:</div>
    <div style="width:100%; height: 200px;"></div>

    <div class="separador"></div>

    <table>
      <tbody>
        <tr>
          <td>TOTAL SERVICIOS:
            <div 
              class="small">100.200.300.000
            </div>
          </td>  
        </tr> 
      </tbody>    
    </table>

    <div class="separador"></div>

    <div style="width:100%; height: 20px;"></div>
    <div style="width:fit-content; border-bottom: 1px solid black;font-size:12px">HONORARIOS:</div>
    <div style="width:100%; height: 200px;"></div>

    <div class="separador"></div>

    <table>
      <tbody>
        <tr>
          <td>TOTAL HONORARIOS:
            <div 
              class="small">200.300.400.000
            </div>
          </td>  
        </tr> 
      </tbody>    
    </table>

    <div class="separador"></div>

    <table>
      <tbody>
        <tr>
          <td>TOTAL GENERAL
            <div 
              class="small">300.400.700.000
            </div>
          </td>  
        </tr> 
      </tbody>    
    </table>
    <div class="separador"></div>

    <table>
      <tbody>
        <tr>
          <td>ESTE PRESUPUESTO TENDRA UNA VALIDEZ DE 48 HORAS</td>
        </tr> 
      </tbody>    
    </table>


    <table>
      <tbody>
        <tr>
          <td>ORIGINAL</td>
        </tr> 
      </tbody>    
    </table>
  </div>  
</page>

<?php

  $content = ob_get_clean();
  //require_once(dirname(__FILE__).'/../vendor/autoload.php');
  require_once('../../vendor/autoload.php');
  use Spipu\Html2Pdf\Html2Pdf;
  try
  {
      $html2pdf = new HTML2PDF('p', 'A4', 'es', true, 'UTF-8');
      //$pdf = new \Spipu\Html2Pdf\Html2Pdf('P','A4','en', false, 'UTF-8', array(mL, mT, mR, mB)); 
      //mL = margel izquierdo
      //mR = margel Derecho
      //mT = margel Superior o Tope
      //mB = margel Inferior o Bottom
      // link de Explicacion esta en Composer de favoritos

      $html2pdf->pdf->SetDisplayMode('fullpage');
      $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
      $html2pdf->Output('../reportes/formulas.pdf');
  }
  catch(HTML2PDF_exception $e) {
      echo $e;
      exit;
  }
?>