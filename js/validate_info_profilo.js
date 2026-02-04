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
        input.addEventListener("change", function () {
            validazioneCampo(this, formId);
        });
    }

    form.addEventListener('submit', function (event) {
        if (!validazioneForm(formId)) {
            event.preventDefault();
        }
    });
}

function validazioneCampo(input, formId) {
    const errorList = document.getElementById("error_" + input.id);
    errorList.innerHTML = "";

    const value = input.value;
    const fieldRules = rules[input.id];
    let isValid = true;
    const errors = [];

    if (
        formId === 'form_modifica_profilo' &&
        (input.id === 'password' || input.id === 'confirmed_password') &&
        value === ""
    ) {
        input.setAttribute('aria-invalid', 'false');
        return true;
    }

    for (let i = 0; i < fieldRules.length; i++) {
        if (!fieldRules[i].test(value)) {
            errors.push(fieldRules[i].message);
            isValid = false;
        }
    }

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
}


function validazioneForm(formId) {
    let valid = true;

    for (let id in rules) {
        const input = document.getElementById(id);
        if (input) {
            valid = validazioneCampo(input, formId) && valid;
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

