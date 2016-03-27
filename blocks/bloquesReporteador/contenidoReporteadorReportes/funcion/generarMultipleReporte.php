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
        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        //Determina que Boton selecciono el usuario si es enviarRegistro genera el certificado Personal
        //De lo contrario direcciona a la vista de selecion grupal
        $personas = array();
        $cont = 0;
        for ($i = 0; $i < $_REQUEST['tamanoTabla']; $i++) {
            if (isset($_POST["checkbox$i"])) {
                $personas[$cont] = $_POST["checkbox$i"];
                $cont = $cont + 1;
            } else {
                $cont = $cont;
            }
        }
        if (isset($_REQUEST['preliquidacion'])) {
            $preliquidacion = $_REQUEST['preliquidacion'];
        } else {
            $preliquidacion = 0;
        }
        for ($j = 0; $j < count($personas); $j++) {
            $datos = array(
                'tipoPlantilla' => $_REQUEST['seltipoPlantilla'],
                'codigoReporte' => $_REQUEST['codigoReporte'],
                'preliquidacion' => $preliquidacion,
                'documento' => $personas[$j],
                'fecha' => date("Y-m-d"),
                'id' => "nextval('reporteador.sec_reporterealizado')"
            );

            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarReporte", $datos);
           
            $resultado = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
            
            if ($resultado != true) {
                Redireccionador::redireccionar('noInserto', $datos);
                exit();
            }
        }
        $datosGrupal = array(
            'tipoPlantilla' => $_REQUEST['seltipoPlantilla'],
            'codigoReporte' => $_REQUEST['codigoReporte'],
            'codigoReporte' => $_REQUEST['codigoReporte'],
            'preliquidacion' => $preliquidacion,
            'personas' => $personas
        );
        Redireccionador::redireccionar('generalGrupal', $datosGrupal);
        exit();
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


