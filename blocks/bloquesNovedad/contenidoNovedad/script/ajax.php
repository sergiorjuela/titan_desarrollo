<?php
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
//Variables
$cadenaACodificar16 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar16 .= "&procesarAjax=true";
$cadenaACodificar16 .= "&action=index.php";
$cadenaACodificar16 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar16 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar16 .= $cadenaACodificar16 . "&funcion=consultarParametroAjax";
$cadenaACodificar16 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena16 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar16, $enlace);
// URL definitiva
$urlFinal16 = $url . $cadena16;
//echo $urlFinal16; exit;
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
//Variables
$cadenaACodificar17 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar17 .= "&procesarAjax=true";
$cadenaACodificar17 .= "&action=index.php";
$cadenaACodificar17 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar17 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar17 .= $cadenaACodificar17 . "&funcion=consultarValorParametroAjax";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar17, $enlace);
// URL definitiva
$urlFinal17 = $url . $cadena17;
//echo $urlFinal16; exit;
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
//Variables
$cadenaACodificar18 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar18 .= "&procesarAjax=true";
$cadenaACodificar18 .= "&action=index.php";
$cadenaACodificar18 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar18 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar18 .= $cadenaACodificar18 . "&funcion=consultarConceptoAjax";
$cadenaACodificar18 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena18 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar18, $enlace);
// URL definitiva
$urlFinal18 = $url . $cadena18;
//echo $urlFinal16; exit;
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
//Variables
$cadenaACodificar19 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar19 .= "&procesarAjax=true";
$cadenaACodificar19 .= "&action=index.php";
$cadenaACodificar19 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar19 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar19 .= $cadenaACodificar19 . "&funcion=consultarValorConceptoAjax";
$cadenaACodificar19 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena19 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar19, $enlace);
// URL definitiva
$urlFinal19 = $url . $cadena19;
//echo $urlFinal16; exit;
?>

