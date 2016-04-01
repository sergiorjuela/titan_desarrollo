<?php

namespace bloquesParametro\contenidoLeyDecretoNorma\funcion;


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
       
        if(isset($_REQUEST ['fdpCiudad'])){
            $datosubicacion = array(
            'fdpDepartamento' => $_REQUEST ['fdpDepartamento'],
            'fdpCiudad' => $_REQUEST ['fdpCiudad']
           );
        }
        else{
            $datosubicacion = array(
            'fdpDepartamento' => $_REQUEST ['fdpDepartamento'],
            'fdpCiudad' => $_REQUEST ['ciudad']
           );
        }
                   
          
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarIdUbicacion",$datosubicacion);
        $ubicacion=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
    
          if(empty($ubicacion)){
              $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarUbicacion",$datosubicacion);
              $primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "insertar");
           
              $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("buscarIdUbicacion",$datosubicacion);
              $ubicacion=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
          }      
       
          $fechaven='NULL'; 
          if($_REQUEST ['fechaVen'] != ''){
              $fechaven=$_REQUEST ['fechaVen'];
          }
          
           
        
     
        
        $datos = array(
            
            'id_ldn' => $_REQUEST ['id_ldn'],
            'nombreRegistro' => $_REQUEST ['nombreRegistro'],
            'fechaExp' => $_REQUEST ['fechaExp'],
            'fechaVen' => $fechaven,
            'entidad' => $_REQUEST ['entidad'],
            'id_ubicacion' => $ubicacion[0][0]
        );
//       
        
                
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("modificarRegistro",$datos);
        $resultado=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");;
        //Al final se ejecuta la redirección la cual pasará el control a otra página
        if (!empty($resultado)) {
              RedireccionadorFP::redireccionar('modifico',$datos);
            exit();
        } else {
           RedireccionadorFP::redireccionar('noInserto');
            exit();
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

