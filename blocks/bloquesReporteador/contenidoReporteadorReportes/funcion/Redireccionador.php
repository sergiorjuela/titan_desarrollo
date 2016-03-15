<?php

namespace bloquesReporteador\contenidoReporteadorPlanillas\funcion;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		
	    $miConfigurador = \Configurador::singleton ();
            $miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
			
			case "registrarInformacionDeCreacionCertificado" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=formularioInformacionDeCreacionCertificado";
				$variable .= "&descripcionPlantilla=" . $valor ['descripcionPlantilla'];
                                $variable .= "&tipoPlantilla=" . $valor ['tipoPlantilla'];
				$variable .= "&nombrePlantilla=" . $valor ['nombrePlantilla'];
				break;
			case "registrarInformacionDeCreacionReporteGeneral" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=formularioInformacionDeCreacionReporteGeneral";
				$variable .= "&descripcionPlantilla=" . $valor ['descripcionPlantilla'];
				$variable .= "&tipoPlantilla=" . $valor ['tipoPlantilla'];
				$variable .= "&nombrePlantilla=" . $valor ['nombrePlantilla'];
				break;
			case "inserto" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=inserto";
				$variable .= "&nombrePlantilla=" . $valor ['nombrePlantilla'];
				$variable .= "&tipoPlantilla=" . $valor ['tipoPlantilla'];
				$variable .= "&idPlantilla=" . $valor ['id'];
				break;
			case "noInserto" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noInserto";
				$variable .= "&tipoPlantilla=".$valor ['tipoPlantilla'];
				break;
			case "modifico" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=modifico";
				$variable .= "&nombrePlantilla=" . $valor ['nombrePlantilla'];
				$variable .= "&idPlantilla=" . $valor ['id_plantilla'];
				break;
			case "nomodifico" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=nomodifico";
				$variable .= "&tipoPlantilla=".$valor ['tipoPlantilla'];
				break;
			case "inactivo" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=inactivo";
				$variable .= "&nuevoestado=".$valor ['estado'];
				$variable .= "&id_plantilla=".$valor ['id_plantilla'];
				break;
			case "noinactivo" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&mensaje=noinactivo";
				$variable .= "&tipoPlantilla=".$valor ['tipoPlantilla'];
				break;
			
			default :
				$variable = '';
			
		}
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
//		$enlace = $miConfigurador->getVariableConfiguracion ( "enlace" );
//		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		
//		$_REQUEST [$enlace] = $variable;
//		$_REQUEST ["recargar"] = true;
                
                $url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		$enlace = $miConfigurador->configuracion ['enlace'];
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		return true;
	}
}
?>