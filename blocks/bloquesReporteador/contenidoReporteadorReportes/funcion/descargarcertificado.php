<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}
ob_end_clean();
$ruta = $this->miConfigurador->getVariableConfiguracion('raizDocumento');
include($ruta . '/blocks/bloquesReporteador/contenidoReporteadorReportes/html2pdf/html2pdf.class.php');
$conexion = 'estructura';
$primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if ($_REQUEST['tipoPlantilla'] == 'Certificado') {
    $sqlReporte = $this->sql->getCadenaSql('obtenerPlantillaCertificadoporId', $_REQUEST['tipoReporte']);
    $cadenaReporte = $primerRecursoDB->ejecutarAcceso($sqlReporte, "busqueda");
    $sqlInformacionLeyes = $this->sql->getCadenaSql('obtenerInformacionLeyesCertificado', $_REQUEST['documento']);
    $informacionLeyes = $primerRecursoDB->ejecutarAcceso($sqlInformacionLeyes, "busqueda");
    $reglamentacion="";
    for ($i = 0; $i < count($informacionLeyes); $i++) {
        $reglamentacion=$reglamentacion." ".$informacionLeyes[$i]['nombre']." (".$informacionLeyes[$i]['reglamentacion']."),";
    }
    $reglamentacion=  substr($reglamentacion,0, -1);
    $sqlInformacionPersona = $this->sql->getCadenaSql('obtenerInformacionPersonaCertificado', $_REQUEST['documento']);
    $informacionPersona = $primerRecursoDB->ejecutarAcceso($sqlInformacionPersona, "busqueda");
    $cuerpo = str_replace("\\", "", $cadenaReporte[0]['cuerpo']);
    $cuerpo = str_replace("[PRIMER_NOMBRE]", " " . $informacionPersona[0]['primer_nombre'] . " ", $cuerpo);
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
    $cuerpo = str_replace("[REGLAMENTACION]", " " . $reglamentacion . " ", $cuerpo);
    $contenidoPagina = "<page backtop='30mm' backbottom='10mm' backleft='20mm' backright='20mm'>";
    $contenidoPagina .= "<page_header>
        <table align='center' style='width:100%;' border=0>
            <tr>
                <td align='center' style='width:18%;' >
                <img src='" . $cadenaReporte[0]['icono_izquierdo'] . "' width='70' height='70' align='left' /> 
                </td>
                <td align='center' style='width:64%;' >
                    <font style='font-size:18px;'><b>" . $cadenaReporte[0]['titulo_encabezado'] . "</b></font>
                    <br>
                    <font style='font-size:16px;'><b>" . $cadenaReporte[0]['empresa'] . "</b></font>
                    <br>
                    <font style='font-size:12px;'><b>" . $cadenaReporte[0]['otro_encabezado'] . "</b></font>
                    <br>
                    <font style='font-size:12px;'><b>" . $cadenaReporte[0]['fecha_creacion'] . "</b></font>
                </td>
                <td align='center' style='width:18%;' >
                <img src='" . $cadenaReporte[0]['icono_derecho'] . "' width='70' height='70' /> 
                </td>
            </tr>
        </table>
        
    </page_header>
    <page_footer>
        <table align='center' width = '100%'>
            <tr>
                <td align='center'>
                    " . $cadenaReporte[0]['titulo_pie'] . "
                    <br>    
                    " . $cadenaReporte[0]['direccion'] . " -
                    " . $cadenaReporte[0]['telefono'] . " -
                    " . $cadenaReporte[0]['email'] . "
                                                     
                </td>
            </tr>
        </table>
    </page_footer>";

$contenidoPagina .= "
<div>
$cuerpo
<br>
</div>
    ";

$contenidoPagina .= "</page>";

$nombre=$_REQUEST['tipoReporte'].$_REQUEST['tipoPlantilla'];
$html2pdf = new HTML2PDF('P', 'LETTER', 'es');
$res = $html2pdf->WriteHTML($contenidoPagina);
$html2pdf->Output($nombre.".pdf", 'D');

} else {
    $sqlReporte = $this->sql->getCadenaSql('obtenerPlantillaReporteporId', $_REQUEST['tipoReporte']);
    $cadenaReporte = $primerRecursoDB->ejecutarAcceso($sqlReporte, "busqueda");
    $cadenaReporte[0]['atributos_persona'] = str_replace("tipo_documento", "tipodocumento", $cadenaReporte[0]['atributos_persona']);
    $cadenaInformacionPersona = 'SELECT ' . $cadenaReporte[0]['atributos_persona'] . ', ';
    $cadenaInformacionPersona.= $cadenaReporte[0]['atributos_vinculacion'] . ',nombre FROM informacionPersona ';
    $cadenaInformacionPersona.= 'WHERE documento=' . $_REQUEST['documento'];
    $informacionPersona = $primerRecursoDB->ejecutarAcceso($cadenaInformacionPersona, "busqueda");
    $cadenaInformacionPreliquidacion = 'SELECT ' . $cadenaReporte[0]['atributos_conceptos'] . ', valor ,naturaleza ';
    $cadenaInformacionPreliquidacion .= 'FROM informacionPreliquidacion ';
    $cadenaInformacionPreliquidacion .= 'WHERE id='.$_REQUEST['preliquidacion'] .' and persona=' . $_REQUEST['documento'] . ' and ( ';
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
    $cadenaInformacionPreliquidacion .= $condicionesdevenga . ' or ';
    $cadenaInformacionPreliquidacion .= $condicionesdeduce . ' );';
    $informacionPreliquidacion = $primerRecursoDB->ejecutarAcceso($cadenaInformacionPreliquidacion, "busqueda");
    
    $contenidoReporte = "<table align='left' class=MsoTableGrid border=0 cellspacing=2 cellpadding=0
                                                style='width:80%;border-collapse:separate;border-spacing:10px 50px;'>";
    $contenidoReporte .= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";
    $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>Vinculacion</strong>: " . $informacionPersona[0]['nombre'] . "</span></p>
                         </td>";
    if (isset($informacionPersona[0]['estado_vinculacion'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-left:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>Estado:</strong> " . $informacionPersona[0]['estado_vinculacion'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['fecha_inicio'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-left:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>F. Inicio:</strong> " . $informacionPersona[0]['fecha_inicio'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['fecha_final'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-left:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>F. Final:</strong> " . $informacionPersona[0]['fecha_final'] . "</span></p>
                         </td>";
    }
    $contenidoReporte.="</tr>";
    $contenidoReporte.= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";
    if (isset($informacionPersona[0]['tipodocumento'])) {
        $contenidoReporte .= "<td text-align:right;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>" . $informacionPersona[0]['tipodocumento'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['documento'])) {
        $contenidoReporte .= "<td text-align:right;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>Documento:</strong> " . $informacionPersona[0]['documento'] . "</span></p>
                         </td>";
    }
    $contenidoReporte.="</tr>";
    $contenidoReporte.= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";
    $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>Nombres:</strong> </span></p>
                         </td>";
    if (isset($informacionPersona[0]['primer_apellido'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>" . $informacionPersona[0]['primer_apellido'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['segundo_apellido'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>" . $informacionPersona[0]['segundo_apellido'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['primer_nombre'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>" . $informacionPersona[0]['primer_nombre'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['segundo_nombre'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>" . $informacionPersona[0]['segundo_nombre'] . "</span></p>
                         </td>";
    }
    $contenidoReporte.="</tr>";
    $contenidoReporte.= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";

    if (isset($informacionPersona[0]['estado_vinculacion_dependencia'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>Dep. Estado: " . $informacionPersona[0]['estado_vinculacion_dependencia'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['gran_contribuyente'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>G. Contribuyente: " . $informacionPersona[0]['gran_contribuyente'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['autorretenedor'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>Autorretenedor: " . substr($informacionPersona[0]['autorretenedor'],1,strlen($informacionPersona[0]['autorretenedor'])-2) . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['regimen_tributario'])) {
       $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>Regimen: " . substr($informacionPersona[0]['regimen_tributario'],1,strlen($informacionPersona[0]['regimen_tributario'])-2) . "</span></p>
                         </td>";
    }
    $contenidoReporte.="</tr>";
    $contenidoReporte.= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";
    if (isset($informacionPersona[0]['modelo_vinculacion'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>M. de Vinculacion:</strong> " . $informacionPersona[0]['modelo_vinculacion'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['numero_contrato'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>N° Contrato:</strong> " . $informacionPersona[0]['numero_contrato'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['actividad'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>Actividad:</strong> " . $informacionPersona[0]['actividad'] . "</span></p>
                         </td>";
    }
    if (isset($informacionPersona[0]['valor_contrato'])) {
        $contenidoReporte .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>V. Contrato:</strong> " . $informacionPersona[0]['valor_contrato'] . "</span></p>
                         </td>";
    }
    $contenidoReporte.="</tr>";
    $contenidoReporte .= "</table>";
    if (isset($informacionPersona[0]['cuerpo'])) {
        $cuerpo = $informacionPersona[0]['cuerpo'];
    }
    else{
        
        $cuerpo="";
    }
    $contenidoConceptosDevenga = "<table align='left' class=MsoTableGrid border=0 cellspacing=2 cellpadding=0
                            style='width:80%;border-collapse:separate;border-spacing:10px 50px;'>";
    $contenidoConceptosDeduce = "<table align='left' class=MsoTableGrid border=0 cellspacing=2 cellpadding=0
                            style='width:80%;border-collapse:separate;border-spacing:10px 50px;'>";
    $sumaDevengos=0;
    $sumaDeducciones=0;
    for ($j = 0; $j < count($informacionPreliquidacion); $j++) {
         if ($informacionPreliquidacion[$j]['naturaleza'] == 'Devenga') {
             $sumaDevengos = $sumaDevengos + $informacionPreliquidacion[$j]['valor'];
             $contenidoConceptosDevenga .="<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";
            for ($k = 0; $k < count($informacionPreliquidacion[$j])/2; $k++) {
                $contenidoConceptosDevenga .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>" . $informacionPreliquidacion[$j][$k] . "</span></p>
                         </td>";
               
            }
            $contenidoConceptosDevenga.="</tr>";
        } else {
            $sumaDeducciones = $sumaDeducciones + $informacionPreliquidacion[$j]['valor'];
            $contenidoConceptosDeduce .="<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";
            for ($k = 0; $k < count($informacionPreliquidacion[$j])/2; $k++) {
                $contenidoConceptosDeduce .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'>" . $informacionPreliquidacion[$j][$k] . "</span></p>
                         </td>";
                
            }
            $contenidoConceptosDeduce.="</tr>";
        }
    }
    $totalPreliquidar = $sumaDevengos-$sumaDeducciones;
    $contenidoConceptosDevenga .= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";
    $contenidoConceptosDevenga .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>Total: </strong>" . $sumaDevengos . "</span></p>
                         </td></tr>";
    $contenidoConceptosDeduce .= "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>";
    $contenidoConceptosDeduce .= "<td text-align:left;>
                            <p class=MsoNormal align=left style='margin-bottom:0cm;margin-bottom:.0001pt;
                            text-align:left;line-height:normal'><span style='font-size:10.0pt;
                            mso-bidi-font-size:11.0pt'><strong>Total: </strong>" .$sumaDeducciones . "</span></p>
                         </td></tr>";
    $contenidoConceptosDevenga .= "</table>";
    $contenidoConceptosDeduce .= "</table>";
    $contenidoPagina = "<page backtop='30mm' backbottom='10mm' backleft='20mm' backright='20mm'>";
    $contenidoPagina .= "<page_header>
        <table align='center' style='width:100%;' border=0>
            <tr>
                <td align='center' style='width:18%;' >
                <img src='" . $cadenaReporte[0]['icono_izquierdo'] . "' width='70' height='70' align='left' /> 
                </td>
                <td align='center' style='width:64%;' >
                    <font style='font-size:18px;'><b>" . $cadenaReporte[0]['titulo_encabezado'] . "</b></font>
                    <br>
                    <font style='font-size:16px;'><b>" . $cadenaReporte[0]['empresa'] . "</b></font>
                    <br>
                    <font style='font-size:12px;'><b>" . $cadenaReporte[0]['otro_encabezado'] . "</b></font>
                    <br>
                    <font style='font-size:12px;'><b>" . $cadenaReporte[0]['fecha_creacion'] . "</b></font>
                </td>
                <td align='center' style='width:18%;' >
                <img src='" . $cadenaReporte[0]['icono_derecho'] . "' width='70' height='70' /> 
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
       <table align='center' width = '100%'>
            <tr>
                <td align='center'>
                    " . $cadenaReporte[0]['titulo_pie'] . "
                    <br>    
                    " . $cadenaReporte[0]['direccion'] . " -
                    " . $cadenaReporte[0]['telefono'] . " -
                    " . $cadenaReporte[0]['email'] . "
                                                     
                </td>
            </tr>
        </table>
    </page_footer>";

$contenidoPagina .= "
<div>
<br>
<h3 align='center'>Informacion de Vinculacion </h3>
<br>
$contenidoReporte
<br>
$cuerpo
<br>
<h3 align='center'>Informacion de Preliquidacion </h3>
<br>
<table border=0.4 px style='width:100%'>
<tr><td>Devengos</td><td>Deducciones</td></tr>
<tr><td>
$contenidoConceptosDevenga
</td><td>
$contenidoConceptosDeduce
</td></tr>
</table>

<h3 align='center'><strong>Total a Preliquidar:$totalPreliquidar </strong></h3>
</div>
    ";

$contenidoPagina .= "</page>";

$nombre=$_REQUEST['tipoReporte'].$_REQUEST['tipoPlantilla'];
$html2pdf = new HTML2PDF('L', 'LETTER', 'es');
$res = $html2pdf->WriteHTML($contenidoPagina,false);
$html2pdf->Output($nombre.".pdf", 'D');
}

?>