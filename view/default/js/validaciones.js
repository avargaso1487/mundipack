function solonumeros(e) {
	key = e.keyCode || e.which;
	teclado = String.fromCharCode(key);
	numeros = "0123456789";
	especiales = "8-37-38-46"
	teclado_especial=false;

	for (var i in especiales) {
	    if (key == especiales[i]) {
	        teclado_especial= true;
	    }
	}

	if (numeros.indexOf(teclado)==-1 && !teclado_especial) {
	    return false;
	}
}

function telefonovalidation(e) {
	var unicode = e.charCode ? e.charCode : e.keyCode            
	if (unicode != 45 && unicode != 32) {
	    if (unicode < 48 || unicode > 57) //if not a number
	    { return false } //disable key press                
	}
}

function soloLetras(e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toLowerCase();
	letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
	especiales = "8-37-39-46";

	tecla_especial = false
	for(var i in especiales){
	    if(key == especiales[i]){
	        tecla_especial = true;
	        break;
	    }
	}

	if(letras.indexOf(tecla)==-1 && !tecla_especial){
	    return false;
	}
}

function NumCheck(e, field) {
    key = e.keyCode ? e.keyCode : e.which
    // backspace
    if (key == 8) return true
    // 0-9
    if (key > 47 && key < 58) {
        if (field.value == "") return true
        regexp = /.[0-9]{2}$/
        return !(regexp.test(field.value))
    }
    // .
    if (key == 46) {
        if (field.value == "") return false
        regexp = /^[0-9]+$/
        return regexp.test(field.value)
    }
    // other key
    return false

}