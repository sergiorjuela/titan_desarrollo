<?php

namespace bloquesParametro\contenidoCargo\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
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
	// Rescatar los datos de este bloque
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];
		
		
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
		$_REQUEST ['tiempo'] = time ();
		
		$conexion = 'estructura';
		$primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		// var_dump($primerRecursoDB);
		// exit;
		
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
		$atributos ['titulo'] = false; // $this->lenguaje->getCadena ( $esteCampo );
		                               
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = false;
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
		$atributos ["leyenda"] = "Detalle de la liquidación";
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
		
		$datos = array (
				'codigoRegistro' => $_REQUEST ['variable'] 
		);
		
		$atributos2 ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarRegistrosxIDCompletos", $datos );
		$matrizItems2 = $primerRecursoDB->ejecutarAcceso ( $atributos2 ['cadena_sql'], "busqueda" );
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		
		$esteCampo = 'codigo';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['tipo'] = 'text';
		$atributos ['estilo'] = 'jqueryui';
		$atributos ['columnas'] = 1;
		$atributos ['dobleLinea'] = false;
		$atributos ['tabIndex'] = $tab;
		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
		$atributos ['valor'] = $matrizItems2 [0] [0];
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
		$atributos ['deshabilitado'] = true;
		$atributos ['tamanno'] = 20;
		$atributos ['maximoTamanno'] = '';
		
		$tab ++;
		
		// Aplica atributos globales al control
		$atributos = array_merge ( $atributos, $atributosGlobales );
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'usuario';
		$atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['columnas'] = 1;
        $atributos ['marco'] = true;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['valor'] = $matrizItems2[0][4];       
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset($atributos);
		unset ( $atributos );
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'nombre';
		$atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['columnas'] = 1;
        $atributos ['marco'] = true;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['valor'] = $matrizItems2[0][1];       
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset($atributos);
		
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'estado';
		$atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['columnas'] = 1;
        $atributos ['marco'] = true;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['valor'] = $matrizItems2[0][5];       
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset($atributos);
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
		
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'vinculacion';
		$atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['columnas'] = 1;
        $atributos ['marco'] = true;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['valor'] = $matrizItems2[0][3];       
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset($atributos);
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        $datos1 = array (
        		'codigoRegistro' => $matrizItems2[0][3]
        );
        
        $atributos3 ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNomina", $datos1 );
        $nomina= $primerRecursoDB->ejecutarAcceso ( $atributos3 ['cadena_sql'], "busqueda" );
        
        $datos2 = array (
        		'codigoRegistro' => $nomina[0][0]
        );
		
        $atributos4 ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarNominaNombre", $datos2 );
        $matrizItems3 = $primerRecursoDB->ejecutarAcceso ( $atributos4 ['cadena_sql'], "busqueda" );
        
		// ---------------- CONTROL: Select --------------------------------------------------------
		$esteCampo = 'nomina';
		$atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['columnas'] = 1;
        $atributos ['marco'] = true;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['valor'] = $matrizItems3[0][0];       
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset($atributos);
		// --------------- FIN CONTROL : Select --------------------------------------------------
       
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
		$esteCampo = 'preliquidacion';
		$atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['columnas'] = 1;
        $atributos ['marco'] = true;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['valor'] = $nomina[0][1];       
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset($atributos);
		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
				
		$datosFecha = array (
				'id_preliquidacion' => $matrizItems2[0] [3] 
		);
		
		$atributos4 ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarFechas", $datosFecha );
		$fechas = $primerRecursoDB->ejecutarAcceso ( $atributos4 ['cadena_sql'], "busqueda" );
		// ---------------- CONTROL: Select --------------------------------------------------------
		
		$esteCampo = 'fechaIni';
		$atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['columnas'] = 1;
        $atributos ['marco'] = true;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['valor'] = $fechas[0][0];       
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset($atributos);
		
		// --------------- FIN CONTROL : Select --------------------------------------------------
		
		// ---------------- CONTROL: Select --------------------------------------------------------
		$esteCampo = 'fechaFin';
		$atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['columnas'] = 1;
        $atributos ['marco'] = true;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['valor'] = $fechas[0][1];       
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset($atributos);
		// --------------- FIN CONTROL : Select --------------------------------------------------
        $datosP = array (
        		'codigoRegistro' => $matrizItems2[0][3]
        );
        
        $atributosD ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarRegistrosDetalle", $datosP );
        $matrizItemsD = $primerRecursoDB->ejecutarAcceso ( $atributosD ['cadena_sql'], "busqueda" );
        $longitud = count ( $matrizItemsD );
        
        $i = 0;
        
        echo '<table id="tablaReporte" class="display" cellspacing="0" width="100%"> ' . '<thead style="display: table-row-group"><tr><th>' . "CÉDULA" . '</th><th>' . "NOMBRE" . '</th><th>' . "DEPENDENCIA" . '</th> <th>' . "VINCULACIÓN" . '</th> <th>' . "CONCEPTOS" . '</th><th>' . "DEVENGOS" . '</th><th>' . "DEDUCCIONES" . '</th><th>' . "SALARIO TOTAL" . '</th><th>' . "VER DETALLE" . '</th></tr></thead>
        
                    <tbody>';
        if (! empty ( $matrizItemsD )) {
        	while ( $i < $longitud ) {
        		echo "<tr><td>" . $matrizItemsD [$i] [0] . "</td>";
        		echo "<td>" . 'pendiente..' . "</td>";
        		echo "<td>" . 'pendiente..' . "</td>";
        		echo "<td>" . 'pendiente..' . "</td>";
        		
        		$variableMOD = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
        		; // pendiente la pagina para modificar parametro
        		$variableMOD .= "&opcion=verdetalleConceptos";
        		$variableMOD .= "&bloque=" . $esteBloque ['nombre'];
        		$variableMOD .= "&tamaño=" . $longitud;
        		$variableMOD .= "&variable=" . $matrizItemsD [$i] [0];
        		$variableMOD .= "&variableN=" . 'pendiente..';
        		$variableMOD .= "&variableP=" . $_REQUEST ['variable'];
        		$variableMOD .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        		$variableMOD = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableMOD, $directorio );
        		
        		echo "<td><center><a href='" . $variableMOD . "'>
                          <img src='" . $rutaBloque . "/css/images/modificar.png' width='25px'>
                          </a></center> </td>";
        		
        		
        		echo "<td>" . $matrizItemsD [$i] [1] . "</td>";
        		echo "<td>" . $matrizItemsD [$i] [1] . "</td>";
        		echo "<td>" . $matrizItemsD [$i] [1] . "</td>";
        
//         		$datos = array (
//         				'id_preliquidacion' => $matrizItems[$i][3]
//         		);
        
//         		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarFechas", $datos );
//         		$matrizItems1 = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda", $datos );
        
//         		echo "<td>" . $matrizItems1 [0] [0] . "</td>";
//         		echo "<td>" . $matrizItems1 [0] [1] . "</td>";
        		

        
        		
        		
        		$variableVD = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
        		; // pendiente la pagina para modificar parametro
        		$variableVD .= "&opcion=verdetallePersona";
        		$variableVD .= "&bloque=" . $esteBloque ['nombre'];
        		$variableVD .= "&tamaño=" . $longitud;
        		$variableVD .= "&variable=" . $matrizItemsD [$i] [0];
        		$variableVD .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        		$variableVD = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableVD, $directorio );
        
        		echo "<td><center><a href='" . $variableVD . "'>
                          <img src='" . $rutaBloque . "/css/images/verDetalle.png' width='25px'>
                          </a></center> </td>";
        
        		
        
