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

        $datos = array(
            'id' => $_REQUEST['id'],
            'nombre' => $_REQUEST ['nombre'],
            'simbolo' => $_REQUEST ['simbolo'],
            'descripcion' => $_REQUEST ['descripcion'],
            'categoriaParametro' => $_REQUEST ['categoriaParametro'],
            'valor' => $_REQUEST ['valor']
        );
        //primero se eliminan las leyes actuales para evitar duplicidad
        $cadenaEliminarLeyes = $this->miSql->getCadenaSql("eliminarLeyesModificar", $datos['id']);
        $resultadoEliminarLeyes = $primerRecursoDB->ejecutarAcceso($cadenaEliminarLeyes, "acceso");
        echo $cadenaEliminarLeyes . "<br>";
        var_dump($resultadoEliminarLeyes);
        echo "<br>";
        //Modificacion de datos de parametro
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("modificarParametro", $datos);
        $resultadoModificar = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");

        echo $atributos ['cadena_sql'] . "<br>";
        var_dump($resultadoModificar);
        echo "<br>";
        //Ingreso de nuevas leyes
        if (!empty($resultadoEliminarLeyes) && !empty($resultadoModificar)) {

            $leyes = $_REQUEST ['leyesParametroHidden'];
            $leyes = explode(",", $leyes);
            for ($i = 0; $i < count($leyes); $i++) {
                $datosLey = array(
                    'id' => $datos['id'],
                    'idLey' => $leyes[$i]
                );
                $cadenaLey = $this->miSql->getCadenaSql("ActualizarLeyesParametroLiquidacion", $datosLey);
                $resultadoLey = $primerRecursoDB->ejecutarAcceso($cadenaLey, "acceso");
                echo $cadenaLey . "<br>";
                var_dump( $resultadoLey);
                echo "<br>";

                if (!$resultadoLey) {
                    exit();
                    Redireccionador::redireccionar('noInserto');
                    exit();
                }
            }
            Redireccionador::redireccionar('modifico', $datos);
            exit();
        } else {
            Redireccionador::redireccionar('nomodifico');
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
