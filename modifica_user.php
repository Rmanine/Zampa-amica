<?php
require_once "php/dbConnection.php";
use DB\DBAccess;


// Controllo sessione
session_start();
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: php/login.php"); // Reindirizza se non loggato
    exit();
}


// Template  HTML caricato come una stringa
$paginaHTML = file_get_contents('modifica_profilo.html');


// Inizializzazione variabili
$messaggiPerForm = "";


// Funzione di pulizia
function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value);
    return $value;
}


$connessione = new DBAccess();
$connessione->openDBConnection();


// Recupero dei dati attuali per riempire il form
$datiUtente = $connessione->getUserById($_SESSION['logged_in_user']);
if (!$datiUtente) { // Se l'utente non viene trovato ritorno alla pagine di login
    $connessione->closeConnection();
    header("Location: php/login.php");
    exit();
}
$id_utente = $datiUtente['ID'];
$username_form = $datiUtente['Username'];
$email_form = $datiUtente['Email'];
$password_attuale = $datiUtente['Password'];


// Invio form
if (isset($_POST['submit'])) {
    // Apertura lista degli errori
    $messaggiPerForm = "<ul>";

    // Validazione username
    $username_form = pulisciInput($_POST['username']);
    if (strlen($username_form) == 0) {
        $messaggiPerForm .= "<li>Inserire lo <span lang='en'>username</span>.</li>";
    } else if (strlen($username_form) < 2) {
        $messaggiPerForm .= "<li><span lang='en'>Username</span> troppo corto (minimo 2 caratteri).</li>";
    }

    // Validazione email
    $email_form = pulisciInput($_POST['email']);
    if (strlen($email_form) == 0) {
        $messaggiPerForm .= "<li>Inserire l'indirizzo <span lang='en'>email</span>.</li>";
    } else if (!filter_var($email_form, FILTER_VALIDATE_EMAIL)) {
        $messaggiPerForm .= "<li>Formato <span lang='en'>email</span> non valido.</li>";
    }

    // Gestione password
    $pass1 = $_POST['new_password'];
    $pass2 = $_POST['repeat_new_password'];
    $password_da_salvare = $password_attuale; // Quella vecchia se non modificata

    if (!empty($pass1)) { // L'utente ha scritto qualcosa nel campo nuova password
        if (strlen($pass1) < 8) {
            $messaggiPerForm .= "<li>La nuova <span lang='en'>password</span> deve essere di almeno 8 caratteri.</li>";
        } else if ($pass1 !== $pass2) {
            $messaggiPerForm .= "<li>Le <span lang='en'>password</span> non coincidono.</li>";
        } else {
            // Criptazione SHA256 per il database
            $password_da_salvare = hash('sha256', $pass1);
        }
    }

    $messaggiPerForm .= "</ul>";

    // Inserimento
    if ($messaggiPerForm == "<ul></ul>") { // Lista errori vuota
        $messaggiPerForm = "";
        
        $risultato = $connessione->updateUser($id_utente, $email_form, $username_form, $password_da_salvare);
        
        if ($risultato) {
            $messaggiPerForm = '<p>Profilo aggiornato con successo!</p>';
        } else {
            // affected_rows è 0 se i dati inviati sono identici a quelli già presenti
            $messaggiPerForm = '<p>Nessuna modifica effettuata (dati identici).</p>';
        }
    }
}

$connessione->closeConnection(); 
// Fuori dal blocco if: la connessione viene chiusa anche se l'utente non preme il tasto "Salva"

// Output
$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[valUsername]', $username_form, $paginaHTML);
$paginaHTML = str_replace('[valEmail]', $email_form, $paginaHTML);

echo $paginaHTML;
?>