window.addEventListener('load', function () {
    validateProfilo('form_modifica_profilo');
    validateProfilo('form_registrazione');
});

const rules = {
    username: [
        {
            test: value => value.length >= 4,
            message: 'Lo <span lang="en">username</span> deve contenere almeno 4 caratteri.'
        },
        {
            test: value => value.length <= 50,
            message: 'Lo <span lang="en">username</span> deve contenere al massimo 50 caratteri.'
        },
        {
            test: value => /^[a-zA-Z0-9.]+$/.test(value),
            message: 'Lo <span lang="en">username</span> può contenere solo lettere, numeri o punti.'
        }
    ],

    email: [
        {
            test: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'Formato <span lang="en">email</span> non valido.'
        }
    ],

    password: [
        {
            test: value => value.length >= 8,
            message: 'La <span lang="en">password</span> deve contenere almeno 8 caratteri.'
        },
        {
            test: value => /[a-z]/.test(value),
            message: 'La <span lang="en">password</span> deve contenere almeno una lettera minuscola.'
        },
        {
            test: value => /[A-Z]/.test(value),
            message: 'La <span lang="en">password</span> deve contenere almeno una lettera maiuscola.'
        },
        {
            test: value => /[*+%]/.test(value),
            message: 'La <span lang="en">password</span> deve contenere almeno un carattere speciale tra * + %.'
        },
        {
            test: value => /[0-9]/.test(value),
            message: 'La <span lang="en">password</span> deve contenere almeno un numero.'
        }
    ],

    confirmed_password: [
        {
            test: value =>
                value === document.getElementById('password').value,
            message: 'Le due <span lang="en">password</span> non coincidono.'
        }
    ]
};

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

    for (let key in rules) {
        let input = document.getElementById(key);
        input.addEventListener("blur", function () {
            validazioneCampo(this);
        });
    }

    form.addEventListener('submit', function (event) {
        if (!validazioneForm()) {
            event.preventDefault();
        }
    });
}

function validazioneCampo(input) {
<<<<<<< HEAD
    const errorList = document.getElementById("error_" + input.id);
    errorList.innerHTML = "";

	const value = input.value;
    const fieldRules = rules[input.id];
    let isValid = true;
    const errors = [];

    for (let i = 0; i < fieldRules.length; i++) {
        if (!fieldRules[i].test(value)) {
            errors.push(fieldRules[i].message);
            isValid = false;
=======
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
>>>>>>> 5f3cddb9cd2daeeb7d5fd002d5045da94a2d21f8
        }
    }

<<<<<<< HEAD
    if (errors.length > 0) {
        const ul = document.createElement('ul');

        for (let i = 0; i < errors.length; i++) {
            const li = document.createElement('li');
            li.innerHTML = errors[i];
            ul.appendChild(li);
        }

        errorList.appendChild(ul);
    }

    input.setAttribute('aria-invalid', String(!isValid));
    return isValid;
=======
    // ALTRI CAMPI
    var regex = dettagli_form[input.id][0];
    if (regex && !regex.test(input.value)) {
        messaggio(input);
        return false;
    }

    return true;
>>>>>>> 5f3cddb9cd2daeeb7d5fd002d5045da94a2d21f8
}


function validazioneForm() {
<<<<<<< HEAD
	let valid = true;
=======
    var errori = true;
    for (var key in dettagli_form) {
        var input = document.getElementById(key);
        if (!validazioneCampo(input)) {
            errori = false;
        }
    }
    return errori;
}
>>>>>>> 5f3cddb9cd2daeeb7d5fd002d5045da94a2d21f8

    for (let id in rules) {
        const input = document.getElementById(id);
        if (input) {
            valid = validazioneCampo(input) && valid;
        }
    }

    return valid;
}

function mostraMessaggioPersonalizzato(input, testo) {
    var p = document.getElementById("error_" + input.id);
    if (p) {
        p.innerHTML = testo;
    }
}

