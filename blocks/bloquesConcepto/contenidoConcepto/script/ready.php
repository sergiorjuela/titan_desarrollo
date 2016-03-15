$('#datepicker').datepicker({
autoHidePrompt: true
});


$('#<?php echo $this->campoSeguro('selecAtributosPersonasReporte') ?>').change(function () {
$("#<?php echo $this->campoSeguro('atributosPersonaHidden') ?>").val($("#<?php echo $this->campoSeguro('selecAtributosPersonasReporte') ?>").val());
});
$('#<?php echo $this->campoSeguro('selecAtributosVinculacionReporte') ?>').change(function () {
$("#<?php echo $this->campoSeguro('atributosVinculacionHidden') ?>").val($("#<?php echo $this->campoSeguro('selecAtributosVinculacionReporte') ?>").val());
});
$('#<?php echo $this->campoSeguro('selecAtributosNovedades') ?>').change(function () {
$("#<?php echo $this->campoSeguro('atributosNovedadHidden') ?>").val($("#<?php echo $this->campoSeguro('selecAtributosNovedades') ?>").val());
});
$('#<?php echo $this->campoSeguro('selectConceptosDevengoReporte') ?>').change(function () {
$("#<?php echo $this->campoSeguro('DevengosdHidden') ?>").val($("#<?php echo $this->campoSeguro('selectConceptosDevengoReporte') ?>").val());
});
$('#<?php echo $this->campoSeguro('selectConceptosDeduccionesReporte') ?>').change(function () {
$("#<?php echo $this->campoSeguro('DeduccionesdHidden') ?>").val($("#<?php echo $this->campoSeguro('selectConceptosDeduccionesReporte') ?>").val());
});
$('#<?php echo $this->campoSeguro('selecAtributosConceptos') ?>').change(function () {
$("#<?php echo $this->campoSeguro('atributosConceptodHidden') ?>").val($("#<?php echo $this->campoSeguro('selecAtributosConceptos') ?>").val());
});
$('#<?php echo $this->campoSeguro('selecNovedades') ?>').change(function () {
$("#<?php echo $this->campoSeguro('novedadesdHidden') ?>").val($("#<?php echo $this->campoSeguro('selecNovedades') ?>").val());
});