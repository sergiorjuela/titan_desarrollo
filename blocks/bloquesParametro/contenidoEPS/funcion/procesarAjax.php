<?php
header('Content-Type: text/html; charset=utf-8');
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if ($_REQUEST ['funcion'] == 'incluirPP') {
        $cadenaSql = $this->sql->getCadenaSql ( 'obtenerNombreParametroAjax', $_GET['valor'] );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
        var_dump($resultado);
        echo "prueba";
}





?>
