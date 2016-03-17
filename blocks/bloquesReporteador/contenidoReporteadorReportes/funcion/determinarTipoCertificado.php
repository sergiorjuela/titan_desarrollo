<?php

namespace bloquesReporteador\contenidoReporteadorReportes\funcion;
 
include_once('Redireccionador.php');

class FormProcessor {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;
    var $conexion;

    function __construct($lenguaje, $sql) {

        $this->miConfigurador = \Configurador::singleton();
        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
    }

    function procesarFormulario() {

        //Determina que Boton selecciono el usuario si es enviarRegistro genera el certificado Personal
        //De lo contrario direcciona a la vista de selecion grupal
        if ($_REQUEST['enviarRegistro']=="true") {
           $datos = array(
                'tipoPlantilla' => $_REQUEST['seltipoPlantilla'],
                'tipoReporte' => $_REQUEST['selReporte'],
                'codigoReporte' => $_REQUEST['codigoReporte'],
                'tipoDocumento' => $_REQUEST['seltipoDocumento'],
                'documento' => $_REQUEST['documentoIdentificacion'],
                'preliquidacion' => $_REQUEST['seltipoPlantilla']   
            );
          Redireccionador::redireccionar('generarPersonal', $datos);
            exit();
        }  else {
            echo "entro";
            $datos = array(
                'tipoPlantilla' => $_REQUEST['seltipoPlantilla'],
                'tipoReporte' => $_REQUEST['selReporte'],
                'codigoReporte' => $_REQUEST['codigoReporte'],
            );

            Redireccionador::redireccionar('vistaSeleccionGrupal', $datos);
            exit();
        }
    }

    function resetForm() {
        foreach ($_REQUEST as $clave => $valor) {

            if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
                unset($_REQUEST[$clave]);
            }
        }
    }

}

$miProcesador = new FormProcessor($this->lenguaje, $this->sql);

$resultado = $miProcesador->procesarFormulario();


