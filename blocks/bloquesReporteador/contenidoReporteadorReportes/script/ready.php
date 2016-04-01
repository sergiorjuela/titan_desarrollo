

$("#contenidoReporteadorReportes").validationEngine({
promptPosition : "centerRight",
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});    

$('#datepicker').datepicker({
autoHidePrompt: true
});


$("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").attr('disabled', '');
$("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").attr('disabled', '');
 $(function () {

        $("#<?php echo $this->campoSeguro('seltipoReporte') ?>").change(function () {
              
            if ($("#<?php echo $this->campoSeguro('seltipoReporte') ?>").val() == "1") {
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").addClass("validate[required]");
                $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").addClass("validate[required]");
                $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").removeAttr('disabled');
               

            } else if ($("#<?php echo $this->campoSeguro('seltipoReporte') ?>").val() == "2") {
            	$("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").attr('disabled', '');
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").attr('disabled', '');
                $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").val("-1");
                $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").removeClass("validate[required]");
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").val("-1");
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").removeClass("validate[required]");
                $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").removeClass("validate[required]");
				
            } else {
                $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").attr('disabled', '');
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").attr('disabled', '');
                $("#<?php echo $this->campoSeguro('seltipoDocumento') ?>").val("");
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").val("");
                $("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").removeClass("validate[required]");
				

            }

        });


    });