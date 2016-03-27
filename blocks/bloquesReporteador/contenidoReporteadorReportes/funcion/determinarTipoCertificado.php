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
        if (isset($_REQUEST['selPreliquidacion'])) {
            $preliquidacion = $_REQUEST['selPreliquidacion'];
        } else {
            $preliquidacion = "0";
        }
        if ($_REQUEST['enviarRegistro'] == "true") {
            $datos = array(
                'tipoPlantilla' => $_REQUEST['seltipoPlantilla'],
                'tipoReporte' => $_REQUEST['selReporte'],
                'codigoReporte' => $_REQUEST['codigoReporte'],
                'tipoDocumento' => $_REQUEST['seltipoDocumento'],
                'documento' => $_REQUEST['documentoIdentificacion'],
                'preliquidacion' => $preliquidacion,
                'fecha' => date("Y-m-d"),
                'id'=> "nextval('reporteador.sec_reporterealizado')"
            );
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarReporte", $datos);
            $resultado = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
            if (!empty($resultado)) {
                Redireccionador::redireccionar('generarPersonal', $datos);
                exit();
            }
            else{
                Redireccionador::redireccionar('noInserto', $datos);
                exit();
            }
        } else {
            $datos = array(
                'tipoPlantilla' => $_REQUEST['seltipoPlantilla'],
                'tipoReporte' => $_REQUEST['selReporte'],
                'preliquidacion' => $preliquidacion,
                'codigoReporte' => $_REQUEST['codigoReporte']
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


