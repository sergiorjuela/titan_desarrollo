<?php
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if ($_REQUEST ['funcion'] == 'mostrarFormulario') {
	$resultado = json_encode ( $resultado);
	echo $resultado;
}
?>