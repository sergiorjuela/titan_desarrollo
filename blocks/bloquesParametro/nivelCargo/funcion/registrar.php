<?php

namespace bloquesPersona\personaNatural\funcion;

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
		
		
		
		$datos = array (
				'nombre' => $_REQUEST ['nombre'],
				'nivel' => $_REQUEST ['nivel'] 
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( "insertarNivel", $datos );
		$resultado = $primerRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso",$datos,"insertarNivel");
		
		if (! empty ( $resultado )) {
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

