<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}
ob_end_clean();
$ruta = $this->miConfigurador->getVariableConfiguracion('raizDocumento');
include($ruta . '/plugin/html2pdf/html2pdf.class.php');
$conexion = 'estructura';
$primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if ($_REQUEST['tipoPlantilla'] == 'Certificado') {
    $sqlReporte = $this->sql->getCadenaSql('obtenerPlantillaCertificadoporId', $_REQUEST['tipoReporte']);
    $cadenaReporte = $primerRecursoDB->ejecutarAcceso($sqlReporte, "busqueda");
    $sqlInformacionPersona = $this->sql->getCadenaSql('obtenerInformacionPersonaCertificado', $_REQUEST['documento']);
    $informacionPersona = $primerRecursoDB->ejecutarAcceso($sqlInformacionPersona, "busqueda");
    $cuerpo = str_replace("[PRIMER_NOMBRE]", " " . $informacionPersona[0]['primer_nombre'] . " ", $cadenaReporte[0]['cuerpo']);
    $cuerpo = str_replace("[SEGUNDO_NOMBRE]", " " . $informacionPersona[0]['segundo_nombre'] . " ", $cuerpo);
    $cuerpo = str_replace("[PRIMER_APELLIDO]", " " . $informacionPersona[0]['primer_apellido'] . " ", $cuerpo);
    $cuerpo = str_replace("[SEGUNDO_APELLIDO]", " " . $informacionPersona[0]['segundo_apellido'] . " ", $cuerpo);
    $cuerpo = str_replace("[DOCUMENTO]", " " . $informacionPersona[0]['documento'] . " ", $cuerpo);
    $cuerpo = str_replace("[TIPO_DOCUMENTO]", " " . $informacionPersona[0]['tipodocumento'] . " ", $cuerpo);
    $cuerpo = str_replace("[TIPO_VINCULACION]", " " . $informacionPersona[0]['nombre'] . " ", $cuerpo);
    $cuerpo = str_replace("[FECHA_INICIO]", " " . $informacionPersona[0]['fecha_inicio'] . " ", $cuerpo);
    $cuerpo = str_replace("[FECHA_FINAL]", " " . $informacionPersona[0]['fecha_final'] . " ", $cuerpo);
    $cuerpo = str_replace("[NUMERO_CONTRATO]", " " . $informacionPersona[0]['numero_contrato'] . " ", $cuerpo);
    $cuerpo = str_replace("[ESTADO_VINCULACION]", " " . $informacionPersona[0]['estado_vinculacion'] . " ", $cuerpo);
    $cuerpo = str_replace("[SEDE]", " " . $informacionPersona[0]['sede'] . " ", $cuerpo);
    $cuerpo = str_replace("[DEPENDENCIA]", " " . $informacionPersona[0]['dependencia'] . " ", $cuerpo);
} else {
    $sqlReporte = $this->sql->getCadenaSql('obtenerPlantillaReporteporId', $_REQUEST['tipoReporte']);
    $cadenaReporte = $primerRecursoDB->ejecutarAcceso($sqlReporte, "busqueda");
    $cadenaReporte[0]['atributos_persona'] = str_replace("tipo_documento", "tipodocumento", $cadenaReporte[0]['atributos_persona']);
    $cadenaInformacionPersona = 'SELECT ' . $cadenaReporte[0]['atributos_persona'] . ', ';
    $cadenaInformacionPersona.= $cadenaReporte[0]['atributos_vinculacion'] . ',nombre FROM informacionPersona ';
    $cadenaInformacionPersona.= 'WHERE documento=' . $_REQUEST['documento'];
    $informacionPersona = $primerRecursoDB->ejecutarAcceso($cadenaInformacionPersona, "busqueda");
    //var_dump($informacionPersona);
    $cadenaInformacionPreliquidacion = 'SELECT ' . $cadenaReporte[0]['atributos_conceptos'] . ', valor ,naturaleza ';
    $cadenaInformacionPreliquidacion .= 'FROM informacionPreliquidacion ';
    $cadenaInformacionPreliquidacion .= 'WHERE persona=' . $_REQUEST['documento'] . ' and ';
    $conceptosdevenga = $cadenaReporte[0]['conceptos_devenga'];
    $conceptosdevenga = explode(",", $conceptosdevenga);
    $condicionesdevenga = "";
    for ($i = 0; $i < count($conceptosdevenga); $i++) {
        $condicionesdevenga = $condicionesdevenga . 'codigo =' . $conceptosdevenga[$i] . ' or ';
    }
    $condicionesdevenga = substr($condicionesdevenga, 0, -3);
    $conceptosdeduce = $cadenaReporte[0]['conceptos_deduce'];
    $conceptosdeduce = explode(",", $conceptosdeduce);
    $condicionesdeduce = "";
    for ($i = 0; $i < count($conceptosdeduce); $i++) {
        $condicionesdeduce = $condicionesdeduce . 'codigo =' . $conceptosdeduce[$i] . ' or ';
    }
    $condicionesdeduce = substr($condicionesdeduce, 0, -3);
    $cadenaInformacionPreliquidacion .= $condicionesdevenga . ' and ';
    $cadenaInformacionPreliquidacion .= $condicionesdeduce . ' ;';
    $informacionPreliquidacion = $primerRecursoDB->ejecutarAcceso($cadenaInformacionPreliquidacion, "busqueda");
    $cuerpo = $cadenaReporte[0]['cuerpo'];
}

