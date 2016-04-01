<?php

?>

<script>
$('#<?php echo $this->campoSeguro('nivelRegistro')?>').width(200);
$("#<?php echo $this->campoSeguro('nivelRegistro')?>").select2(); 

$('#<?php echo $this->campoSeguro('ley')?>').width(200);
$("#<?php echo $this->campoSeguro('ley')?>").select2(); 

 $('#<?php echo $this->campoSeguro('tipoSueldoRegistro')?>').width(200);
 $("#<?php echo $this->campoSeguro('tipoSueldoRegistro')?>").select2(); 


 $('#<?php echo $this->campoSeguro('codTipoCargoRegistro')?>').width(200);
 $("#<?php echo $this->campoSeguro('codTipoCargoRegistro')?>").select2();
 


 $('#<?php echo $this->campoSeguro('tipoSueldoRegistroMod')?>').width(200);
 $("#<?php echo $this->campoSeguro('tipoSueldoRegistroMod')?>").select2();  
 
 
 $('#<?php echo $this->campoSeguro('estadoRegistro')?>').width(200);
 $("#<?php echo $this->campoSeguro('estadoRegistro')?>").select2();  
    
$( "#<?php echo $this->campoSeguro('personaNaturalPrimerNombre')?>" ).change(function() {
	$("#<?php echo $this->campoSeguro('personaNaturalPrimerApellido') ?>").val('Nada');
	$("#<?php echo $this->campoSeguro('personaCarrera') ?>").val(-6);
});
</script>