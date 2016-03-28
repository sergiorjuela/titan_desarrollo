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

        $otro_Encabezado = '';
        $otro_Pie = '';
        if ($_REQUEST ['otroDatoEncabezado'] != '') {
            $otro_Encabezado = $_REQUEST ['otroDatoEncabezado'];
        }
        if ($_REQUEST ['otroDatoPie'] != '') {
            $otro_Pie = $_REQUEST ['otroDatoPie'];
        }
        if ($_REQUEST ['tipo'] == "Certificado") {
            
            
            $obtenerRutasdeArchivos = $this->miSql->getCadenaSql("obtenerRutasArchivoCertificado", $_REQUEST ['id']);
            $rutas = $primerRecursoDB->ejecutarAcceso($obtenerRutasdeArchivos, "busqueda");
            $id=$_REQUEST ['id'];
            $nombreRuta = $_REQUEST ['nombrePlantilla'];
            $tipoPlantilla =$_REQUEST ['tipo'];
            $fecha = date("Y-m-d");
            $dir_subidaIzquierdo = "blocks/bloquesReporteador/Iconos/Certificado/IconoIzquierdo-$id-";
            $dir_subidaDerecho = "blocks/bloquesReporteador/Iconos/Certificado/IconoDerecho-$id-";
            if ($_FILES["iconoIzquierdo"]["tmp_name"]) {
                 unlink($rutas[0]['icono_izquierdo']);
                $almacenar1 = move_uploaded_file($_FILES['iconoIzquierdo']['tmp_name'], utf8_decode($dir_subidaIzquierdo . $_FILES['iconoIzquierdo']['name']));
                $iconoIzquiedo = $dir_subidaIzquierdo . $_FILES['iconoIzquierdo']['name'];
            } else {
                $iconoIzquiedo = $rutas[0]['icono_izquierdo'];
            }
            if ($_FILES["iconoDerecho"]["tmp_name"]) {
                unlink($rutas[0]['icono_derecho']);
                $almacenar1 = move_uploaded_file($_FILES['iconoDerecho']['tmp_name'], utf8_decode($dir_subidaDerecho . $_FILES['iconoDerecho']['name']));
                $iconoDerecho = $dir_subidaDerecho . $_FILES['iconoDerecho']['name'];
            } else {
                $iconoDerecho = $rutas[0]['icono_derecho'];
            }

            $datosPlantilla = array(
                'nombrePlantilla' => $_REQUEST ['nombrePlantilla'],
                'descripcionPlantilla' => $_REQUEST ['descripcionPlantilla'],
                'id_plantilla' => $_REQUEST ['id']
            );
            $datosCertificado = array(
                'empresa' => $_REQUEST ['empresa'],
                'tituloEncabezado' => $_REQUEST ['tituloEncabezado'],
                'otroDatoEncabezado' => $otro_Encabezado,
                'fechaCreacion' => $_REQUEST ['fechaCreacion'],
                'contenidoCertificado' => str_replace("\\", "", $_REQUEST ['contenidoCertificado']),
                'tituloPie' => $_REQUEST ['tituloPie'],
                'direccion' => $_REQUEST ['direccion'],
                'telefono' => $_REQUEST ['telefono'],
                'iconoIzquiero' => $iconoIzquiedo,
                'iconoDerecho' => $iconoDerecho,
                'email' => $_REQUEST ['email'],
                'otroDatoPie' => $otro_Pie,
                'selecNumeroFirmas' => $_REQUEST ['selecNumeroFirmas'],
                'id_plantilla' => $_REQUEST ['id']
            );


            // Actualiza informacion general de plantilla   
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("actualizarInformacionGeneral", $datosPlantilla);
            $resultado1 = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
            //echo $atributos ['cadena_sql']."<br>";
            //var_dump($resultado1);
            // Actualiza informacion de certificado   
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("actualizarPlantillaCertificado", $datosCertificado);
            $resultado2 = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
            //echo $atributos ['cadena_sql']."<br>";
            //var_dump($resultado2);
            //Al final se ejecuta la redirección la cual pasará el control a otra página

            if (!empty($resultado1) && !empty($resultado2)) {
                Redireccionador::redireccionar('modifico', $datosPlantilla);
                exit();
            } else {
                Redireccionador::redireccionar('nomodifico', $datosPlantilla);
                exit();
            }
        }
        if ($_REQUEST ['tipo'] == "Reporte General") {
            
            
            $obtenerRutasdeArchivos = $this->miSql->getCadenaSql("obtenerRutasArchivoReportes", $_REQUEST ['id']);
            $rutas = $primerRecursoDB->ejecutarAcceso($obtenerRutasdeArchivos, "busqueda");
            $nombreRuta = $_REQUEST ['nombrePlantilla'];
            $tipoPlantilla =$_REQUEST ['tipo'];
            $fecha = date("Y-m-d");
            $id=$_REQUEST ['id'];
            $dir_subidaIzquierdo = "blocks/bloquesReporteador/Iconos/Reporte General/IconoIzquierdo-$id-";
            $dir_subidaDerecho = "blocks/bloquesReporteador/Iconos/Reporte General/IconoDerecho-$id-";
            
            if ($_FILES["iconoIzquierdo"]["tmp_name"]) {
                unlink($rutas[0]['icono_izquierdo']);
                $almacenar1 = move_uploaded_file($_FILES['iconoIzquierdo']['tmp_name'], utf8_decode($dir_subidaIzquierdo . $_FILES['iconoIzquierdo']['name']));
                $iconoIzquiedo = $dir_subidaIzquierdo . $_FILES['iconoIzquierdo']['name'];
                
            } else {
                $iconoIzquiedo = $rutas[0]['icono_izquierdo'];
            }
            if ($_FILES["iconoDerecho"]["tmp_name"]) {
                unlink($rutas[0]['icono_derecho']);
                $almacenar1 = move_uploaded_file($_FILES['iconoDerecho']['tmp_name'], utf8_decode($dir_subidaDerecho . $_FILES['iconoDerecho']['name']));
                $iconoDerecho = $dir_subidaDerecho . $_FILES['iconoDerecho']['name'];
            } else {
                $iconoDerecho = $rutas[0]['icono_derecho'];
                
            }
            
            $datosPlantilla = array(
                'nombrePlantilla' => $_REQUEST ['nombrePlantilla'],
                'descripcionPlantilla' => $_REQUEST ['descripcionPlantilla'],
                'id_plantilla' => $_REQUEST ['id']
            );
            $datosReporte = array(
                'empresa' => $_REQUEST ['empresa'],
                'tituloEncabezado' => $_REQUEST ['tituloEncabezado'],
                'otroDatoEncabezado' => $otro_Encabezado,
                'fechaCreacion' => $_REQUEST ['fechaCreacion'],
                'nomina' => $_REQUEST ['selectNomina'],
                'contenidoReporte' => $_REQUEST ['contenidoReporteGeneral'],
                'tituloPie' => $_REQUEST ['tituloPie'],
                'direccion' => $_REQUEST ['direccion'],
                'telefono' => $_REQUEST ['telefono'],
                'email' => $_REQUEST ['email'],
                'otroDatoPie' => $otro_Pie,
                'iconoIzquiero' => $iconoIzquiedo,
                'iconoDerecho' => $iconoDerecho,
                'atributosPersonaHidden' => str_replace("\\", "", $_REQUEST ['atributosPersonaHidden']),
                'atributosVinculacionHidden' => str_replace("\\", "", $_REQUEST ['atributosVinculacionHidden']),
                'atributosNovedadHidden' => str_replace("\\", "", $_REQUEST ['atributosNovedadHidden']),
                'DevengosdHidden' => str_replace("\\", "", $_REQUEST ['DevengosdHidden']),
                'DeduccionesdHidden' => str_replace("\\", "", $_REQUEST ['DeduccionesdHidden']),
                'atributosConceptodHidden' => str_replace("\\", "", $_REQUEST ['atributosConceptodHidden']),
                'novedadesdHidden' => str_replace("\\", "", $_REQUEST ['novedadesdHidden']),
                'selecNumeroFirmas' => $_REQUEST ['selecNumeroFirmas'],
                'selectNomina' => $_REQUEST ['selectNomina'],
                'id_reporte' => $_REQUEST ['id']
            );

            // Actualiza informacion general de reporte   
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("actualizarInformacionGeneral", $datosPlantilla);
            $resultado1 = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
//            echo $atributos ['cadena_sql'] . "<br>";
//            var_dump($resultado1);
            //Actualiza informacion de reporte  
            echo"<br>";
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("actualizarPlantillaReporte", $datosReporte);
            $resultado2 = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
//            echo $atributos ['cadena_sql'] . "<br>";
//            var_dump($resultado2);
//            //Al final se ejecuta la redirección la cual pasará el control a otra página

            if (!empty($resultado1) && !empty($resultado2)) {
                Redireccionador::redireccionar('modifico', $datosPlantilla);
                exit();
            } else {
                Redireccionador::redireccionar('nomodifico', $datosPlantilla);
                exit();
            }
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


