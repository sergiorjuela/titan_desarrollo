<?php

namespace bloquesLiquidacion\tipoNomina;

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
            case 'buscarTipoVinculacion':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id as ID, ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'descripcion as DESCRIPCION, ';
                $cadenaSql .= 'naturaleza as NATURALEZA, ';
                $cadenaSql .= 'reglamentacion as REGLAMENTACION ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.tipo_vinculacion';
           break;
            
            case 'buscarNomina':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'codigo_nomina as CODIGO_NOMINA, ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'descripcion as DESCRIPCION, ';
                $cadenaSql .= 'estado as ESTADO, ';
                $cadenaSql .= 'periodo as PERIODO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.nomina ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id = ';
                $cadenaSql .= $variable ['id'] . '';
           break;
       case 'buscarNominaAlterno':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'codigo_nomina as CODIGO_NOMINA ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.nomina ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'nombre = ';
                $cadenaSql .= '\'' . $variable['nombreNomina'] .   '\' ';
           break;

       
       case 'buscarNominaxregistro':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'codigo_nomina as CODIGO_NOMINA, ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'tipo_nomina as TIPO_NOMINA, ';
                $cadenaSql .= 'periodo as PERIODO, ';
                $cadenaSql .= 'estado as ESTADO, ';
                $cadenaSql .= 'descripcion as DESCRIPCION ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.nomina ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'codigo_nomina = ';
                $cadenaSql .= $variable;
           break;
       case 'buscarNominaxregistroMod':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'codigo_nomina as CODIGO_NOMINA, ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'tipo_nomina as TIPO_NOMINA, ';
                $cadenaSql .= 'periodo as PERIODO, ';
                $cadenaSql .= 'estado as ESTADO, ';
                $cadenaSql .= 'descripcion as DESCRIPCION ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.nomina ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'id = ';
                $cadenaSql .= $variable . '';
           break;
       case 'buscarTipoVinculacionDetalle':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id as ID, ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'descripcion as DESCRIPCION, ';
                $cadenaSql .= 'naturaleza as NATURALEZA, ';
                $cadenaSql .= 'reglamentacion as REGLAMENTACION, ';
                $cadenaSql .= 'estado as ESTADO ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.tipo_vinculacion';
           break;
       
            case 'insertarRegistro' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'parametro.cargo ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nivel,';
                $cadenaSql .= 'codigo_alternativo,';
                $cadenaSql .= 'grado,';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'cod_tipo_cargo,';
                $cadenaSql .= 'sueldo,';
                $cadenaSql .= 'tipo_sueldo,';
                $cadenaSql .= 'estado';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= $variable ['nivelRegistro'] . ', ';
                $cadenaSql .= $variable ['codAlternativoRegistro'] . ', ';
                $cadenaSql .= $variable ['gradoRegistro'] . ', ';
                $cadenaSql .= '\'' . $variable ['nombreRegistro']  . '\', ';
                $cadenaSql .= '\'' . $variable ['codTipoCargoRegistro'] . '\', ';
                $cadenaSql .= $variable ['sueldoRegistro'] . ', ';
                $cadenaSql .= '\'' . $variable['tipoSueldoRegistro'] . '\', ';
                $cadenaSql .= '\'' . $variable['estadoRegistro'] . '\' ';
                $cadenaSql .= ') ';
            break;
            
            case 'insertarRegistroNomina' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'liquidacion.nomina ';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= 'descripcion,';
                $cadenaSql .= 'tipo_nomina,';
                $cadenaSql .= 'estado,';
                $cadenaSql .= 'periodo,';
                $cadenaSql .= 'id';
                $cadenaSql .= ') ';
                $cadenaSql .= 'VALUES ';
                $cadenaSql .= '( ';
                $cadenaSql .= '\'' . $variable ['nombreNomina']  . '\', ';
                $cadenaSql .= '\'' . $variable ['descripcionNomina'] . '\', ';
                $cadenaSql .= '\'' . $variable['tipoNomina'] . '\', ';
                $cadenaSql .= '\'' . $variable['estadoRegistroNomina'] . '\', ';
                $cadenaSql .= '\'' . $variable['periodo'] . '\', ';
                $cadenaSql .= $variable ['id'] . '';
                $cadenaSql .= ') ';
                break;
              case 'buscarRegistroxLEY' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'id_ldn as ID_LDN, ';
                        $cadenaSql .= 'nombre as NOMBRE ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'parametro.ley_decreto_norma ';
