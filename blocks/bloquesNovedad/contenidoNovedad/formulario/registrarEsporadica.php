<?php

namespace bloquesNovedad\contenidoNovedad\formulario;

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

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
        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
        $rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];



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
        $atributos ['tipoFormulario'] = '';

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
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario($atributos);

        // ---------------- SECCION: Controles del Formulario -----------------------------------------------
        // --------------------------------------------------------------------------------------------------

        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "Formulario y Estructura de la novedad Esporádica";
        echo $this->miFormulario->marcoAgrupacion('inicio', $atributos); {
            $atributos ["id"] = "blocBotn";
            $atributos ["estilo"] = "col-md-5";
            echo $this->miFormulario->division("inicio", $atributos); {
                
            }
            echo $this->miFormulario->division("fin");
            $atributos ["id"] = "blocBotn";
            $atributos ["estilo"] = "col-md-2";
            echo $this->miFormulario->division("inicio", $atributos); {
                echo "<center>";
                echo "<input type=\"button\" id=\"btAgregar\" value=\"Añadir Campo\" class=\"btn btn-success btn-block\" />";
                echo "</center>";

                // ---------------- CONTROL: Select --------------------------------------------------------
            }
            echo $this->miFormulario->division("fin");
            echo '<br>';
            // --------------------------------------------------------------------------------------------------
            $atributos ["id"] = "camposDinamicosCont";
            $atributos ["estilo"] = "col-md-12";
            echo $this->miFormulario->division("inicio", $atributos); {
                unset($atributos);
                $atributos ["id"] = "camposDinamicos";
                $atributos ["estilo"] = "col-md-12";
                echo $this->miFormulario->division("inicio", $atributos); {
                    
                }
                echo $this->miFormulario->division("fin");

                unset($atributos);
                $atributos ["id"] = "blocBotn";
                $atributos ["estilo"] = "col-md-5";
                echo $this->miFormulario->division("inicio", $atributos); {
                    
                }
                echo $this->miFormulario->division("fin");
                $atributos ["id"] = "blocBotn";
                $atributos ["estilo"] = "col-md-2";
                echo $this->miFormulario->division("inicio", $atributos); {
                    echo "<center>";
                    echo "<input type=\"button\" id=\"btEliminar\" value=\"Eliminar Campo\" class=\"btn btn-danger btn-block\" />";
                    echo "</center>";

                    // ---------------- CONTROL: Select --------------------------------------------------------
                }
                echo $this->miFormulario->division("fin");
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = "marcoDatosBasicos";
                $atributos ['id'] = $esteCampo;
                $atributos ["estilo"] = "jqueryui";
                $atributos ["leyenda"] = "Campos Creados";
                echo $this->miFormulario->marcoAgrupacion('inicio', $atributos); {
                    echo '<table id="tablaCampos" class="display" cellspacing="0" width="100%"> '
                    . '<thead style="display: table-row-group"><tr><th>' . "NOMBRE" . '</th><th>' . "LABEL" . '</th> <th>' . "TIPO DATO" . '</th><th>' . "REQUERIDO" . '</th><th>' . "FORMULA" . '</th><th>' . "SIMBOLO" . '</th></tr></thead>
                    ';
                    echo '</table>';
                }
                echo $this->miFormulario->marcoAgrupacion('fin');


                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                unset($atributos);

                //***********************************************************************************************
                //***********************************************************************************************
                //  ***********************************************************************************************                     
                //***********************************************************************************************
                //***********************************************************************************************
                //Campos atributos pagina anterior Info Basica

                unset($atributos);
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'tipoNovedadInfo';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;

                if (isset($_REQUEST ['tipoNovedad'])) {
                    $atributos ['valor'] = $_REQUEST ['tipoNovedad'];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['maximoTamanno'] = '';
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'categoriaConceptosInfo';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;

                if (isset($_REQUEST ['categoriaConceptos'])) {
                    $atributos ['valor'] = $_REQUEST ['categoriaConceptos'];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['maximoTamanno'] = '';
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'nombreInfo';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;

                if (isset($_REQUEST ['nombre'])) {
                    $atributos ['valor'] = $_REQUEST ['nombre'];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['maximoTamanno'] = '';
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'simboloInfo';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;

                if (isset($_REQUEST ['simbolo'])) {
                    $atributos ['valor'] = $_REQUEST ['simbolo'];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['maximoTamanno'] = '';
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'leyInfo';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;

                if (isset($_REQUEST ['leyRegistros'])) {
                    $atributos ['valor'] = $_REQUEST ['leyRegistros'];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['maximoTamanno'] = '';
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'naturalezaInfo';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;

                if (isset($_REQUEST ['naturaleza'])) {
                    $atributos ['valor'] = $_REQUEST ['naturaleza'];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['maximoTamanno'] = '';
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
                $esteCampo = 'descripcionInfo';
                $atributos ['id'] = $esteCampo;
                $atributos ['nombre'] = $esteCampo;
                $atributos ['tipo'] = 'hidden';
                $atributos ['estilo'] = 'jqueryui';
                $atributos ['marco'] = true;
                $atributos ['columnas'] = 1;
                $atributos ['dobleLinea'] = false;
                $atributos ['tabIndex'] = $tab;

                if (isset($_REQUEST ['descripcion'])) {
                    $atributos ['valor'] = $_REQUEST ['descripcion'];
                } else {
                    $atributos ['valor'] = '';
                }
                $atributos ['deshabilitado'] = false;
                $atributos ['maximoTamanno'] = '';
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoCuadroTexto($atributos);
                // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
                //***********************************************************************************************
                //***********************************************************************************************
                // ------------------Division para los botones-------------------------
                $atributos ["id"] = "botones";
                $atributos ["estilo"] = "marcoBotones";
                echo $this->miFormulario->division("inicio", $atributos);

                unset($atributos);
                // ---------------- CONTROL: Select --------------------------------------------------------
                $atributos ["id"] = "confirmar";
                $atributos ["estilo"] = "col-md-4";
                echo $this->miFormulario->division("inicio", $atributos);
                {
                    echo "<center>";
                    echo "<input type=\"button\" id=\"confirmarDina2\" value=\"Confirmar\" class=\"btn btn-primary btn-block\" onclick=\"PasoComponente()\" />";
                    echo "</center>";
                }
                echo $this->miFormulario->division("fin");

                unset($atributos);

                // -----------------CONTROL: Botón ----------------------------------------------------------------
                $esteCampo = 'siguiente';
                $atributos ["id"] = $esteCampo;
                $atributos ["tabIndex"] = $tab;
                $atributos ["tipo"] = 'boton';
                // submit: no se coloca si se desea un tipo button genérico
                $atributos ['submit'] = true;
                $atributos ["estiloMarco"] = '';
                $atributos ["estiloBoton"] = 'jqueryui';
                // verificar: true para verificar el formulario antes de pasarlo al servidor.
                $atributos ["verificar"] = true;
                $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                $atributos ["valor"] = $this->lenguaje->getCadena($esteCampo);
                $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
                $tab++;

                // Aplica atributos globales al control
                $atributos = array_merge($atributos, $atributosGlobales);
                echo $this->miFormulario->campoBoton($atributos);



                // -----------------FIN CONTROL: Botón -----------------------------------------------------------
                // ------------------Fin Division para los botones-------------------------
                echo $this->miFormulario->division("fin");
            }
            echo $this->miFormulario->division("fin");
        }
        echo $this->miFormulario->marcoAgrupacion('fin');
        // ------------------- SECCION: Paso de variables ------------------------------------------------

        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'variablesCampo';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['valor'] = '';
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'camposFormulacion';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['valor'] = '';
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab++;

        // Aplica atributos globales al control
        $atributos = array_merge($atributos, $atributosGlobales);
        echo $this->miFormulario->campoCuadroTexto($atributos);
        unset($atributos);



        /**


          // ---------------- CONTROL: Tabla Cargos -----------------------------------------------
          //
          //        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarRegistroxCargo");
          //        $matrizItems=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
          //
          //        echo $this->miFormulario->tablaReporte($matrizItems);
          //
          //       echo $this->miFormulario->marcoAgrupacion ( 'fin' );

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
//        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"]; //Ir pagina Funcionalidad
        $valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion('pagina'); //Frontera mostrar formulario
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];

        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=formulacion";
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