<?php
// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";
//Variables
$cadenaACodificar17 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar17 .= "&procesarAjax=true";
$cadenaACodificar17 .= "&action=index.php";
$cadenaACodificar17 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar17 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar17 .= $cadenaACodificar17 . "&funcion=consultarCiudadAjax";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar17, $enlace );
// URL definitiva
$urlFinal17 = $url . $cadena17;
?>

<script>
    function consultarCiudad(elem, request, response){
		  $.ajax({
		    url: "<?php echo $urlFinal17?>",
		    dataType: "json",
		    data: { valor:$("#<?php echo $this->campoSeguro('tipoVinculacion')?>").val()},
		    success: function(data){ 
		        if(data[0]!=" "){
		            $("#<?php echo $this->campoSeguro('tipoNomina')?>").html('');
		            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('tipoNomina')?>");
		            $.each(data , function(indice,valor){
		            	$("<option value='"+data[ indice ].id+"'>"+data[ indice ].nombre+"</option>").appendTo("#<?php echo $this->campoSeguro('tipoNomina')?>");
		            	
		            });
		            
		            $("#<?php echo $this->campoSeguro('tipoNomina')?>").removeAttr('disabled');
		            
		            //$('#<?php echo $this->campoSeguro('tipoNomina')?>').width(250);
		            $("#<?php echo $this->campoSeguro('tipoNomina')?>").select2();
		            
		            $("#<?php echo $this->campoSeguro('tipoNomina')?>").removeClass("validate[required]");
		            
			        }
		    			
		    }
			                    
		   });
		};
                
          $(function () {
	        
	        $("#<?php echo $this->campoSeguro('tipoVinculacion')?>").change(function(){
	        	if($("#<?php echo $this->campoSeguro('tipoVinculacion')?>").val()!=''){
	            	consultarCiudad();
	    		}else{
	    			$("#<?php echo $this->campoSeguro('tipoNomina')?>").attr('disabled','');
	    			}
	    	      });
	        
		
	    });
</script>