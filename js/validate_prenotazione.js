
window.addEventListener('load', function () {
	validatePrenotazione();
});

function validatePrenotazione() {
    let form = document.getElementById('form_prenotazione');
    form.addEventListener('submit', function(event) {
        let err = document.getElementsByClassName("form_errors")[0];
        err.innerHTML = "";

        let msg = "";
        let validated = true;

        if(!validateDate()) {
            msg = "<p>La data selezionata deve essere un giorno valido a partire da domani.JS</p>";
            validated = false;
        }

        if(!validated) {
            err.innerHTML += msg;
            event.preventDefault();
        }
    })
}

function validateDate() {
    const input = document.getElementById("date").value;
    
    if (!input) {
        return false;
    }
    const selectedDate = new Date(input);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    return selectedDate > today;
}