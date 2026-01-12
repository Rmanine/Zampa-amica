<?php
require_once "php/dbConnection.php";
require_once "template.php";
use DB\DBAccess;


// Template HTML caricato come una stringa
$paginaHTML = file_get_contents('volontariato.html');


// Inizializzazone delle variabili
$messaggiPerForm = "";
$nome = ''; 
$cognome = ''; 
$email = ''; 
$telefono = '';


// Funzione di pulizia
function pulisciInput($value) {
    $value = trim($value); 
    $value = strip_tags($value); 
    $value = htmlentities($value);
    return $value;
}


//Invio form
if (isset($_POST['submit'])) {
    // Apertura lista degli errori
    $messaggiPerForm = "<ul>";

    // Validazione nome
    $nome = pulisciInput($_POST['nome']);
    if (strlen($nome) == 0) {
        $messaggiPerForm .= "<li>Inserire il nome.</li>";
    } else {
        if (preg_match("/\d/", $nome)) {
            $messaggiPerForm .= "<li>Il nome non può contenere numeri.</li>";
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
        $messaggiPerForm .= "<li>Inserire l'indirizzo email.</li>";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $messaggiPerForm .= "<li>Formato email non valido.</li>";
        }
    }

    // Validazione telefono
    $telefono = pulisciInput($_POST['telefono']);
    if (strlen($telefono) == 0) {
        $messaggiPerForm .= "<li>Inserire il numero di telefono.</li>";
    } else {
        if (!preg_match("/^\d{7,15}$/", $telefono)) {
            $messaggiPerForm .= "<li>Il telefono deve contenere tra 7 e 15 cifre.</li>";
        }
    }

    $messaggiPerForm .= "</ul>";

    // Inserimento
    if ($messaggiPerForm == "<ul></ul>") { // Lista errori vuota
        $messaggiPerForm = "";
        $connessione = new DBAccess();
        if ($connessione->openDBConnection()) { // Controllo connessione al database
            $risultato = $connessione->addVolontario($email, $nome, $cognome, $telefono);
            $connessione->closeConnection();

            if ($risultato) {
                $messaggiPerForm = '<p>Richiesta inviata con successo!</p>';
                $nome = $cognome = $email = $telefono = "";
            } else {
                $messaggiPerForm = '<p>Errore: email già presente.</p>';
            }
        } else {
            $messaggiPerForm = '<p>Errore di connessione.</p>';
        }
    }
}

$template = new Template();
$headerProcessato = $template->getHeader('volontariato');
$footerProcessato = $template->getFooter();
$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

// Output
$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[valNome]', $nome, $paginaHTML);
$paginaHTML = str_replace('[valCognome]', $cognome, $paginaHTML);
$paginaHTML = str_replace('[valEmail]', $email, $paginaHTML);
$paginaHTML = str_replace('[valTelefono]', $telefono, $paginaHTML);


echo $paginaHTML;
?>