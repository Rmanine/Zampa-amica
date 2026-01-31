<?php

require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
require_once "template.php";
use DB\DBAccess;

function formattaData($data)
{
    $mesi = [
        1 => 'Gennaio',
        2 => 'Febbraio',
        3 => 'Marzo',
        4 => 'Aprile',
        5 => 'Maggio',
        6 => 'Giugno',
        7 => 'Luglio',
        8 => 'Agosto',
        9 => 'Settembre',
        10 => 'Ottobre',
        11 => 'Novembre',
        12 => 'Dicembre'
    ];

    $timestamp = strtotime($data);
    if ($timestamp === false) {
        return '';
    }

    $giorno = (int) date('j', $timestamp);
    $mese = (int) date('n', $timestamp);
    $anno = date('Y', $timestamp);

    return $giorno . ' ' . $mesi[$mese] . ' ' . $anno;
}

$paginaHTML = file_get_contents('profilo_utente.html');
$connessione = new DBAccess();

// Verifica che l'utente sia autenticato
session_start();
if (!isset($_SESSION["logged_in_user"])) {
    header("Location: accedi.php");
    exit();
}

$success = "";
$idUtente = $_SESSION["logged_in_user"];
$msgPrenotazioni = "";
$id = null;
$nomeAnimale = "";
$data = "";
$note = "";

if (isset($_GET['update'])) {
    if ($_GET['update'] == 1) {
        $success = '<p class="success" role="alert">Modifica avvenuta con successo.</p>';
    }
}
if (isset($_GET['delete'])) {
    if ($_GET['delete'] == 1) {
        $success = '<p class="success" role="alert">Eliminazione avvenuta con successo.</p>';
    }
}

$connessioneOK = $connessione->openDBConnection();

if (!$connessioneOK) {
    header("Location: errore_500.html");
    exit();
}

$infoUtente = $connessione->getUserById($idUtente);
$listaPrenotazioni = $connessione->getListaPrenotazioni($idUtente);
$connessione->closeConnection();

if ($infoUtente == null) {
    header("Location: errore_500.html");
    exit();
}

$username = is_null($infoUtente['Username']) ? '' : $infoUtente['Username'];
$email = is_null($infoUtente['Email']) ? '' : $infoUtente['Email'];

if ($listaPrenotazioni == null) {
    // l'utente non ha effettuato nessuna prenotazione
    $msgPrenotazioni = '<p class="label-elemento">Nessuna prenotazione trovata.</p>';
} else {
    $msgPrenotazioni = "<ul>";

    foreach ($listaPrenotazioni as $prenotazione) {
        // controllo che ogni prenotazione appartenga all'utente loggato
        if ($prenotazione['UtenteID'] == $idUtente) {
            $id = $prenotazione['ID'];
            if ($prenotazione['Lingua'] == 'en') {
                $nomeAnimale = '<span lang="en">' . $prenotazione['Nome'] . '</span>';
            } else {
                $nomeAnimale = $prenotazione['Nome'];
            }
            $data = $prenotazione['Data'];
            $note = !empty($prenotazione['Note']) ? $prenotazione['Note'] : 'Nessuna nota';
            $dataFormatoIta = formattaData($data);

            $msgPrenotazioni .= "<li>";
            $msgPrenotazioni .= "<div>";
            $msgPrenotazioni .= "<h3>" . $nomeAnimale . "</h3>";
            $msgPrenotazioni .= '<p>Data: <time datetime="' . $data . '">' . $dataFormatoIta . '</time></p>';
            $msgPrenotazioni .= '<p class="note">Note: ' . $note . "</p>";
            $msgPrenotazioni .= "</div>";
            $msgPrenotazioni .= '<div class="account-buttons">';
            $msgPrenotazioni .= '<a class="stile-bottone-2" href="modifica_prenotazione.php?id=' . $id . '">Gestisci appuntamento</a>';
            $msgPrenotazioni .= "</div>";
            $msgPrenotazioni .= "</li>";
        }
    }

    $msgPrenotazioni .= "</ul>";
}

$template = new Template();
$headerProcessato = $template->getHeader('profilo_utente');
$footerProcessato = $template->getFooter();
$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

$paginaHTML = str_replace("[success]", $success, $paginaHTML);
$paginaHTML = str_replace("[Lista Prenotazioni]", $msgPrenotazioni, $paginaHTML);
$paginaHTML = str_replace("[username]", $username, $paginaHTML);
$paginaHTML = str_replace("[email]", $email, $paginaHTML);

echo $paginaHTML;

?>