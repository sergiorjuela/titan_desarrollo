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
				'id' => $_REQUEST ['id'],
				'nombre' => $_REQUEST ['nombre'],
				'descripcion' => $_REQUEST ['descripcion'] 
		);
		
		$cadenaSql = $this->miSql->getCadenaSql ( "modificarCategoria", $datos );
		$primerRecursoDB->ejecutarAcceso ( $cadenaSql, "acceso" );
		
                
        	$cadenaSql = $this->miSql->getCadenaSql("eliminarLeyesModificar",$datos);
        	$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
                
        	$arrayLeyes = explode(",", $_REQUEST['leyRegistros']);
        	$count = 0;
        	
        	while($count < count($arrayLeyes)){
        	
        		$datosLeyesConcepto = array(
        				'fk_id_ley' => $arrayLeyes[$count],
        				'fk_categoria' => $_REQUEST['variable']
        		);
        	
        		$cadenaSql = $this->miSql->getCadenaSql("insertarCategoriaxLey",$datosLeyesConcepto);
        		$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        		 
        		
        		$count++;
        	
        	}
              
		
		Redireccionador::redireccionar ( 'form' );
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