$contenidoPagina = "<page backtop='30mm' backbottom='10mm' backleft='20mm' backright='20mm'>";
$contenidoPagina .= "<page_header>
        <table align='center' style='width: 100%;'>
            <tr>
                <td align='left' >
                <img src='" . $cadenaReporte[0]['icono_izquierdo'] . "' width='80' height='80' /> 
                </td>
                <td align='center' >
                    <br>
                    <br>
                    <br>
                    <font style='font-size:30px;'><b>" . $cadenaReporte[0]['titulo_encabezado'] . "</b></font>
                    <br>
                    <font style='font-size:22px;'><b>" . $cadenaReporte[0]['empresa'] . "</b></font>
                    <br>
                    <font style='font-size:16px;'><b>" . $cadenaReporte[0]['otro_encabezado'] . "</b></font>
                    <br>
                    <font style='font-size:16px;'><b>" . $cadenaReporte[0]['fecha_creacion'] . "</b></font>
                    <br>
                </td>
                <td align='center' >
                <img src='" . $cadenaReporte[0]['icono_derecho'] . "' width='80' height='80' /> 
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table align='center' width = '100%'>
            <tr>
                <td align='center'>
                    
                </td>
            </tr>
            <tr>
                <td align='center'>
                    " . $cadenaReporte[0]['titulo_pie'] . "
                    <br>
                    " . $cadenaReporte[0]['direccion'] . "
                    <br>
                    " . $cadenaReporte[0]['telefono'] . "
                    <br>
                    " . $cadenaReporte[0]['email'] . "
                                                     
                </td>
            </tr>
        </table>
    </page_footer>";

$contenidoPagina .= "
<div>
<br><br><br><br><br><br><br><br><br>
<table align='center' class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='width:80%;border-collapse:collapse;border:none;'>   
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=123 valign=top style='width:12%;border:solid windowtext 1.0pt; 
  mso-border-alt:solid windowtext .5pt;background:#BDD6EE;mso-background-themecolor:
  accent1;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: 
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>TIPO:".$informacionPersona[0]['tipodocumento']." </span></b></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Identificación:".$_REQUEST['documento']."</span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=123 valign=top style='width:12%;border:solid windowtext 1.0pt; 
  mso-border-alt:solid windowtext .5pt;background:#BDD6EE;mso-background-themecolor:
  accent1;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: 
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Apellidos:".$informacionPersona[0]['primer_apellido']." ".$informacionPersona[0]['segundo_apellido']." </span></b></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Nombres:".$informacionPersona[0]['primer_nombre']." ".$informacionPersona[0]['segundo_nombre']."</span></p>
  </td>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=123 valign=top style='width:12%;border:solid windowtext 1.0pt; 
  mso-border-alt:solid windowtext .5pt;background:#BDD6EE;mso-background-themecolor:
  accent1;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: 
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Gran Contribuyente:".$informacionPersona[0]['gran_contribuyente']." </span></b></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Autorrtenedor:".$informacionPersona[0]['autorretenedor']."</span></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Regimen Tributario:".$informacionPersona[0]['regime_tributario']."</span></p>
  </td>
 </tr>
  <td width=123 valign=top style='width:12%;border:solid windowtext 1.0pt; 
  mso-border-alt:solid windowtext .5pt;background:#BDD6EE;mso-background-themecolor:
  accent1;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: 
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Numero Contrato:".$informacionPersona[0]['numero_contrato']." </span></b></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Fecha Final:".$informacionPersona[0]['fecha_inicio']."</span></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Fecha Fin:".$informacionPersona[0]['fecha_final']."</span></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Estado Vinculacion:".$informacionPersona[0]['estado_vinculacion']."</span></p>
  </td>
 </tr>
 </tr>
  <td width=123 valign=top style='width:12%;border:solid windowtext 1.0pt; 
  mso-border-alt:solid windowtext .5pt;background:#BDD6EE;mso-background-themecolor:
  accent1;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height: 
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Estado Dependencia:".$informacionPersona[0]['estado_vinculacion_dependencia']." </span></b></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Modelo de Liquidacion:".$informacionPersona[0]['modelo_vinculacion']."</span></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Valor Contrato:".$informacionPersona[0]['valor_contrato']."</span></p>
  </td>
  <td width=236 valign=top style='width:95%;border:solid windowtext 1.0pt;  
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Actividad:".$informacionPersona[0]['actividad']."</span></p>
  </td>
 </tr>
 <table>
</div>
    ";

$contenidoPagina .= "</page>";

$html2pdf = new HTML2PDF('P', 'LETTER', 'es');
$res = $html2pdf->WriteHTML($contenidoPagina);
$html2pdf->Output('resumenUsuario.pdf', 'D');
//$html2pdf->Output('certificado.pdf');
?>