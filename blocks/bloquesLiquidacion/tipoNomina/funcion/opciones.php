<?php

namespace bloquesLiquidacion\tipoNomina\funcion;


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
        
        
        //Al final se ejecuta la redirección la cual pasará el control a otra página
        
        
         $i=0;
            while($i<$_REQUEST['tamaño']){
                if(isset($_REQUEST['botonModificarNomina'.$i]) && $_REQUEST['botonModificarNomina'.$i] == 'true'){
                    $datos = array(
            
            'variablei' => $i,
            'variable' => $_REQUEST['variable'],            
            'vinculacion' => $_REQUEST['vinculacion']
            
                       );
                    
                 Redireccionador::redireccionar('modificar',$datos); 
                  break; 
                }
                if(isset($_REQUEST['botonVerDetalleNomina'.$i]) && $_REQUEST['botonVerDetalleNomina'.$i] == 'true'){
                    $datos = array(
            
            'variablei' => $i,
            'variable' => $_REQUEST['variable'],            
            'vinculacion' => $_REQUEST['vinculacion']
            
                       );
                    Redireccionador::redireccionar('verdetalleNomina',$datos);
                  break;
                }
                if(isset($_REQUEST['botonInactivarNomina'.$i]) && $_REQUEST['botonInactivarNomina'.$i] == 'true'){
                  $datos = array(
            
            'variablei' => $i,
            'variable' => $_REQUEST['variable'],            
            'vinculacion' => $_REQUEST['vinculacion']
            
                       );
                    
                    Redireccionador::redireccionar('inactivar',$datos);
                  break;
                }
                
                
                $i+=1;
            }
            
    	
	if(isset($_REQUEST['botonRegistrarNomina']) && $_REQUEST['botonRegistrarNomina'] == 'true'){
                  Redireccionador::redireccionar('registrar',$_REQUEST['variable']);
                
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
