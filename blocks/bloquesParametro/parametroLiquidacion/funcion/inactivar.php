<?php

namespace bloquesParametro\parametroLiquidacion\funcion;

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


        if ($_REQUEST['enviarInactivar'] == 'true') {
           
            $datos = array(
                'codigoRegistro' => $_REQUEST ['id'],
                'estadoRegistro' => $_REQUEST ['nuevoEstado']
            );
//       
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("inactivarRegistro", $datos);
            $resultado = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");

            if (!empty($resultado)) {
                Redireccionador::redireccionar('cambioestado',$datos);
            } else {
                echo $atributos ['cadena_sql'];
                echo "<br>";
                var_dump($resultado);
                exit();
                Redireccionador::redireccionar('noCambioestado');
            }
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

