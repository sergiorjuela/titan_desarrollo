<?php

namespace bloquesReporteador\contenidoReporteadorPlanillas;

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
                $cadenaSql .= 'icono_izquierdo,';
                $cadenaSql .= 'icono_derecho,';
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
                $cadenaSql .= '\'' . $variable ['iconoizquierdo'] . '\', ';
                $cadenaSql .= '\'' . $variable ['iconoderecho'] . '\', ';
                $cadenaSql .= $variable ['id'];
                $cadenaSql .= '); ';
                break;
            case 'insertarPlantillaReporte' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'reporteador.plantilla_reporte ';
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
                $cadenaSql .= 'atributos_persona,';
                $cadenaSql .= 'atributos_vinculacion,';
                $cadenaSql .= 'atributos_novedades,';
                $cadenaSql .= 'atributos_conceptos,';
                $cadenaSql .= 'conceptos_devenga,';
                $cadenaSql .= 'conceptos_deduce,';
                $cadenaSql .= 'novedades,';
                $cadenaSql .= 'nomina,';
                $cadenaSql .= 'icono_izquierdo,';
                $cadenaSql .= 'icono_derecho,';
                $cadenaSql .= 'id_plantilla_reporte';
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
                $cadenaSql .= '\'' . $variable ['atributosPersonaHidden'] . '\', ';
                $cadenaSql .= '\'' . $variable ['atributosVinculacionHidden'] . '\', ';
                $cadenaSql .= '\'' . $variable ['atributosNovedadHidden'] . '\', ';
                $cadenaSql .= '\'' . $variable ['atributosConceptodHidden'] . '\', ';
                $cadenaSql .= '\'' . $variable ['DevengosdHidden'] . '\', ';
                $cadenaSql .= '\'' . $variable ['DeduccionesdHidden'] . '\', ';
                $cadenaSql .= '\'' . $variable ['novedadesdHidden'] . '\', ';
                $cadenaSql .= '\'' . $variable ['nomina'] . '\', ';
                $cadenaSql .= '\'' . $variable ['iconoizquierdo'] . '\', ';
                $cadenaSql .= '\'' . $variable ['iconoderecho'] . '\', ';
                $cadenaSql .= $variable ['id'];
                $cadenaSql .= '); ';
                break;

            case 'insertarInformacionGeneral' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'reporteador.plantilla ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'id_plantilla,';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'descripcion,';
                $cadenaSql .= 'tipo,';
                $cadenaSql .= 'estado';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= $variable ['id'] . ",";
                $cadenaSql .= '\'' . $variable ['nombrePlantilla'] . '\', ';
                $cadenaSql .= '\'' . $variable ['descripcionPlantilla'] . '\', ';
                $cadenaSql .= '\'' . $variable ['tipoPlantilla'] . '\', ';
                $cadenaSql .= '\'' . $variable ['estado'] . "'";
                $cadenaSql .= '); ';
                break;

            case 'obtenerPlantillaCertificadoporId' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'empresa, ';
                $cadenaSql .= 'titulo_encabezado, ';
                $cadenaSql .= 'cuerpo, ';
                $cadenaSql .= 'titulo_pie, ';
                $cadenaSql .= 'email, ';
                $cadenaSql .= 'direccion, ';
                $cadenaSql .= 'otro_pie, ';
                $cadenaSql .= 'telefono, ';
                $cadenaSql .= 'numero_firmas, ';
                $cadenaSql .= 'fecha_creacion, ';
                $cadenaSql .= 'otro_encabezado, ';
                $cadenaSql .= 'id_plantilla_certificado, ';
                $cadenaSql .= 'icono_izquierdo, ';
                $cadenaSql .= 'icono_derecho, ';
                $cadenaSql .= 'nombre, ';
                $cadenaSql .= 'descripcion, ';
                $cadenaSql .= 'estado, ';
                $cadenaSql .= 'tipo ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla_certificado as rpc, reporteador.plantilla as rp ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'rp.id_plantilla = rpc.id_plantilla_certificado and rp.id_plantilla=' . $variable . ";";
                break;
            case 'obtenerPlantillaReporteporId' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'empresa, ';
                $cadenaSql .= 'titulo_encabezado, ';
                $cadenaSql .= 'cuerpo, ';
                $cadenaSql .= 'titulo_pie, ';
                $cadenaSql .= 'email, ';
                $cadenaSql .= 'direccion, ';
                $cadenaSql .= 'otro_pie, ';
                $cadenaSql .= 'telefono, ';
                $cadenaSql .= 'numero_firmas, ';
                $cadenaSql .= 'fecha_creacion, ';
                $cadenaSql .= 'otro_encabezado, ';
                $cadenaSql .= 'id_plantilla_reporte, ';
                $cadenaSql .= 'atributos_persona, ';
                $cadenaSql .= 'atributos_vinculacion, ';
                $cadenaSql .= 'atributos_novedades, ';
                $cadenaSql .= 'atributos_conceptos, ';
                $cadenaSql .= 'conceptos_devenga, ';
                $cadenaSql .= 'nomina, ';
                $cadenaSql .= 'conceptos_deduce, ';
                $cadenaSql .= 'novedades, ';
                $cadenaSql .= 'nombre, ';
                $cadenaSql .= 'descripcion, ';
                $cadenaSql .= 'estado, ';
                $cadenaSql .= 'icono_izquierdo, ';
                $cadenaSql .= 'icono_derecho, ';
                $cadenaSql .= 'tipo ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla_reporte as rpr, reporteador.plantilla as rp ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'rp.id_plantilla = rpr.id_plantilla_reporte and rp.id_plantilla=' . $variable . ";";
                break;

            case 'consultarRegistrosDePlantilla' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_plantilla as ID, ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'descripcion as DESCP, ';
                $cadenaSql .= 'tipo as TIPO, ';
                $cadenaSql .= 'estado as ESTADO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla';
                break;

            case 'obtenerParametroPersonasAjax' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'text_campo as TEXTO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.campos_certificado ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_campo = ' . $variable . ';';
                break;
            case 'obtenerParametroVinculacionAjax' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'text_campo as TEXTO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.campos_certificado ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_campo = ' . $variable . ';';
                break;

            case 'obtenerOpcionesTipoPlantilla' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_opcion as ID, ';
                $cadenaSql .= 'texto_opcion as TEXTO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.opciones_tipoplantilla ';
                break;

            case 'obtenerOpcionesInfoPersona' :
                $criterio = "'persona'";
                $cadenaSql = "SELECT ";
                $cadenaSql .= "id_campo as ID_CAMPO, ";
                $cadenaSql .= "text_campo as TEXTO ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "reporteador.campos_certificado ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "tipo_campo = " . $criterio . " ;";
                break;
            case 'obtenerOpcionesInfoVinculacion' :
                $criterio = "'vinculacion'";
                $cadenaSql = "SELECT ";
                $cadenaSql .= "id_campo as ID_CAMPO, ";
                $cadenaSql .= "text_campo as TEXTO ";
                $cadenaSql .= "FROM ";
                $cadenaSql .= "reporteador.campos_certificado ";
                $cadenaSql .= "WHERE ";
                $cadenaSql .= "tipo_campo = " . $criterio . " ;";
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

            case 'actualizarPlantillaCertificado' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'reporteador.plantilla_certificado ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'empresa = ';
                $cadenaSql .= '\'' . $variable ['empresa'] . '\', ';
                $cadenaSql .= 'titulo_encabezado = ';
                $cadenaSql .= '\'' . $variable ['tituloEncabezado'] . '\', ';
                $cadenaSql .= 'cuerpo = ';
                $cadenaSql .= '\'' . $variable ['contenidoCertificado'] . '\', ';
                $cadenaSql .= 'titulo_pie = ';
                $cadenaSql .= '\'' . $variable ['tituloPie'] . '\', ';
                $cadenaSql .= 'email = ';
                $cadenaSql .= '\'' . $variable ['email'] . '\', ';
                $cadenaSql .= 'direccion = ';
                $cadenaSql .= '\'' . $variable ['direccion'] . '\', ';
                $cadenaSql .= 'otro_pie = ';
                $cadenaSql .= '\'' . $variable ['otroDatoPie'] . '\', ';
                $cadenaSql .= 'icono_izquierdo = ';
                $cadenaSql .= '\'' . $variable ['iconoIzquiero'] . '\', ';
                $cadenaSql .= 'icono_derecho = ';
                $cadenaSql .= '\'' . $variable ['iconoDerecho'] . '\', ';
                $cadenaSql .= 'telefono = ';
                $cadenaSql .= $variable ['telefono'] . ', ';
                $cadenaSql .= 'numero_firmas = ';
                $cadenaSql .= $variable ['selecNumeroFirmas'] . ', ';
                $cadenaSql .= 'fecha_creacion = ';
                $cadenaSql .= '\'' . $variable ['fechaCreacion'] . '\', ';
                $cadenaSql .= 'otro_encabezado = ';
                $cadenaSql .= '\'' . $variable ['otroDatoEncabezado'] . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_plantilla_certificado = ' . $variable ['id_plantilla'] . ';';
                break;
            case 'actualizarPlantillaReporte' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'reporteador.plantilla_reporte ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'empresa = ';
                $cadenaSql .= '\'' . $variable ['empresa'] . '\', ';
                $cadenaSql .= 'titulo_encabezado = ';
                $cadenaSql .= '\'' . $variable ['tituloEncabezado'] . '\', ';
                $cadenaSql .= 'cuerpo = ';
                $cadenaSql .= '\'' . $variable ['contenidoReporte'] . '\', ';
                $cadenaSql .= 'titulo_pie = ';
                $cadenaSql .= '\'' . $variable ['tituloPie'] . '\', ';
                $cadenaSql .= 'email = ';
                $cadenaSql .= '\'' . $variable ['email'] . '\', ';
                $cadenaSql .= 'direccion = ';
                $cadenaSql .= '\'' . $variable ['direccion'] . '\', ';
                $cadenaSql .= 'otro_pie = ';
                $cadenaSql .= '\'' . $variable ['otroDatoPie'] . '\', ';
                $cadenaSql .= 'icono_izquierdo = ';
                $cadenaSql .= '\'' . $variable ['iconoIzquiero'] . '\', ';
                $cadenaSql .= 'icono_derecho = ';
                $cadenaSql .= '\'' . $variable ['iconoDerecho'] . '\', ';
                $cadenaSql .= 'atributos_persona = ';
                $cadenaSql .= '\'' . $variable ['atributosPersonaHidden'] . '\', ';
                $cadenaSql .= 'atributos_vinculacion = ';
                $cadenaSql .= '\'' . $variable ['atributosVinculacionHidden'] . '\', ';
                $cadenaSql .= 'atributos_novedades = ';
                $cadenaSql .= '\'' . $variable ['atributosNovedadHidden'] . '\', ';
                $cadenaSql .= 'conceptos_devenga = ';
                $cadenaSql .= '\'' . $variable ['DevengosdHidden'] . '\', ';
                $cadenaSql .= 'conceptos_deduce = ';
                $cadenaSql .= '\'' . $variable ['DeduccionesdHidden'] . '\', ';
                $cadenaSql .= 'atributos_conceptos = ';
                $cadenaSql .= '\'' . $variable ['atributosConceptodHidden'] . '\', ';
                $cadenaSql .= 'novedades = ';
                $cadenaSql .= '\'' . $variable ['novedadesdHidden'] . '\', ';
                $cadenaSql .= 'nomina = ';
                $cadenaSql .= '\'' . $variable ['selectNomina'] . '\', ';
                $cadenaSql .= 'telefono = ';
                $cadenaSql .= $variable ['telefono'] . ', ';
                $cadenaSql .= 'numero_firmas = ';
                $cadenaSql .= $variable ['selecNumeroFirmas'] . ', ';
                $cadenaSql .= 'fecha_creacion = ';
                $cadenaSql .= '\'' . $variable ['fechaCreacion'] . '\', ';
                $cadenaSql .= 'otro_encabezado = ';
                $cadenaSql .= '\'' . $variable ['otroDatoEncabezado'] . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_plantilla_reporte = ' . $variable ['id_reporte'] . ';';
                break;

            case 'consultarEstadoPlantilla' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'estado, ';
                $cadenaSql .= 'tipo, ';
                $cadenaSql .= 'nombre ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_plantilla = ' . $variable . ';';
                break;

            case 'actualizarEstado' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'reporteador.plantilla ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'estado= ';
                $cadenaSql .= '\'' . $variable ['estado'] . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_plantilla = ' . $variable ['id_plantilla'] . ';';
                break;
            case 'obtenerNominas' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'codigo_nomina, ';
                $cadenaSql .= 'nombre ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.nomina; ';

                break;
            case 'obtenerAtributosPersona' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'column_name ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'information_schema.columns ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'table_name = \'persona_natural\'  ';
                $cadenaSql .= 'and column_name <> \'id_ubicacion\' ';
                $cadenaSql .= 'and column_name <> \'consecutivo\' ';
                $cadenaSql .= 'and column_name <> \'soporte_documento\' ';
                $cadenaSql .= 'and column_name <> \'estado_solicitud\' ';
                $cadenaSql .= 'and column_name <> \'id_ubicacion\';';
                break;
            case 'obtenerAtributosVinculacion' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'column_name ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'information_schema.columns ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'table_name = \'vinculacion_persona_natural\'  ';
                $cadenaSql .= 'and column_name <> \'id\' ';
                $cadenaSql .= 'and column_name <> \'consecutivo\' ';
                $cadenaSql .= 'and column_name <> \'id_tipo_vinculacion\' ';
                $cadenaSql .= 'and column_name <> \'documento\'; ';
                break;
            case 'obtenerAtributosConcepto' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'column_name ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'information_schema.columns ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'table_name = \'concepto\'  ';
                $cadenaSql .= 'and column_name <> \'id\' ';
                $cadenaSql .= 'and column_name <> \'con_codigo\' ';
                $cadenaSql .= 'and column_name <> \'naturaleza\'; ';
                break;
            case 'obtenerDevengaConcepto' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'codigo, ';
                $cadenaSql .= 'nombre ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'concepto.concepto ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'naturaleza = \'Devenga\';  ';

                break;
            case 'obtenerDeduceConcepto' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'codigo, ';
                $cadenaSql .= 'nombre ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'concepto.concepto ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'naturaleza = \'Deduce\';  ';

                break;
            case 'obtenerRutasArchivoCertificado' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'icono_izquierdo, ';
                $cadenaSql .= 'icono_derecho ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla_certificado ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_plantilla_certificado ='.$variable.';';

                break;
            case 'obtenerRutasArchivoReportes' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'icono_izquierdo, ';
                $cadenaSql .= 'icono_derecho ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla_reporte ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_plantilla_reporte ='.$variable.';';

                break;
            case 'ObtenerConsecutivo' :
                $cadenaSql = 'Select ';
                $cadenaSql .= 'MAX(id_plantilla) AS consecutivo ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.plantilla; ';

                break;
        }


        return $cadenaSql;
    }

}

?>
