
// Asociar el widget de validación al formulario
$("#login").validationEngine({
	promptPosition : "centerRight",
	scroll : false
});

$('#usuario').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#login').submit();
    }
});

$('#clave').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#login').submit();
    }
});

$(function() {
	$(document).tooltip({
		position : {
			my : "left+30 center",
			at : "right center"
		}
	},
	{ hide: { duration: 800 } }
	);
});

$(function() {
	$("button").button().click(function(event) {
		event.preventDefault();
	});
});

$("#tablaReporte").dataTable().fnDestroy();

$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#tablaReporte tfoot th').each( function () {
        var title = $(this).text();
        
        $(this).html( '<input type="text" placeholder="'+title+'" size="15"/>' );
    } );
 
    // DataTable
//    var table = 






        $('#tablaReporte').DataTable({
    
        
    "language": {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
	"sZeroRecords":    "No se encontraron resultados",
        "sSearch":         "Buscar:",
        "sLoadingRecords": "Cargando...",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
	"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	"oPaginate": {
		"sFirst":    "Primero",
		"sLast":     "Ãšltimo",
		"sNext":     "Siguiente",
		"sPrevious": "Anterior"
	}
    }
    });
    
//    $('#tablaReporte tbody')
//        .on( 'mouseenter', 'td', function () {
//            var colIdx = table.cell(this).index().column;
// 
//            $( table.cells().nodes() ).removeClass( 'highlight' );
//            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
//        } );
//    // Apply the search
//    table.columns().every( function () {
//        var that = this;
// 
//        $( 'input', this.footer() ).on( 'keyup change', function () {
//            if ( that.search() !== this.value ) {
//                that
//                    .search( this.value )
//                    .draw();
//            }
//        } );
//    } );
} );











//MANEJO DE CAMPOS MULTIPLES PARA MODIFICACION Y VERDETALLE

if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificar'){
	var values = $('#<?php echo $this->campoSeguro('atributosPersonaHidden')?>').val();
       	$.each(values.split(","), function(i,e){
	    $("#<?php echo $this->campoSeguro('selecAtributosPersonasReporte') ?>" + " option[value='" + e + "']").prop("selected", true);
	    $("#<?php echo $this->campoSeguro('selecAtributosPersonasReporte')?>").width(250);
	    $("#<?php echo $this->campoSeguro('selecAtributosPersonasReporte')?>").select2(); 
	});
}
if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificar'){
	var values = $('#<?php echo $this->campoSeguro('atributosVinculacionHidden')?>').val();
     	$.each(values.split(","), function(i,e){
	    $("#<?php echo $this->campoSeguro('selecAtributosVinculacionReporte') ?>" + " option[value='" + e + "']").prop("selected", true);
	    $("#<?php echo $this->campoSeguro('selecAtributosVinculacionReporte')?>").width(250);
	    $("#<?php echo $this->campoSeguro('selecAtributosVinculacionReporte')?>").select2(); 
	});
}

