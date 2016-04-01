<?php

/**
*	Interfaz para la construcción de la clase nodoConcepto o de cualquier clase que cumple la misma función de nodoConcepto
*/
interface NodoConceptoInterfaz{

    public function evaluarConcepto($referencia );
    
    public function getValor();
    
    public function getNombre();
}
?>