document.addEventListener('DOMContentLoaded', function () {
    const toggleFiltri = document.getElementById('toggle-filtri');
    const filtri = document.getElementById('filtri');
    const overlay = document.getElementById('overlay-filtri');
    const chiudiFiltri = document.getElementById('chiudi-filtri');
    let ultimoFocusPrimaApertura = null;

    // Verifica se siamo su mobile
    const isMobile = () => window.innerWidth <= 768;

    // Disabilita/abilita elementi focusabili nel menu filtri
    const setFiltriInert = (inert) => {
        if (!isMobile()) return; // Solo su mobile

        const elementi = filtri.querySelectorAll(
            'button, [href], input, select, textarea, summary, [tabindex]:not([tabindex="-1"])'
        );

        elementi.forEach(el => {
            if (inert) {
                el.setAttribute('tabindex', '-1');
                el.setAttribute('data-was-focusable', 'true');
            } else {
                if (el.getAttribute('data-was-focusable')) {
                    el.removeAttribute('tabindex');
                    el.removeAttribute('data-was-focusable');
                }
            }
        });
    };

    // Elementi focusabili nel menu (quando aperto)
    const getFocusableElements = () => {
        return filtri.querySelectorAll(
            'button:not([tabindex="-1"]), [href]:not([tabindex="-1"]), input:not([tabindex="-1"]), select:not([tabindex="-1"]), textarea:not([tabindex="-1"]), summary:not([tabindex="-1"])'
        );
    };

    // Blocco il focus nel menu
    const trapFocus = (e) => {
        if (!isMobile()) return;

        const focusabili = Array.from(getFocusableElements());

        if (focusabili.length === 0) return;

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

    const apriFiltri = () => {
        if (!isMobile()) return;

        ultimoFocusPrimaApertura = document.activeElement;

        filtri.classList.add('aperto');
        overlay.classList.add('attivo');
        filtri.setAttribute('aria-hidden', 'false');
        overlay.setAttribute('aria-hidden', 'false');
        toggleFiltri.setAttribute('aria-expanded', 'true');

        setFiltriInert(false);

        // Impedisci scroll del body
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            const primoElemento = getFocusableElements()[0];
            if (primoElemento) {
                primoElemento.focus();
            }
        }, 100);

        document.addEventListener('keydown', trapFocus);
        document.addEventListener('keydown', handleEscape);
    };

    const chiudiFiltriFunc = () => {
        if (!isMobile()) return;

        filtri.classList.remove('aperto');
        overlay.classList.remove('attivo');
        filtri.setAttribute('aria-hidden', 'true');
        overlay.setAttribute('aria-hidden', 'true');
        toggleFiltri.setAttribute('aria-expanded', 'false');

        setFiltriInert(true);

        document.body.style.overflow = '';

        if (ultimoFocusPrimaApertura) {
            ultimoFocusPrimaApertura.focus();
        }

        document.removeEventListener('keydown', trapFocus);
    };

    if (toggleFiltri && filtri && overlay) {
        if (isMobile()) {
            filtri.setAttribute('aria-hidden', 'true');
            setFiltriInert(true);
        }

        toggleFiltri.addEventListener('click', apriFiltri);

        if (chiudiFiltri) {
            chiudiFiltri.addEventListener('click', chiudiFiltriFunc);
        }

        overlay.addEventListener('click', chiudiFiltriFunc);

        window.addEventListener('resize', () => {
            if (!isMobile()) {
                filtri.classList.remove('aperto');
                overlay.classList.remove('attivo');
                filtri.removeAttribute('aria-hidden');
                document.body.style.overflow = '';

                const elementi = filtri.querySelectorAll('[data-was-focusable]');
                elementi.forEach(el => {
                    el.removeAttribute('tabindex');
                    el.removeAttribute('data-was-focusable');
                });
            } else {
                if (!filtri.classList.contains('aperto')) {
                    filtri.setAttribute('aria-hidden', 'true');
                    setFiltriInert(true);
                }
            }
        });
    }
});