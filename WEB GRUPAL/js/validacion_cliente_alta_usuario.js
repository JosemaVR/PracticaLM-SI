// Funciones de validación
	// EJERCICIO 3: Validación del formulario en cliente con Javascript (después de la validación de HTML5)
	function validateForm() {
		// Comprobar que la longitud de la contraseña es >=8, que contiene letras mayúsculas y minúsculas y números
		var error1 = passwordValidation();
        
		var error2 = passwordConfirmation();
        
		return (error1.length==0) && (error2.length==0);
	}

	// EJERCICIO 3.1: Comprobar la restricciones del password y aplicar clases CSS mediante JQuery
	function passwordValidation(){
		var password = document.getElementById("PASSUSUARIO");
		var pwd = password.value;
		var valid = true;

		// Comprobamos la longitud de la contraseña
		valid = valid && (pwd.length>=8);
		
		// Comprobamos si contiene letras mayúsculas, minúsculas y números
		var hasNumber = /\d/;
		var hasUpperCases = /[A-Z]/;
		var hasLowerCases = /[a-z]/;
		valid = valid && (hasNumber.test(pwd)) && (hasUpperCases.test(pwd)) && (hasLowerCases.test(pwd));
		
		// Si no cumple las restricciones, devolvemos un error
		if(!valid){
			var error = "¡Inserte una contraseña valida! Al menos 8 carácteres: mayúsculas, minúsculas y números.";
		}else{
			var error = "";
		}
	        password.setCustomValidity(error);
		return error;
	}
	
	// EJERCICIO 3.2: Campos de contraseña y confirmación de contraseña iguales
	function passwordConfirmation(){
		// Obtenemos el campo de password y su valor
        var password = document.getElementById("PASSUSUARIO");
		var pwd = password.value;
		// Obtenemos el campo de confirmación de password y su valor
		var passconfirm = document.getElementById("confirmpass");
		var confirmation = passconfirm.value;

		// Los comparamos
		if (pwd != confirmation) {
			var error = "¡Las contraseñas no coinciden!";
		}else{
			var error = "";
		}

		passconfirm.setCustomValidity(error);

		return error;
	}
	function passwordStrength(password){
    		// Creamos un Map donde almacenar las ocurrencias de cada carácter
    		var letters = {};

    		// Recorremos la contraseña carácter por carácter
    		var length = password.length;
    		for(x = 0, length; x < length; x++) {
        		// Consultamos el carácter en la posición x
        		var l = password.charAt(x);

        		// Si NO existe en el Map, inicializamos su contador a uno
        		// Si ya existía, incrementamos el contador en uno
        		letters[l] = (isNaN(letters[l])? 1 : letters[l] + 1);
    		}

    		// Devolvemos el cociente entre el número de caracteres únicos (las claves del Map)
		// y la longitud de la contraseña
    		return Object.keys(letters).length / length;
	}
	
	function passwordColor(){
		var passField = document.getElementById("PASSUSUARIO");
		var strength = passwordStrength(passField.value);
		
		if(!isNaN(strength)){
			var type = "weakpass";
			if(passwordValidation()!=""){
				type = "weakpass";
			}else if(strength > 0.7){
				type = "strongpass";
			}else if(strength > 0.4){
				type = "middlepass";
			}
		}else{
			type = "nanpass";
		}
		passField.className = type;
		
		return type;
	}
	