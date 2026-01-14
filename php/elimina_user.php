<?php
require_once "dbConnection.php";
use DB\DBAccess;

session_start();

// Verifica autenticazione
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: ../errore_403.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: profilo_utente.php");
    exit();
}

$id_utente = $_SESSION['logged_in_user'];

$connessione = new DBAccess();
if ($connessione->openDBConnection()) {

    // Eliminazione dell'utente dal database
    $risultato = $connessione->deleteUser($id_utente);
    $connessione->closeConnection();

    if ($risultato) {
        // Se l'eliminazione ha avuto successo, distruzione della sessione
        session_unset(); // Libera le variabili di sessione
        session_destroy();

        // Reindirizzamento alla pagina di accesso
        header("Location: ../accedi.php?account_deleted=1");
        exit();
    }
}


// se qualcosa va storto
header("Location: ../errore_500.html");
exit();
?>