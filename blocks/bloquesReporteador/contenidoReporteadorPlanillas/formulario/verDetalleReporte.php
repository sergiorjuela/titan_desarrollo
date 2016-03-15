<?php

namespace bloquesReporteador\contenidoReporteadorPlanillas\formulario;

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

/**
 * Description of Formulario
 *
 * @author Toshiba
 */
class Formulario {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;

    function __construct($lenguaje, $formulario, $sql) {

        $this->miConfigurador = \Configurador::singleton();

        $this->miConfigurador->fabricaConexiones->setRecursoDB('principal');

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;

        $this->miSql = $sql;
    }

    function formulario() {

        /**
         * IMPORTANTE: Este formulario está utilizando jquery.
         * Por tanto en el archivo ready.php se delaran algunas funciones js
         * que lo complementan.
         */
        // Rescatar los datos de este bloque
        $directorio = $this->miConfigurador->getVariableConfiguracion("host");
        $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
        $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
        /**
         * Atributos que deben ser aplicados a todos los controles de este formulario.
         * Se utiliza un arreglo
         * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
         *
         * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
         * $atributos= array_merge($atributos,$atributosGlobales);
         */
        $atributosGlobales ['campoSeguro'] = 'true';
        $_REQUEST['tiempo'] = time();

        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        //var_dump($primerRecursoDB);
        //exit;
        // -------------------------------------------------------------------------------------------------
        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;

        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = 'multipart/form-data';

        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';

        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        $atributos ['titulo'] = false; //$this->lenguaje->getCadena ( $esteCampo );
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // //---------------------OBTENER DATOS ACTUALES PARA EL REGISTRO----------------------------------
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerPlantillaReporteporId", $_REQUEST['variable']);
        $resultado = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
        //----------------------------------------------------------------------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);

        // ---------------- SECCION: Controles del Formulario -----------------------------------------------
        // --------------------------------------------------------------------------------------------------

        $esteCampo = "marcoPlantillaVerReporte";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = $atributos ["leyenda"] = $this->lenguaje->getCadena($esteCampo) . "Nombre: " . $resultado[0]['nombre'] . " / Tipo: " . $resultado[0]['tipo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

         $esteCampo = "divisionNombre";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "col-md-4";
        echo $this->miFormulario->division("inicio", $atributos);
        
        $esteCampo = 'nombrePlantilla';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 200;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, maxSize[100]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['nombre'];
            ;
        }
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        echo $this->miFormulario->division("fin");
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        $esteCampo = "divisionDescripcion";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "col-md-8";
        echo $this->miFormulario->division("inicio", $atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'descripcionPlantilla';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);

        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'maxSize[300]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['descripcion'];
        }

        $atributos ['columnas'] = 60;
        $atributos ['filas'] = 4;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoTextArea($atributos);
        unset($atributos);
        echo $this->miFormulario->division("fin");
        
        //------------------CONTROL CREACION MARCO DE AGRUPACION ENCABEZADO---------------------------------------------------
        $esteCampo = "divisionEncabezado";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = $atributos ["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
       
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // // ---------------- CONTROL: Cuadro de Texto Empresa --------------------------------------------------------
        $esteCampo = 'empresa';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 250;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, maxSize[200],minSize[1]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['empresa'];
        }

        $atributos ['tamanno'] = 50;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // // ---------------- CONTROL: Cuadro de Texto titulo--------------------------------------------------------
        $esteCampo = 'tituloEncabezado';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 150;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, maxSize[300], minSize[10]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['titulo_encabezado'];
        }

        $atributos ['tamanno'] = 50;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // // ---------------- CONTROL: Cuadro de Texto Otro--------------------------------------------------------
        $esteCampo = 'otroDatoEncabezado';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 100;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = false;
        $atributos ['validar'] = 'maxSize[300]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['otro_encabezado'];
        }

        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
