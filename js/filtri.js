// Gestione filtri mobile accessibile
document.addEventListener('DOMContentLoaded', function () {
    const toggleFiltri = document.getElementById('toggle-filtri');
    const filtri = document.getElementById('filtri');
    const overlay = document.getElementById('overlay-filtri');
    const chiudiFiltri = document.getElementById('chiudi-filtri');
    let ultimoFocusPrimaApertura = null;

    // Elementi focusabili nel menu
    const getFocusableElements = () => {
        return filtri.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
    };

    // Blocco il focus nel menu
    const trapFocus = (e) => {
        const focusabili = getFocusableElements();
        const primoFocusabile = focusabili[0];
        const ultimoFocusabile = focusabili[focusabili.length - 1];

        if (e.key === 'Tab') {
            if (e.shiftKey) {
                if (document.activeElement === primoFocusabile) {
                    ultimoFocusabile.focus();
                    e.preventDefault();
                }
            } else {
                if (document.activeElement === ultimoFocusabile) {
                    primoFocusabile.focus();
                    e.preventDefault();
                }
            }
        }
    };

    // Funzione per aprire i filtri
    const apriFiltri = () => {
        ultimoFocusPrimaApertura = document.activeElement;

        filtri.classList.add('aperto');
        overlay.classList.add('attivo');
        filtri.setAttribute('aria-hidden', 'false');
        overlay.setAttribute('aria-hidden', 'false');
        toggleFiltri.setAttribute('aria-expanded', 'true');

        // Impedisci scroll del body
        document.body.style.overflow = 'hidden';

        // Attiva trap focus
        document.addEventListener('keydown', trapFocus);
        document.addEventListener('keydown', handleEscape);
    };

    const chiudiFiltriFunc = () => {
        filtri.classList.remove('aperto');
        overlay.classList.remove('attivo');
        filtri.setAttribute('aria-hidden', 'true');
        overlay.setAttribute('aria-hidden', 'true');
        toggleFiltri.setAttribute('aria-expanded', 'false');

        // Ripristina scroll del body
        document.body.style.overflow = '';

        // Riporta focus al bottone che ha aperto il menu
        if (ultimoFocusPrimaApertura) {
            ultimoFocusPrimaApertura.focus();
        }

        // Rimuovi trap focus
        document.removeEventListener('keydown', trapFocus);
        document.removeEventListener('keydown', handleEscape);
    };

    if (toggleFiltri && filtri && overlay) {
        filtri.setAttribute('aria-hidden', 'true');

        toggleFiltri.addEventListener('click', apriFiltri);

        if (chiudiFiltri) {
            chiudiFiltri.addEventListener('click', chiudiFiltriFunc);
        }
        overlay.addEventListener('click', chiudiFiltriFunc);
    }
});