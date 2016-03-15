<?php

namespace bloquesReporteador\contenidoReporteadorPlanillas\funcion;

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

        //Aquí va la lógica de procesamiento

        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        $datos = array(
            'descripcionPlantilla' => $_REQUEST ['descripcionPlantilla'],
            'tipoPlantilla' => $_REQUEST['tipoPlantilla'],
            'nombrePlantilla' => $_REQUEST ['nombrePlantilla']
        );
        if ($_REQUEST['tipoPlantilla'] == '1') {
            Redireccionador::redireccionar('registrarInformacionDeCreacionCertificado',$datos);
        } else {

            Redireccionador::redireccionar('registrarInformacionDeCreacionReporteGeneral',$datos);
        }

        //Al final se ejecuta la redirección la cual pasará el control a otra página
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

