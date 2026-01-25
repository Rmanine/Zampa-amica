window.addEventListener('load', function () {
    validateProfilo('form_modifica_profilo');
    validateProfilo('form_registrazione');
});

var dettagli_form = {
	username: ["/^[a-zA-Z0-9.]{4,50}$/",'<span lang="en">Username</span> non valido: usa 4–50 caratteri, solo lettere, numeri o punti.'],
    email: ["/^[^\s@]+@[^\s@]+\.[^\s@]+$/",'Indirizzo <span lang="en">email</span> non valido.'],
    new_password: ["/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!*+%]).{8,}$/","La password non rispetta i requisiti."],
    confirmed_password: [null,'Le <span lang="en">password</span> non coincidono.']
}

function validateProfilo(form) {
    let form = document.getElementById(form);

    for (let key in dettagli_form) {
        let input = document.getElementById(key);
        input.addEventListener("blur", function () {
            validazioneCampo(this);
        });
    }

    form.addEventListener('submit', function (event) {
        if (!event.submitter || event.submitter.name !== "submit") return;

        if (!validazioneForm()) {
            event.preventDefault();
        }
    });
}

function validazioneCampo(input) {
	var regex = dettagli_form[input.id][0];
	var text = input.value
	var p = input.parentNode;
	if (p.children[2]) {
		p.removeChild(p.children[2]);
    }
    if (input.id === "repeat_new_password") {
        let pwd = document.getElementById("new_password").value;
        if (input.value !== pwd) {
            messaggio(input);
            return false;
        }
        return true;
    }
	if (text.search(regex) != 0) {
		messaggio(input);
		input.focus();
		input.select(); 
		return false;
	}
	return true;
}

function validazioneForm() {
	var errori = true
	for (var key in dettagli_form) {
		var input = document.getElementById(key);
		errori = validazioneCampo(input) && errori;
	}
	return errori;
}

function messaggio(input) {
    var p = input.parentNode;
    var node = document.createElement("strong");
    node.textContent = dettagli_form[input.id][1];
    p.appendChild(node);
}
