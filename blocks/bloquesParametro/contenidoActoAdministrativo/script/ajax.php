<?php

?>

<script>


 $('#<?php echo $this->campoSeguro('tipoActo')?>').width(400);
 $("#<?php echo $this->campoSeguro('tipoActo')?>").select2();
 
 $('#<?php echo $this->campoSeguro('tipoDocumento')?>').width(200);
 $("#<?php echo $this->campoSeguro('tipoDocumento')?>").select2(); 
 
 
 
 $('#<?php echo $this->campoSeguro('estadoRegistro')?>').width(200);
 $("#<?php echo $this->campoSeguro('estadoRegistro')?>").select2();  
    

</script>