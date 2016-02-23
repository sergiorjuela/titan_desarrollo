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
		
		$datosUbicacion = array (
				'pais' => $_REQUEST ['personaNaturalPais'],
				'departamento' => $_REQUEST ['personaNaturalDepartamento'],
				'ciudad' => $_REQUEST ['personaNaturalCiudad'] 
		);
		
	
		
		$cadenaSql = $this->miSql->getCadenaSql ( "insertarUbicacion", $datosUbicacion );
		$id_ubicacion = $primerRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda", $datosUbicacion, "insertarUbicacion" );
		
		if (isset ( $_REQUEST ['personaNaturalRegimen'] )) {
			switch ($_REQUEST ['personaNaturalRegimen']) {
				case 1 :
					$_REQUEST ['personaNaturalRegimen'] = 'comun';
					break;
				case 2 :
					$_REQUEST ['personaNaturalRegimen'] = 'simplificado';
					break;
				case 3 :
					$_REQUEST ['personaNaturalRegimen'] = 'noAplica';
					break;
			}
		}
		
		if (isset ( $_REQUEST ['personaNaturalAutorretenedor'] )) {
			switch ($_REQUEST ['personaNaturalAutorretenedor']) {
				case 1 :
					$_REQUEST ['personaNaturalAutorretenedor'] = 'si';
					break;
				case 2 :
					$_REQUEST ['personaNaturalAutorretenedor'] = 'no';
					break;
			}
		}
		
		if (isset ( $_REQUEST ['personaNaturalContribuyente'] )) {
			switch ($_REQUEST ['personaNaturalContribuyente']) {
				case 1 :
					$_REQUEST ['personaNaturalContribuyente'] = 'Si';
					break;
				case 2 :
					$_REQUEST ['personaNaturalContribuyente'] = 'No';
					break;
			}
		}
		
		$datos = array (
				'tipoDocumento' => $_REQUEST ['personaNaturalIdentificacion'],
				'numeroDocumento' => $_REQUEST ['personaNaturalDocumento'],
				'fk_ubicacion' => $id_ubicacion [0] [0],
				'primerNombre' => $_REQUEST ['personaNaturalPrimerNombre'],
				'segundoNombre' => $_REQUEST ['personaNaturalSegundoNombre'],
				'primerApellido' => $_REQUEST ['personaNaturalPrimerApellido'],
				'segundoApellido' => $_REQUEST ['personaNaturalSegundoApellido'],
				'contribuyente' => $_REQUEST ['personaNaturalContribuyente'],
				'autorretenedor' => $_REQUEST ['personaNaturalAutorretenedor'],
				'regimen' => $_REQUEST ['personaNaturalRegimen']
// 				'soporteDocumento' => $_REQUEST ['personaNaturalSoporteIden'] 
		);
		
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "insertarRegistroBasico", $datos );
		$primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "acceso" );
		
		if (isset ( $_REQUEST ['personaNaturalBanco'] )) {
			switch ($_REQUEST ['personaNaturalBanco']) {
				case 1 :
					$_REQUEST ['personaNaturalBanco'] = 'Banco de Bogotá';
					break;
				case 2 :
					$_REQUEST ['personaNaturalBanco'] = 'Banco Popular';
					break;
				case 3 :
					$_REQUEST ['personaNaturalBanco'] = 'Bancolombia';
					break;
				case 4 :
					$_REQUEST ['personaNaturalBanco'] = 'CityBank Colombia';
					break;
				case 5 :
					$_REQUEST ['personaNaturalBanco'] = 'GNB Colombia S.A.';
					break;
				case 6 :
					$_REQUEST ['personaNaturalBanco'] = 'BBVA Colombia';
					break;
			}
			
			if (isset ( $_REQUEST ['personaNaturalTipoCuenta'] )) {
				switch ($_REQUEST ['personaNaturalTipoCuenta']) {
					case 1 :
						$_REQUEST ['personaNaturalTipoCuenta'] = 'ahorros';
						break;
					case 2 :
						$_REQUEST ['personaNaturalTipoCuenta'] = 'corriente';
						break;
				}
			}
			
			if (isset ( $_REQUEST ['personaNaturalTipoPago'] )) {
				switch ($_REQUEST ['personaNaturalTipoPago']) {
					case 1 :
						$_REQUEST ['personaNaturalTipoPago'] = 'Transferencia';
						break;
					case 2 :
						$_REQUEST ['personaNaturalTipoPago'] = 'SAP';
						break;
				}
			}
			
			if (isset ( $_REQUEST ['personaNaturalEconomicoEstado'] )) {
				switch ($_REQUEST ['personaNaturalEconomicoEstado']) {
					case 1 :
						$_REQUEST ['personaNaturalEconomicoEstado'] = 'Activo';
						break;
					case 2 :
						$_REQUEST ['personaNaturalEconomicoEstado'] = 'Inactivo';
						break;
				}
			}
			
			$datosCom = array (
					'consecutivo' => $_REQUEST ['personaNaturalConsecutivo'],
					'banco' => $_REQUEST ['personaNaturalBanco'],
					'tipoCuenta' => $_REQUEST ['personaNaturalTipoCuenta'],
					'numeroCuenta' => $_REQUEST ['personaNaturalNumeroCuenta'],
					'tipoPago' => $_REQUEST ['personaNaturalTipoPago'],
					'estado' => $_REQUEST ['personaNaturalEconomicoEstado'],
					'fecha' => $_REQUEST ['fechaCreacionConsulta1'],
					'creador' => $_REQUEST ['personaNaturalCreo']
// 					'soporteRUT' => $_REQUEST ['personaNaturalSoporteRUT'] 
			);
			
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "insertarRegistroComercial", $datosCom );
			$id_comercial = $primerRecursoDB->ejecutarAcceso (  $atributos ['cadena_sql'], "busqueda", $datosCom, "insertarRegistroComercial" );
			
			
			$datosPersonaComercial = array (
					'documento' => $_REQUEST ['personaNaturalDocumento'],
					'consecutivo' => $id_comercial [0][0]
			);
			
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "insertarPersonaComercial", $datosPersonaComercial );
			$primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "acceso" );
			
			
			// Al final se ejecuta la redirección la cual pasará el control a otra página
			
			
			
			if (isset ( $_REQUEST ['personaNaturalContactoTipo'] )) {
				switch ($_REQUEST ['personaNaturalContactoTipo']) {
					case 1 :
						$_REQUEST ['personaNaturalContactoTipo'] = 'Dirección';
						break;
					case 2 :
						$_REQUEST ['personaNaturalContactoTipo'] = 'e-mail';
						break;
					case 3 :
						$_REQUEST ['personaNaturalContactoTipo'] = 'Teléfono fijo';
						break;
					case 4 :
						$_REQUEST ['personaNaturalContactoTipo'] = 'Teléfono Movil';
						break;
					case 5 :
						$_REQUEST ['personaNaturalBanco'] = 'Fax';
						break;
				}
				
				if (isset ( $_REQUEST ['personaNaturalContactosEstado'] )) {
					switch ($_REQUEST ['personaNaturalContactosEstado']) {
						case 1 :
							$_REQUEST ['personaNaturalContactosEstado'] = 'Activo';
							break;
						case 2 :
							$_REQUEST ['personaNaturalContactosEstado'] = 'Inactivo';
							break;
					}
				}
				
				$datosUbicacionContacto = array (
						'pais' => $_REQUEST ['personaNaturalContactosPais'],
						'departamento' => $_REQUEST ['personaNaturalContactosDepartamento'],
						'ciudad' => $_REQUEST ['personaNaturalContactosCiudad'] 
				);
				
				$cadenaSql = $this->miSql->getCadenaSql ( "insertarUbicacion", $datosUbicacionContacto );
				$id_ubicacion_contacto = $primerRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda", $datosUbicacionContacto, "insertarUbicacion" );
				
				$datosContacto = array (
						'tipo' => $_REQUEST ['personaNaturalContactoTipo'],
						'descripcion' => $_REQUEST ['personaNaturalContactosDescrip'],
						'estado' => $_REQUEST ['personaNaturalContactosEstado'],
						'observacion' => $_REQUEST ['personaNaturalContactosObserv'],
						'fecha' => $_REQUEST ['fechaCreacionConsulta'],
						'creador' => $_REQUEST ['personaNaturalContactosUsuarioCreo'],
						'ubicacion'=>$id_ubicacion_contacto[0][0]
				);
				
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "insertarRegistroContacto", $datosContacto );
				$id_contacto = $primerRecursoDB->ejecutarAcceso (  $atributos ['cadena_sql'], "busqueda", $datosContacto, "insertarRegistroContacto" );
				
				$datosPersonaContacto = array (
						'documento' => $_REQUEST ['personaNaturalDocumento'],
						'consecutivo' => $id_contacto [0][0] 
				);
				
				$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "insertarPersonaContacto", $datosPersonaContacto );
				$primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "acceso" );
				
		if ($datos[0][1] == $datosPersonaContacto[0][0]) {
        	
        	$this->miConfigurador->setVariableConfiguracion("cache", true);
        	Redireccionador::redireccionar('inserto', $datos);
        	exit();
        } else {
        	
        	//$this->miConfigurador->setVariableConfiguracion("cache", true);
        	Redireccionador::redireccionar('noInserto', $datos);
        	//var_dump("TEXTO NO INS");exit;
        	exit();
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
	}
}
$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();
