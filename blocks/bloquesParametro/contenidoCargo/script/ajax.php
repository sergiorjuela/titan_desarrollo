<?php

?>

<script>


$( '#<?php echo $this->campoSeguro('ley')?>' ).change(function() {
	$("#<?php echo $this->campoSeguro('leyRegistros') ?>").val($("#<?php echo $this->campoSeguro('ley') ?>").val());
});
</script>