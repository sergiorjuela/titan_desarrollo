<?php

namespace bloquesReporteador\contenidoReporteadorReportes;

if (!isset($GLOBALS ["autorizado"])) {
    include ("../index.php");
    exit();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros. Utilizar mecanismos para - independiente del motor de bases de datos,
 * poder realizar rollbacks gestionados por el aplicativo.
 */
class Sql extends \Sql {

    var $miConfigurador;

    function getCadenaSql($tipo, $variable = '') {
        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");
        $cadenaSql = '';
        switch ($tipo) {

            /**
             * Clausulas específicas
             */
            case 'insertarPlantillaCertificado' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'reporteador.plantilla_certificado ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'empresa,';
                $cadenaSql .= 'titulo_encabezado,';
                $cadenaSql .= 'cuerpo,';
                $cadenaSql .= 'titulo_pie,';
                $cadenaSql .= 'email,';
                $cadenaSql .= 'direccion,';
                $cadenaSql .= 'otro_pie,';
                $cadenaSql .= 'telefono,';
                $cadenaSql .= 'numero_firmas,';
                $cadenaSql .= 'fecha_creacion,';
                $cadenaSql .= 'otro_encabezado,';
                $cadenaSql .= 'imagen_1,';
                $cadenaSql .= 'imagen_2,';
                $cadenaSql .= 'id_plantilla_certificado';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= '\'' . $variable ['empresa'] . '\', ';
                $cadenaSql .= '\'' . $variable ['tituloEncabezado'] . '\', ';
                $cadenaSql .= '\'' . $variable ['contenidoCertificado'] . '\', ';
                $cadenaSql .= '\'' . $variable ['tituloPie'] . '\', ';
                $cadenaSql .= '\'' . $variable ['email'] . '\', ';
                $cadenaSql .= '\'' . $variable ['direccion'] . '\', ';
                $cadenaSql .= '\'' . $variable ['otroDatoPie'] . '\', ';
                $cadenaSql .= $variable ['telefono'] . ",";
                $cadenaSql .= $variable ['selecNumeroFirmas'] . ', ';
                $cadenaSql .= '\'' . $variable ['fechaCreacion'] . '\', ';
                $cadenaSql .= '\'' . $variable ['otroDatoEncabezado'] . '\', ';
                $cadenaSql .= '\'' . $variable ['imagen1'] . '\', ';
                $cadenaSql .= '\'' . $variable ['imagen2'] . '\', ';
                $cadenaSql .= $variable ['id'];
                $cadenaSql .= '); ';
                break;

            case 'consultarPlantillasParaReportes' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'r.codigo_reporte, ';
                $cadenaSql .= 'p.nombre, ';
                $cadenaSql .= 'p.tipo ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla p, ';
                $cadenaSql .= 'reporteador.reporte r ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'p.id_plantilla = r.reporte;';
                break;
            case 'obtenerOpcionesTipoPlantilla' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_opcion, ';
                $cadenaSql .= 'texto_opcion ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.opciones_tipoplantilla';
                break;
            case 'obtenerRepotesAjax' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_plantilla, ';
                $cadenaSql .= 'nombre ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'tipo=\''.$variable.'\' ';
                $cadenaSql .= 'AND ';
                $cadenaSql .= 'estado=\'Activo\'';
                break;
            case 'obtenerReportes' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_plantilla, ';
                $cadenaSql .= 'nombre ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla ';
            break;
            case 'obtenerTiposDocumentos' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'tipo_documento, ';
                $cadenaSql .= 'abreviatura ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'persona.tipo_documento ';
            break;
            case 'consultarPersonasParaReportes' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'pn.documento, ';
                $cadenaSql .= 'pn.primer_apellido||\' \'||pn.segundo_apellido||\' \'||pn.primer_nombre||\' \'||pn.segundo_nombre as nombre, ';
                $cadenaSql .= '\'Sede:\'||vpn.sede||\'(\'|| vpn.dependencia||\')\' as Ubicacion, ';
                $cadenaSql .= 'ptv.nombre AS vinculacion ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.tipo_vinculacion ptv, ';
                $cadenaSql .= 'persona.persona_natural pn, ';
                $cadenaSql .= 'persona.vinculacion_persona_natural vpn ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'pn.documento = vpn.documento  ';
                $cadenaSql .= 'and vpn.id_tipo_vinculacion = ptv.id; ';
                
            break;


            case 'actualizarInformacionGeneral' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'reporteador.plantilla ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'nombre = ';
                $cadenaSql .= '\'' . $variable ['nombrePlantilla'] . '\', ';
                $cadenaSql .= 'descripcion = ';
                $cadenaSql .= '\'' . $variable ['descripcionPlantilla'] . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_plantilla = ';
                $cadenaSql .= $variable ['id_plantilla'] . ';';
                break;
        }


        return $cadenaSql;
    }

}

?>
