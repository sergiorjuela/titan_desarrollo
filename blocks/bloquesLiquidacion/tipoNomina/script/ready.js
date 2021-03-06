
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
//    $('#tablaReporte tfoot th').each( function () {
//        var title = $(this).text();
//        
//        $(this).html( '<input type="text" placeholder="'+title+'" size="15"/>' );
//    } );
 
    // DataTable
    var table = $('#tablaReporte').DataTable({
        
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
    
    
    
    $("#tipoNomina").change(function() {
        
       var tiponomina = document.getElementById('tipoNomina');
	        
    if(tiponomina == 2)
    {
       $("#perido").removeAttr('disabled');
    }
    else{
        $("#perido").removeAttr('enabled');
        
    }
   



		
} );
    
} );

if($('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina')?>').val() == 'modificar'){
	var values = $('#<?php echo $this->campoSeguro('cargaSelectMultiple')?>').val();
	$.each(values.split(","), function(i,e){
	    $("#<?php echo $this->campoSeguro('leyes') ?>" + " option[value='" + e + "']").prop("selected", true);
	    $("#<?php echo $this->campoSeguro('leyes')?>").width(250);
	    $("#<?php echo $this->campoSeguro('leyes')?>").select2(); 
	});
}