<?php 
namespace bloquesParametro\parametroLiquidacion\formulario;
if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
class Formulario {
    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    function __construct($lenguaje, $formulario, $sql) {
        $this->miConfigurador = \Configurador::singleton ();
        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
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
        $esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
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
        $_REQUEST['tiempo']=time();
        
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
        $atributos ['titulo'] = false;//$this->lenguaje->getCadena ( $esteCampo );
        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario ( $atributos );
        // ---------------- SECCION: Controles del Formulario -----------------------------------------------
        
        
       
        
        // --------------------------------------------------------------------------------------------------
        
        $esteCampo = "marcoDatosBasicos";
	$atributos ['id'] = $esteCampo;
	$atributos ["estilo"] = "jqueryui";
	$atributos ['tipoEtiqueta'] = 'inicio';
	$atributos ["leyenda"] = "Modificar";
	echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
        
       
        
        
        
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarParametroLiquidacion");
      
        $resultado=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
        
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        
               
                $_REQUEST['id'] =  $resultado[$_REQUEST['variable']]['id'];
                $_REQUEST['nombre'] =  $resultado[$_REQUEST['variable']]['nombre'];
		$_REQUEST['descripcion'] =  $resultado[$_REQUEST['variable']]['descripcion'];
                $_REQUEST['simbolo'] =  $resultado[$_REQUEST['variable']]['simbolo'];
               $_REQUEST['categoria'] =  $resultado[$_REQUEST['variable']]['categoria'];
		$_REQUEST['valor'] =  $resultado[$_REQUEST['variable']]['valor'];
		
		
       
       
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'id';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, maxSize[100]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        
        
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'nombre';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required,minSize[2],maxSize[100]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
   
                
// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'simbolo';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required,minSize[1],maxSize[5],custom[onlyLetterBack]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        // ---------------- CONTROL: Select --------------------------------------------------------
         
	        $esteCampo = 'categoria';
	        $atributos['nombre'] = $esteCampo;
	        $atributos['id'] = $esteCampo;
	        $atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
	        $atributos['tab'] = $tab;
	     
	        $atributos['evento'] = ' ';
	        $atributos['deshabilitado'] = false;
	        $atributos['limitar']= 50;
	        $atributos['tamanno']= 1;
	        $atributos['columnas']= 1;
	        
	        $atributos ['obligatorio'] = true;
	        $atributos ['etiquetaObligatorio'] = true;
	        $atributos ['validar'] = 'required';
	        
	        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarCategoria" );
	        $matrizItems = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
	        
	        $atributos['matrizItems'] = $matrizItems;
	        
	        if (isset ( $_REQUEST [$esteCampo] )) {
                    
	        	   $atributos['seleccion']  = $_REQUEST [$esteCampo];
	        } else {
	        	   $atributos['seleccion']  = '';
	        }
	        $tab ++;
	        
	        // Aplica atributos globales al control
	        $atributos = array_merge ( $atributos, $atributosGlobales );
	        echo $this->miFormulario->campoCuadroLista ( $atributos );
	        // --------------- FIN CONTROL : Select --------------------------------------------------
	       
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'valor';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, custom[number], maxSize[14]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        $cadenaSqlDetalle = $this->miSql->getCadenaSql("consultarLeyesParametros",$_REQUEST['id']);
      
        $matrizDatosLeyes = $primerRecursoDB->ejecutarAcceso($cadenaSqlDetalle, "busqueda", $_REQUEST['id'], "consultarLeyesParametros");
        
        $i = 0; $cadenaSelectMultiple = '';
        
        while($i < count($matrizDatosLeyes)){
        	$cadenaSelectMultiple = $cadenaSelectMultiple . $matrizDatosLeyes[$i]['id'] . ',';
        	$i++;
                
        }
        
        $cadenaSelectMultiple = substr($cadenaSelectMultiple, 0, -1);
        
        
        // ---------------- CONTROL: Select --------------------------------------------------------
	        $esteCampo = 'ley';
	        $atributos['nombre'] = $esteCampo;
	        $atributos['id'] = $esteCampo;
	        $atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
	        $atributos['tab'] = $tab;
	        $atributos['seleccion'] = -1;
	        $atributos['evento'] = ' ';
	        $atributos['deshabilitado'] = false;
	        $atributos['limitar']= 50;
	        $atributos['tamanno']= 1;
	        $atributos['columnas']= 1;
	        $atributos ['multiple'] = true;
	        $atributos ['obligatorio'] = true;
	        $atributos ['etiquetaObligatorio'] = true;
	        $atributos ['validar'] = '';
	        
	        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarLey" );
	        $matrizItems = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
	        
	        $atributos['matrizItems'] = $matrizItems;
	        
	        if (isset ( $_REQUEST [$esteCampo] )) {
	        	$atributos ['valor'] = $_REQUEST [$esteCampo];
	        } else {
	        	$atributos ['valor'] = '';
	        }
	        $tab ++;
	        
	        // Aplica atributos globales al control
	        $atributos = array_merge ( $atributos, $atributosGlobales );
	        echo $this->miFormulario->campoCuadroLista ( $atributos );
	        // --------------- FIN CONTROL : Select --------------------------------------------------
	        
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'descripcion';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 40;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, minSize[5], maxSize[500]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['filas'] = 4;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoTextArea( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto ------------
        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'leyRegistros';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        	
        $atributos ['valor'] = $cadenaSelectMultiple;
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        	
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'estadoPagina';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
         
        $atributos ['valor'] = 'modificar';
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
         
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'cargaSelectMultiple';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
         
        $atributos ['valor'] = $cadenaSelectMultiple;
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
         
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
         
        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'variable';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
         
    	if (isset ( $_REQUEST [$esteCampo] )) {
	        $atributos ['valor'] = $_REQUEST [$esteCampo];
	    } else {
	        $atributos ['valor'] = '';
	    }
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
         
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
         // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        $atributos ["titulo"] = "Enviar Información";
        echo $this->miFormulario->division ( "inicio", $atributos );
        // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'modificar';
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
        $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
        $tab ++;
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoBoton ( $atributos );
        
      
        
        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
      // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'regresar';
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
        $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
        $tab ++;
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoBoton ( $atributos );
        
      
        
        // -----------------FIN CONTROL: Botón -----------------------------------------------------------
       
        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division ( "fin" );
        echo $this->miFormulario->marcoAgrupacion ( 'fin' );
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
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );//Frontera mostrar formulario
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        
        $valorCodificado .= "&opcion=modificar";
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. 
         */
        $valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );
        // ----------------FIN SECCION: Paso de variables -------------------------------------------------
        // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
        // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
        // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario ( $atributos );
        return true;
    }
    function mensaje() {
        // Si existe algun tipo de error en el login aparece el siguiente mensaje
        $mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
        $this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );
        if ($mensaje) {
            $tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );
            if ($tipoMensaje == 'json') {
                $atributos ['mensaje'] = $mensaje;
                $atributos ['json'] = true;
            } else {
                $atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
            }
            // -------------Control texto-----------------------
            $esteCampo = 'divMensaje';
            $atributos ['id'] = $esteCampo;
            $atributos ["tamanno"] = '';
            $atributos ["estilo"] = 'information';
            $atributos ["etiqueta"] = '';
            $atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
            echo $this->miFormulario->campoMensaje ( $atributos );
            unset ( $atributos );
             
        }
        return true;
    }
}
$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );
$miFormulario->formulario ();
$miFormulario->mensaje ();
?>


