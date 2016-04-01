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

        //---------------------OBTENER DATOS ACTUALES PARA EL REGISTRO----------------------------------
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("obtenerPlantillaCertificadoporId", $_REQUEST['variable']);
        $resultado = $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");

        //----------------------------------------------------------------------------------------
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);

        // ---------------- SECCION: Controles del Formulario -----------------------------------------------
        // --------------------------------------------------------------------------------------------------

        $esteCampo = "marcoPlantillaVerCertificado";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = $atributos ["leyenda"] = $this->lenguaje->getCadena($esteCampo) . " / Estado: " . $resultado[0]['estado'] . " / Tipo: " . $resultado[0]['tipo'];
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);

        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
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
      
        $atributos ['validar'] = 'required, maxSize[100]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['nombre'];
            ;
        }
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
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

        $atributos ['validar'] = 'maxSize[300]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['descripcion'];
        }
        $atributos ['deshabilitado'] = true;
        $atributos ['columnas'] = 40;
        $atributos ['filas'] = 4;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoTextArea($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        //------------------CONTROL CREACION MARCO DE AGRUPACION ENCABEZADO---------------------------------------------------
        $esteCampo = "divisionEncabezado";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = $atributos ["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos);





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
        $atributos ['validar'] = 'required, maxSize[200],minSize[1]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['empresa'];
        }
        $atributos ['deshabilitado'] = true;
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
        $atributos ['validar'] = 'required, maxSize[300], minSize[10]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['titulo_encabezado'];
        }
        $atributos ['deshabilitado'] = true;
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
        $atributos ['validar'] = 'maxSize[300]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['otro_encabezado'];
        }
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
//        // // ---------------- CONTROL: Input Date --------------------------------------------------------
        $esteCampo = 'fechaCreacionVerDetalle';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 150;
        $atributos ['validar'] = 'required';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['fecha_creacion'];
        }
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : Cuadro de Input File --------------------------------------------------

       
        
        //$imagen1 = pg_unescape_bytea($resultado[0]['imagen_1']);
        //echo $imagen1;
        //echo "<img id=\"iconoIzquierdoAnterior\" src=\"\" />";
       
        // // ---------------- CONTROL: Cuadro hidden Texto imagen 1--------------------------------------------------------
//        $esteCampo = 'hiddenimagen1';
//        $atributos ['id'] = $esteCampo;
//        $atributos ['nombre'] = $esteCampo;
//        $atributos ['tipo'] = 'hidden';
//        if (isset($_REQUEST [$esteCampo])) {
//            $atributos ['valor'] = $_REQUEST [$esteCampo];
//        } else {
//            $atributos ['valor'] = $imagen1;
//        }
    

        // Aplica atributos globales al control
//        $atributos = array_merge($atributos, $atributosGlobales);
//        echo $this->miFormulario->campoCuadroTexto($atributos);
//        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
//     
        
        
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

        $atributos ["id"] = "divContenido";
        $atributos ["estilo"] = "col-md-8";
        echo $this->miFormulario->division("inicio", $atributos);

        //--------------------- CONTROL CONTENIDO DEL CERTIFICADO---------------------------------

        $esteCampo = 'contenidoCertificado';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['validar'] = 'required';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['cuerpo'];
        }

        $atributos ['deshabilitado'] = true;
        $atributos ['columnas'] = 70;
        $atributos ['filas'] = 18;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoTextArea($atributos);
        unset($atributos);
        //---------------------FIN CONTROL CONTENIDO DEL CERTIFICADO---------------------------------
        echo $this->miFormulario->division("fin");
        //---------------------FIN DIV CUERPO DEL CERTIFICADO---------------------------------
        
        echo $this->miFormulario->division("fin");
        echo "<br>";
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
         $atributos ['validar'] = 'required, maxSize[300],minSize[10]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['titulo_pie'];
        }
        $atributos ['deshabilitado'] = true;
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
        $atributos ['validar'] = 'required, maxSize[200],minSize[5]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['direccion'];
        }
        $atributos ['deshabilitado'] = false;
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
        $atributos ['tipo'] = 'number';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 2;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena($esteCampo);
        $atributos ['anchoEtiqueta'] = 100;
        $atributos ['validar'] = 'required, maxSize[12],minSize[7]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['telefono'];
        }
        $atributos ['deshabilitado'] = true;
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
        $atributos ['validar'] = 'required, maxSize[70],minSize[5]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['email'];
        }
        $atributos ['deshabilitado'] = true;
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
        $atributos ['validar'] = 'maxSize[200]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['otro_pie'];
        }
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Input otrodatopie --------------------------------------------------
        // --------------- CONTROL :Select Numero de Firmas --------------------------------------------------
        // // ---------------- CONTROL: cuadro de texto otroDatoPie --------------------------------------------------------
        $esteCampo = 'selecNumeroFirmas';
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
        $atributos ['validar'] = 'maxSize[200]';

        if (isset($_REQUEST [$esteCampo])) {
            $atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
            $atributos ['valor'] = $resultado[0]['numero_firmas'];
        }
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        // --------------- FIN CONTROL : Cuadro de Input otrodatopie --------------------------------------------------
      
        echo $this->miFormulario->marcoAgrupacion('fin');
        //--------------------FIN CONTROL MARCO DE AGRUPACION ENCABEZADO------------------------------------------------------
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        $atributos ["titulo"] = "Enviar Información";
        echo $this->miFormulario->division("inicio", $atributos);

        // -----------------CONTROL: Botón ----------------------------------------------------------------
//        $esteCampo = 'EditarPlantilla';
//        $atributos ["id"] = $esteCampo;
//        $atributos ["tabIndex"] = $tab;
//        $atributos ["tipo"] = 'boton';
//        // submit: no se coloca si se desea un tipo button genérico
//        $atributos ['submit'] = true;
//        $atributos ["estiloMarco"] = '';
//        $atributos ["estiloBoton"] = 'jqueryui';
//        // verificar: true para verificar el formulario antes de pasarlo al servidor.
//        $atributos ["verificar"] = '';
//        $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
//        $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
//        $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
//        $tab ++;
//        // Aplica atributos globales al control
//        $atributos = array_merge($atributos, $atributosGlobales);
//        echo $this->miFormulario->campoBoton($atributos);
        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
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
        $valorCodificado .= "&tipo=" . $resultado[0]['tipo'];
        $valorCodificado .= "&estado=" . $resultado[0]['estado'];
        $valorCodificado .= "&id=" . $resultado[0]['id_plantilla_certificado'];
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