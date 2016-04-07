

$("#asociacionConcepto").validationEngine({
	promptPosition : "bottomRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});


    
    
$('#datepicker').datepicker({
	autoHidePrompt: true
});

$('#<?php echo $this->campoSeguro('fdpDepartamento')?>').width(200); 
$("#<?php echo $this->campoSeguro('fdpDepartamento')?>").select2();

$('#<?php echo $this->campoSeguro('fdpCiudad')?>').width(200); 
$("#<?php echo $this->campoSeguro('fdpCiudad')?>").select2();

$('#<?php echo $this->campoSeguro('concepto')?>').width(200); 
$("#<?php echo $this->campoSeguro('concepto')?>").select2();

$('#<?php echo $this->campoSeguro('tipoVinculacion')?>').width(200); 
$("#<?php echo $this->campoSeguro('tipoVinculacion')?>").select2();

$('#<?php echo $this->campoSeguro('tipoNomina')?>').width(200); 
$("#<?php echo $this->campoSeguro('tipoNomina')?>").select2();
