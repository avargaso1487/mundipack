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

function SoloNumerosDecimales3(e, valInicial, nEntero, nDecimal) {
    var obj = e.srcElement || e.target;
    var tecla_codigo = (document.all) ? e.keyCode : e.which;
    var tecla_valor = String.fromCharCode(tecla_codigo);
    var patron2 = /[\d.]/;
    var control = (tecla_codigo === 46 && (/[.]/).test(obj.value)) ? false : true;
    var existePto = (/[.]/).test(obj.value);

    //el tab
    if (tecla_codigo === 8)
        return true;

    if (valInicial !== obj.value) {
        var TControl = obj.value.length;
        if (existePto === false && tecla_codigo !== 46) {
            if (TControl === nEntero) {
                obj.value = obj.value + ".";
            }
        }

        if (existePto === true) {
            var subVal = obj.value.substring(obj.value.indexOf(".") + 1, obj.value.length);

            if (subVal.length > 1) {
                return false;
            }
        }

        return patron2.test(tecla_valor) && control;
    }
    else {
        if (valInicial === obj.value) {
            obj.value = '';
        }
        return patron2.test(tecla_valor) && control;
    }
}

function soloNumeroDecimal(e){
    key = e.keycode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = ".1234567890";
    especiales = "8-37-38-46-164-32-0";
    teclado_especial = false;
    for(var i in especiales){
        if(key == especiales[i]){
            teclado_especial = true;
        }
    }
    if(letras.indexOf(teclado)==-1 && !teclado_especial){
        return false;
    }
}