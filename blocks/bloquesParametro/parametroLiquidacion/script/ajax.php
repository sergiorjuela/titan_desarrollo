<?php
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
//Variables
$cadenaACodificar17 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar17 .= "&procesarAjax=true";
$cadenaACodificar17 .= "&action=index.php";
$cadenaACodificar17 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar17 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar17 .= $cadenaACodificar17 . "&funcion=consultarCiudadAjax";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar17, $enlace);
// URL definitiva
$urlFinal17 = $url . $cadena17;
?>

<script>

    function validarNumero(numero) {
        if (!/^([0-9])*?(\.[0-9][0-9]?)?$/.test(numero)) {
            alert("Error en el valor ingresado,digite solo numeros, utilice punto (.) para el ingreso de decimales(maximo 2)");
            
        }
    }


</script>