<?php
 $conexion = 'estructura';
 $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if ($_REQUEST ['funcion'] == 'cargarReportes') {
        $cadenaSql = $this->sql->getCadenaSql ('obtenerRepotesAjax',$_GET['valor']);
	$resultado = $primerRecursoDB->ejecutarAcceso( $cadenaSql, "busqueda" );
        $resultado = json_encode ( $resultado);
	echo $resultado;
       
}
if ($_REQUEST ['funcion'] == 'cargarPersonas') {
        $cadenaSql = $this->sql->getCadenaSql ('obtenerPersonasAjax',$_GET['valor']);
	$resultado = $primerRecursoDB->ejecutarAcceso( $cadenaSql, "busqueda" );
        $resultado = json_encode ( $resultado);
	echo $resultado;
       
}





?>





