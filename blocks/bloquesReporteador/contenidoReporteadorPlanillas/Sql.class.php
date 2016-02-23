<?php

namespace bloquesReporteador\contenidoReporteadorPlanillas;

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
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
        $prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
        $idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
        $cadenaSql='';
        switch ($tipo) {
            
            /**
             * Clausulas específicas
             */
            case 'insertarConcepto' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'concepto.concepto ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'simbolo,';
                $cadenaSql .= 'estado,';
                $cadenaSql .= 'id,';
                $cadenaSql .= 'naturaleza,';
                $cadenaSql .= 'descripcion,';
                $cadenaSql .= 'formula';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= '\'' . $variable ['nombre']  . '\', ';
                $cadenaSql .= '\'' . $variable ['simbolo']  . '\', ';
                $cadenaSql .= '\'Activo\', ';
                $cadenaSql .= $variable ['categoria'] . ', ';
                $cadenaSql .= '\'' . $variable ['naturaleza'] . '\', ';
                $cadenaSql .= '\'' . $variable ['descripcion'] . '\', ';
                $cadenaSql .= '\'' . $variable ['formula'] . '\' ';
                $cadenaSql .= ') ';
                $cadenaSql .= "RETURNING  codigo; ";
                break;
                
			case 'insertarLeyesConcepto' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= 'concepto.ldnxconcepto ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'id_ldn,';
				$cadenaSql .= 'codigo';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= $variable ['fk_id_ley'] . ', ';
				$cadenaSql .= $variable ['fk_concepto'];
				$cadenaSql .= '); ';
				break;
				
			case 'insertarCondicion' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= 'concepto.condicion ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'codigo,';
				$cadenaSql .= 'cadena';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= $variable ['fk_concepto'] . ', ';
				$cadenaSql .= '\'' . $variable ['cadena']  . '\' ';
				$cadenaSql .= '); ';
				break;
                
            case 'buscarRegistroxParametro' :      
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id as ID, ';
                $cadenaSql .= 'simbolo as SIMBOLO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.parametro_liquidacion';        
                break;
                
			case 'buscarRegistroxConcepto' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'codigo as ID, ';
				$cadenaSql .= 'simbolo as SIMBOLO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.concepto';
				break;
				
			case 'buscarLey' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ldn as ID, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.ley_decreto_norma ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estado != \'Inactivo\';';
				break;
				
			case 'buscarCategoria' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.categoria ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estado != \'Inactivo\';';
				break;
				
			case 'buscarParametroAjax' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID_CATEGORIA, ';
				$cadenaSql .= 'simbolo as SIMBOLO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.parametro_liquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_categoria = ' . $variable . ';';
				break;
				
			case 'buscarConceptoAjax' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'codigo as ID, ';
				$cadenaSql .= 'simbolo as SIMBOLO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.concepto ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ' . $variable . ';';
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
				
			case 'consultarRegistrosDePlantillaConFiltro' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_plantilla as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCP, ';
				$cadenaSql .= 'tipo as TIPO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'reporteador.plantilla ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_plantilla = ' . $variable . ';';
				break;
				
			case 'obtenerOpcionesTipoPlantilla' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_opcion as ID, ';
				$cadenaSql .= 'texto_opcion as TEXTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'reporteador.opciones_tipoplantilla ';
				break;
				
			case 'consultarLeyesDeConceptos' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ldn as ID, ';
				$cadenaSql .= 'codigo as CODIGO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.ldnxconcepto ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo = ' . $variable . ';';
				break;
				
			case 'inactivarRegistro' :
				$cadenaSql = 'UPDATE ';
				$cadenaSql .= 'concepto.concepto ';
				$cadenaSql .= 'SET ';
				$cadenaSql .= 'estado = ';
				$cadenaSql .= '\'' . $variable ['estadoRegistro'] . '\' ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'simbolo = ';
				$cadenaSql .= '\'' . $variable ['simbolo'] . '\'';
				break;
				
			case 'modificarConcepto' :
				$cadenaSql = 'UPDATE ';
				$cadenaSql .= 'concepto.concepto ';
				$cadenaSql .= 'SET ';
				$cadenaSql .= 'nombre = ';
				$cadenaSql .= '\'' . $variable ['nombre'] . '\', ';
				$cadenaSql .= 'simbolo = ';
				$cadenaSql .= '\'' . $variable ['simbolo'] . '\', ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= $variable ['categoria'] . ', ';
				$cadenaSql .= 'naturaleza = ';
				$cadenaSql .= '\'' . $variable ['naturaleza'] . '\', ';
				$cadenaSql .= 'descripcion = ';
				$cadenaSql .= '\'' . $variable ['descripcion'] . '\', ';
				$cadenaSql .= 'formula = ';
				$cadenaSql .= '\'' . $variable ['formula'] . '\' ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo = ' . $variable ['id_concepto'] . ';';
				break;
				
			case 'eliminarLeyesModificar' :
				$cadenaSql = 'DELETE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.ldnxconcepto ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo = ' . $variable ['fk_concepto'] . ';';
				break;
				
			case 'eliminarCondicionesModificar' :
				$cadenaSql = 'DELETE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.condicion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo = ' . $variable ['fk_concepto'] . ';';
				break;
        }
                
        
        return $cadenaSql;
    
    }
}
?>
