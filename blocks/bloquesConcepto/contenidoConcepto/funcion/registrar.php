<?php

namespace bloquesConcepto\contenidoConcepto\funcion;


include_once('Redireccionador.php');
include_once('Interprete.php');

class FormProcessor {
    
    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;
    var $conexion;
    
    function __construct($lenguaje, $sql) {
        
        $this->miConfigurador = \Configurador::singleton ();
        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
    
    }
    
    function procesarFormulario() {    

        //Aquí va la lógica de procesamiento
        
        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        
        
        //***************************VALIDAR Formula*****************************************************************
        
        
        
        //-------------------------- Seccion Validar Formula ------------------------------------------------
		//-------------------------------------------------------------------------------------------------------
             
        $_entradaFormulaCompilador = $_REQUEST['formulaConcepto'];
        
        
        $_resultadoInterprete = Interprete::evaluarSentencia($_entradaFormulaCompilador); 
        
        
        if($_resultadoInterprete == "true"){
        	//Ejecutar sentencias de almacenamiento si ha sido validada la sintaxis de la formula
        	
        	//----------------------------------------------------------------------------------------------------------
        	//------------------------ Codigo A Ejecutar Una Vez VALIDADA la Formula -----------------------------------
        	
        	if(isset($_REQUEST['naturalezaInfoConcepto'])){
        		switch($_REQUEST['naturalezaInfoConcepto']){
        			case 1 :
        				$_REQUEST['naturalezaInfoConcepto']='Devenga';
        				break;
        			case 2 :
        				$_REQUEST['naturalezaInfoConcepto']='Deduce';
        				break;
        		}
        	}
        	
        	$datosConcepto = array (
        			'nombre' => $_REQUEST['nombreInfoConcepto'],
        			'simbolo' => $_REQUEST['simboloInfoConcepto'],
        			'categoria' => $_REQUEST['categoriaInfoConcepto'],
        			'naturaleza' => $_REQUEST['naturalezaInfoConcepto'],
        			'descripcion' => $_REQUEST['descripcionInfoConcepto'],
        			'formula' => $_REQUEST['formulaConcepto']
        	);
        	
        	$cadenaSql = $this->miSql->getCadenaSql("insertarConcepto",$datosConcepto);
        	$id_concepto = $primerRecursoDB->ejecutarAcceso($cadenaSql, "busqueda", $datosConcepto, "insertarConcepto");
        	
        	$arrayLeyes = explode(",", $_REQUEST['leyRegistrosInfoConcepto']);
        	$count = 0;
        	
        	while($count < count($arrayLeyes)){
        		 
        		$datosLeyesConcepto = array(
        				'fk_id_ley' => $arrayLeyes[$count],
        				'fk_concepto' => $id_concepto[0][0]
        		);
        		 
        		$cadenaSql = $this->miSql->getCadenaSql("insertarLeyesConcepto",$datosLeyesConcepto);
        		$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        		 
        		$count++;
        	
        	}
        	
        	//---------------------------------------------------------------------------------------------------------
        	//---------------------------------------------------------------------------------------------------------

        	//*********************************************************************************
        }else{
        	
        	$datosConcepto = array (
        			'nombre' => $_REQUEST['nombreInfoConcepto'],
        			'simbolo' => $_REQUEST['simboloInfoConcepto'],
        			'categoria' => $_REQUEST['categoriaInfoConcepto'],
        			'naturaleza' => $_REQUEST['naturalezaInfoConcepto'],
        			'descripcion' => $_REQUEST['descripcionInfoConcepto'],
        			'formula' => $_REQUEST['formulaConcepto'],
        			'error' => $_resultadoInterprete,
        			'refError' => "En el Campo Fórmula, "
        	);
        	
        	Redireccionador::redireccionar('noInserto',$datosConcepto);
        	exit();
        }
        
        
        
        
        
        
        //***************************VALIDAR Condiciones*************************************************************
        
        
        // ---------------- INICIO: Lista Variables Control--------------------------------------------------------
        
        $cantidadCondiciones = $_REQUEST['cantidadCondicionesConcepto'];
        
        // ---------------- FIN: Lista Variables Control--------------------------------------------------------
        
        // --------------------------------- n Condiciones ----------------------------------
        
    	$count = 0;
    	$control = 0;
    	$limite = 0;
    	
    	$arrayPartCondicion = explode(",", $_REQUEST['variablesRegistros']);
    	
    	while($control < $cantidadCondiciones){
    		
    		$arrayCondiciones[$control] = 'Si(' .$arrayPartCondicion[$limite++]. ') Entonces{'.$arrayPartCondicion[$limite++].'}'; 
    		 
    		$control++;
    	}
   
        while($count < $cantidadCondiciones){
        	
        	//-------------------------- Seccion Validar Condiciones ------------------------------------------------
        	//Formato:
        	//					Si(condiciones) Entonces{Accion}
        	//-------------------------------------------------------------------------------------------------------
        	
        	$_entradaCondicionCompilador = $arrayCondiciones[$count];
        	
        	$_resultadoInterprete = Interprete::evaluarSentencia($_entradaCondicionCompilador);
        	
        	if($_resultadoInterprete == "true"){
        		
        		//Ejecutar sentencias de almacenamiento si ha sido validada la sintaxis de la condicion
        		
        		//----------------------------------------------------------------------------------------------------------
        		//------------------------ Codigo A Ejecutar Una Vez VALIDADA la Condicion -----------------------------------
        		
        		$datosCondicion = array(
        				'cadena' => $arrayCondiciones[$count],
        				'fk_concepto' => $id_concepto[0][0]
        		);
        		 
        		$cadenaSql = $this->miSql->getCadenaSql("insertarCondicion",$datosCondicion);
        		$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        		 
        		//-------------------------------------------------------------------------------------------------------
        		
        		
        	}else{
        		$ident = $count + 1;
        		$datosConcepto = array (
        			'nombre' => $_REQUEST['nombreInfoConcepto'],
        			'simbolo' => $_REQUEST['simboloInfoConcepto'],
        			'categoria' => $_REQUEST['categoriaInfoConcepto'],
        			'naturaleza' => $_REQUEST['naturalezaInfoConcepto'],
        			'descripcion' => $_REQUEST['descripcionInfoConcepto'],
        			'formula' => $_REQUEST['formulaConcepto'],
        			'error' => $_resultadoInterprete,
        			'refError' => "En la Condición #".$ident.", "
        		);
        	
        		Redireccionador::redireccionar('noInserto',$datosConcepto);
        		exit();
        		
        	}
        	$count++;
        }
        
        
        
        if (!empty($id_concepto)) {
           Redireccionador::redireccionar('inserto',$datosConcepto);
            exit();
        } else {
           Redireccionador::redireccionar('noInserto',$datosConcepto);
            exit();
        }
        
    	        
    }
    
    function resetForm(){
        foreach($_REQUEST as $clave=>$valor){
             
            if($clave !='pagina' && $clave!='development' && $clave !='jquery' &&$clave !='tiempo'){
                unset($_REQUEST[$clave]);
            }
        }
    }
    
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado= $miProcesador->procesarFormulario ();

