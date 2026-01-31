window.addEventListener('load', function () {
    validateProfilo('form_modifica_profilo');
    validateProfilo('form_registrazione');
});

var dettagli_form = {
    username: [/^[a-zA-Z0-9.]{4,50}$/, '<span lang="en">Username</span> non valido: usa dai 4 ai 50 caratteri, solo lettere, numeri o punti.'],
    email: [/^[^\s@]+@[^\s@]+\.[^\s@]+$/, 'Inserire un indirizzo <span lang="en">email</span> nel formato mario.rossi@gmail.com.'],
    password: [null, ''],
    confirmed_password: [null, 'Le <span lang="en">password</span> non coincidono.']
}

var passwordChecks = [
    {
        test: pwd => pwd.length >= 8,
        msg: "La password deve contenere almeno 8 caratteri."
    },
    {
        test: pwd => /[a-z]/.test(pwd),
        msg: "La password deve contenere almeno una lettera minuscola."
    },
    {
        test: pwd => /[A-Z]/.test(pwd),
        msg: "La password deve contenere almeno una lettera maiuscola."
    },
    {
        test: pwd => /\d/.test(pwd),
        msg: "La password deve contenere almeno un numero."
    },
    {
        test: pwd => /[*+%]/.test(pwd),
        msg: "La password deve contenere almeno un carattere speciale (* + %)."
    }
];


function validateProfilo(formId) {
    let form = document.getElementById(formId);

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
    document.getElementById("error_" + input.id).textContent = "";

    // PASSWORD
    if (input.id === "password") {
        for (let check of passwordChecks) {
            if (!check.test(input.value)) {
                mostraMessaggioPersonalizzato(input, check.msg);
                return false;
            }
        }
        return true;
    }

    // CONFERMA PASSWORD
    if (input.id === "confirmed_password") {
        let pwd = document.getElementById("password").value;
        if (input.value !== pwd) {
            messaggio(input);
            return false;
        }
        return true;
    }

    // ALTRI CAMPI
    var regex = dettagli_form[input.id][0];
    if (regex && !regex.test(input.value)) {
        messaggio(input);
        return false;
    }

    return true;
}


function validazioneForm() {
    var errori = true;
    for (var key in dettagli_form) {
        var input = document.getElementById(key);
        if (!validazioneCampo(input)) {
            errori = false;
        }
    }
    return errori;
}

function messaggio(input) {
    var p = document.getElementById("error_" + input.id);
    if (p) {
        p.innerHTML = dettagli_form[input.id][1];
    }
}

function mostraMessaggioPersonalizzato(input, testo) {
    var p = document.getElementById("error_" + input.id);
    if (p) {
        p.innerHTML = testo;
    }
}