//        // // ---------------- CONTROL: Input Date --------------------------------------------------------
        $esteCampo = 'fechaCreacion';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 150;
        $atributos ['deshabilitado'] = true;
        $atributos ['validar'] = 'required';
        
        $atributos ['etiquetaObligatorio'] = true;


        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['fecha_creacion'];
        }
       
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Input File --------------------------------------------------

        $esteCampo = "marcoIconosCertificado";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] =  $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);
        
       
        
        $atributos ["id"] = "divIconoIzquierda";
        $atributos ["estilo"] = "col-md-6";
        echo $this->miFormulario->division("inicio", $atributos);
        echo "<label class=\"control-label\">Icono Derecho</label>";
       
        $esteCampo = "iconoIzquierdo";
        $atributos['id'] = $esteCampo;
        $atributos ['estilo'] = "jqueryui";
        $atributos['imagen'] = $resultado[0]['icono_izquierdo'];
        $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoImagen($atributos);
        echo $this->miFormulario->division("fin");
        
       
        
        $atributos ["id"] = "divIconoIzquierda";
        $atributos ["estilo"] = "col-md-6";
        echo $this->miFormulario->division("inicio", $atributos);
         echo "<label class=\"control-label\">Icono Derecho</label>";
        $esteCampo = "iconoDerecho";
        $atributos['id'] = $esteCampo;
        $atributos ['estilo'] = "jqueryui";
        $atributos['imagen'] = $resultado[0]['icono_derecho'];
        $atributos['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoImagen($atributos);
        echo $this->miFormulario->division("fin");
       
       echo $this->miFormulario->marcoAgrupacion('fin');

        echo $this->miFormulario->marcoAgrupacion('fin');
        //--------------------FIN CONTROL MARCO DE AGRUPACION ENCABEZADO------------------------------------------------------
        //---------------------MARCO DE AGRUPACION CUERPO DEL CERTIFICADO---------------------------------

        $esteCampo = "divisionCuerpo";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = $atributos ["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);


        //---------------------DIV CUERPO DEL CERTIFICADO---------------------------------
        //--------------------- CONTROL CONTENIDO DEL CERTIFICADO---------------------------------
        //---------------------DIV CUERPO DEL CERTIFICADO---------------------------------

        $atributos ["id"] = "divContenido";
        $atributos ["estilo"] = "col-md-4";
        echo $this->miFormulario->division("inicio", $atributos);

        //--------------------- CONTROL CONTENIDO DEL CERTIFICADO---------------------------------

        $esteCampo = 'contenidoReporteGeneral';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['cuerpo'];
        }


        $atributos ['columnas'] = 32;
        $atributos ['filas'] = 15;
        $atributos ['maximoTamanno'] = '100';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoTextArea($atributos);
        unset($atributos);
        //---------------------FIN CONTROL CONTENIDO DEL CERTIFICADO---------------------------------
        echo $this->miFormulario->division("fin");
        //---------------------FIN DIV CUERPO DEL CERTIFICADO---------------------------------





        $atributos ["id"] = "divInfoPersonas";
        $atributos ["estilo"] = "col-md-4";
        echo $this->miFormulario->division("inicio", $atributos);

        // --------------- CONTROL :Select Nomina --------------------------------------------------
        $esteCampo = 'selectNomina';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos ['seleccion'] = -1;
        $atributos['evento'] = ' ';
        $atributos['deshabilitado'] = true;
        $atributos['limitar'] = 50;
        $atributos['tamanno'] = 1;
        $atributos ['anchoEtiqueta'] = 350;
        $atributos['columnas'] = 1;
        $atributos ['obligatorio'] = true;
        $atributos ['validar'] = 'required';
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerNominas");
        $matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

        $atributos['matrizItems'] = $matrizItems;

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['seleccion'] = $resultado[0]["nomina"];
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);




        // --------------- FIN CONTROL :Select Nomina --------------------------------------------------
//         // --------------- CONTROL :Select Atributos Persona --------------------------------------------------
        $esteCampo = 'selecAtributosPersonasReporte';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos ['evento'] = '';
        $atributos ['deshabilitado'] = true;
        $atributos ['limitar'] = 50;
        $atributos ['tamanno'] = 1;
        $atributos ['anchoEtiqueta'] = 300;
        $atributos ['columnas'] = 1;
        $atributos ['obligatorio'] = true;
        $atributos ['validar'] = 'required';
        $atributos ['multiple'] = true;
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerAtributosPersona");
        $matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

        for ($i = 0; $i < count($matrizItems); $i++) {
            $camposAtributosPersonas[$i] = array($matrizItems[$i]["column_name"], $matrizItems[$i]["column_name"]);
        }
        //var_dump($camposAtributosPersonas);
        $atributos['matrizItems'] = $camposAtributosPersonas;


        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);