//                        $cadenaSql .= 'WHERE ';
//                        $cadenaSql .= 'nombre=\'' . $_REQUEST ['usuario']  . '\' AND ';
//                        $cadenaSql .= 'clave=\'' . $claveEncriptada . '\' ';
                break;
          
                case 'insertarLeyesNomina' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= 'liquidacion.ldnxnomina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'codigo_nomina,';
				$cadenaSql .= 'id_ldn';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= $variable ['fk_nomina'] . ', ';
				$cadenaSql .= $variable ['fk_id_ley'];
				$cadenaSql .= '); ';
				break;
             case 'buscarRegistroxCargo' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'codigo_cargo as COD_CARGO, ';
                        $cadenaSql .= 'nivel as NIVEL, ';
                        $cadenaSql .= 'codigo_alternativo as COD_ALTERNATIVO,';
                        $cadenaSql .= 'grado as GRADO,';
                        $cadenaSql .= 'nombre as NOMBRE,';
                        $cadenaSql .= 'cod_tipo_cargo as COD_TIPO, ';
                        $cadenaSql .= 'estado as ESTADO ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'parametro.cargo';
//                        $cadenaSql .= 'WHERE ';
//                        $cadenaSql .= 'nombre=\'' . $_REQUEST ['usuario']  . '\' AND ';
//                        $cadenaSql .= 'clave=\'' . $claveEncriptada . '\' ';
                        
                break;
                	case 'eliminarLeyesModificar' :
				$cadenaSql = 'DELETE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.ldnxnomina ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo_nomina = ' . $variable ['fk_nomina'] . ';';
				break;
				
                case 'buscarModificarxCargo' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'codigo_cargo as COD_CARGO, ';
                        $cadenaSql .= 'nivel as NIVEL, ';
                        $cadenaSql .= 'codigo_alternativo as COD_ALTERNATIVO,';
                        $cadenaSql .= 'grado as GRADO,';
                        $cadenaSql .= 'nombre as NOMBRE,';
                        $cadenaSql .= 'cod_tipo_cargo as COD_TIPO, ';
                        $cadenaSql .= 'sueldo as SUELDO, ';
                        $cadenaSql .= 'tipo_sueldo as TIPO_SUELDO ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'parametro.cargo';
                        
                break;
            
            
            case 'buscarVerdetallexCargo' :
                
                	$cadenaSql = 'SELECT ';
                        $cadenaSql .= 'codigo_cargo as COD_CARGO, ';
                        $cadenaSql .= 'nivel as NIVEL, ';
                        $cadenaSql .= 'codigo_alternativo as COD_ALTERNATIVO,';
                        $cadenaSql .= 'grado as GRADO,';
                        $cadenaSql .= 'nombre as NOMBRE,';
                        $cadenaSql .= 'cod_tipo_cargo as COD_TIPO, ';
                        $cadenaSql .= 'sueldo as SUELDO, ';
                        $cadenaSql .= 'tipo_sueldo as TIPO_SUELDO, ';
                        $cadenaSql .= 'estado as ESTADO ';
                        $cadenaSql .= 'FROM ';
                        $cadenaSql .= 'parametro.cargo';
                        
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
    case 'consultarLeyesDeNomina' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'codigo_nomina as CODIGO, ';
				$cadenaSql .= 'id_ldn as ID ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.ldnxnomina ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo_nomina = ' . $variable . '';
				break;
				
           case 'modificarRegistroxnomina' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'liquidacion.nomina ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'nombre = ';
                $cadenaSql .= '\'' . $variable ['nombreNomina']  . '\', ';
                $cadenaSql .= 'descripcion = ';
                $cadenaSql .= '\'' . $variable ['descripcionNomina']  . '\', ';
                $cadenaSql .= 'tipo_nomina = ';
                $cadenaSql .= '\'' . $variable ['tipoNomina']  . '\', ';
                $cadenaSql .= 'estado = ';
                $cadenaSql .= '\'' . $variable ['estadoRegistroNomina']  . '\', ';
                $cadenaSql .= 'periodo = ';
                $cadenaSql .= '\'' . $variable ['periodo']  . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'codigo_nomina = ';
                $cadenaSql .= '\'' . $variable ['codigoNomina']  . '\'';              
             break;
                
             case 'inactivarRegistro' :
                $cadenaSql = 'UPDATE ';
                $cadenaSql .= 'liquidacion.nomina ';
                $cadenaSql .= 'SET ';
                $cadenaSql .= 'estado = ';
                $cadenaSql .= '\'' . $variable ['estadoRegistroNomina']  . '\' ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'codigo_nomina = ';
                $cadenaSql .= '\'' . $variable ['codigoNomina']  . '\'';
            break;
        
        case 'buscarley' :
               $cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ldn as ID, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.ley_decreto_norma ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estado != \'Inactivo\';';
            break;
        
        }
        
       
        
        return $cadenaSql;
    
    }
}
?>
