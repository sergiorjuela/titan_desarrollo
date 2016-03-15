<?php

namespace bloquesParametro\parametroLiquidacion;

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
            case 'buscarParametroLiquidacion':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'b.nombre as NOMBRE, ';
                $cadenaSql .= 'simbolo as SIMBOLO, ';
                $cadenaSql .= 'descripcion as DESCRIPCION   , ';
                $cadenaSql .= 'valor as VALOR, ';
                $cadenaSql .= 'b.estado as ESTADO, ';
                $cadenaSql .= 'id ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.parametro_liquidacion b ';

                break;
            case 'buscarParametroPorId':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nombre, ';
                $cadenaSql .= 'simbolo, ';
                $cadenaSql .= 'descripcion, ';
                $cadenaSql .= 'valor, ';
                $cadenaSql .= 'estado, ';
                $cadenaSql .= 'id_categoria ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.parametro_liquidacion ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id=' . $variable . ';';

                break;

            case 'buscarCategoria':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_categoria, ';
                $cadenaSql .= 'nombre ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.categoria_parametro;';
                break;

            case 'modificarParametro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'parametro.parametro_liquidacion ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'nombre = ';
                $cadenaSql .= "'" . $variable ['nombre'] . "',";
                $cadenaSql .= 'simbolo = ';
                $cadenaSql .= "'" . $variable ['simbolo'] . "',";
                $cadenaSql .= 'id_categoria = ';
                $cadenaSql .= $variable ['categoriaParametro'] . ",";
                $cadenaSql .= 'descripcion = ';
                $cadenaSql .= "'" . $variable ['descripcion'] . "', ";
                $cadenaSql .= 'valor = ';
                $cadenaSql .= $variable ['valor'];
                $cadenaSql .= ' WHERE ';
                $cadenaSql .= 'id = ';
                $cadenaSql .= $variable ['id'] . ';';
                break;

            case 'inactivarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'parametro.parametro_liquidacion ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'estado = ';
                $cadenaSql .= "'" . $variable ['estadoRegistro'] . "' ";
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id = ';
                $cadenaSql .= $variable ['codigoRegistro'] . ";";
                break;

            case 'actualizarRegistro' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= $prefijo . 'pagina ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'descripcion,';
                $cadenaSql .= 'modulo,';
                $cadenaSql .= 'nivel,';
                $cadenaSql .= 'parametro';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
                $cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
                $cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
                $cadenaSql .= ') ';
                break;

                break;

            case 'borrarRegistro' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= $prefijo . 'pagina ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'descripcion,';
                $cadenaSql .= 'modulo,';
                $cadenaSql .= 'nivel,';
                $cadenaSql .= 'parametro';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
                $cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
                $cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
                $cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
                $cadenaSql .= ') ';
                break;
            case 'buscarLey' ://Provisionalmente solo Departamentos de Colombia
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_ldn as ID, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.ley_decreto_norma ';
                break;
            case 'eliminarLeyesModificar' ://Provisionalmente solo Departamentos de Colombia
                $cadenaSql = 'DELETE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.ldnxparametro ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id='.$variable;
                break;
            
            case 'obtenerLeyesParametroPorId' ://Provisionalmente solo Departamentos de Colombia
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'b.id_ldn ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.parametro_liquidacion a, ';
                $cadenaSql .= 'parametro.ldnxparametro b, ';
                $cadenaSql .= 'parametro.ley_decreto_norma c ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'a.id = b.id and ';
                $cadenaSql .= 'b.id_ldn = c.id_ldn and ';
                $cadenaSql .= 'a.id='.$variable;
                break;
            case 'obtenerNombresLeyesParametroPorId' ://Provisionalmente solo Departamentos de Colombia
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'c.nombre, ';
                $cadenaSql .= 'c.fecha_ven ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.parametro_liquidacion a, ';
                $cadenaSql .= 'parametro.ldnxparametro b, ';
                $cadenaSql .= 'parametro.ley_decreto_norma c ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'a.id = b.id and ';
                $cadenaSql .= 'b.id_ldn = c.id_ldn and ';
                $cadenaSql .= 'a.id='.$variable;
                break;
            
            case 'registrarLeyesParametroLiquidacion' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'parametro.ldnxparametro ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'id, ';
                $cadenaSql .= 'id_ldn ';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES( ';
                $cadenaSql .= "currval('parametro.secuencia_parametro_liquidacion'), ";
                $cadenaSql .= $variable . " ";
                $cadenaSql .= ");";

                break;
            case 'ActualizarLeyesParametroLiquidacion' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'parametro.ldnxparametro ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'id, ';
                $cadenaSql .= 'id_ldn ';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES( ';
                $cadenaSql .= $variable['id'] .", ";
                $cadenaSql .= $variable['idLey'] . " ";
                $cadenaSql .= ");";

                break;


            case "registrarParametroLiquidacion" :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'parametro.parametro_liquidacion ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'id, ';
                $cadenaSql .= 'nombre, ';
                $cadenaSql .= 'simbolo, ';
                $cadenaSql .= 'descripcion, ';
                $cadenaSql .= 'valor, ';
                $cadenaSql .= 'estado, ';
                $cadenaSql .= 'id_categoria ';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= $variable ['id'] . ', ';
                $cadenaSql .= '\'' . $variable ['nombre'] . '\', ';
                $cadenaSql .= '\'' . $variable ['simbolo'] . '\', ';
                $cadenaSql .= '\'' . $variable ['descripcion'] . '\', ';
                $cadenaSql .= $variable ['valor'] . ', ';
                $cadenaSql .= '\'' . $variable ['estado'] . '\', ';
                $cadenaSql .= $variable ['categoriaParametro'] . ' ';
                $cadenaSql .= '); ';

                break;
        }

        return $cadenaSql;
    }

}

?>