//
//      // --------------- FIN CONTROL :Select Atributos Persona --------------------------------------------------
//      // --------------- CONTROL :Select Atributos de Vinculacion --------------------------------------------------
        $esteCampo = 'selecAtributosVinculacionReporte';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos ['seleccion'] = -1;
        $atributos['evento'] = '';
        $atributos['deshabilitado'] = true;
        $atributos['limitar'] = 50;
        $atributos['tamanno'] = 1;
        $atributos ['anchoEtiqueta'] = 350;
        $atributos['columnas'] = 1;
        $atributos ['obligatorio'] = true;
        $atributos ['validar'] = 'required';
        $atributos ['multiple'] = true;
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerAtributosVinculacion");
        $matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

        for ($i = 0; $i < count($matrizItems); $i++) {
            $camposAtributosVinculacion[$i] = array($matrizItems[$i]["column_name"], $matrizItems[$i]["column_name"]);
        }

        $atributos['matrizItems'] = $camposAtributosVinculacion;


        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);



        // --------------- FIN CONTROL :Select Atributos de Vinculacion --------------------------------------------------
        // --------------- CONTROL :Select Novedades --------------------------------------------------
        $esteCampo = 'selecNovedades';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos ['seleccion'] = -1;
        $atributos['evento'] = '';
        $atributos['deshabilitado'] = true;
        $atributos['limitar'] = 50;
        $atributos['tamanno'] = 1;
        $atributos ['anchoEtiqueta'] = 350;
        $atributos['columnas'] = 1;
        $atributos ['obligatorio'] = true;
        $atributos ['validar'] = 'required';
        $atributos ['multiple'] = true;
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerAtributosVinculacion");
        $matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

        for ($i = 0; $i < count($matrizItems); $i++) {
            $camposNovedades[$i] = array($matrizItems[$i]["column_name"], $matrizItems[$i]["column_name"]);
        }
        $atributos['matrizItems'] = $camposNovedades;

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);

        // --------------- FIN CONTROL :Select Novedades --------------------------------------------------
        // --------------- CONTROL :Select Atributos de Novedad --------------------------------------------------
        $esteCampo = 'selecAtributosNovedades';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos ['seleccion'] = -1;
        $atributos['evento'] = ' ';
        $atributos['deshabilitado'] = true;
        $atributos['limitar'] = 50;
        $atributos['tamanno'] = 5;
        $atributos ['anchoEtiqueta'] = 350;
        $atributos['columnas'] = 1;
        $atributos ['obligatorio'] = true;
        $atributos ['validar'] = 'required';
        $atributos ['multiple'] = true;
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerAtributosVinculacion");
        $matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");

        for ($i = 0; $i < count($matrizItems); $i++) {
            $camposAtributosNovedad[$i] = array($matrizItems[$i]["column_name"], $matrizItems[$i]["column_name"]);
        }
        $atributos['matrizItems'] = $camposAtributosNovedad;

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);



        // --------------- FIN CONTROL :Select Atributos de Novedad --------------------------------------------------
        //        


        echo $this->miFormulario->division("fin");
        //---------------------FIN DIV INFOPERSONA DEL CERTIFICADO---------------------------------




        $atributos ["id"] = "divInfoConceptos";
        $atributos ["estilo"] = "col-md-4";
        echo $this->miFormulario->division("inicio", $atributos);

        // --------------- CONTROL :Select Conceptos Devengo --------------------------------------------------
        $esteCampo = 'selectConceptosDevengoReporte';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos ['seleccion'] = -1;
        $atributos['evento'] = ' ';
        $atributos['deshabilitado'] = true;
        $atributos['limitar'] = 50;
        $atributos['tamanno'] = 1;
        $atributos ['anchoEtiqueta'] = 350;
        $atributos['columnas'] = 1;
        $atributos ['obligatorio'] = true;
        $atributos ['validar'] = 'required';
        $atributos ['multiple'] = true;
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerDevengaConcepto");
        $matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
        //var_dump($matrizItems);
        $atributos['matrizItems'] = $matrizItems;

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);

        // --------------- FIN CONTROL :Select Atributos Persona --------------------------------------------------
        // --------------- CONTROL :Select Conceptos Devengo --------------------------------------------------
        $esteCampo = 'selectConceptosDeduccionesReporte';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos ['seleccion'] = -1;
        $atributos['evento'] = ' ';
        $atributos['deshabilitado'] = true;
        $atributos['limitar'] = 50;
        $atributos['tamanno'] = 1;
        $atributos ['anchoEtiqueta'] = 350;
        $atributos['columnas'] = 1;
        $atributos ['obligatorio'] = true;
        $atributos ['validar'] = 'required';
        $atributos ['multiple'] = true;
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerDeduceConcepto");
        $matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
        $atributos['matrizItems'] = $matrizItems;

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);

        // --------------- FIN CONTROL :Select Atributos Persona --------------------------------------------------
        // --------------- CONTROL :Select Atributos de Novedad --------------------------------------------------
        $esteCampo = 'selecAtributosConceptos';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos ['seleccion'] = -1;
        $atributos['evento'] = ' ';
        $atributos ['deshabilitado'] = true;
        $atributos['limitar'] = 50;
        $atributos['tamanno'] = 5;
        $atributos ['anchoEtiqueta'] = 350;
        $atributos['columnas'] = 1;
        $atributos ['obligatorio'] = true;
        $atributos ['validar'] = 'required';
        $atributos ['multiple'] = true;
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerAtributosConcepto");
        $matrizItems = $primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "busqueda");
        for ($i = 0; $i < count($matrizItems); $i++) {
            $camposAtributoConcepto[$i] = array($matrizItems[$i]["column_name"], $matrizItems[$i]["column_name"]);
        }
        //var_dump($camposAtributoConcepto);
        $atributos['matrizItems'] = $camposAtributoConcepto;

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = '';
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);



        // --------------- FIN CONTROL :Select Atributos de Novedad --------------------------------------------------
        //---------------------FIN DIV INFOPERSONA DEL CERTIFICADO---------------------------------

        echo $this->miFormulario->division("fin");


        echo $this->miFormulario->marcoAgrupacion('fin');
        //---------------------FIN DE AGRUPACION CUERPO DEL CERTIFICADO---------------------------------
        //------------------CONTROL CREACION MARCO DE AGRUPACION PIE DE PAGINA---------------------------------------------------
        $esteCampo = "divisionPiePagina";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = $atributos ["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

        // // ---------------- CONTROL: Cuadro de Texto titulo --------------------------------------------------------
        $esteCampo = 'tituloPie';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 150;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, maxSize[300],minSize[10]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['titulo_pie'];
        }

        $atributos ['tamanno'] = 40;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // // ---------------- CONTROL: Cuadro de Texto direccion--------------------------------------------------------
        $esteCampo = 'direccion';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 100;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, maxSize[200],minSize[5]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['direccion'];
        }
        ;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // // ---------------- CONTROL: Cuadro de Texto telefono--------------------------------------------------------
        $esteCampo = 'telefono';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 100;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, maxSize[12],minSize[7],custom[onlyNumberSp]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['telefono'];
        }

        $atributos ['tamanno'] = 10;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // // ---------------- CONTROL: Input email --------------------------------------------------------
        $esteCampo = 'email';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'email';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 100;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, maxSize[70],minSize[5],custom[email]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['email'];
        }

        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Input email --------------------------------------------------
        // // ---------------- CONTROL: cuadro de texto otroDatoPie --------------------------------------------------------
        $esteCampo = 'otroDatoPie';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 100;
        $atributos ['obligatorio'] = true;
        $atributos ['deshabilitado'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'maxSize[200]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['otro_pie'];
        }

        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Input otrodatopie --------------------------------------------------
        // --------------- CONTROL :Select Numero de Firmas --------------------------------------------------
        $esteCampo = 'selecNumeroFirmas';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['tab'] = $tab;
        $atributos['evento'] = ' ';
        $atributos['deshabilitado'] = true;
        $atributos['limitar'] = 50;
        $atributos['tamanno'] = 1;
        $atributos ['anchoEtiqueta'] = 250;
        $atributos['columnas'] = 4;
        $atributos ['obligatorio'] = true;

        $atributos ['validar'] = 'required';

        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerOpcionesInfoPersona");
        $matrizItems = array(
            array(1, '1'),
            array(2, '2'),
            array(3, '3')
        );

        $atributos['matrizItems'] = $matrizItems;

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['seleccion'] = $resultado[0]['numero_firmas'];
        }
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);
        //----------------------------FIN select Numero de firmas---------------------------------------------
        // // ---------------- CONTROL: hidden Atributos Personas--------------------------------------------------------
        $esteCampo = 'atributosPersonaHidden';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        $atributos ['valor'] = $resultado[0]['atributos_persona'];
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = "";
        //var_dump($resultado[0]['atributos_persona']);
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : hidden Atributos Personas --------------------------------------------------
        // // ---------------- CONTROL: hidden Atributos Vinculacion--------------------------------------------------------
        $esteCampo = 'atributosVinculacionHidden';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        $atributos ['valor'] = $resultado[0]['atributos_vinculacion'];
        ;
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : hidden Atributos Vinculacion --------------------------------------------------
        // // ---------------- CONTROL: hidden Atributos Novedad--------------------------------------------------------
        $esteCampo = 'atributosNovedadHidden';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        $atributos ['valor'] = $resultado[0]['atributos_novedades'];
        ;
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;


        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : hidden Atributos Novedad --------------------------------------------------
        // // ---------------- CONTROL: hidden Devengos--------------------------------------------------------
        $esteCampo = 'DevengosdHidden';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        //var_dump($resultado[0]['conceptos_devenga']);
        $atributos ['valor'] = $resultado[0]['conceptos_devenga'];
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : hidden Devengos --------------------------------------------------
        // // ---------------- CONTROL: hidden Deducciones--------------------------------------------------------
        $esteCampo = 'DeduccionesdHidden';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        $atributos ['valor'] = $resultado[0]['conceptos_deduce'];
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : hidden Deducciones --------------------------------------------------
        // // ---------------- CONTROL: hidden Atributos Concepto--------------------------------------------------------
        $esteCampo = 'atributosConceptodHidden';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        $atributos ['valor'] = $resultado[0]['atributos_conceptos'];
        //var_dump( $resultado[0]['atributos_conceptos']);
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : hidden Atributos Novedad --------------------------------------------------
        // // ---------------- CONTROL: hidden Atributos novedades--------------------------------------------------------
        $esteCampo = 'novedadesdHidden';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;

        $atributos ['valor'] = $resultado[0]['novedades'];
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : hidden Atributos novedades --------------------------------------------------
        // // ---------------- CONTROL: hidden Atributos novedades--------------------------------------------------------
        $esteCampo = 'estadoPagina';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['valor'] = "modificar";
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : hidden Atributos novedades --------------------------------------------------

        echo $this->miFormulario->marcoAgrupacion('fin');
        //--------------------FIN CONTROL MARCO DE AGRUPACION ENCABEZADO------------------------------------------------------
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        $atributos ["titulo"] = "Enviar Información";
        echo $this->miFormulario->division("inicio", $atributos);

        // -----------------CONTROL: Boton de Regreso
        // Este boton regresa a la pagina principal de plantillas
        $esteCampo = "botonRegreso";
        $atributos["id"] = $esteCampo;
        $atributos["tabIndex"] = $tab;
        $variableRegreso = "pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina'); // pendiente la pagina para modificar parametro
        $variableRegreso .= "&opcion=regresar";
        $variableRegreso .= "&bloque=" . $esteBloque ['nombre'];
        $variableRegreso .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $variableRegreso = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableRegreso, $directorio);
        $atributos["enlace"] = $variableRegreso;
        $atributos["estilo"] = "jqueryui";
        $atributos["enlaceTexto"] = $this->lenguaje->getCadena($esteCampo);
        $atributos = array_merge($atributos, $atributosGlobales);

        echo $this->miFormulario->enlace($atributos);
        // -------------------------Fin Control Boton------------------------------------------------------
        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
        echo $this->miFormulario->marcoAgrupacion('fin');
        // ------------------- SECCION: Paso de variables ------------------------------------------------

        /**
         * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
         * SARA permite realizar esto a través de tres
         * mecanismos:
         * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
         * la base de datos.
         * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
         * formsara, cuyo valor será una cadena codificada que contiene las variables.
         * (c) a través de campos ocultos en los formularios. (deprecated)
         */
        // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
        // Paso 1: crear el listado de variables

        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"]; //Ir pagina Funcionalidad
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina'); //Frontera mostrar formulario
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=modificarPlantilla";
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. 
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);

        // ----------------FIN SECCION: Paso de variables -------------------------------------------------
        // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
        // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
        // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario($atributos);

        return true;
    }

    function mensaje() {

        // Si existe algun tipo de error en el login aparece el siguiente mensaje
        $mensaje = $this->miConfigurador->getVariableConfiguracion('mostrarMensaje');
        $this->miConfigurador->setVariableConfiguracion('mostrarMensaje', null);

        if ($mensaje) {

            $tipoMensaje = $this->miConfigurador->getVariableConfiguracion('tipoMensaje');

            if ($tipoMensaje == 'json') {

                $atributos ['mensaje'] = $mensaje;
                $atributos ['json'] = true;
            } else {
                $atributos ['mensaje'] = $this->lenguaje->getCadena($mensaje);
            }
            // -------------Control texto-----------------------
            $esteCampo = 'divMensaje';
            $atributos ['id'] = $esteCampo;
            $atributos ["tamanno"] = '';
            $atributos ["estilo"] = 'information';
            $atributos ["etiqueta"] = '';
            $atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
            echo $this->miFormulario->campoMensaje($atributos);
            unset($atributos);
        }

        return true;
    }

}

$miFormulario = new Formulario($this->lenguaje, $this->miFormulario, $this->sql);


$miFormulario->formulario();
$miFormulario->mensaje();
?>