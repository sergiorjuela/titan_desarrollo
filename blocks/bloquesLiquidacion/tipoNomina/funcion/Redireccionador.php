<?php

namespace bloquesLiquidacion\tipoNomina\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class Redireccionador {
	public static function redireccionar($opcion, $valor = "") {
		
	    $miConfigurador = \Configurador::singleton ();
            $miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		switch ($opcion) {
			
			case "opcion1" :
				
				$variable = 'pagina=segundaPagina';
				$variable .= '&variable' . $valor;				
				break;
			case "form" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=form";
				break;
                        case "modificar" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=modificar";
                                $variable .= '&variable=' . $valor['variable'];
                                $variable .= '&variablei=' . $valor['variablei'];
                                $variable .= '&vinculacion='. $valor['vinculacion'];
                               
				break; 
                            
                        case "verDetalle" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=verdetalle";
                                $variable .= '&variable=' . $valor;
                                break;
                        case "inserto" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=mensaje";
                                $variable .= "&mensaje=inserto";
                                $variable .= "&nombreNomina=" . $valor ['nombreNomina'];
                                $variable .= "&estadoRegistroNomina=" . $valor ['estadoRegistroNomina'];
                                $variable .= "&variable=" . $valor ['variable'];
				break;  
                        case "noInserto" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=mensaje";
                                $variable .= "&mensaje=noInserto";
				break;     
                        case "modifico" :
				$variable = 'pagina='.$miPaginaActual;
                                $variable .= "&mensaje=modifico";
				$variable .= "&opcion=mensaje";
                                $variable .= "&nombreNomina=" . $valor ['nombreNomina'];
                                $variable .= "&estadoRegistroNomina=" . $valor ['estadoRegistroNomina'];
                                $variable .= "&variable=" . $valor ['variable'];
				break;        
                        case "verDetalle2" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=verdetalle";
                                $variable .= '&variable=' . $valor['variable'];
                                break;     
                            
                         case "verdetalleNomina" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=verdetallenomina";
                                $variable .= '&variable=' . $valor['variable'];
                                $variable .= '&variablei=' . $valor['variablei'];
                                $variable .= '&vinculacion='. $valor['vinculacion'];
                                break;
                        case "inactivar" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=inactivar";
                                $variable .= '&variable=' . $valor['variable'];
                                $variable .= '&variablei=' . $valor['variablei'];
                                $variable .= '&vinculacion='. $valor['vinculacion'];
                            break;  
                        case "registrar" :
				$variable = 'pagina='.$miPaginaActual;                                
				$variable .= "&opcion=registrarnomina";
                                $variable .= '&variable=' . $valor;
                                $variable .= '&vinculacion='.$_REQUEST['vinculacion'];
                            break;
			default:
			    $variable='';
			
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