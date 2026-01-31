window.addEventListener('load', function () {
    validateProfilo();
});

const rules = {
    nome: [
        {
            test: value => value.length > 0,
            message: 'Inserire il nome.'
        },
        {
            test: value => !/\d/.test(value),
            message: 'Il nome non può contenere numeri.'
        }
    ],

    cognome: [
        {
            test: value => value.length > 0,
            message: 'Inserire il cognome.'
        }
    ],

    email: [
        {
            test: value => value.length > 0,
            message: 'Inserire l\'indirizzo <span lang="en">email</span>.'
        },
        {
            test: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
            message: 'Formato <span lang="en">email</span> non valido.'
        }
    ],

    telefono: [
        {
            test: value => value.length > 0,
            message: 'Inserire il numero di telefono.'
        },
        {
            test: value => /^\d{10}$/.test(value),
            message: 'Il numero di telefono deve contenere 10 cifre e non deve contenere il prefisso.'
        }
    ]
};

function validateProfilo() {
    let form = document.getElementById("form_volontario");

    for (let id in rules) {
        const input = document.getElementById(id);
        if (!input) continue;
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
	const errorBox = document.getElementById('error_' + input.id);
    errorBox.innerHTML = '';
    const value = input.value;
    const fieldRules = rules[input.id];
    let isValid = true;
    const errors = [];

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

        errorBox.appendChild(ul);
    }

    input.setAttribute('aria-invalid', String(!isValid));
    return isValid;
}

function validazioneForm() {
	var valid = true
	for (let id in rules) {
        const input = document.getElementById(id);
        if (input) {
            valid = validazioneCampo(input) && valid;
        }
    }
    return valid;
}
