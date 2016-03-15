<?php
// URL base
$url = $this->miConfigurador->getVariableConfiguracion("host");
$url .= $this->miConfigurador->getVariableConfiguracion("site");
$url .= "/index.php?";
//Variables
$cadenaACodificar1 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar1 .= "&procesarAjax=true";
$cadenaACodificar1 .= "&action=index.php";
$cadenaACodificar1 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar1 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar1 .= $cadenaACodificar1 . "&funcion=incluirPP";
$cadenaACodificar1 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
$cadena1 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar1, $enlace);
// URL definitiva
$urlFinal1 = $url . $cadena1;
?>

<script>
    var click_boton = document.getElementById("btincluirPP");
    click_boton.addEventListener('click', presionBoton1, false);


    function presionBoton1(e) {
        var selectPP = document.getElementById("<?php echo $this->campoSeguro('selecAtributosPersonas') ?>");
        cargarParametro1(selectPP.value);
    }
    var conexion1;

    function cargarParametro1(valorSelect)
    {
        conexion1 = new XMLHttpRequest();
        conexion1.onreadystatechange = procesarEventos1;
        var url = "<?php echo $urlFinal1 ?>" + "&valor=" + valorSelect;
        conexion1.open("GET", url, true);
        conexion1.send();
    }
    function insertTextAtCursor(el, text) {
        var val = el.value, endIndex, range, doc = el.ownerDocument;
        if (typeof el.selectionStart == "number"
                && typeof el.selectionEnd == "number") {
            endIndex = el.selectionEnd;
            el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
            el.selectionStart = el.selectionEnd = endIndex + text.length;
        } else if (doc.selection != "undefined" && doc.selection.createRange) {
            el.focus();
            range = doc.selection.createRange();
            range.collapse(false);
            range.text = text;
            range.select();
        }
    }

    function procesarEventos1()
    {
        var selectPP = document.getElementById("<?php echo $this->campoSeguro('selecAtributosPersonas') ?>");
        var textArea = document.getElementById("<?php echo $this->campoSeguro('contenidoCertificado') ?>");
        if (selectPP.value != "") {
            if (conexion1.readyState == 4)
            {
                var text = " [" + conexion1.responseText + "] ";
                insertTextAtCursor(textArea, text);
            }
        } else {
            alert("Selecione un Parametro");
        }
    }

</script>
<?php
//Variables
$cadenaACodificar2 = "pagina=" . $this->miConfigurador->getVariableConfiguracion("pagina");
$cadenaACodificar2 .= "&procesarAjax=true";
$cadenaACodificar2 .= "&action=index.php";
$cadenaACodificar2 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar2 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar2 .= $cadenaACodificar2 . "&funcion=incluirPV";
$cadenaACodificar2 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$cadena2 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaACodificar1, $enlace);
// URL definitiva
$urlFinal2 = $url . $cadena2;
?>
<script>

    var click_boton1 = document.getElementById("btincluirPV");
    click_boton1.addEventListener('click', presionBoton2, false);


    function presionBoton2(e) {
        var selectPP = document.getElementById("<?php echo $this->campoSeguro('selecInfoVinculacion') ?>");
        cargarParametro2(selectPP.value);
    }

    var conexion2;

    function cargarParametro2(valorSelect)
    {
        conexion2 = new XMLHttpRequest();
        conexion2.onreadystatechange = procesarEventos2;
        var url = "<?php echo $urlFinal2 ?>" + "&valor=" + valorSelect;
        conexion2.open("GET", url, true);
        conexion2.send();
    }


    function procesarEventos2()
    {
        var selectPV = document.getElementById("<?php echo $this->campoSeguro('selecInfoVinculacion') ?>");
        var textArea = document.getElementById("<?php echo $this->campoSeguro('contenidoCertificado') ?>");
        if (selectPV.value != "") {
            if (conexion2.readyState == 4)
            {
                var text = " [" + conexion2.responseText + "] ";
                insertTextAtCursor(textArea, text);
            }
        } else {
            alert("Selecione un Parametro");
        }
    }

    var click_botonLimpiar = document.getElementById("btlimpiarTexarea");
    click_botonLimpiar.addEventListener('click', limpiarTexArea, false);
    function limpiarTexArea() {
        var textArea = document.getElementById("<?php echo $this->campoSeguro('contenidoCertificado') ?>");
        textArea.value = "";
    }

    var click_validarContenido = document.getElementById("btvalidarTexarea");
    click_validarContenido.addEventListener('click', obtenerContenido, false);
    function obtenerContenido() {
        var textArea = document.getElementById("<?php echo $this->campoSeguro('contenidoCertificado') ?>");
        var validacion;
        validacion = validarContenido(textArea.value);
    }

    function validarContenido(text) {
        var numErrores = 0;
        var posErrores = [];
        for (i = 0; i < text.length; i++) {
            if (text.charAt(i) == "[" && text.charAt(i + 1) == " ") {
                numErrores = numErrores + 1;
                posErrores.push(pos = i + 1);
            } else if (text.charAt(i) == " " && text.charAt(i + 1) == "]") {
                numErrores = numErrores + 1;
                posErrores.push(pos = i);
            }
        }
        alert("Numero de Errores Encontrados: " + numErrores);
        for (i = 0; i < posErrores.length; i++) {
            alert("Error en la posision: " + posErrores[i]);
        }

    }


</script>
