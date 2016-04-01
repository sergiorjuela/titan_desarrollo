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
            case 'insertarReporte' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'reporteador.reportes_realizados ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'codigo_reporte, ';
                $cadenaSql .= 'codigo_plantilla, ';
                $cadenaSql .= 'preliquidacion, ';
                $cadenaSql .= 'fecha, ';
                $cadenaSql .= 'documento ';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES';
                $cadenaSql .= '(';
                $cadenaSql .= $variable['id'].', ';
                $cadenaSql .= $variable['codigoReporte'].', ';
                $cadenaSql .= $variable['preliquidacion'].', ';
                $cadenaSql .= '\''.$variable['fecha'].'\', ';
                $cadenaSql .= $variable['documento'].' ';
                $cadenaSql .= '); ';
                
                break;
            case 'obtenerHistoricoReporteId' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'r.codigo_reporte, ';
                $cadenaSql .= 'r.fecha, ';
                $cadenaSql .= 'p.tipo, ';
                $cadenaSql .= 'p.nombre as nombrePlantilla, ';
                $cadenaSql .= 'pn.documento, ';
                $cadenaSql .= 'pn.primer_apellido||\' \'||pn.segundo_apellido||\' \'||pn.primer_nombre||\' \'||pn.segundo_nombre as nombreEmpleado, ';
                $cadenaSql .= 'pl.nombre AS nombrePreliquidacion ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.reportes_realizados r, ';
                $cadenaSql .= 'persona.persona_natural pn, ';
                $cadenaSql .= 'reporteador.plantilla p, ';
                $cadenaSql .= 'liquidacion.preliquidacion pl ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'r.documento = pn.documento and ';
                $cadenaSql .= 'p.id_plantilla=r.codigo_plantilla and ';
                $cadenaSql .= 'pl.id = r.preliquidacion and ';
                $cadenaSql .= 'r.codigo_reporte='.$variable;
            
                
                break;
            case 'obtenerHistoricoCertificadoId' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'r.codigo_reporte, ';
                $cadenaSql .= 'r.fecha, ';
                $cadenaSql .= 'p.tipo, ';
                $cadenaSql .= 'p.nombre as nombrePlantilla, ';
                $cadenaSql .= 'pn.documento, ';
                $cadenaSql .= 'pn.primer_apellido||\' \'||pn.segundo_apellido||\' \'||pn.primer_nombre||\' \'||pn.segundo_nombre as nombreEmpleado ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'reporteador.reportes_realizados r, ';
                $cadenaSql .= 'persona.persona_natural pn, ';
                $cadenaSql .= 'reporteador.plantilla p ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'r.documento = pn.documento and ';
                $cadenaSql .= 'p.id_plantilla=r.codigo_plantilla and ';
                $cadenaSql .= 'r.codigo_reporte='.$variable;
            
                
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
            case 'obtenerPersonasAjax' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'pn.documento, ';
                $cadenaSql .= 'pn.primer_apellido||\' \'||pn.segundo_apellido||\' \'||pn.primer_nombre||\' \'||pn.segundo_nombre as nombre, ';
                $cadenaSql .= 'td.abreviatura ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'persona.persona_natural pn, ';
                $cadenaSql .= 'persona.tipo_documento td ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'pn.tipo_documento = td.tipo_documento ';
                $cadenaSql .= 'AND ';
                $cadenaSql .= 'td.tipo_documento=\''.$variable.'\' ';
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
                $cadenaSql .= 'vpn.ubicacion_sede_dependencia as Ubicacion, ';
                $cadenaSql .= 'ptv.nombre AS vinculacion ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.tipo_vinculacion ptv, ';
                $cadenaSql .= 'persona.persona_natural pn, ';
                $cadenaSql .= 'persona.vinculacion_persona_natural vpn ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'pn.documento = vpn.documento  ';
                $cadenaSql .= 'and vpn.id_tipo_vinculacion = ptv.id; ';
                
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
            case 'obtenerInformacionPersonaCertificado' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'td.nombre||\'(\'||td.abreviatura||\')\' as tipodocumento, ';
                $cadenaSql .= 'pn.documento, ';
                $cadenaSql .= 'pn.primer_apellido, ';
                $cadenaSql .= 'pn.segundo_apellido, ';
                $cadenaSql .= 'pn.primer_nombre, ';
                $cadenaSql .= 'pn.segundo_nombre, ';
                $cadenaSql .= 'ptv.nombre, ';
                $cadenaSql .= 'vpn.fecha_inicio, ';
                $cadenaSql .= 'vpn.fecha_final, ';
                $cadenaSql .= 'vpn.numero_contrato, ';
                $cadenaSql .= 'vpn.estado_vinculacion ';
                $cadenaSql .= 'FROM  ';
                $cadenaSql .= 'parametro.tipo_vinculacion ptv, ';
                $cadenaSql .= 'persona.persona_natural pn, ';
                $cadenaSql .= 'persona.vinculacion_persona_natural vpn, ';
                $cadenaSql .= 'persona.tipo_documento td ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'pn.documento = vpn.documento and ';
                $cadenaSql .= 'vpn.id_tipo_vinculacion = ptv.id and ';
                $cadenaSql .= 'pn.tipo_documento = td.tipo_documento and ';
                $cadenaSql .= 'pn.documento='.$variable.';';
                break;
            case 'obtenerInformacionLeyesCertificado' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'ldn.nombre,\'Entidad Reguladora: \'||ldn.entidad as reglamentacion ';
                $cadenaSql .= 'FROM  ';
                $cadenaSql .= 'parametro.tipo_vinculacion ptv, ';
                $cadenaSql .= 'persona.persona_natural pn, ';
                $cadenaSql .= 'persona.vinculacion_persona_natural vpn, ';
                $cadenaSql .= 'persona.tipo_documento td, ';
                $cadenaSql .= 'parametro.ldnxtipo_vinculacion ldntv, ';
                $cadenaSql .= 'parametro.ley_decreto_norma ldn ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'pn.documento = vpn.documento and ';
                $cadenaSql .= 'vpn.id_tipo_vinculacion = ptv.id and ';
                $cadenaSql .= 'pn.tipo_documento = td.tipo_documento and ';
                $cadenaSql .= 'ldntv.id=ptv.id and ';
                $cadenaSql .= 'ldn.id_ldn=ldntv.id_ldn and ';
                $cadenaSql .= 'pn.documento='.$variable.';'; 
                break;
            case 'obtenerPreliquidaciones' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id, ';
                $cadenaSql .= 'nombre ';
                $cadenaSql .= 'FROM  ';
                $cadenaSql .= 'liquidacion.preliquidacion;  ';
                
                break;
            case 'consultarReportes' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'codigo_reporte, ';
                $cadenaSql .= 'nombre, ';
                $cadenaSql .= 'tipo ';
                $cadenaSql .= 'FROM  ';
                $cadenaSql .= 'reporteador.reportes_realizados r,';
                $cadenaSql .= 'reporteador.plantilla p ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'r.codigo_plantilla = p.id_plantilla; ';
                
                
                break;
            case 'obtenerInformacionPersonaReporte' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'td.nombre||\'(\'||td.abreviatura||\')\' as tipodocumento, ';
                $cadenaSql .= 'pn.documento, ';
                $cadenaSql .= 'pn.primer_apellido, ';
                $cadenaSql .= 'pn.segundo_apellido, ';
                $cadenaSql .= 'pn.primer_nombre, ';
                $cadenaSql .= 'pn.segundo_nombre, ';
                $cadenaSql .= 'vpn.sede, ';
                $cadenaSql .= 'vpn.dependencia, ';
                $cadenaSql .= 'ptv.nombre, ';
                $cadenaSql .= 'vpn.fecha_inicio, ';
                $cadenaSql .= 'vpn.fecha_final, ';
                $cadenaSql .= 'vpn.numero_contrato, ';
                $cadenaSql .= 'pn.gran_contribuyente, ';
                $cadenaSql .= 'pn.autorretenedor, ';
                $cadenaSql .= 'pn.regimen_tributario, ';
                $cadenaSql .= 'vpn.estado_vinculacion_dependencia, ';
                $cadenaSql .= 'vpn.modelo_vinculacion, ';
                $cadenaSql .= 'vpn.valor_contrato, ';
                $cadenaSql .= 'vpn.actividad, ';
                $cadenaSql .= 'vpn.estado_vinculacion ';
                $cadenaSql .= 'FROM  ';
                $cadenaSql .= 'parametro.tipo_vinculacion ptv, ';
                $cadenaSql .= 'persona.persona_natural pn, ';
                $cadenaSql .= 'persona.vinculacion_persona_natural vpn, ';
                $cadenaSql .= 'persona.tipo_documento td ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'pn.documento = vpn.documento and ';
                $cadenaSql .= 'vpn.id_tipo_vinculacion = ptv.id and ';
                $cadenaSql .= 'pn.tipo_documento = td.tipo_documento and ';
                $cadenaSql .= 'pn.documento='.$variable.';';
                break;
        }


        return $cadenaSql;
    }

}

?>