if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificar'){
	var values = $('#<?php echo $this->campoSeguro('atributosNovedadHidden')?>').val();
	$.each(values.split(","), function(i,e){
	    $("#<?php echo $this->campoSeguro('selecAtributosNovedades') ?>" + " option[value='" + e + "']").prop("selected", true);
	    $("#<?php echo $this->campoSeguro('selecAtributosNovedades')?>").width(250);
	    $("#<?php echo $this->campoSeguro('selecAtributosNovedades')?>").select2(); 
	});
}
if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificar'){
	var values = $('#<?php echo $this->campoSeguro('DevengosdHidden')?>').val();
	$.each(values.split(","), function(i,e){
	    $("#<?php echo $this->campoSeguro('selectConceptosDevengoReporte') ?>" + " option[value='" + e + "']").prop("selected", true);
	    $("#<?php echo $this->campoSeguro('selectConceptosDevengoReporte')?>").width(250);
	    $("#<?php echo $this->campoSeguro('selectConceptosDevengoReporte')?>").select2(); 
	});
}
if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificar'){
	var values = $('#<?php echo $this->campoSeguro('DeduccionesdHidden')?>').val();
	$.each(values.split(","), function(i,e){
	    $("#<?php echo $this->campoSeguro('selectConceptosDeduccionesReporte') ?>" + " option[value='" + e + "']").prop("selected", true);
	    $("#<?php echo $this->campoSeguro('selectConceptosDeduccionesReporte')?>").width(250);
	    $("#<?php echo $this->campoSeguro('selectConceptosDeduccionesReporte')?>").select2(); 
	});
}
if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificar'){
	var values = $('#<?php echo $this->campoSeguro('atributosConceptodHidden')?>').val();
        $.each(values.split(","), function(i,e){
            $("#<?php echo $this->campoSeguro('selecAtributosConceptos')?>" + " option[value='" + e + "']").prop("selected", true);
	    $("#<?php echo $this->campoSeguro('selecAtributosConceptos')?>").width(250);
	    $("#<?php echo $this->campoSeguro('selecAtributosConceptos')?>").select2(); 
	});
}
if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificar'){
	var values = $('#<?php echo $this->campoSeguro('novedadesdHidden')?>').val();
        $.each(values.split(","), function(i,e){
            $("#<?php echo $this->campoSeguro('selecNovedades')?>" + " option[value='" + e + "']").prop("selected", true);
	    $("#<?php echo $this->campoSeguro('selecNovedades')?>").width(250);
	    $("#<?php echo $this->campoSeguro('selecNovedades')?>").select2(); 
	});
}













$("#btOper1").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + "(";
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});

$("#btOper2").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + ")";
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});

$("#btOper3").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + "+";
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});

$("#btOper4").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + "-";
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});

$("#btOper5").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + "*";
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});

$("#btOper6").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + "/";
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});

$("#btOper7").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + "√";
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});

$("#btOper8").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + "^";
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});

$("#btOper9").click(function(){
	$('#<?php echo $this->campoSeguro('formula')?>').val("");
});

$("#ingresoBotonesConcepto").hide("fast");
$("#editarBotonesConcepto").hide("fast");

$("#btEditB").click(function(){
	$("#editarBotonesConcepto").hide("fast");
	$("#ingresoBotonesConcepto").show("slow");
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').removeAttr("readonly");
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').removeClass("readOnly");
});

$("#btOper1B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	var post = actual + "(";
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val(post);
});

$("#btOper2B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	var post = actual + ")";
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val(post);
});

$("#btOper3B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	var post = actual + "+";
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val(post);
});

$("#btOper4B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	var post = actual + "-";
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val(post);
});

$("#btOper5B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	var post = actual + "*";
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val(post);
});

$("#btOper6B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	var post = actual + "/";
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val(post);
});

$("#btOper7B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	var post = actual + "√";
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val(post);
});

$("#btOper8B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	var post = actual + "^";
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val(post);
});

$("#btOper9B").click(function(){
	$('#<?php echo $this->campoSeguro('valorConcepto')?>').val("");
});

$("#btOper10B").click(function(){
	var actual = $('#<?php echo $this->campoSeguro('formula')?>').val();
	var post = actual + $('#<?php echo $this->campoSeguro('valorConcepto')?>').val();
	$('#<?php echo $this->campoSeguro('formula')?>').val(post);
});


$("#confirmarDina").click(function(){
	$("#confirmar").hide("fast");
	$("#cancelar").show("fast");
	$("#camposDinamicosCont").hide("slow");
	$("#blocBotn").hide("slow");
	$('#<?php echo $this->campoSeguro('botones')?>').show("fast");
});

$("#cancelarDina").click(function(){
	$("#confirmar").show("fast");
	$("#cancelar").hide("fast");
	$("#camposDinamicosCont").show("slow");
	$("#blocBotn").show("slow");
	$('#<?php echo $this->campoSeguro('botones')?>').hide("fast");
});