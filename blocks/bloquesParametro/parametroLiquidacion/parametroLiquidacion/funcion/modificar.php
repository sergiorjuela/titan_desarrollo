<?php

namespace bloquesParametro\parametroLiquidacion\funcion;
    
include_once('Redireccionador.php');
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
        
          if(isset ( $_REQUEST ['regresar'] ) && $_REQUEST ['regresar'] == "true"){
                  
                     Redireccionador::redireccionar('form'); 
                     exit;
                }
      
                
                
        $datos = array(
            'id' => $_REQUEST ['id'],
            'nombre' => $_REQUEST ['nombre'],
            'simbolo' => $_REQUEST ['simbolo'],
            'descripcion' => $_REQUEST ['descripcion'],
            'categoria' => $_REQUEST ['categoria'],
            'valor' => $_REQUEST ['valor'],
            
        );
//       
        $cadenaSql = $this->miSql->getCadenaSql("modificarRegistro",$datos);
      
        	$resultado = $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");
        	
        
  
             
      $datosLeyesConcepto = array(
        			'id_parametro' => $_REQUEST['id']
        	);
        	
        	$cadenaSql = $this->miSql->getCadenaSql("eliminarLeyesModificar",$datosLeyesConcepto);
        	
                 $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        	 
        	$arrayLeyes = explode(",", $_REQUEST['leyRegistros']);
        $count = 0;
        
        while($count < count($arrayLeyes)){
        	
        	$datosLeyesConcepto = array(
        			'id_ley' => $arrayLeyes[$count],
        			'concepto' => $_REQUEST ['id']
        	);
        	
        	$atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarLeyesParametro",$datosLeyesConcepto);
        	
                $resultado1=$primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "acceso");//********************************
        	
 
        	$count++;
        
        }
        	
        	
      
   if (!empty($resultado)&&!empty($resultado1)) {
      

            Redireccionador::redireccionar('modifico');
            
            exit();
        } else {
       
        
           Redireccionador::redireccionar('nomodifico');
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