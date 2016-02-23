<?php
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
//Variables
$cadenaACodificar1 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar1 .= "&procesarAjax=true";
$cadenaACodificar1 .= "&action=index.php";
$cadenaACodificar1 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar1 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar1 .= $cadenaACodificar1 . "&funcion=mostrarFormulario";
$cadenaACodificar1 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena1 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar1, $enlace);
// URL definitiva
$urlFinal1 = $url . $cadena1;
?>

<script>


    function mostrarFormulario () {
        $("#<?php echo $this->campoSeguro('tipoPlantilla') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('tipoPlantilla')?>").val() != '1') {
                var elemento = document.getElementById('marcoTipoPlantilla');
                elemento.style.display='none';
            } else {
                var elemento = document.getElementById('marcoTipoPlantilla');
                elemento.style.display= 'block';
            }
        });



    }
    ;
</script>