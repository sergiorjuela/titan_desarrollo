

$("#parametroLiquidacion").validationEngine({
promptPosition : "centerRight",
scroll: false,
autoHidePrompt: true,
autoHideDelay: 2000
});




$('#datepicker').datepicker({
autoHidePrompt: true
});

$('#<?php echo $this->campoSeguro('ley') ?>').width(200); 
$("#<?php echo $this->campoSeguro('ley') ?>").select2();

$('#<?php echo $this->campoSeguro('categoriaParametro') ?>').width(200); 
$("#<?php echo $this->campoSeguro('categoriaParametro') ?>").select2();


$( '#<?php echo $this->campoSeguro('ley')?>' ).change(function() {
		$("#<?php echo $this->campoSeguro('leyesParametroHidden') ?>").val($("#<?php echo $this->campoSeguro('ley') ?>").val());
});

