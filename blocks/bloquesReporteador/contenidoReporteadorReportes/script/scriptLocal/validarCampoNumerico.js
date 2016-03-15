$( document ).ready(function() {
	
	var campoValidar = [];
	
	var INumero = 0; 
	campoValidar[INumero++] = "#<?php echo $this->campoSeguro('numeroResolucion')?>";

	$(campoValidar).each(function(){
		$(this.valueOf()).keydown(function(tecla) {
			if(tecla.keyCode < 8 || tecla.keyCode > 57){
				if(tecla.keyCode < 96 || tecla.keyCode > 105){
					return false;
				}
			}
		})
	});
	
	
});


