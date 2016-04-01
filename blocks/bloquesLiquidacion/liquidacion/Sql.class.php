<?php

namespace bloquesModelo\bloqueContenido;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros.
 * Utilizar mecanismos para - independiente del motor de bases de datos,
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
		$cadenaSql = '';
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			case 'insertarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= 'liquidacion.liquidacion ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'preliquidacion,';
				$cadenaSql .= 'usuario_genero,';
				$cadenaSql .= 'estado';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $variable ['nombre'] . '\', ';
				$cadenaSql .= '\'' . $variable ['descripcion'] . '\', ';
				$cadenaSql .= $variable ['preliquidacion'] . ', ';
				$cadenaSql .= '\'' . 'Administrador' . '\', ';
				$cadenaSql .= '\'' . 'Pendiente' . '\' ';
				$cadenaSql .= ') ';
				break;
			
			case 'buscarPreliquidacion' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.preliquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'estado= \'Activo\'' . ' ';
				$cadenaSql .= 'order by fecha desc';
				// $cadenaSql .= 'clave=\'' . $claveEncriptada . '\' ';
				
				break;
			
			case 'buscarRegistros' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION, ';
				$cadenaSql .= 'preliquidacion as PRELIQUIDACION, ';
				$cadenaSql .= 'estado as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.liquidacion ';
				break;
			
			case 'buscarNomina' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'tipo_nomina as NOMINA, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.preliquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= '\'' . $variable ['codigoRegistro'] . '\'';
				break;
			
			case 'buscarNominaNombre' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.nomina ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'codigo_nomina = ';
				$cadenaSql .= '\'' . $variable ['codigoRegistro'] . '\'';
				break;
			
			case 'buscarRegistrosxID' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION, ';
				$cadenaSql .= 'preliquidacion as PRELIQUIDACION, ';
				$cadenaSql .= 'estado as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.liquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= '\'' . $variable ['codigoRegistro'] . '\'';
				break;
			
			case 'buscarRegistrosxIDCompletos' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION, ';
				$cadenaSql .= 'preliquidacion as PRELIQUIDACION, ';
				$cadenaSql .= 'usuario_genero as USUARIO, ';
				$cadenaSql .= 'estado as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.liquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= '\'' . $variable ['codigoRegistro'] . '\'';
				break;
			
			case 'buscarRegistrosDetalle' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'persona as PERSONA, ';
				$cadenaSql .= 'valor as VALOR, ';
				$cadenaSql .= 'concepto as CONCEPTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.detalle_preliquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'preliquidacion = ';
				$cadenaSql .= '\'' . $variable ['codigoRegistro'] . '\'';
				break;
			
			case 'buscarConceptoxPers' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'concepto as CONCEPTO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.detalle_preliquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'persona = ';
				$cadenaSql .= $variable ['codigoRegistro'];
				break;
			
			case 'buscarFechas' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'fecha_inicio as FECHA, ';
				$cadenaSql .= 'fecha_fin as FEECHA ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'liquidacion.preliquidacion ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= '\'' . $variable ['id_preliquidacion'] . '\'';
				break;
			
			case 'modificarRegistro' :
				$cadenaSql = 'UPDATE ';
				$cadenaSql .= 'liquidacion.liquidacion ';
				$cadenaSql .= 'SET ';
				$cadenaSql .= 'estado = ';
				$cadenaSql .= '\'' . $variable ['estado'] . '\'';
				$cadenaSql .= ' WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= $variable ['codigo'];
				break;
		}
		
		return $cadenaSql;
	}
}
?>
