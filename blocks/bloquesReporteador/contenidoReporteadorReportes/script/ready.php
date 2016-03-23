

$("#contenidoReporteadorReportes").validationEngine({
promptPosition : "centerRight",
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});    

$('#datepicker').datepicker({
autoHidePrompt: true
});



$("#<?php echo $this->campoSeguro('documentoIdentificacion') ?>").attr('disabled', '');

