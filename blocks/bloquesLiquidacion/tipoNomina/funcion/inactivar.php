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
        
        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
       
        
        if($_REQUEST['enviarInactivar'] =='true'){
            if($_REQUEST ['estadoRegistroNomina']=='Inactivo'){
                      $opcion='Activo';
        }
        else{
            $opcion='Inactivo';
        }
        
            
            $datos = array(
            'codigoNomina'=> $_REQUEST['codigoNomina'],
            'nombreNomina' => $_REQUEST ['nombreNomina'],
            'estadoRegistroNomina' => $opcion,
            'variable' => $_REQUEST['variable']
        );
//       
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("inactivarRegistro",$datos);
       
        $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
                
        
                  Redireccionador::redireccionar('verDetalle2',$datos);      

        
       }
                
      if($_REQUEST['cancelarInactivar'] =='true'){
                    $datos = array(
            'codigoNomina'=> $_REQUEST['codigoNomina'],
            'variable' => $_REQUEST['variable']
        );
                     Redireccionador::redireccionar('verDetalle2',$datos); 
                }
        
       
        //Al final se ejecuta la redirección la cual pasará el control a otra página
        
        
    	        
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

