<?php

require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "login.php";
require_once "template.php";
use DB\DBAccess;

// Se l'utente è autenticato allora va al suo profilo
session_start();
if (isset($_SESSION["logged_in_user"])) {
    header("Location: profilo_utente.php");
    exit();
}

$paginaHTML = file_get_contents('registrati.html');

$messaggiPerForm = "";
$username = '';
$email = '';

// PRE: Stringa "sporca"
// POST: Stringa sanificata e sicura per la stampa
function pulisciInput($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}


if (isset($_POST['submit'])) {
    // Validazione Username
    $username = pulisciInput($_POST['username']);
    $email = pulisciInput($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmed_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $messaggiPerForm .= '<li>Compilare tutti i campi</li>';
    } else {
        if (strlen($username) < 4) {
            $messaggiPerForm .= '<li>Lo <span lang="en">username</span> deve contenere almeno 4 caratteri.</li>';
        }
        if (strlen($username) > 50) {
            $messaggiPerForm .= '<li>Lo <span lang="en">username</span> deve contenere al massimo 50 caratteri.</li>';
        }
        if (!preg_match("/^[a-zA-Z0-9.]+$/", $username)) {
            $messaggiPerForm .= '<li>Lo <span lang="en">username</span> può contenere solo lettere, numeri o punti.</li>';
        }

        // Validazione Email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $messaggiPerForm .= '<li>Formato <span lang="en">email</span> non valido.</li>';
        }

        // Validazione Password
        if (strlen($password) < 8) {
            $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno 8 caratteri.</li>';
        }
        if (!preg_match("/[a-z]/", $password)) {
            $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno una lettera minuscola.</li>';
        }
        if (!preg_match("/[A-Z]/", $password)) {
            $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno una lettera maiuscola.</li>';
        }
        if (!preg_match("/[!*+%]/", $password)) {
            $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno un carattere speciale tra ! * + %.</li>';
        }
        if (!preg_match("/[0-9]/", $password)) {
            $messaggiPerForm .= '<li>La <span lang="en">password</span> deve contenere almeno un numero.</li>';
        }

        if ($password !== $confirmPassword) {
            $messaggiPerForm .= '<li>Le due <span lang="en">password</span> non coincidono.</li>';
        }

        // Inserimento nel database
        if (empty($messaggiPerForm)) {
            $connessione = new DBAccess();
            $connessioneOK = $connessione->openDBConnection();
            if ($connessioneOK) {
                $loginService = new Login($connessione);
                $esito = $loginService->add_user($username, $email, $password);
                $connessione->closeConnection();

                if ($esito) {
                    header("Location: profilo_utente.php");
                    exit();
                } else {
                    $messaggiPerForm = '<li><span lang="en">username</span> o <span lang="en">email</span> gi&agrave; esistenti.</li>';
                }
            } else {
                header("Location: errore_500.html");
                exit();
            }
        }
    }

    // raccolta errori
    if (!empty($messaggiPerForm)) {
        $messaggiPerForm = '<div class="form-errors"><ul role="alert">Errore:' . $messaggiPerForm . '</ul></div>';
    }
}

$template = new Template();
$headerProcessato = $template->getHeader('registrati');
$footerProcessato = $template->getFooter();

$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[valUsername]', $username, $paginaHTML);
$paginaHTML = str_replace('[valEmail]', $email, $paginaHTML);

echo $paginaHTML;
?>