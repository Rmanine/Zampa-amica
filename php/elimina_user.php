<?php
require_once "dbConnection.php";
use DB\DBAccess;


// Controllo sessione
session_start();
if (isset($_SESSION['logged_in_user'])) {
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
            header("Location: ../accedi.php"); 
            exit();
        }
    }
}

// se qualcosa va storto
header("Location: ../errore_500.html");
exit();
?>