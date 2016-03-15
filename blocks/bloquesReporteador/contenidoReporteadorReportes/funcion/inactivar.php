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
            'id_plantilla' => $_REQUEST ['id_plantilla'],
            'estado' => $_REQUEST['estadoActual']
        );
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("actualizarEstado", $datos);
        $resultado = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        //echo $atributos ['cadena_sql'] . "<br>";
        //var_dump($resultado);
        if (!empty($resultado)) {
            Redireccionador::redireccionar('inactivo', $datos);
            exit();
        } else {
            Redireccionador::redireccionar('noinactivo');
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


