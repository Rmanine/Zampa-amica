window.addEventListener('load', function () {
    validateProfilo();
});

var dettagli_form = {
	nome: [/^[A-Za-zÀ-ÖØ-öø-ÿ]+(?:[ '\-][A-Za-zÀ-ÖØ-öø-ÿ]+)*$/, 'Inserire un nome valido (solo lettere, spazi o apostrofi).'],
    cognome: [/^[A-Za-zÀ-ÖØ-öø-ÿ]+(?:[ '\-][A-Za-zÀ-ÖØ-öø-ÿ]+)*$/, 'Inserire un cognome valido (sono ammessi cognomi composti).'],
    telefono: [/^[0-9]{8,11}$/, 'Inserire un numero di telefono valido (solo cifre, senza spazi, massimo 11 numeri).'],
    email: [/^[^\s@]+@[^\s@]+\.[^\s@]+$/,'Inserire un indirizzo <span lang="en">email</span> nel formato mario.rossi@gmail.com.']
}

function validateProfilo() {
    let form = document.getElementById("form_volontario");

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
    document.getElementById("error_" + input.id).textContent = "";
	if (regex && !regex.test(text)) {
		messaggio(input);
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
    var p = document.getElementById("error_" + input.id);
    if (p) {
        p.innerHTML = dettagli_form[input.id][1];
    }
}
