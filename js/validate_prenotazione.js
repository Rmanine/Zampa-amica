
window.addEventListener('load', function () {
    validatePrenotazione();
});

const rules = {
    date: [
        {
            test: value => validateDate(value),
            message: 'La data selezionata deve essere un giorno valido a partire da domani.'
        }
    ]
};

function validatePrenotazione() {
    let form = document.getElementById('form_prenotazione');

    for (let key in rules) {
        let input = document.getElementById(key);
        input.addEventListener('blur', function (event) {
            validazioneCampo(this)
        });
    }

    form.addEventListener('submit', function (event) {
        if (!validazioneForm()) {
            event.preventDefault();
        }
    })
}

function validazioneCampo(input) {
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

function validazioneForm() {
	let valid = true;
    for (let id in rules) {
        const input = document.getElementById(id);
        if (input) {
            valid = validazioneCampo(input) && valid;
        }
    }
    return valid;
}

function validateDate(value) {
    if (!value) return false;

    const selectedDate = new Date(value);
    selectedDate.setHours(0, 0, 0, 0);

    const tomorrow = new Date();
    tomorrow.setHours(0, 0, 0, 0);
    tomorrow.setDate(tomorrow.getDate() + 1);

    return selectedDate >= tomorrow;
}
