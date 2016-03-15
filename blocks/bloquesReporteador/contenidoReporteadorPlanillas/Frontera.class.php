<?

namespace bloquesReporteador\contenidoReporteadorPlanillas;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
class Frontera {
	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $miFormulario;
	var $miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->miFormulario = $formulario;
	}
	function frontera() {
		$this->html ();
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	function html() {
		
		
        $this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
       

		
        if(isset($_REQUEST['opcion'])){
			switch ($_REQUEST ['opcion']) {
				
				case "registrar" :
					include_once ($this->ruta . "/formulario/registrarInformacionGeneral.php");
					break;
				case "formularioInformacionDeCreacionCertificado" :
					include_once ($this->ruta . "/formulario/registrarInformacionDeCreacionCertificado.php");
					break;
				case "formularioInformacionDeCreacionReporteGeneral" :
					include_once ($this->ruta . "/formulario/registrarInformacionDeCreacionReporteGeneral.php");
					break;
				case "regresar" :
					include_once ($this->ruta . "/formulario/form.php");
					break;
				case "mensaje" :
					include_once ($this->ruta . "/formulario/mensaje.php");
					break;  
				case "inactivar" :
					include_once ($this->ruta . "/formulario/inactivaPlantilla.php");
					break;  
				case "modificar" :
                                
                                        if ($_REQUEST['tipo'] == 'Certificado') {
                                            include_once ($this->ruta . "/formulario/modificarcertificado.php");
                                        }
                                        else{
                                          include_once ($this->ruta . "/formulario/modificarreporte.php");
                                        }
				break;  
				case "verdetalle" :
                                
                                        if ($_REQUEST['tipo'] == 'Certificado') {
                                            include_once ($this->ruta . "/formulario/verDetalleCertificado.php");
                                        }
                                        else{
                                            include_once ($this->ruta . "/formulario/verDetalleReporte.php");
                                        }
				break;  
				 
        		}
                       
                       
		}else{
			include_once ($this->ruta . "/formulario/form.php");
		}
	}
}
?>