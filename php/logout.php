<?php

// Controllo sessione
session_start();
if (isset($_SESSION['logged_in_user'])) {

    // Distruzione della sessione
    session_unset(); // Libera le variabili di sessione
    session_destroy();

    // Reindirizzamento alla pagina di accesso
    header("Location: ../accedi.php");
    exit();
}

// se qualcosa va storto
header("Location: ../errore_500.html");
exit();
?>