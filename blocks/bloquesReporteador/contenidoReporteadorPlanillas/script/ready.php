

$("#contenidoReporteadorPlanillas").validationEngine({
	promptPosition : "centerRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});


    
    
$('#datepicker').datepicker({
	autoHidePrompt: true
});


 $('#<?php echo $this->campoSeguro('tipoPlantilla')?>').width(150);
 $("#<?php echo $this->campoSeguro('tipoPlantilla')?>").select2(); 


 $('#<?php echo $this->campoSeguro('seccionConceptos')?>').width(150);
 $("#<?php echo $this->campoSeguro('seccionConceptos')?>").select2();


 