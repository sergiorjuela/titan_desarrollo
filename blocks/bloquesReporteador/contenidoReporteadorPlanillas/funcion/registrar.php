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
        if ($_REQUEST ['tipoPlantilla'] == "1") {
            
            $cadenaObtenerConsecutivo= $this->miSql->getCadenaSql("ObtenerConsecutivo");
            $consecutivo = $primerRecursoDB->ejecutarAcceso($cadenaObtenerConsecutivo, "busqueda");
            $consecutivoArchivo = $consecutivo[0]['consecutivo']+1;
            $tipoPlantilla = "Certificado";
            $estado = "Activo";
            $fecha = date("Y-m-d");
            $nombreRuta = $_REQUEST ['nombrePlantilla'];
            $dir_subidaIzquierdo = "blocks/bloquesReporteador/Iconos/Certificado/IconoIzquierdo-$consecutivoArchivo-";
            $dir_subidaDerecho = "blocks/bloquesReporteador/Iconos/Certificado/IconoDerecho-$consecutivoArchivo-";
            $almacenar1 = move_uploaded_file($_FILES['iconoIzquierdo']['tmp_name'], utf8_decode($dir_subidaIzquierdo.$_FILES['iconoIzquierdo']['name']));
            $almacenar2 = move_uploaded_file($_FILES['iconoDerecho']['tmp_name'], utf8_decode($dir_subidaDerecho.$_FILES['iconoDerecho']['name']));
            
            $datosPlantilla = array(
                'nombrePlantilla' => $_REQUEST ['nombrePlantilla'],
                'tipoPlantilla' => $tipoPlantilla,
                'descripcionPlantilla' => $_REQUEST ['descripcionPlantilla'],
                'estado' => $estado,
                'id' => "nextval('reporteador.sec_plantilla')"
            );
            
            $datosCertificado = array(
                'empresa' => $_REQUEST ['empresa'],
                'tituloEncabezado' => $_REQUEST ['tituloEncabezado'],
                'otroDatoEncabezado' => $otro_Encabezado,
                'fechaCreacion' => $_REQUEST ['fechaCreacion'],
                'contenidoCertificado' => $_REQUEST ['contenidoCertificado'],
                'tituloPie' => $_REQUEST ['tituloPie'],
                'direccion' => $_REQUEST ['direccion'],
                'telefono' => $_REQUEST ['telefono'],
                'email' => $_REQUEST ['email'],
                'otroDatoPie' => $otro_Pie,
                'iconoizquierdo' => $dir_subidaIzquierdo.$_FILES['iconoIzquierdo']['name'],
                'iconoderecho' => $dir_subidaDerecho.$_FILES['iconoDerecho']['name'],
                'selecNumeroFirmas' => $_REQUEST ['selecNumeroFirmas'],
                'id' => "currval('reporteador.sec_plantilla')"
            );



            // Insertar informacion general de plantilla   
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarInformacionGeneral", $datosPlantilla);
            $resultado1 = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
            //var_dump($resultado1);
            // Insertar informacion de certificado   
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarPlantillaCertificado", $datosCertificado);
            $resultado2 = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
            //var_dump($resultado2);
            //Al final se ejecuta la redirección la cual pasará el control a otra página
            if (!empty($resultado1) && !empty($resultado2)) {
                Redireccionador::redireccionar('inserto', $datosPlantilla);
                exit();
            } else {
                Redireccionador::redireccionar('noInserto', $datosPlantilla);
                exit();
            }
        }

        if ($_REQUEST ['tipoPlantilla'] == "2") {
           
            $tipoPlantilla = "Reporte General";
            $estado = "Activo";
            $cadenaObtenerConsecutivo= $this->miSql->getCadenaSql("ObtenerConsecutivo");
            $consecutivo = $primerRecursoDB->ejecutarAcceso($cadenaObtenerConsecutivo, "busqueda");
            $consecutivoArchivo = $consecutivo[0]['consecutivo']+1;
           
            $datosPlantilla = array(
                'nombrePlantilla' => $_REQUEST ['nombrePlantilla'],
                'tipoPlantilla' => $tipoPlantilla,
                'descripcionPlantilla' => $_REQUEST ['descripcionPlantilla'],
                'estado' => $estado,
                'id' => "nextval('reporteador.sec_plantilla')"
            );
            $fecha = date("Y-m-d");
            $nombreRuta = $_REQUEST ['nombrePlantilla'];
            $dir_subidaIzquierdo = "blocks/bloquesReporteador/Iconos/Reporte General/IconoIzquierdo-$consecutivoArchivo-";
            $dir_subidaDerecho = "blocks/bloquesReporteador/Iconos/Reporte General/IconoDerecho-$consecutivoArchivo-";
            $almacenar1 = move_uploaded_file($_FILES['iconoIzquierdo']['tmp_name'], utf8_decode($dir_subidaIzquierdo.$_FILES['iconoIzquierdo']['name']));
            $almacenar2 = move_uploaded_file($_FILES['iconoDerecho']['tmp_name'], utf8_decode($dir_subidaDerecho.$_FILES['iconoDerecho']['name']));
           

            $datosReporte = array(
                'empresa' => $_REQUEST ['empresa'],
                'tituloEncabezado' => $_REQUEST ['tituloEncabezado'],
                'otroDatoEncabezado' => $otro_Encabezado,
                'fechaCreacion' => $_REQUEST ['fechaCreacion'],
                'nomina' => $_REQUEST ['selectNomina'],
                'contenidoCertificado' => $_REQUEST ['contenidoReporteGeneral'],
                'tituloPie' => $_REQUEST ['tituloPie'],
                'direccion' => $_REQUEST ['direccion'],
                'telefono' => $_REQUEST ['telefono'],
                'email' => $_REQUEST ['email'],
                'otroDatoPie' => $otro_Pie,
                'atributosPersonaHidden' => $_REQUEST ['atributosPersonaHidden'],
                'atributosVinculacionHidden' => $_REQUEST ['atributosVinculacionHidden'],
                'atributosNovedadHidden' => $_REQUEST ['atributosNovedadHidden'],
                'DevengosdHidden' => $_REQUEST ['DevengosdHidden'],
                'DeduccionesdHidden' => $_REQUEST ['DeduccionesdHidden'],
                'atributosConceptodHidden' => $_REQUEST ['atributosConceptodHidden'],
                'novedadesdHidden' => $_REQUEST ['novedadesdHidden'],
                'selecNumeroFirmas' => $_REQUEST ['selecNumeroFirmas'],
                'iconoizquierdo' => $dir_subidaIzquierdo.$_FILES['iconoIzquierdo']['name'],
                'iconoderecho' => $dir_subidaDerecho.$_FILES['iconoDerecho']['name'],
                'selectNomina' => $_REQUEST ['selectNomina'],
                'id' => "currval('reporteador.sec_plantilla')"
            );

            // Insertar informacion general de plantilla   
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarInformacionGeneral", $datosPlantilla);
            $resultado1 = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
            //var_dump($resultado1);
            // Insertar informacion de Reporte   
            echo "<br>";
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarPlantillaReporte", $datosReporte);
            $resultado2 = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
            //var_dump($resultado2);
            //Al final se ejecuta la redirección la cual pasará el control a otra página
            if (!empty($resultado1) && !empty($resultado2)) {
                Redireccionador::redireccionar('inserto', $datosPlantilla);
                exit();
            } else {
                Redireccionador::redireccionar('noInserto', $datosPlantilla);
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

