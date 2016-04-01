<?php
namespace bloquesConcepto\contenidoConcepto;
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
				
			case 'buscarLeyXConcepto' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ldn as ID, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.ley_decreto_norma ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_ldn = ' . $variable .' ';
				$cadenaSql .= 'AND estado != \'Inactivo\';';
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
				
			case 'buscarCategoriaConcepto' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.categoria ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estado != \'Inactivo\';';
				break;
				
			case 'buscarCategoriaParametro' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_categoria as ID, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.categoria_parametro ';
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
				$cadenaSql .= 'id_categoria = ' . $variable .' ';
				$cadenaSql .= 'AND estado != \'Inactivo\';';
				break;
				
			case 'buscarConceptoAjax' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'codigo as ID, ';
				$cadenaSql .= 'simbolo as SIMBOLO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.concepto ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ' . $variable .' ';
				$cadenaSql .= 'AND estado != \'Inactivo\';';
				break;
				
			case 'buscarValorParametroAjax' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'valor as VALOR ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.parametro_liquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ' . $variable . ';';
				break;
			
			case 'buscarValorConceptoAjax' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'formula as FORMULA ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.concepto ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo = ' . $variable . ';';
				break;
				
			case 'buscarRegistrosDeConceptos' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'simbolo as SIMBOLO, ';
				$cadenaSql .= 'descripcion as DESCRIPCION, ';
				$cadenaSql .= 'simbolo as LEY, ';
				$cadenaSql .= 'naturaleza as NATURALEZA, ';
				$cadenaSql .= 'estado as ESTADO, ';
				$cadenaSql .= 'codigo as ID ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.concepto';
				break;
				
			case 'consultarRegistrosDeConceptos' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'codigo as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'simbolo as SIMBOLO, ';
				$cadenaSql .= 'naturaleza as NATURALEZA, ';
				$cadenaSql .= 'descripcion as DESCRIPCION, ';
				$cadenaSql .= 'id as CATEGORIA, ';
				$cadenaSql .= 'formula as FORMULA, ';
				$cadenaSql .= 'estado as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.concepto ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo = ' . $variable . ';';
				break;
				
			case 'consultarCondicionesDeConceptos' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'cadena as CADENA, ';
				$cadenaSql .= 'codigo as CODIGO, ';
				$cadenaSql .= 'id_condicion as ID ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.condicion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo = ' . $variable . ';';
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
			case 'buscarVariables' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'simbolo as SIMBOLO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.variable ';
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
