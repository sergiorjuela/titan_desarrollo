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
            $tipoPlantilla = "Certificado";
            $estado = "Activo";

            $datosPlantilla = array(
                'nombrePlantilla' => $_REQUEST ['nombrePlantilla'],
                'tipoPlantilla' => $tipoPlantilla,
                'descripcionPlantilla' => $_REQUEST ['descripcionPlantilla'],
                'estado' => $estado,
                'id' => "nextval('reporteador.sec_plantilla')"
            );
            $tmp_name = $_FILES["iconoIzquierdo"]["tmp_name"];
            $file1 = fopen($tmp_name, "rb");
            $imagen1 = fread($file1, filesize($tmp_name));
            fclose($file1);
            $imagen1 = pg_escape_bytea($imagen1);
            $tmp_name2 = $_FILES["iconoDerecho"]["tmp_name"];
            $file2 = fopen($tmp_name2, "rb");
            $imagen2 = fread($file2, filesize($tmp_name2));
            fclose($file2);
            $imagen2 = pg_escape_bytea($imagen2);
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
                'selecNumeroFirmas' => $_REQUEST ['selecNumeroFirmas'],
                'imagen1' => "$imagen1",
                'imagen2' => "$imagen2",
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
            echo "entro bien<br>";
            $tipoPlantilla = "Reporte General";
            $estado = "Activo";

            $datosPlantilla = array(
                'nombrePlantilla' => $_REQUEST ['nombrePlantilla'],
                'tipoPlantilla' => $tipoPlantilla,
                'descripcionPlantilla' => $_REQUEST ['descripcionPlantilla'],
                'estado' => $estado,
                'id' => "nextval('reporteador.sec_plantilla')"
            );
             echo "<br>";
                     
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

