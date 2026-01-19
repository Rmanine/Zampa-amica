<?php
require_once "php/dbConnection.php";
require_once "template.php";
use DB\DBAccess;


// Template HTML caricato come una stringa
$paginaHTML = file_get_contents('volontariato.html');

$template = new Template();
$headerProcessato = $template->getHeader('volontariato');
$footerProcessato = $template->getFooter();
$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);


// Inizializzazone delle variabili
$messaggiPerForm = '';
$nome = '';
$cognome = '';
$email = '';
$telefono = '';
$info = '';


// Funzione di pulizia
function pulisciInput($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}


//Invio form
if (isset($_POST['submit'])) {
    // Apertura lista degli errori

    // Validazione nome
    $nome = pulisciInput($_POST['nome']);
    if (strlen($nome) == 0) {
        $messaggiPerForm .= "<li>Inserire il nome.</li>";
    } else {
        if (preg_match("/\d/", $nome)) {
            $messaggiPerForm .= "<li>Il nome non pu&ograve; contenere numeri.</li>";
        }
    }

    // Validazione cognome
    $cognome = pulisciInput($_POST['cognome']);
    if (strlen($cognome) == 0) {
        $messaggiPerForm .= "<li>Inserire il cognome.</li>";
    }

    // Validazione email
    $email = pulisciInput($_POST['email']);
    if (strlen($email) == 0) {
        $messaggiPerForm .= '<li>Inserire l\'indirizzo <span lang="en">email</span>.</li>';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $messaggiPerForm .= '<li>Formato <span lang="en">email</span> non valido.</li>';
        }
    }

    // Validazione telefono
    $telefono = pulisciInput($_POST['telefono']);
    if (strlen($telefono) == 0) {
        $messaggiPerForm .= "<li>Inserire il numero di telefono.</li>";
    } else {
        if (!preg_match("/^\d{10}$/", $telefono)) {
            $messaggiPerForm .= "<li>Il numero di telefono deve contenere 10 cifre e non deve contenere il prefisso.</li>";
        }
    }

    // Inserimento
    if (empty($messaggiPerForm)) { // Lista errori vuota
        $connessione = new DBAccess();
        if ($connessione->openDBConnection()) { // Controllo connessione al database
            $risultato = $connessione->addVolontario($email, $nome, $cognome, $telefono);
            $connessione->closeConnection();

            if ($risultato) {
                $info = '<p class="success" role="status">Richiesta inviata con successo.</p>';
                $nome = $cognome = $email = $telefono = "";
            } else {
                $messaggiPerForm .= '<li>&Egrave; gi&agrave; stata effettuata una richiesta di volontariato con l\'indirizzo <span lang="en">email</span> inserito.</li>';
            }
        } else {
            header("Location: errore_500.html");
            exit();
        }
    }

    if (!empty($messaggiPerForm)) {
        $messaggiPerForm = '<div class="form-errors"><ul role="alert">Errore:' . $messaggiPerForm . '</ul></div>';
    }
}

// Output
$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[valNome]', $nome, $paginaHTML);
$paginaHTML = str_replace('[valCognome]', $cognome, $paginaHTML);
$paginaHTML = str_replace('[valEmail]', $email, $paginaHTML);
$paginaHTML = str_replace('[valTelefono]', $telefono, $paginaHTML);
$paginaHTML = str_replace('[info]', $info, $paginaHTML);


echo $paginaHTML;
?>