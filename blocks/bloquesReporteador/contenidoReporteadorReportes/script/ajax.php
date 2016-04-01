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
$cadenaACodificar17 .= $cadenaACodificar17 . "&funcion=cargarReportes";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar17, $enlace);
// URL definitiva
$urlFinal17 = $url . $cadena17;
?>


<script>

    $('#<?php echo $this->campoSeguro('seltipoPlantilla') ?>').width(250);
    $("#<?php echo $this->campoSeguro('seltipoPlantilla') ?>").select2();
    $('#<?php echo $this->campoSeguro('selReporte') ?>').width(250);
    $("#<?php echo $this->campoSeguro('selReporte') ?>").select2();
    $('#<?php echo $this->campoSeguro('seltipoDocumento') ?>').width(250);
    $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").select2();
    $('#<?php echo $this->campoSeguro('seltipoReporte') ?>').width(250);
    $("#<?php echo $this->campoSeguro('seltipoReporte') ?>").select2();
    $('#<?php echo $this->campoSeguro('selPreliquidacion') ?>').width(250);
    $("#<?php echo $this->campoSeguro('selPreliquidacion') ?>").select2();
    $('#<?php echo $this->campoSeguro('documentoIdentificacion') ?>').width(350);
    $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").select2();


    function consultarReportes(elem, request, response) {
        $.ajax({
            url: "<?php echo $urlFinal17 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('seltipoPlantilla') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('selReporte') ?>").html('');
                    $("<option value='-1'>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('selReporte') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].id_plantilla + "'>" + data[ indice ].nombre + "</option>").appendTo("#<?php echo $this->campoSeguro('selReporte') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('selReporte') ?>").removeAttr('disabled');

                    //$('#<?php echo $this->campoSeguro('selReporte') ?>').width(250);
                    $("#<?php echo $this->campoSeguro('selReporte') ?>").select2();
                   


                }

            }

        });
    }
    ;

    $(function () {

        $("#<?php echo $this->campoSeguro('seltipoPlantilla') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('seltipoPlantilla') ?>").val() != '') {
                consultarReportes();
            } else {
                $("#<?php echo $this->campoSeguro('selReporte') ?>").attr('disabled', '');
            }
        });


    });
    $(function () {

        $("#<?php echo $this->campoSeguro('selReporte') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('selReporte') ?>").val() != '') {
                $("#<?php echo $this->campoSeguro('selReporte') ?>").removeClass("validate[required]");
            } 
        });


    });
    $(function () {

        $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").val() != '') {
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").removeClass("validate[required]");
            } 
        });


    });
       $(function () {

        $("#<?php echo $this->campoSeguro('selReporte') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('selReporte') ?>").val() != '') {
                $("#<?php echo $this->campoSeguro('codigoReporte') ?>").val($("#<?php echo $this->campoSeguro('selReporte') ?>").val());
            }
            if ($("#<?php echo $this->campoSeguro('selReporte') ?>").val() == '-1') {
                $("#<?php echo $this->campoSeguro('codigoReporte') ?>").val("");
            }
        });


    });
   

    $(function () {
       $("#checkboxPadre").change(function () {
            if ($(this).is(':checked')) {
                var rowCount = $('#tablaReporte tr').length;
                for(i=0;i<rowCount-1;i++){
                   $('#checkbox'+i).attr('checked','checked');
                }
            } else {
                var rowCount = $('#tablaReporte tr').length;
                for(i=0;i<rowCount-1;i++){
                   $('#checkbox'+i).removeAttr('checked');
                }
            }
        });


    });
    
     $(function () {

        $("#<?php echo $this->campoSeguro('seltipoPlantilla') ?>").change(function () {
           
            if ($("#<?php echo $this->campoSeguro('seltipoPlantilla') ?>").val() != 'Certificado') {
                $("#<?php echo $this->campoSeguro('selPreliquidacion') ?>").removeAttr('disabled');
                $("#<?php echo $this->campoSeguro('selPreliquidacion') ?>").addClass("validate[required]");
            }
            else{
            	
                $("#<?php echo $this->campoSeguro('selPreliquidacion') ?>").attr('disabled', '');
            }
        });


    });


</script>

<?php

//Variables
$cadenaACodificar12 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar12 .= "&procesarAjax=true";
$cadenaACodificar12 .= "&action=index.php";
$cadenaACodificar12 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar12 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar12 .= $cadenaACodificar12 . "&funcion=cargarPersonas";
$cadenaACodificar12 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$cadena12 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar12, $enlace);
// URL definitiva
$urlFinal12 = $url . $cadena12;
?>

<script>

 function consultarPersonas(elem, request, response) {
     
        $.ajax({
            url: "<?php echo $urlFinal12 ?>",
            dataType: "json",
            data: {valor: $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").val()},
            success: function (data) {

                if (data[0] != " ") {
                    $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").html('');
                    $("<option value='-1'>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>");
                    $.each(data, function (indice, valor) {
                        $("<option value='" + data[ indice ].documento + "'>" + data[ indice ].documento +"("+data[ indice ].nombre+")"+ "</option>").appendTo("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>");

                    });

                    $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").removeAttr('disabled');
                    $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").select2();
                   

                }

            }

        });
    }
    ;

    $(function () {

        $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").change(function () {
            if ($("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").val() != '') {
                consultarPersonas();
            } else {
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").attr('disabled', '');
            }
        });


    });



</script>