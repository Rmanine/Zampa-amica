
const btnElimina = document.getElementById('btn-elimina-profilo');
const dialog = document.getElementById('dialog-elimina-profilo');
const btnAnnulla = document.getElementById('btn-annulla');
const body = document.body;
let elementoFocusPrecedente = null;
let trapFocusHandler = null; // Salva il riferimento all'handler

if (btnElimina && dialog && btnAnnulla) {

    // Apri dialog
    btnElimina.addEventListener('click', function () {
        elementoFocusPrecedente = document.activeElement;
        dialog.removeAttribute('hidden');
        body.style.overflow = 'hidden';
        btnAnnulla.focus();
        trapFocus(dialog);
    });

    btnAnnulla.addEventListener('click', function () {
        chiudiDialog();
    });

    function chiudiDialog() {
        dialog.setAttribute('hidden', '');
        body.style.overflow = '';

        // Rimuovi l'event listener del trap focus
        if (trapFocusHandler) {
            dialog.removeEventListener('keydown', trapFocusHandler);
            trapFocusHandler = null;
        }

        if (elementoFocusPrecedente) {
            elementoFocusPrecedente.focus();
        }
    }

    function trapFocus(elemento) {
        const elementiInterattivi = elemento.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        const primoElemento = elementiInterattivi[0];
        const ultimoElemento = elementiInterattivi[elementiInterattivi.length - 1];

        // Rimuovi handler precedente se esistente
        if (trapFocusHandler) {
            elemento.removeEventListener('keydown', trapFocusHandler);
        }

        trapFocusHandler = function (e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === primoElemento) {
                        ultimoElemento.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === ultimoElemento) {
                        primoElemento.focus();
                        e.preventDefault();
                    }
                }
            }
        };

        elemento.addEventListener('keydown', trapFocusHandler);
    }
}