<?php

// URL base

?>

<script>
    $('#<?php echo $this->campoSeguro('tipoNomina')?>').width(250);
    $("#<?php echo $this->campoSeguro('tipoNomina')?>").select2();            
    $('#<?php echo $this->campoSeguro('periodo')?>').width(250);
    $("#<?php echo $this->campoSeguro('periodo')?>").select2();
    $('#<?php echo $this->campoSeguro('reglamentacion')?>').width(250);
    $("#<?php echo $this->campoSeguro('reglamentacion')?>").select2();
    $('#<?php echo $this->campoSeguro('estadoRegistroNomina')?>').width(250);
    $("#<?php echo $this->campoSeguro('estadoRegistroNomina')?>").select2();
    $('#<?php echo $this->campoSeguro('leyes')?>').width(250);
    $("#<?php echo $this->campoSeguro('leyes')?>").select2();
    
    $( '#<?php echo $this->campoSeguro('leyes')?>' ).change(function() {
		$("#<?php echo $this->campoSeguro('leyRegistros') ?>").val($("#<?php echo $this->campoSeguro('leyes') ?>").val());
    });
          $(function () {
	        
	        $("#<?php echo $this->campoSeguro('tipoNomina')?>").change(function(){
	        	if($("#<?php echo $this->campoSeguro('tipoNomina')?>").val()==1 || $("#<?php echo $this->campoSeguro('tipoNomina')?>").val()==3  ){
	            	     $("#<?php echo $this->campoSeguro('periodo')?>").removeAttr('disabled');
		            
		            //$('#<?php echo $this->campoSeguro('periodo')?>').width(250);
		            $("#<?php echo $this->campoSeguro('periodo')?>").select2();
		            
		           
	    		}else{
	    			$("#<?php echo $this->campoSeguro('periodo')?>").attr('disabled','');
	    			}
	    	      });
	        
		
	    });
</script>