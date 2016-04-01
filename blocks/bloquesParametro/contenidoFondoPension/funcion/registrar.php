<?php

namespace bloquesModelo\bloqueContenido\funcion;

include_once('RedireccionadorFP.php');

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

        $datosubicacion = array(
            'fdpDepartamento' => $_REQUEST ['fdpDepartamento'],
            'fdpCiudad' => $_REQUEST ['fdpCiudad']
        );


        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarIdUbicacion", $datosubicacion);
        $ubicacion = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");

        if (empty($ubicacion)) {
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarUbicacion", $datosubicacion);
            $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "insertar");

            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarIdUbicacion", $datosubicacion);
            $ubicacion = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
        }
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarNit", $_REQUEST ['nitRegistro']);
        $nit = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
        $var = 0;
        if (empty($nit)) {



            $extTel = '0';
            $fax = '0';
            $extFax = '0';
            if ($_REQUEST ['extTelefonoRegistro'] != '') {
                $extTel = $_REQUEST ['extTelefonoRegistro'];
            }
            if ($_REQUEST ['faxRegistro'] != '') {
                $fax = $_REQUEST ['faxRegistro'];
            }
            if ($_REQUEST ['extFaxRegistro'] != '') {
                $extFax = $_REQUEST ['extFaxRegistro'];
            }




            $datos = array(
                'nitRegistro' => $_REQUEST ['nitRegistro'],
                'nombreRegistro' => $_REQUEST ['nombreRegistro'],
                'direccionRegistro' => $_REQUEST ['direccionRegistro'],
                'telefonoRegistro' => $_REQUEST ['telefonoRegistro'],
                'extTelefonoRegistro' => $extTel,
                'faxRegistro' => $fax,
                'extFaxRegistro' => $extFax,
                'id_ubicacion' => $ubicacion[0][0],
                'nomRepreRegistro' => $_REQUEST ['nomRepreRegistro'],
                'emailRegistro' => $_REQUEST ['emailRegistro']
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

            RedireccionadorFP::redireccionar('inserto', $datos);
            exit();
        } else {

            if ($var == 1) {
                RedireccionadorFP::redireccionar('nitRep', $_REQUEST ['nitRegistro']);
            } else {
                RedireccionadorFP::redireccionar('noInserto');
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

