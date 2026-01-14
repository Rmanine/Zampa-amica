<?php

require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "login.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('accedi.html');

$messaggiPerForm = '';
$success = '';

function pulisciInput($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    return $value;
}

session_start();
if (isset($_SESSION["logged_in_user"])) {
    header("Location: profilo_utente.php");
    exit();
}

if (isset($_GET['account_deleted'])) {
    if ($_GET['account_deleted'] == 1) {
        $success = '<p class="success" role="status">Eliminazione del profilo avvenuta con successo.</p>';
    }
}

if (isset($_POST['submit'])) {

    $username = pulisciInput($_POST['username']);
    if (strlen($username) == 0) {
        $messaggiPerForm .= '<li>Inserire lo <span lang="en">username</span></li>';
    } else {
        if (!preg_match('/^\S+$/', $username)) {
            $messaggiPerForm .= '<li>Lo <span lang="en">username</span> non deve contenere spazi</li>';
        }
    }

    $password = pulisciInput($_POST['password']);
    if (strlen($password) == 0) {
        $messaggiPerForm .= '<li>Inserire la <span lang="en">password</span></li>';
    } else {
        if (!preg_match('/^\S+$/', $password)) { //da rivedere
            $messaggiPerForm .= '<li>La <span lang="en">password</span> non deve contenere spazi</li>';
        }
    }

    if ($messaggiPerForm == "") {
        $connessione = new DBAccess();
        $connessioneOK = $connessione->openDBConnection();

        if ($connessioneOK) {
            $auth = new login($connessione);
            $userID = $auth->authenticate($username, $password);
            if ($userID) {
                $auth->log_user_in($userID);
                if (isset($_SESSION['return_url'])) {
                    $returnUrl = $_SESSION['return_url'];
                    unset($_SESSION['return_url']); // pulisci la sessione
                    header("Location: " . $returnUrl);
                    exit();
                }
                header("Location: profilo_utente.php");
                exit();
            } else {
                $messaggiPerForm = '<li><span lang="en">Username</span> o <span lang="en">password</span> errati.</li>';
            }
        } else {
            //$messaggiPerForm = '<p class="req">I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio. Riprova più tardi, contattaci a questa email miao@gmail.com</p>';
            header("Location: errore_500.html");
            exit();
        }
    }
    if ($messaggiPerForm != "") {
        $messaggiPerForm = '<div class="form-errors"><ul role="alert">Errore:' . $messaggiPerForm . '</ul></div>';
    }

}

$template = new Template();
$headerProcessato = $template->getHeader('accedi');
$footerProcessato = $template->getFooter();
$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[success]', $success, $paginaHTML);

echo $paginaHTML;

?>