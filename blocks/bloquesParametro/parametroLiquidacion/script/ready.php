

$("#parametroLiquidacion").validationEngine({
	promptPosition : "bottomRight",
	scroll: false,
	autoHidePrompt: true,
	autoHideDelay: 2000
});


    
    
$('#datepicker').datepicker({
	autoHidePrompt: true
});

$('#<?php echo $this->campoSeguro('fdpCiudad')?>').width(200); 
$("#<?php echo $this->campoSeguro('fdpCiudad')?>").select2();

  $('#<?php echo $this->campoSeguro('categoria')?>').width(200); 
$("#<?php echo $this->campoSeguro('categoria')?>").select2();


  $('#<?php echo $this->campoSeguro('ley')?>').width(200); 
$("#<?php echo $this->campoSeguro('ley')?>").select2();


   
        
     


$( '#<?php echo $this->campoSeguro('ley')?>' ).change(function() {
		$("#<?php echo $this->campoSeguro('leyRegistros') ?>").val($("#<?php echo $this->campoSeguro('ley') ?>").val());
});

  

