<?php
require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
require_once "template.php";
use DB\DBAccess;


// Controllo sessione
session_start();
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: accedi.php");
    exit();
}


// Template  HTML caricato come una stringa
$paginaHTML = file_get_contents('modifica_profilo.html');

$template = new Template();
$headerProcessato = $template->getHeader('modifica_profilo');
$footerProcessato = $template->getFooter();
$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);


// Inizializzazione variabili
$messaggiPerForm = "";
$username_form = "";
$email_form = "";
$new_password_form = "";
$confirmPassword_form = "";


// Funzione di pulizia
function pulisciInput($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}


$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

if (!$connessioneOK) {
    header("Location: errore_500.html");
    exit();
}

// Recupero dei dati attuali per riempire il form
$datiUtente = $connessione->getUserById($_SESSION['logged_in_user']);
$connessione->closeConnection();
if (!$datiUtente) { // Se l'utente non viene trovato errore 403
    header("Location: errore_403.html");
    exit();
}
$id_utente = $datiUtente['ID'];
$username = $datiUtente['Username'];
$email = $datiUtente['Email'];
$password = $datiUtente['Password'];

$username_form = $username;
$email_form = $email;


// Invio form
if (isset($_POST['submit'])) {

    $username_form = pulisciInput($_POST['username']);
    $email_form = pulisciInput($_POST['email']);
    $new_password_form = $_POST['new_password'];
    $confirmPassword_form = $_POST['repeat_new_password'];

    if (empty($username_form) || empty($email_form)) {
        $messaggiPerForm .= '<li>Compilare i campi richiesti.</li>';
    } else {
        // Controllo se sono state eseguite modifiche ai dati rispetto al database. Se non ci sono modifiche non faccio niente e torno indietro
        if ($username_form == $username && $email_form == $email && empty($new_password_form)) {
            header("Location: profilo_utente.php");
            exit();
        }

        if (strlen($username_form) < 4) {
            $messaggiPerForm .= '<li>Lo <span lang="en">username</span> deve contenere almeno 4 caratteri.</li>';
        }
        if (strlen($username_form) > 50) {
            $messaggiPerForm .= '<li>Lo <span lang="en">username</span> deve contenere al massimo 50 caratteri.</li>';
        }
        if (!preg_match("/^[a-zA-Z0-9.]+$/", $username_form)) {
            $messaggiPerForm .= '<li>Lo <span lang="en">username</span> può contenere solo lettere, numeri o punti.</li>';
        }

        // Validazione Email
        if (!filter_var($email_form, FILTER_VALIDATE_EMAIL)) {
            $messaggiPerForm .= '<li>Formato <span lang="en">email</span> non valido.</li>';
        }

        // Validazione Password SOLO se è stata inserita
        if (!empty($new_password_form)) {
            if (strlen($new_password_form) < 8) {
                $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno 8 caratteri.</li>';
            }
            if (!preg_match("/[a-z]/", $new_password_form)) {
                $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno una lettera minuscola.</li>';
            }
            if (!preg_match("/[A-Z]/", $new_password_form)) {
                $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno una lettera maiuscola.</li>';
            }
            if (!preg_match("/[!*+%]/", $new_password_form)) {
                $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno un carattere speciale tra ! * + %.</li>';
            }
            if (!preg_match("/[0-9]/", $new_password_form)) {
                $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno un numero.</li>';
            }
            if ($new_password_form !== $confirmPassword_form) {
                $messaggiPerForm .= '<li>Le due <span lang="en">password</span> non coincidono.</li>';
            }
        }

        // Update nel database
        if (empty($messaggiPerForm)) { // Se non ci sono errori

            // Se la password è stata inserita, hashala, altrimenti mantieni quella vecchia
            $password_da_salvare = !empty($new_password_form) ? hash('sha256', $new_password_form) : $password;
            $connessioneOK = $connessione->openDBConnection();

            if (!$connessioneOK) {
                header("Location: errore_500.html");
                exit();
            }

            $risultato = $connessione->updateUser($id_utente, $email_form, $username_form, $password_da_salvare);
            $connessione->closeConnection();

            if ($risultato) {
                header("Location: profilo_utente.php?update=1");
                exit();
            } else {
                header("Location: errore_500.html");
                exit();
            }
        } else {
            $messaggiPerForm = '<div class="form-errors"><ul role="alert">Errore:' . $messaggiPerForm . '</ul></div>';
        }

    }
}

// Output
$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[valUsername]', $username_form, $paginaHTML);
$paginaHTML = str_replace('[valEmail]', $email_form, $paginaHTML);

echo $paginaHTML;
?>