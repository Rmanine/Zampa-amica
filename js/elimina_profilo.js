
const btnElimina = document.getElementById('btn-elimina-profilo');
const dialog = document.getElementById('dialog-elimina-profilo');
const btnAnnulla = document.getElementById('btn-annulla');
const body = document.body;

if (btnElimina && dialog && btnAnnulla) {

    btnElimina.addEventListener('click', function () {
        dialog.showModal();
    });

    btnAnnulla.addEventListener('click', function () {
        dialog.close();
    });
}