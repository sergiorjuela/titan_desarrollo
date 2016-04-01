<?php

namespace bloquesParametro\contenidoActoAdministrativo;

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
            case 'insertarRegistro' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'parametro.acto_administrativo ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nit,';
                $cadenaSql .= 'id_tipo_acto,';
                $cadenaSql .= 'fecha,';
                $cadenaSql .= 'tipo_documento,';
                if ($variable ['fechaExp'] != 'NULL') {
                    $cadenaSql .= 'fecha_efectividad,';
                }
                if ($variable ['fechaVen'] != 'NULL') {
                    $cadenaSql .= 'fecha_caducidad,';
                }
                $cadenaSql .= 'justificacion,';
                $cadenaSql .= 'estado';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= $variable ['nit'] . ', ';
                $cadenaSql .= $variable ['tipo_acto'] . ', ';
                $cadenaSql .= '\'' . $variable ['fecha'] . '\', ';
                $cadenaSql .= '\'' . $variable ['tipoDocumento'] . '\', ';
                if ($variable ['fechaExp'] != 'NULL') {
                    $cadenaSql .= '\'' . $variable ['fechaExp'] . '\', ';
                }
                if ($variable ['fechaVen'] != 'NULL') {
                    $cadenaSql .= '\'' . $variable ['fechaVen'] . '\', ';
                }
                $cadenaSql .= '\'' . $variable ['justificacion'] . '\', ';
                $cadenaSql .= '\'' . 'Activo' . '\' ';
                $cadenaSql .= ') ';
                break;


            case 'buscarRegistroxtipoActo' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.tipo_acto ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id_tipo_acto = ';
                $cadenaSql .= '\'' . $variable . '\'';

                break;
            case 'buscarNit' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nit as NIT ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.acto_administrativo ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nit =' . $variable . ';';
                break;
            case 'buscarRegistroxtipoActoTotal' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_tipo_acto as ID_TIPO_ACTO, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.tipo_acto ';

                break;


            case 'buscarRegistroxAA' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nit as NIT, ';
                $cadenaSql .= 'id_tipo_acto as ID_TIPO_ACTO, ';
                $cadenaSql .= 'estado as ESTADO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.acto_administrativo';
//                        $cadenaSql .= 'WHERE ';
//                        $cadenaSql .= 'nombre=\'' . $_REQUEST ['usuario']  . '\' AND ';
//                        $cadenaSql .= 'clave=\'' . $claveEncriptada . '\' ';

                break;

            case 'buscarModificarxAA' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nit as NIT, ';
                $cadenaSql .= 'id_tipo_acto as ID_TIPO_ACTO, ';
                $cadenaSql .= 'fecha as FECHA,';
                $cadenaSql .= 'tipo_documento as TIPO_DOCUMENTO,';
                $cadenaSql .= 'fecha_efectividad as FECHA_EFECTIVIDAD,';
                $cadenaSql .= 'fecha_caducidad as FECHA_CADUCIDAD, ';
                $cadenaSql .= 'justificacion as JUSTIFICACION ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.acto_administrativo';

                break;


            case 'buscarVerdetallexAA' :

                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nit as NIT, ';
                $cadenaSql .= 'id_tipo_acto as ID_TIPO_ACTO, ';
                $cadenaSql .= 'fecha as FECHA,';
                $cadenaSql .= 'tipo_documento as TIPO_DOCUMENTO,';
                $cadenaSql .= 'fecha_efectividad as FECHA_EFECTIVIDAD,';
                $cadenaSql .= 'fecha_caducidad as FECHA_CADUCIDAD, ';
                $cadenaSql .= 'justificacion as JUSTIFICACION, ';
                $cadenaSql .= 'estado as ESTADO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.acto_administrativo';

                break;

            case 'modificarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'parametro.acto_administrativo ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'id_tipo_acto = ';
                $cadenaSql .= $variable ['tipo_acto'] . ', ';
                $cadenaSql .= 'fecha = ';
                $cadenaSql .= '\'' . $variable ['fecha'] . '\', ';
                $cadenaSql .= 'tipo_documento = ';
                $cadenaSql .= '\'' . $variable ['tipoDocumento'] . '\', ';
                if ($variable ['fechaExp'] != 'NULL') {
                    $cadenaSql .= 'fecha_efectividad = ';
                    $cadenaSql .= '\'' . $variable['fechaExp'] . '\', ';
                }
                if ($variable ['fechaVen'] != 'NULL') {
                    $cadenaSql .= 'fecha_caducidad = ';
                    $cadenaSql .= '\'' . $variable['fechaVen'] . '\', ';
                }
                $cadenaSql .= 'justificacion = ';
                $cadenaSql .= '\'' . $variable['justificacion'] . '\' ';
                $cadenaSql .= ' WHERE ';
                $cadenaSql .= 'nit = ';
                $cadenaSql .= '\'' . $variable ['nit'] . '\'';
                break;

            case 'inactivarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'parametro.acto_administrativo ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'estado = ';
                $cadenaSql .= '\'' . $variable ['estado'] . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nit = ';
                $cadenaSql .= '\'' . $variable ['nit'] . '\'';
                break;
        }



        return $cadenaSql;
    }

}

?>
