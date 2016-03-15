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
        $estado = "Activo";
        $datos = array(
            'id' => "nextval('parametro.secuencia_parametro_liquidacion')",
            'nombre' => $_REQUEST ['nombre'],
            'simbolo' => $_REQUEST ['simbolo'],
            'descripcion' => $_REQUEST ['descripcion'],
            'categoriaParametro' => $_REQUEST ['categoriaParametro'],
            'estado' => $estado,
            'valor' => $_REQUEST ['valor']
        );
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("registrarParametroLiquidacion", $datos);
        $resultado = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        if (!empty($resultado)) {
            $leyes = $_REQUEST ['leyesParametroHidden'];
            $leyes = explode(",", $leyes);
            for ($i = 0; $i < count($leyes); $i++) {
                $cadenaLey = $this->miSql->getCadenaSql("registrarLeyesParametroLiquidacion", $leyes[$i]);
                $resultadoLey = $primerRecursoDB->ejecutarAcceso($cadenaLey, "acceso");
                if (!$resultadoLey) {
                    Redireccionador::redireccionar('noInserto');
                    exit();
                }
            }
            Redireccionador::redireccionar('inserto', $datos);
            exit();
        } else {
            Redireccionador::redireccionar('noInserto');
            exit();
        }

        //Al final se ejecuta la redirección la cual pasará el control a otra página
        // Redireccionador::redireccionar('opcion1');
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

