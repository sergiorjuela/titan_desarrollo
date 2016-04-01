<?php

namespace bloquesPersona\personaNatural;

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
			case 'insertarNivel' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= 'parametro.nivel_cargo ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'estado, ';
				$cadenaSql .= 'identificador ';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $variable ['nombre'] . '\'' . ', ';
				$cadenaSql .= '\'' . 'Activo'. '\'' . ', ';
				$cadenaSql .= '\'' . $variable ['nivel'] . '\'';
				$cadenaSql .= ') ';

				break;
			
					
			
			
			case 'buscarRegistroxActivo' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'estado as ESTADO, ';
				$cadenaSql .= 'identificador as IDENTIFICADOR ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.nivel_cargo ';
// 				$cadenaSql .= 'WHERE ';
// 				$cadenaSql .= 'ESTADO=\'' . 'Activo' . '\'';
				// $cadenaSql .= 'ESTADO=\'' . 'rechazada' . '\' ';
				
				break;
			
			case 'buscarVerdetallexCategoria' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'estado as ESTADO, ';
				$cadenaSql .= 'identificador as IDENTIFICADOR ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.nivel_cargo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= $variable ['id'];
				break;
			
			case 'buscarIDLey' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ldn as ID_LDN ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.categxldn ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= $variable ['id'];
				break;
			
			case 'buscarley' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.ley_decreto_norma ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_ldn = ';
				$cadenaSql .= '\'' . $variable ['id'] . '\'';
				break;
			
			case 'buscar_ley' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ldn as ID, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.ley_decreto_norma';
				break;
			
			case 'buscarModificarxPersona' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'documento as DOCUMENTO, ';
				$cadenaSql .= 'primer_nombre as PRIMER_NOMBRE, ';
				$cadenaSql .= 'segundo_nombre as SEGUNDO_NOMBRE,';
				$cadenaSql .= 'primer_apellido as PRIMER_APELLIDO,';
				$cadenaSql .= 'segundo_apellido as SEGUNDO_APELLIDO,';
				$cadenaSql .= 'regimen_tributario as REGIMEN_TRIBUTARIO, ';
				$cadenaSql .= 'estado_solicitud as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'persona.persona_natural';
				
				break;
			
			case 'buscarVerdetallexCargo' :
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id as ID, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'estado as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'parametro.nivel_cargo ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= $variable ['id'];
				
				break;
			
			case 'buscarConceptos' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'codigo as CODIGO, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION, ';
				$cadenaSql .= 'estado as ESTADO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'concepto.concepto ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= $variable ['codigoRegistro'];
				break;
			
			case 'inactivarRegistro' :
				$cadenaSql = 'UPDATE ';
				$cadenaSql .= 'parametro.nivel_cargo ';
				$cadenaSql .= 'SET ';
				$cadenaSql .= 'estado = ';
				$cadenaSql .= '\'' . $variable ['estadoRegistro'] . '\' ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= '\'' . $variable ['codigoRegistro'] . '\'';
				break;
			
			case 'modificarCategoria' :
				$cadenaSql = 'UPDATE ';
				$cadenaSql .= 'parametro.nivel_cargo ';
				$cadenaSql .= 'SET ';
				$cadenaSql .= 'nombre = ';
				$cadenaSql .= '\'' . $variable ['nombre'] . '\' ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= '\'' . $variable ['id'] . '\'';
				break;
			
			case 'modificarCategoriaLey' :
				$cadenaSql = 'UPDATE ';
				$cadenaSql .= 'concepto.categxldn ';
				$cadenaSql .= 'SET ';
				$cadenaSql .= 'id_ldn = ';
				$cadenaSql .= $variable ['ley'];
				$cadenaSql .= ' WHERE ';
				$cadenaSql .= 'id = ';
				$cadenaSql .= '\'' . $variable ['id'] . '\'';
				break;
			
			case 'buscarPais' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_pais as ID_PAIS, ';
				$cadenaSql .= 'nombre_pais as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'otro.pais';
				break;
			
			case 'buscarDepartamento' : // Provisionalmente solo Departamentos de Colombia
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'otro.departamento ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_pais = 112;';
				break;
			
			case 'buscarDepartamentoAjax' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_departamento as ID_DEPARTAMENTO, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'otro.departamento ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_pais = ' . $variable . ';';
				break;
			
			case 'buscarCiudad' : // Provisionalmente Solo Ciudades de Colombia sin Agrupar
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ciudad as ID_CIUDAD, ';
				$cadenaSql .= 'nombre as NOMBRE ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'otro.ciudad ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'ab_pais = \'CO\';';
				break;
			
			case 'buscarCiudadAjax' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_ciudad as ID_CIUDAD, ';
				$cadenaSql .= 'nombre as NOMBRECIUDAD ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'otro.ciudad ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'id_departamento = ' . $variable . ';';
				break;
		}
		
		return $cadenaSql;
	}
}
?>