//         		// $variableACT = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );; // pendiente la pagina para modificar parametro
//         		// $variableACT .= "&opcion=inactivar";
//         		// $variableACT .= "&bloque=" . $esteBloque ['nombre'];
//         		// $variableACT .="&tamaño=".$longitud;
//         		// $variableACT .= "&variable=" . $matrizItems[$i][0];
//         		// $variableACT .= "&bloqueGrupo=" . $esteBloque ["grupo"];
//         		// $variableACT = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableACT, $directorio );
        
//         		// echo "<td><center><a href='" . $variableACT . "'>";
//         		// if($matrizItems[$i][4]=='Activo'){
//         		// echo "<img src='" . $rutaBloque . "/css/images/desactivacion.png' width='25px'>";
//         			// }
//         			// else{
//         			// echo "<img src='" . $rutaBloque . "/css/images/activacion.png' width='25px'>";
//         			// }
        
//         		// echo "</a></center> </td></tr>";
        
        		$i += 1;
        	}
        }
        echo '</tbody></table>';
		// ------------------Division para los botones-------------------------
		$atributos ["id"] = "botones";
		$atributos ["estilo"] = "marcoBotones";
		$atributos ["titulo"] = "Enviar Información";
		echo $this->miFormulario->division ( "inicio", $atributos );
		
		// -----------------CONTROL: Botón ----------------------------------------------------------------
		$esteCampo = 'verdetalleRegistro';
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
		
		// $valorCodificado = "actionBloque=" . $esteBloque ["nombre"]; //Ir pagina Funcionalidad
		$valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' ); // Frontera mostrar formulario
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=form";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
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