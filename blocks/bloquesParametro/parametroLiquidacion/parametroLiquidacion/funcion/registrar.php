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
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ($conexion );
       
       
  
       $datos = array(
            'nombre' => $_REQUEST ['nombre'],
            'simbolo' => $_REQUEST ['simbolo'],
            'descripcion' => $_REQUEST ['descripcion'],
            'ley' => $_REQUEST ['ley'],
            'valor' => $_REQUEST ['valor'],
            'categoria' => $_REQUEST ['categoria'],
           
        );
      
   $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("registrarParametroLiquidacion", $datos);
 
    $resultado=    $id_concepto = $primerRecursoDB->ejecutarAcceso( $atributos ['cadena_sql'], "busqueda", $datos, "registrarParametroLiquidacion");
   
        
 $arrayLeyes = explode(",", $_REQUEST['leyRegistros']);
        $count = 0;
        
        while($count < count($arrayLeyes)){
        	
        	$datosLeyesConcepto = array(
        			'id_ley' => $arrayLeyes[$count],
        			'concepto' => $resultado[0][0]
        	);
        	
        	$atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarLeyesParametro",$datosLeyesConcepto);
        	$resultado1=$primerRecursoDB->ejecutarAcceso($atributos ['cadena_sql'], "acceso");//********************************
        	
 
        	$count++;
        
        }
   if (!empty($resultado)&&!empty($resultado1)) {
            Redireccionador::redireccionar('inserto');
            exit();
        } else {
           Redireccionador::redireccionar('noInserto');
            exit();
        }
        
        //Al final se ejecuta la redirección la cual pasará el control a otra página
        
       // Redireccionador::redireccionar('opcion1');
      
    	        
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

