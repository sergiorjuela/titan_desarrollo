<?php

namespace bloquesParametro\contenidoActoAdministrativo\funcion;

if (!isset($GLOBALS ["autorizado"])) {
    include ("index.php");
    exit();
}

class Redireccionador {

    public static function redireccionar($opcion, $valor = "") {

        $miConfigurador = \Configurador::singleton();
        $miPaginaActual = $miConfigurador->getVariableConfiguracion("pagina");

        switch ($opcion) {

            case "opcion1" :

                $variable = 'pagina=segundaPagina';
                $variable .= '&variable' . $valor;
                break;
            case "nitRep" :
                $variable = 'pagina=' . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=nitRep";
                $variable .= "&nitRegistro=" . $valor;
                break;
            case "form" :
                $variable = 'pagina=' . $miPaginaActual;
                $variable .= "&opcion=form";
                break;
            case "modificar" :
                $variable = 'pagina=' . $miPaginaActual;
                $variable .= "&opcion=modificar";
                $variable .= '&variable=' . $valor;
                break;
            case "verdetalle" :
                $variable = 'pagina=' . $miPaginaActual;
                $variable .= "&opcion=verdetalle";
                $variable .= '&variable=' . $valor;
                break;
            case "inserto" :
                $variable = 'pagina=' . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=inserto";
                $variable .= "&nombreRegistro=" . $valor ['nit'];
                $variable .= "&estadoRegistro=" . $valor ['tipo_acto'];
                break;
            case "noInserto" :
                $variable = 'pagina=' . $miPaginaActual;
                $variable .= "&opcion=mensaje";
                $variable .= "&mensaje=noInserto";
                break;
            case "modifico" :
                $variable = 'pagina=' . $miPaginaActual;
                $variable .= "&mensaje=modifico";
                $variable .= "&opcion=mensaje";
                $variable .= "&nombreRegistro=" . $valor ['nit'];
                $variable .= "&estadoRegistro=" . $valor ['tipo_acto'];

                break;
            case "inactivar" :
                $variable = 'pagina=' . $miPaginaActual;
                $variable .= "&opcion=inactivar";
                $variable .= '&variable=' . $valor;
                break;
            default:
                $variable = '';
        }
        foreach ($_REQUEST as $clave => $valor) {
            unset($_REQUEST [$clave]);
        }

//		$enlace = $miConfigurador->getVariableConfiguracion ( "enlace" );
//		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
//		$_REQUEST [$enlace] = $variable;
//		$_REQUEST ["recargar"] = true;

        $url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
        $enlace = $miConfigurador->configuracion ['enlace'];
        $variable = $miConfigurador->fabricaConexiones->crypto->codificar($variable);
        $_REQUEST [$enlace] = $enlace . '=' . $variable;
        $redireccion = $url . $_REQUEST [$enlace];

        echo "<script>location.replace('" . $redireccion . "')</script>";

        return true;
    }

}

?>