<?php

namespace bloquesReporteador\contenidoReporteadorReportes\funcion;
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		
	    $miConfigurador = \Configurador::singleton ();
            $miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
			
			case "vistaSeleccionGrupal" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=asociarPersonas";
				$variable .= "&tipoPlantilla=" . $valor ['tipoPlantilla'];
				$variable .= "&tipoReporte=" . $valor ['tipoReporte'];
				$variable .= "&codigoReporte=" . $valor ['codigoReporte'];
				$variable .= "&preliquidacion=" . $valor ['preliquidacion'];
				break;
			case "generarPersonal" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&tipoPlantilla=". $valor ['tipoPlantilla'];
				$variable .= "&tipoReporte=". $valor ['tipoReporte'];
				$variable .= "&codigoReporte=". $valor ['codigoReporte'];
				$variable .= "&tipoDocumento=". $valor ['tipoDocumento'];
				$variable .= "&documento=". $valor ['documento'];
				$variable .= "&preliquidacion=". $valor ['preliquidacion'];
				$variable .= "&resultado=generarPersonal";
				break;
			case "generalGrupal" :
                                $variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&tipoPlantilla=". $valor ['tipoPlantilla'];
				$variable .= "&codigoReporte=". $valor ['codigoReporte'];
				$variable .= "&personas=". serialize($valor ['personas']);
				$variable .= "&preliquidacion=". $valor ['preliquidacion'];
				$variable .= "&resultado=generalGrupal";
				break;
			case "noInserto" :
				$variable = 'pagina=' . $miPaginaActual;
				$variable .= "&opcion=mensaje";
				$variable .= "&resultado=noInserto";
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