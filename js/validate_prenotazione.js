
window.addEventListener('load', function () {
	validatePrenotazione();
    setupRealtimeValidation();
});

function validatePrenotazione() {
    let form = document.getElementById('form_prenotazione');
    form.addEventListener('submit', function(event) {
        let err = document.getElementsByClassName("form-errors")[0];
        err.innerHTML = "";

        let msg = "<ul>";
        let validated = true;

        if(!validateDate()) {
            msg += "<li>La data selezionata deve essere un giorno valido a partire da domani.</li>";
            validated = false;
        }
        msg += "</ul>";

        if(!validated) {
            err.innerHTML += msg;
            event.preventDefault();
        }
    })
}

function setupRealtimeValidation() {
    const dateInput = document.getElementById("date");
    const err = document.getElementsByClassName("form-errors")[0];
    
    // Si attiva quando l'utente cambia la data
    dateInput.addEventListener('change', function() {
        err.innerHTML = "";
        
        if (!validateDate()) {
            err.innerHTML = "<ul><li>La data selezionata deve essere un giorno valido a partire da domani.</li></ul>";
        }
    });
}

function validateDate() {
    const input = document.getElementById("date").value;
    if (!input) return false;

    const selectedDate = new Date(input);
    selectedDate.setHours(0, 0, 0, 0);

    const tomorrow = new Date();
    tomorrow.setHours(0, 0, 0, 0);
    tomorrow.setDate(tomorrow.getDate() + 1);

    return selectedDate >= tomorrow;
}
