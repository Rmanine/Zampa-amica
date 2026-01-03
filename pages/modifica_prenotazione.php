<?php

require_once ".." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

function pulisciInput($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}

$tagPermessi = '<em><strong><ul><li>';
function pulisciNote($value)
{
    global $tagPermessi;
    $value = trim($value);
    $value = strip_tags($value, $tagPermessi);
    return $value;
}

// Verifica che l'utente sia autenticato
/*
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: accedi.html");
    exit();
}
*/

$nomeAnimale = "";
$data = "";
$note = "";
$imgAnimale = "";
$idPrenotazione = null;
$errors = "";
$idAnimale = null;
$idUtente = null;

$paginaHTML = file_get_contents('modifica_prenotazione.html');

$connessione = new DBAccess();

// Recupero dati prenotazione (GET)
if (!isset($_POST['submit'])) {
    if (!isset($_GET['id'])) {
        header("Location: profilo_utente.php");
        exit();
    }

    $idPrenotazione = intval($_GET['id']);

    $connessioneOK = $connessione->openDBConnection();

    if (!$connessioneOK) {
        header("Location: errore_500.html");
        exit();
    }

    $prenotazione = $connessione->getPrenotazione($idPrenotazione);
    $connessione->closeConnection();

    if ($prenotazione == null) {
        header("Location: errore_500.html");
        exit();
    }

    // Verifica che la prenotazione appartenga all'utente loggato
    /*
    if ($prenotazione['UtenteID'] != $_SESSION['user_id']) {
        header("Location: errore_500.html");
        exit();
    }
    */

    $nomeAnimale = is_null($prenotazione['NomeAnimale']) ? '' : $prenotazione['NomeAnimale'];
    $data = is_null($prenotazione['DataOra']) ? '' : $prenotazione['DataOra'];
    $note = is_null($prenotazione['Note']) ? '' : $prenotazione['Note'];
    $idAnimale = is_null($prenotazione['AnimaleID']) ? '' : $prenotazione['AnimaleID'];
    $idUtente = is_null($prenotazione['UtenteID']) ? '' : $prenotazione['UtenteID'];

    $imgAnimale = '<img src="../img/assets/' . htmlspecialchars($prenotazione['ImmagineAnimale']) . '" alt="Foto di ' . htmlspecialchars($nomeAnimale) . '">';
}

// Invio form (POST)
if (isset($_POST['submit'])) {
    $idPrenotazione = intval($_POST['idPrenotazione']);

    // Ricarica i dati della prenotazione per avere nome e immagine
    $connessioneOK = $connessione->openDBConnection();

    if (!$connessioneOK) {
        header("Location: errore_500.html");
        exit();
    }

    $prenotazione = $connessione->getPrenotazione($idPrenotazione);
    $connessione->closeConnection();

    if ($prenotazione == null) {
        header("Location: errore_500.html");
        exit();
    }

    // Verifica che la prenotazione appartenga all'utente loggato
    /*
    if ($prenotazione['UtenteID'] != $_SESSION['user_id']) {
        $connessione->closeConnection();
        header("Location: errore_500.html");
        exit();
    }
    */

    $nomeAnimale = $prenotazione['NomeAnimale'];
    $imgAnimale = '<img src="../img/assets/' . $prenotazione['ImmagineAnimale'] . '" alt="Foto di ' . $nomeAnimale . '">';

    if (empty($_POST['date'])) { // Data è campo obbligatorio
        $errors .= "<p>Compilare i campi richiesti.</p>";
    } else {
        $data = pulisciInput($_POST['date']);
        if (strlen($data) == 0) {
            $errors .= "<p>Selezionare un giorno valido.</p>";
        } else {
            if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data)) {
                $errors .= "<p>Inserire la data nel formato AAAA-MM-DD.</p>";
            } else {
                $domani = date('Y-m-d', strtotime('+1 day'));
                if ($data < $domani) {
                    $errors .= '<p>La data deve corrispondere ad un giorno valido partendo da domani.</p>';
                }
            }
        }
    }

    if (isset($_POST['note']) && !empty($_POST['note'])) { // Note è campo opzionale
        $note = pulisciNote($_POST['note']);
    } else {
        $note = "";
    }

    if (!empty($errors)) {
        $paginaHTML = str_replace("[idPrenotazione]", $idPrenotazione, $paginaHTML);
        $paginaHTML = str_replace("[NomeAnimale]", $nomeAnimale, $paginaHTML);
        $paginaHTML = str_replace("[ImgAnimale]", $imgAnimale, $paginaHTML);
        $paginaHTML = str_replace("[data]", $data, $paginaHTML);
        $paginaHTML = str_replace("[note]", $note, $paginaHTML);
        $paginaHTML = str_replace("[errors]", $errors, $paginaHTML);
        echo $paginaHTML;
        exit();
    }

    $connessioneOK = $connessione->openDBConnection();

    if (!$connessioneOK) {
        header("Location: errore_500.html");
        exit();
    }

    $risultato = $connessione->updatePrenotazione($idPrenotazione, $data, $note);
    $connessione->closeConnection();

    if ($risultato) {
        header("Location: profilo_utente.php?success=1");
        exit();
    } else {
        header("Location: errore_500.html");
        exit();
    }
}


$paginaHTML = str_replace("[idPrenotazione]", htmlspecialchars($idPrenotazione), $paginaHTML);
$paginaHTML = str_replace("[NomeAnimale]", htmlspecialchars($nomeAnimale), $paginaHTML);
$paginaHTML = str_replace("[ImgAnimale]", $imgAnimale, $paginaHTML);
$paginaHTML = str_replace("[data]", htmlspecialchars($data), $paginaHTML);
$paginaHTML = str_replace("[note]", htmlspecialchars($note), $paginaHTML);
$paginaHTML = str_replace("[errors]", $errors, $paginaHTML);

echo $paginaHTML;

?>