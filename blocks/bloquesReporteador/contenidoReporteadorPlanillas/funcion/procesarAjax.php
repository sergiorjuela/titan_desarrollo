<?php
header('Content-Type: text/html; charset=utf-8');

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if ($_REQUEST ['funcion'] == 'incluirPP') {
        $cadenaSql = $this->sql->getCadenaSql ( 'obtenerParametroPersonasAjax', $_GET['valor'] );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
        echo $resultado[0]["texto"];
}
if ($_REQUEST ['funcion'] == 'incluirPV') {
        $cadenaSql = $this->sql->getCadenaSql ( 'obtenerParametroVinculacionAjax', $_GET['valor'] );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );
        echo $resultado[0]["texto"];
}





?>