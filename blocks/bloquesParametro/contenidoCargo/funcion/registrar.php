<?php

namespace bloquesModelo\bloqueContenido\funcion;

include_once ('Redireccionador.php');
class FormProcessor {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
	}
	function procesarFormulario() {
		
		// Aquí va la lógica de procesamiento
		$conexion = 'estructura';
		$primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		if (isset ( $_REQUEST ['tipoSueldoRegistro'] )) {
			switch ($_REQUEST ['tipoSueldoRegistro']) {
				case 1 :
					$_REQUEST ['tipoSueldoRegistro'] = 'M';
					break;
				
				case 2 :
					$_REQUEST ['tipoSueldoRegistro'] = 'H';
					break;
			}
		}
		
// 		if (isset ( $_REQUEST ['estadoRegistro'] )) {
// 			switch ($_REQUEST ['estadoRegistro']) {
// 				case 1 :
// 					$_REQUEST ['estadoRegistro'] = 'Activo';
// 					break;
				
// 				case 2 :
// 					$_REQUEST ['estadoRegistro'] = 'Inactivo';
// 					break;
// 			}
// 		}
		
		$datos = array (
				'nivelRegistro' => $_REQUEST ['nivelRegistro'],
				'gradoRegistro' => $_REQUEST ['gradoRegistro'],
				'TipoCargo' => $_REQUEST ['tipoCargo'],
				'sueldoRegistro' => $_REQUEST ['sueldoRegistro'],
				'tipoSueldoRegistro' => $_REQUEST ['tipoSueldoRegistro'],
				'funciones' => $_REQUEST ['funciones']
				 
		);
		//
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "insertarRegistro", $datos );
		$resultado = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda",$datos,"insertarRegistro" );
		
		$arrayLeyes = explode(",", $_REQUEST['leyRegistros']);
		$count = 0;
		
		while($count < count($arrayLeyes)){
		
			$datosLeyesCargo = array(
					'ley' => $arrayLeyes[$count],
					'fk_cargo' => $resultado[0][0]
			);
		
			$cadenaSql = $this->miSql->getCadenaSql("insertarCargoxley",$datosLeyesCargo);
			$resultado1 = $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
			$count++;
		
		}
		// Al final se ejecuta la redirección la cual pasará el control a otra página

		if (! empty ( $resultado )&& !empty ($resultado1)) {
			Redireccionador::redireccionar ( 'inserto', $datos );
			exit ();
		} else {
			Redireccionador::redireccionar ( 'noInserto' );
			exit ();
		}
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

