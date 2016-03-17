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
    $cuerpo = str_replace("[PRIMER_NOMBRE]", " ".$informacionPersona[0]['primer_nombre']." ", $cadenaReporte[0]['cuerpo']);
    $cuerpo = str_replace("[SEGUNDO_NOMBRE]", " ".$informacionPersona[0]['segundo_nombre']." ", $cuerpo);
    $cuerpo = str_replace("[PRIMER_APELLIDO]", " ".$informacionPersona[0]['primer_apellido']." ", $cuerpo);
    $cuerpo = str_replace("[SEGUNDO_APELLIDO]", " ".$informacionPersona[0]['segundo_apellido']." ", $cuerpo);
    $cuerpo = str_replace("[DOCUMENTO]", " ".$informacionPersona[0]['documento']." ", $cuerpo);
    $cuerpo = str_replace("[TIPO_DOCUMENTO]", " ".$informacionPersona[0]['tipodocumento']." ", $cuerpo);
    $cuerpo = str_replace("[TIPO_VINCULACION]", " ".$informacionPersona[0]['nombre']." ", $cuerpo);
    $cuerpo = str_replace("[FECHA_INICIO]", " ".$informacionPersona[0]['fecha_inicio']." ", $cuerpo);
    $cuerpo = str_replace("[FECHA_FINAL]", " ".$informacionPersona[0]['fecha_final']." ", $cuerpo);
    $cuerpo = str_replace("[NUMERO_CONTRATO]", " ".$informacionPersona[0]['numero_contrato']." ", $cuerpo);
    $cuerpo = str_replace("[ESTADO_VINCULACION]", " ".$informacionPersona[0]['estado_vinculacion']." ", $cuerpo);
    $cuerpo =str_replace("[SEDE]", " ".$informacionPersona[0]['sede']." ", $cuerpo);
    $cuerpo =str_replace("[DEPENDENCIA]", " ".$informacionPersona[0]['dependencia']." ", $cuerpo);
   } else {
    $sqlReporte = $this->sql->getCadenaSql('obtenerPlantillaReporteporId', $_REQUEST['tipoReporte']);
    $cadenaReporte = $primerRecursoDB->ejecutarAcceso($sqlReporte, "busqueda");
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
<font style='font-size:12px; style='text-align: justify;'><p>" .$cuerpo. "</p></font>
</div>
    ";

$contenidoPagina .= "</page>";

$html2pdf = new HTML2PDF('P', 'LETTER', 'es');
$res = $html2pdf->WriteHTML($contenidoPagina);
$html2pdf->Output('resumenUsuario.pdf', 'D');
//$html2pdf->Output('certificado.pdf');
?>