<script>
    $('#<?php echo $this->campoSeguro('VariablesList') ?>').width(240);
    $("#<?php echo $this->campoSeguro('VariablesList') ?>").select2(); 
    $('#<?php echo $this->campoSeguro('CamposFormulacionList') ?>').width(240);
    $("#<?php echo $this->campoSeguro('CamposFormulacionList') ?>").select2(); 
    $('#<?php echo $this->campoSeguro('categoriaConceptosList') ?>').width(240);
    $("#<?php echo $this->campoSeguro('categoriaConceptosList') ?>").select2();
    $('#<?php echo $this->campoSeguro('categoriaParametrosList') ?>').width(240);
    $("#<?php echo $this->campoSeguro('categoriaParametrosList') ?>").select2();
 
 
    
    $( '#<?php echo $this->campoSeguro('categoriaConceptosList') ?>' ).change(function() {
        $('#<?php echo $this->campoSeguro('valorConcepto') ?>').attr("readonly","readonly");
        $('#<?php echo $this->campoSeguro('valorConcepto') ?>').addClass("readOnly");
        $('#<?php echo $this->campoSeguro('valorConcepto') ?>').val("");
        $("#editarBotonesConcepto").show("slow");
        $("#ingresoBotonesConcepto").hide("fast");
        $("#<?php echo $this->campoSeguro('seccionConceptos') ?>").removeAttr('disabled');
        $("#<?php echo $this->campoSeguro('seccionConceptos') ?>").select2();
    });
    $( '#<?php echo $this->campoSeguro('seccionConceptos') ?>' ).change(function() {
        $('#<?php echo $this->campoSeguro('valorConcepto') ?>').attr("readonly","readonly");
        $('#<?php echo $this->campoSeguro('valorConcepto') ?>').addClass("readOnly");
        $('#<?php echo $this->campoSeguro('valorConcepto') ?>').val("");
        $("#editarBotonesConcepto").show("slow");
        $("#ingresoBotonesConcepto").hide("fast");
    });
    
    if($('#<?php echo $this->campoSeguro('estadoPagina') ?>').val() == 'verDetalle' || $('#<?php echo $this->campoSeguro('estadoPagina') ?>').val() == 'modificar'){
       
       var values = $('#<?php echo $this->campoSeguro('cargaSelectMultiple') ?>').val();
        $.each(values.split(","), function(i,e){
            $("#<?php echo $this->campoSeguro('ley') ?>" + " option[value='" + e + "']").prop("selected", true);
            $("#<?php echo $this->campoSeguro('ley') ?>").width(250);
            $("#<?php echo $this->campoSeguro('ley') ?>").select2(); 
            
            $("#<?php echo $this->campoSeguro('leyRegistros') ?>").val($("#<?php echo $this->campoSeguro('ley') ?>").val());
        });
    }
    $( '#<?php echo $this->campoSeguro('ley') ?>' ).change(function() {
        
        $("#<?php echo $this->campoSeguro('leyRegistros') ?>").val($("#<?php echo $this->campoSeguro('ley') ?>").val());
    });
    $( '#<?php echo $this->campoSeguro('categoriaParametrosList') ?>' ).change(function() {
        $("#<?php echo $this->campoSeguro('seccionParametros') ?>").removeAttr('disabled');
        $("#<?php echo $this->campoSeguro('seccionParametros') ?>").select2();
    })
    $( '#<?php echo $this->campoSeguro('formula') ?>' ).keypress(function(tecla) {
        if(tecla.charCode != 0  && tecla.charCode != 42 && tecla.charCode != 43 && 
            tecla.charCode != 45 && tecla.charCode != 47 && 
            tecla.charCode != 40 && tecla.charCode != 41 && tecla.charCode != 38 && tecla.charCode != 179 &&
            tecla.charCode != 60 && tecla.charCode != 61 && tecla.charCode != 62 && tecla.charCode != 33 &&
            tecla.charCode != 48 && tecla.charCode != 49 && tecla.charCode != 50 && tecla.charCode != 51 &&
            tecla.charCode != 52 && tecla.charCode != 53 && tecla.charCode != 54 && tecla.charCode != 55 &&
            tecla.charCode != 56 && tecla.charCode != 57) return false;
    });
    $( '#<?php echo $this->campoSeguro('valorConcepto') ?>' ).keypress(function(tecla) {
        if(tecla.charCode != 0  && tecla.charCode != 42 && tecla.charCode != 43 && 
            tecla.charCode != 45 && tecla.charCode != 47 && 
            tecla.charCode != 40 && tecla.charCode != 41) return false;
    });
    $(function () {
        $("#parametros").draggable({
            revert: true,
            helper: 'clone',
            start: function (event, ui) {
                $(this).fadeTo('fast', 1.5);
            },
            stop: function (event, ui) {
                $(this).fadeTo(0, 1);
            }
        });
        $('#<?php echo $this->campoSeguro('formula') ?>').droppable({
            hoverClass: 'active',
            drop: function (event, ui) {
                this.value += $(ui.draggable).find('select option:selected').text();
            }
        });
    });
    $(function () {
        $("#conceptos").draggable({
            revert: true,
            helper: 'clone',
            start: function (event, ui) {
                $(this).fadeTo('fast', 1.5);
            },
            stop: function (event, ui) {
                $(this).fadeTo(0, 1);
            }
        });
        $('#<?php echo $this->campoSeguro('formula') ?>').droppable({
            hoverClass: 'active',
            drop: function (event, ui) {
                this.value += $(ui.draggable).find('select option:selected').text();
            }
        });
    });
    $(function () {
        $("#variables_lista").draggable({
            revert: true,
            helper: 'clone',
            start: function (event, ui) {
                $(this).fadeTo('fast', 1.5);
            },
            stop: function (event, ui) {
                $(this).fadeTo(0, 1);
            }
        });
        $('#<?php echo $this->campoSeguro('formula') ?>').droppable({
            hoverClass: 'active',
            drop: function (event, ui) {
                this.value += $(ui.draggable).find('select option:selected').text();
            }
        });
    });
    $(function () {
        $("#formulacion_campos").draggable({
            revert: true,
            helper: 'clone',
            start: function (event, ui) {
                $(this).fadeTo('fast', 1.5);
            },
            stop: function (event, ui) {
                $(this).fadeTo(0, 1);
            }
        });
        $('#<?php echo $this->campoSeguro('formula') ?>').droppable({
            hoverClass: 'active',
            drop: function (event, ui) {
                this.value += $(ui.draggable).find('select option:selected').text();
            }
        });
    });


    var iCnt2 = 0;  
    var campos_numero = 0;   
    var container = $(document.createElement('div')).css({
        padding: '5px'
    });
    $(container).attr('class', 'col-md-12')
    $(container).attr('id', 'pushDina')
    $(document).ready(function() {
        var t = $('#tablaCampos').DataTable();
        
        $('#btAgregar').click(function() {
		        
            var validacion=0;          
            iCnt2 = iCnt2 + 1;
            if(iCnt2>1){
                var n=iCnt2-1;
                if($('#nombreCampo'+n).val()=='' || $('#labelCampo'+n).val()==''){
                    if($('#nombreCampo'+n).val()==''){
                        alert('ingese nombre de campo');
                    }
                    if($('#labelCampo'+n).val()==''){
                        alert('ingese label del campo');
                    }    
                                
                    validacion=1;
                }
            }
            // Añadir elementos Dinamicos en el DOM
            if(validacion==0){
                $(container).append('<fieldset id=panel'+iCnt2+' class="ui-widget ui-widget-content">'+
                    '<legend class="ui-state-default ui-corner-all"> CAMPO'+iCnt2+'</legend>'+
                    '<div id=lab1'+iCnt2+' class="col-md-2">'+
                    '<label> Nombre del Campo:  </label> ' + 
                    '</div>'+
                    '<input type=text class="input" id=nombreCampo'+ iCnt2 + ' size="50"  maxlength="30" value="" required/>'+
                    '<br/><br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt2+' class="col-md-2">'+
                    '<label> Label del Campo: </label> ' + 
                    '</div>'+
                    '<input type=text class="input" id=labelCampo' + iCnt2 + ' size="50"  maxlength="500" value=""/>'+
                    '</div>'+
                    '<br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt2+' class="col-md-2">'+
                    '<label> Tipo de dato: </label> ' + 
                    '</div>'+
                    '<select id=tipoDatoCampo'+iCnt2+' onchange="habilitar(this.value,'+iCnt2+')"><option value="Alfanumerico" >Alfanumérico</option>'+
                    '<option value="Valor">Valor</option>'+
                    '<option value="Lista">Lista</option>'+
                    '<option value="Fecha">Fecha</option>'+
                    '<option value="Tabla">Tabla</option>'+
                    '</select>'+
                    '</div>'+
                    '<br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt2+' class="col-md-2">'+
                    '<label> Requerido: </label> ' + 
                    '</div>'+
                    '<select id=requeridoCampo'+iCnt2+'><option value="No">No</option>'+
                    '<option value="Si">Si</option>'+
                    '</select>'+
                    '</div>'+
                    '<br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt2+' class="col-md-2">'+
                    '<label> Fórmula: </label> ' + 
                    '</div>'+
                    '<select  disabled id=formulacionCampo'+iCnt2+' onchange="habilitar(this.value,'+iCnt2+')"><option value="No">No</option>'+
                    '<option value="Si">Si</option>'+
                    '</select>'+
                    '</div>'+ 
                    '<br/>'+
                    '</div>'+
                    '<div>'+
                    '<div id=lab52'+iCnt2+' class="col-md-2">'+
                    '<label> Simbolo : </label> ' + 
                    '</div>'+
                    '<input disabled type=text class="input" id=simboloCampo' + iCnt2 + ' onkeyup = "this.value=this.value.toUpperCase()" size="50"  maxlength="5" minlength="5"  value="XXXXX"/>'+
                    '</div>'+
                    '</fieldset>');
                $('#camposDinamicos').after(container);
                $('#tipoDatoCampo'+iCnt2).width(250);
                $('#requeridoCampo'+iCnt2).width(250);
                $('#formulacionCampo'+iCnt2).width(250);
                if(iCnt2>1){
                    var num=iCnt2-1;
                    t.row.add( [ ($('#nombreCampo'+num).val()),
                        ($('#labelCampo'+num).val()),
                        ($('#tipoDatoCampo'+num).val()),
                        ($('#requeridoCampo'+num).val()),
                        ($('#formulacionCampo'+num).val()),
                        ($('#simboloCampo'+num).val())
                    ]).draw( false );
                                         
                                                      
                    $('#panel'+num).hide();     
                }
            }
            else{
                iCnt2 = iCnt2 - 1;
            }
                        
                        
        });
        
              
         

 
        $('#tablaCampos tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                t.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        
        
        } );
        $('#btEliminar').click(function() { // Elimina un panel de condiciones del DOM
		
            var data = t.row('.selected').data();
            var interacion = 0;
      
      
            interacion=interacion+1;
            while(interacion <= iCnt2){
       
                if(($("#nombreCampo"+interacion).val())== data[0] && ($("#labelCampo"+interacion).val())== data[1]){
                    $('#panel'+interacion).remove();  
                }
                interacion=interacion+1;
            }
            t.row('.selected').remove().draw( false );
        });
    
    
    });
    function habilitar(valor,consecutivo){

        if(valor=='Valor')
        {   
   
            $('#formulacionCampo'+consecutivo).removeAttr('disabled');
        }
        if(valor=='Si')
        {   
   
            $('#simboloCampo'+consecutivo).removeAttr('disabled');
        }
    }
    
    
    var iCnt3 = 0;  
    var campos_numero2 = 0;   
    var container = $(document.createElement('div')).css({
        padding: '5px'
    });
    $(container).attr('class', 'col-md-12')
    $(container).attr('id', 'pushDina')
    var table = $('#tablaCamposAux').DataTable();
    $(document).ready(function() {
        
        $('#btAgregarMod').click(function() {
		        
            var validacion2=0;          
            iCnt3 = iCnt3 + 1;
            if(iCnt3>1){
                var n=iCnt3-1;
                if($('#nombreCampoM'+n).val()=='' || $('#labelCampoM'+n).val()==''){
                    if($('#nombreCampoM'+n).val()==''){
                        alert('ingese nombre de campo');
                    }
                    if($('#labelCampoM'+n).val()==''){
                        alert('ingese label del campo');
                    }    
                                
                    validacion2=1;
                }
            }
            // Añadir elementos Dinamicos en el DOM
            if(validacion2==0){
                $(container).append('<fieldset id=panelM'+iCnt3+' class="ui-widget ui-widget-content">'+
                    '<legend class="ui-state-default ui-corner-all"> CAMPO'+iCnt3+'</legend>'+
                    '<div id=lab1'+iCnt3+' class="col-md-2">'+
                    '<label> Nombre del Campo:  </label> ' + 
                    '</div>'+
                    '<input type=text class="input" id=nombreCampoM'+ iCnt3 + ' size="50"  maxlength="30" value="" required/>'+
                    '<br/><br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt3+' class="col-md-2">'+
                    '<label> Label del Campo: </label> ' + 
                    '</div>'+
                    '<input type=text class="input" id=labelCampoM' + iCnt3 + ' size="50"  maxlength="500" value=""/>'+
                    '</div>'+
                    '<br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt3+' class="col-md-2">'+
                    '<label> Tipo de dato: </label> ' + 
                    '</div>'+
                    '<select id=tipoDatoCampoM'+iCnt3+' onchange="habilitarM(this.value,'+iCnt3+')"><option value="Alfanumerico" >Alfanumérico</option>'+
                    '<option value="Valor">Valor</option>'+
                    '<option value="Lista">Lista</option>'+
                    '<option value="Fecha">Fecha</option>'+
                    '<option value="Tabla">Tabla</option>'+
                    '</select>'+
                    '</div>'+
                    '<br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt3+' class="col-md-2">'+
                    '<label> Requerido: </label> ' + 
                    '</div>'+
                    '<select id=requeridoCampoM'+iCnt3+'><option value="No">No</option>'+
                    '<option value="Si">Si</option>'+
                    '</select>'+
                    '</div>'+
                    '<br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt3+' class="col-md-2">'+
                    '<label> Fórmula: </label> ' + 
                    '</div>'+
                    '<select  disabled id=formulacionCampoM'+iCnt3+' onchange="habilitarM(this.value,'+iCnt3+')"><option value="No">No</option>'+
                    '<option value="Si">Si</option>'+
                    '</select>'+
                    '</div>'+ 
                    '<br/>'+
                    '</div>'+
                    '<div>'+
                    '<div id=lab52'+iCnt3+' class="col-md-2">'+
                    '<label> Simbolo : </label> ' + 
                    '</div>'+
                    '<input disabled type=text class="input" id=simboloCampoM' + iCnt3 + ' onkeyup = "this.value=this.value.toUpperCase()" size="50"  maxlength="5" minlength="5"  value="XXXXX"/>'+
                    '</div>'+
                    '</fieldset>');
                $('#camposDinamicos').after(container);
                $('#tipoDatoCampoM'+iCnt3).width(250);
                $('#requeridoCampoM'+iCnt3).width(250);
                $('#formulacionCampoM'+iCnt3).width(250);
                if(iCnt3>1){
                    var num=iCnt3-1;
                    table.row.add( [ ($('#nombreCampoM'+num).val()),
                        ($('#labelCampoM'+num).val()),
                        ($('#tipoDatoCampoM'+num).val()),
                        ($('#requeridoCampoM'+num).val()),
                        ($('#formulacionCampoM'+num).val()),
                        ($('#simboloCampoM'+num).val())
                    ]).draw( false );
                                         
                                                      
                    $('#panelM'+num).hide();     
                }
            }
            else{
                iCnt3 = iCnt3 - 1;
            }
                        
                        
        });
        
              
         

 
        $('#tablaCamposAux tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        
        
        } );
        $('#btEliminarMod').click(function() { // Elimina un panel de condiciones del DOM
		
            var data = table.row('.selected').data();
            var interacion = 0;
      
      
            interacion=interacion+1;
            while(interacion <= iCnt3){
       
                if(($("#nombreCampoM"+interacion).val())== data[0] && ($("#labelCampoM"+interacion).val())== data[1]){
                    $('#panelM'+interacion).remove();  
                }
                interacion=interacion+1;
            }
            table.row('.selected').remove().draw( false );
        });
    
    
    });
    function habilitarM(valor,consecutivo){

        if(valor=='Valor')
        {   
   
            $('#formulacionCampoM'+consecutivo).removeAttr('disabled');
        }
        if(valor=='Si')
        {   
   
            $('#simboloCampoM'+consecutivo).removeAttr('disabled');
        }
    }
    function consultarParametro(elem, request, response){
        $.ajax({
            url: "<?php echo $urlFinal16 ?>",
            dataType: "json",
            data: { valor:$("#<?php echo $this->campoSeguro('categoriaParametrosList') ?>").val()},
            success: function(data){ 
                if(data[0]!=" "){
                    $("#<?php echo $this->campoSeguro('seccionParametros') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('seccionParametros') ?>");
                    $.each(data , function(indice,valor){
                        $("<option value='"+data[ indice ].id_categoria+"'>"+data[ indice ].simbolo+"</option>").appendTo("#<?php echo $this->campoSeguro('seccionParametros') ?>");
	            	
                    });
	            
                    $("#<?php echo $this->campoSeguro('seccionParametros') ?>").removeAttr('disabled');
	            
                    //$('#<?php echo $this->campoSeguro('seccionParametros') ?>').width(250);
                    $("#<?php echo $this->campoSeguro('seccionParametros') ?>").select2();
	            
                    $("#<?php echo $this->campoSeguro('seccionParametros') ?>").removeClass("validate[required]");
	            
                }
	    			
            }
		                    
        });
    }; 
    function consultarValorParametro(elem, request, response){
        $.ajax({
            url: "<?php echo $urlFinal17 ?>",
            dataType: "json",
            data: { valor:$("#<?php echo $this->campoSeguro('seccionParametros') ?>").val()},
            success: function(data){ 
                if(data[0]!=" "){
                    $("#<?php echo $this->campoSeguro('valorParametro') ?>").val(data[0].valor);
			            
                }
			    			
            }
				                    
        });
    };
                        
    $("#<?php echo $this->campoSeguro('categoriaParametrosList') ?>").change(function(){
		    
        if($("#<?php echo $this->campoSeguro('categoriaParametrosList') ?>").val()!=''){
            consultarParametro();
        }else{
            $("#<?php echo $this->campoSeguro('seccionParametros') ?>").attr('disabled','');
        }
        $("#<?php echo $this->campoSeguro('valorParametro') ?>").val('');
    });
                
    $("#<?php echo $this->campoSeguro('seccionParametros') ?>").change(function(){
        if($("#<?php echo $this->campoSeguro('seccionParametros') ?>").val()!=''){
            consultarValorParametro();
        }else{
            $("#<?php echo $this->campoSeguro('valorParametro') ?>").val('');
        }
    });                
    function consultarConcepto(elem, request, response){
        $.ajax({
            url: "<?php echo $urlFinal18 ?>",
            dataType: "json",
            data: { valor:$("#<?php echo $this->campoSeguro('categoriaConceptosList') ?>").val()},
            success: function(data){ 
                if(data[0]!=" "){
                    $("#<?php echo $this->campoSeguro('seccionConceptos') ?>").html('');
                    $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('seccionConceptos') ?>");
                    $.each(data , function(indice,valor){
                        $("<option value='"+data[ indice ].id+"'>"+data[ indice ].simbolo+"</option>").appendTo("#<?php echo $this->campoSeguro('seccionConceptos') ?>");
		            	
                    });
		            
                    $("#<?php echo $this->campoSeguro('seccionConceptos') ?>").removeAttr('disabled');
		            
                    //$('#<?php echo $this->campoSeguro('seccionConceptos') ?>').width(250);
                    $("#<?php echo $this->campoSeguro('seccionConceptos') ?>").select2();
		            
                    $("#<?php echo $this->campoSeguro('seccionConceptos') ?>").removeClass("validate[required]");
		            
                }
		    			
            }
			                    
        });
    };
    function consultarValorConcepto(elem, request, response){
        $.ajax({
            url: "<?php echo $urlFinal19 ?>",
            dataType: "json",
            data: { valor:$("#<?php echo $this->campoSeguro('seccionConceptos') ?>").val()},
            success: function(data){ 
                if(data[0]!=" "){
                    $("#<?php echo $this->campoSeguro('valorConcepto') ?>").val(data[0].formula);
				            
                }
				    			
            }
					                    
        });
    };
    $("#<?php echo $this->campoSeguro('categoriaConceptosList') ?>").change(function(){
        if($("#<?php echo $this->campoSeguro('categoriaConceptosList') ?>").val()!=''){
            consultarConcepto();
        }else{
            $("#<?php echo $this->campoSeguro('seccionConceptos') ?>").attr('disabled','');
            $("#<?php echo $this->campoSeguro('valorConcepto') ?>").val('');
        }
    });
    $("#<?php echo $this->campoSeguro('seccionConceptos') ?>").change(function(){
        if($("#<?php echo $this->campoSeguro('seccionConceptos') ?>").val()!=''){
            consultarValorConcepto();
        }else{
            $("#<?php echo $this->campoSeguro('valorConcepto') ?>").val('');
        }
    });    





             
                     
    //***********************************************************************************************************
    //***********************************************************************************************************
    //Codigo AGREGAR y QUITAR Campos Dinamicos
    var limite = 20; //Se define el Limite de Paneles de Condiciones que se pueden Generar
    //No requiere que se cambie en otro lugar
				 
    var iCnt = 0;
    var numId = 0;
 
    // Crear un elemento div añadiendo estilos CSS
    var container = $(document.createElement('div')).css({
        padding: '5px'
    });
    $(container).attr('class', 'col-md-12')
    $(container).attr('id', 'pushDina')


    $( document ).ready(function() {
    

    
        $("#cancelar").hide("fast");
        //	$('#<?php echo $this->campoSeguro('botones') ?>').hide("fast");
                      
	 
        $('#btAdd').click(function() {
            if (iCnt < limite) {
	 
                iCnt = iCnt + 1;
	 
                // Añadir elementos Dinamicos en el DOM
			
                $(container).append('<fieldset id=panel'+iCnt+' class="ui-widget ui-widget-content">'+
                    '<legend class="ui-state-default ui-corner-all"> CONDICIÓN #'+iCnt+'</legend>'+
                    '<div id=lab1'+iCnt+' class="col-md-2">'+
                    '<label> Si </label> ' + 
                    '</div>'+
                    '<input type=text class="input" id=tb1' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos('+iCnt+')"/>'+
                    '<br/><br/>'+
                    '<div>'+
                    '<div id=lab2'+iCnt+' class="col-md-2">'+
                    '<label> Entonces </label> ' + 
                    '</div>'+
                    '<input type=text class="input" id=tb2' + iCnt + ' size="80"  maxlength="500" value="" onBlur="devPos2('+iCnt+')"/>'+
                    '</textarea>'+	
                    '</div>'+ 
                    '</fieldset>');
			
                $('#camposDinamicos').after(container);
                $('#sel1'+iCnt).width(120);
                $('#sel1'+iCnt).select2();
			
                $('#sel2'+iCnt).width(120);
                $('#sel2'+iCnt).select2();
                        
                arrastreParametro('tb1' + iCnt);
                arrastreParametro('tb2' + iCnt);
	              
                arrastreConcepto('tb1' + iCnt);
                arrastreConcepto('tb2' + iCnt);
       
            }
            else { //alerta y deshabilitar boton de agregar por alcanzar el limite
	 
                alert('Limite Alcanzado');
                $('#btAdd').attr('disabled', 'disabled');
	 
            }
            $("#<?php echo $this->campoSeguro('cantidadCondicionesConcepto') ?>").val(iCnt)
        });
	
         
        
        
        
        
        $('#btRemove').click(function() { // Elimina un panel de condiciones del DOM
            if (iCnt != 0) {
                $('#lab1' + iCnt).remove(); 
                $('#tb1' + iCnt).remove();
                $('#sel1' + iCnt).remove();
                $('#tb2' + iCnt).remove();
                $('#sel2' + iCnt).remove();
                $('#lab2' + iCnt).remove(); 
                $('#tb3' + iCnt).remove();
                $('#panel' + iCnt).remove();    
                iCnt = iCnt - 1; 
                $('#btAdd').removeAttr('disabled');
                $('#btAdd').attr('class', 'btn btn-success btn-block');
            }
	 
            if (iCnt == 0) { $(container).empty(); 
	 
                $(container).remove();
                $('#btAdd').removeAttr('disabled');
                $('#btAdd').attr('class', 'btn btn-success btn-block')
	 
            }
            $("#<?php echo $this->campoSeguro('cantidadCondicionesConcepto') ?>").val(iCnt)
        });
	 
        $('#btRemoveAll').click(function() { //Quitar todos los paneles de condiciones Agregados
	 
            $(container).empty();
            $(container).remove();
            iCnt = 0;
            $('#btAdd').removeAttr('disabled');
            $('#btAdd').attr('class', 'btn btn-success btn-block');
            $("#<?php echo $this->campoSeguro('cantidadCondicionesConcepto') ?>").val(iCnt)
        });
        
        
    });
    function devPos(nombre){
        $("#btOper1C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
       	    var post = actual + "(";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper2C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + ")";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper3C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "+";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper4C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "-";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper5C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "*";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper6C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "/";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper7C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "√";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });           
        $("#btOper8C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "^";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper9C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "<";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });    
        $("#btOper10C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "<=";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper11C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + ">";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper12C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + ">=";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper13C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "=";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper14C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "!=";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper15C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "&&";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });  
        $("#btOper16C").on("click",function(){
            var actual = $('#tb1'+nombre).val();
            var post = actual + "||";
            $('#tb1'+nombre).val(post);
            desactivarClick();
        });           
        $("#btOper17C").on("click",function(){
            $('#tb1'+nombre).val("");
            desactivarClick();
        });
    }
       
           
    function devPos2(nombre){
        $("#btOper1C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
       	    var post = actual + "(";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper2C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + ")";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        }); 
        $("#btOper3C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "+";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper4C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "-";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper5C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "*";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper6C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "/";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper7C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "√";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });           
        $("#btOper8C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "^";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper9C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "<";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });    
        $("#btOper10C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "<=";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper11C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + ">";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper12C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + ">=";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper13C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "=";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper14C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "!=";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });
        $("#btOper15C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "&&";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });  
        $("#btOper16C").on("click",function(){
            var actual = $('#tb2'+nombre).val();
            var post = actual + "||";
            $('#tb2'+nombre).val(post);
            desactivarClick();
        });           
        $("#btOper17C").on("click",function(){
            $('#tb2'+nombre).val("");
            desactivarClick();
        });
    } 
    //Funciones de arrastre apara dinamicos
    //
    //
    function desactivarClick() {
        $("#btOper1C").off("click");$("#btOper2C").off("click");$("#btOper3C").off("click");$("#btOper4C").off("click");
        $("#btOper5C").off("click"); $("#btOper6C").off("click");$("#btOper7C").off("click");$("#btOper8C").off("click");
        $("#btOper9C").off("click");$("#btOper10C").off("click");$("#btOper11C").off("click");$("#btOper12C").off("click");
        $("#btOper13C").off("click");$("#btOper14C").off("click");$("#btOper15C").off("click");$("#btOper16C").off("click");
        $("#btOper17C").off("click");
    }
    function arrastreParametro(nombre) {
        $('#'+nombre ).keypress(function(tecla) {
            if(tecla.charCode != 0  && tecla.charCode != 42 && tecla.charCode != 43 && 
                tecla.charCode != 45 && tecla.charCode != 47 && tecla.charCode != 40 && tecla.charCode != 41 && tecla.charCode != 38 && tecla.charCode != 179 &&
                tecla.charCode != 60 && tecla.charCode != 61 && tecla.charCode != 62 && tecla.charCode != 33 &&
                tecla.charCode != 48 && tecla.charCode != 49 && tecla.charCode != 50 && tecla.charCode != 51 &&
                tecla.charCode != 52 && tecla.charCode != 53 && tecla.charCode != 54 && tecla.charCode != 55 &&
                tecla.charCode != 56 && tecla.charCode != 57
        ) return false;
        });
         
          
        $("#parametros").draggable({
            revert: true,
            helper: 'clone',
            start: function (event, ui) {
                $(this).fadeTo('fast', 1.5);
            },
            stop: function (event, ui) {
                $(this).fadeTo(0, 1);
            }
        });
        $('#'+nombre).droppable({
            hoverClass: 'active',
            drop: function (event, ui) {
                this.value += $(ui.draggable).find('select option:selected').text();
            }
        });
    };
    function arrastreConcepto(nombre) {
            
        $("#conceptos").draggable({
            revert: true,
            helper: 'clone',
            start: function (event, ui) {
                $(this).fadeTo('fast', 1.5);
            },
            stop: function (event, ui) {
                $(this).fadeTo(0, 1);
            }
        });
        $('#'+nombre).droppable({
            hoverClass: 'active',
            drop: function (event, ui) {
                this.value += $(ui.draggable).find('select option:selected').text();
            }
        });
    };		
	 
    // Funcion que Obtiene los valores de los textbox y los select
    var values = '', condiciones = '', campos = '', cantidad = 0;
	 
    function GetTextValue() {
	 
        values = '';
        campos = '';
        var j = 0;
        while(j < iCnt){
            j++;
            values = values + $("#tb1"+j).val() + ',';
            values = values + $("#tb2"+j).val() + ',';
        }
        $("#<?php echo $this->campoSeguro('variablesRegistros') ?>").val(values);
    
        condiciones = '';
        $( "select option:selected" ).each(function() {
            condiciones += '['+ this.value + ']';
            $("#<?php echo $this->campoSeguro('condicionesRegistros') ?>").val(condiciones);
        });
	
    }

    function PasoComponente() {
	
	
	
        var con = 0;
	
        while(con < iCnt2-1){
            con++;
              
            campos = campos + $("#nombreCampo"+con).val() + ',';
            campos = campos + $('#labelCampo'+con).val() + ',';
            campos = campos + $("#tipoDatoCampo"+con).val() + ',';
            campos = campos + $("#requeridoCampo"+con).val() + ',';
            campos = campos + $("#formulacionCampo"+con).val() + ',';
            campos = campos + $("#simboloCampo"+con).val() + ',';
        }
        $("#<?php echo $this->campoSeguro('variablesCampo') ?>").val(campos);
        campos='';
        var con = 0;
        while(con < iCnt2-1){
            con++;
            if( $("#simboloCampo"+con).val()!='XXXXX'){
                campos = campos + $("#simboloCampo"+con).val() + ',';   
            }
                    
                
                
        }
        $("#<?php echo $this->campoSeguro('camposFormulacion') ?>").val(campos);
	
	
	
    }
    
    function PasoComponenteModificar() {
	
        
       
        table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            var data = this.data();
                 
            campos = campos + data[0] + ',';
            campos = campos + data[1] + ',';
            campos = campos + data[2] + ',';
            campos = campos + data[3] + ',';
            campos = campos + data[4] + ',';
            campos = campos + data[5] + ',';
            // ... do something with data(), or this.node(), etc
        } );
        $("#<?php echo $this->campoSeguro('variablesCampo') ?>").val(campos);
        campos='';
        table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            var data = this.data();
            if( data[5]!='XXXXX'){
                campos = campos + data[5] + ',';   
            }
        } );
        $("#<?php echo $this->campoSeguro('camposFormulacion') ?>").val(campos);
	
	
	
    }
</script>