<?php

namespace bloquesParametro\contenidoActoAdministrativo\funcion;

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

        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarNit", $_REQUEST ['nit']);
        $nit = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
        $var = 0;
        if (empty($nit)) {
            if (isset($_REQUEST['tipoDocumento'])) {
                switch ($_REQUEST ['tipoDocumento']) {
                    case 1 :
                        $_REQUEST ['tipoDocumento'] = 'Resolucion';
                        break;

                    case 2 :
                        $_REQUEST ['tipoDocumento'] = 'Decreto';
                        break;

                    case 3 :
                        $_REQUEST ['tipoDocumento'] = 'Planilla';
                        break;
                }
            }

            $fechaexp = 'NULL';
            if ($_REQUEST ['fechaExp'] != '') {
                $fechaexp = $_REQUEST ['fechaExp'];
            }
            $fechaven = 'NULL';
            if ($_REQUEST ['fechaVen'] != '') {
                $fechaven = $_REQUEST ['fechaVen'];
            }

            $datos = array(
                'nit' => $_REQUEST ['nit'],
                'tipo_acto' => $_REQUEST['tipoActo'],
                'fecha' => $_REQUEST ['fecha'],
                'tipoDocumento' => $_REQUEST ['tipoDocumento'],
                'fechaExp' => $fechaexp,
                'fechaVen' => $fechaven,
                'justificacion' => $_REQUEST ['justificacion']
            );
//       


            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarRegistro", $datos);
            $resultado = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        } else {
            $resultado = false;
            $var = 1;
        }


        //Al final se ejecuta la redirección la cual pasará el control a otra página

        if (!empty($resultado)) {
            Redireccionador::redireccionar('inserto', $datos);
            exit();
        } else {
            if ($var == 1) {
                Redireccionador::redireccionar('nitRep', $_REQUEST ['nit']);
            } else {
                Redireccionador::redireccionar('noInserto');
            }



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

