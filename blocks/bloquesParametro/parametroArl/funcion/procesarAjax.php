<?php
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


if ($_REQUEST ['funcion'] == 'consultarCiudadAjax') {
       
	$cadenaSql = $this->sql->getCadenaSql ( 'buscarCiudadAjax',$variable  );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
        
	$resultado = json_encode ( $resultado);
	echo $resultado;
}
?>