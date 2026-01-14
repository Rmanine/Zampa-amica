<?php

require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
require_once "template.php";
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
session_start();
if (!isset($_SESSION["logged_in_user"])) {
    header("Location: errore_403.html");
    exit();
}

$nomeAnimale = "";
$data = "";
$note = "";
$imgAnimale = "";
$idPrenotazione = null;
$errors = "";
$idAnimale = null;
$idUtente = null;

$paginaHTML = file_get_contents('modifica_prenotazione.html');

$template = new Template();
$headerProcessato = $template->getHeader('modifica_prenotazione');
$footerProcessato = $template->getFooter();
$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

$connessione = new DBAccess();


if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Se è GET
    if (!isset($_GET['id'])) {
        header("Location: profilo_utente.php");
        exit();
    }
    $idPrenotazione = intval($_GET['id']);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Se è POST (sumbit form o elimina appuntamento)
    if (empty($_POST['idPrenotazione'])) {
        header("Location: profilo_utente.php");
        exit();
    }
    $idPrenotazione = intval($_POST['idPrenotazione']);
} else {
    header("Location: profilo_utente.php");
    exit();
}

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

$connessioneOK = $connessione->openDBConnection();

if (!$connessioneOK) {
    header("Location: errore_500.html");
    exit();
}

$animale = $connessione->getAnimale($prenotazione['AnimaleID']);
$connessione->closeConnection();

// Verifica che la prenotazione appartenga all'utente loggato
if ($prenotazione['UtenteID'] != $_SESSION["logged_in_user"]) {
    header("Location: errore_403.html");
    exit();
}

if (is_null($animale['Nome'])) {
    $nomeAnimale = '';
} else {
    if ($animale['Lingua'] == 'en') {
        $nomeAnimale = '<span lang=\'en\'>' . $animale['Nome'] . '</span>';
    } else {
        $nomeAnimale = $animale['Nome'];
    }
}

//$nomeAnimale = is_null($prenotazione['NomeAnimale']) ? '' : $prenotazione['NomeAnimale'];
$data = is_null($prenotazione['DataOra']) ? '' : $prenotazione['DataOra'];
$note = is_null($prenotazione['Note']) ? '' : $prenotazione['Note'];
$idAnimale = is_null($prenotazione['AnimaleID']) ? '' : $prenotazione['AnimaleID'];
$idUtente = is_null($prenotazione['UtenteID']) ? '' : $prenotazione['UtenteID'];
$imgAnimale = '<img src="./img/assets/' . $prenotazione['ImmagineAnimale'] . '" alt="' . $animale['Specie'] . ' di taglia ' . $animale['Taglia'] . '">';


//Elimina appuntamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $connessioneOK = $connessione->openDBConnection();

    if (!$connessioneOK) {
        header("Location: errore_500.html");
        exit();
    }

    $eliminaPrenotazione = $connessione->deletePrenotazione($idPrenotazione);
    $connessione->closeConnection();

    if ($eliminaPrenotazione) {
        header("Location: profilo_utente.php?delete=1");
        exit();
    } else {
        header("Location: errore_500.html");
        exit();
    }
}

// Invio form (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // controllo se l'utente ha fatto modifiche sui campi. Se sono identici alle info nel database non eseguo niente
    $dataPost = isset($_POST['date']) ? pulisciInput($_POST['date']) : '';
    $notePost = isset($_POST['note']) ? pulisciNote($_POST['note']) : '';
    if ($dataPost == $data && $notePost == $note) {
        header("Location: profilo_utente.php");
        exit();
    }
    
    if (empty($dataPost)) { // Data è campo obbligatorio
        $errors .= "<li>Compilare tutti i campi richiesti.</li>";
    } else {
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dataPost)) {
            $errors .= "<li>Inserire la data nel formato AAAA-MM-DD.</li>";
        } else {
            $domani = date('Y-m-d', strtotime('+1 day'));
            if ($dataPost < $domani) {
                $errors .= '<li>La data deve corrispondere ad un giorno valido, partendo da domani.</li>';
            }
        }
    }

    $connessioneOK = $connessione->openDBConnection();

    if (!$connessioneOK) {
        header("Location: errore_500.html");
        exit();
    }

    // controllo se per quell'utente esiste già una prenotazione allo stesso animale nello stesso giorno
    $prenotazioniUtente = $connessione->getListaPrenotazioni($idUtente);
    $connessione->closeConnection();
    $prenotazioneEsistente = false;

    if ($prenotazioniUtente != null) {
        foreach ($prenotazioniUtente as $prenotazione) {
            if ($prenotazione['AnimaleID'] == $idAnimale && $prenotazione['DataOra'] == $dataPost && $prenotazione['ID'] != $idPrenotazione) {
                $prenotazioneEsistente = true;
                break;
            }
        }
    }

    if ($prenotazioneEsistente) {
        $errors .= '<li>Hai gi&agrave; una prenotazione per questo animale nella data selezionata.</li>';
    }

    if (!empty($errors)) { // Se ci sono errori li mostro
        $errors = '<div class="form-errors"><ul role="alert">Errore:' . $errors . '</ul></div>';
        $paginaHTML = str_replace("[idPrenotazione]", $idPrenotazione, $paginaHTML);
        $paginaHTML = str_replace("[NomeAnimale]", $nomeAnimale, $paginaHTML);
        $paginaHTML = str_replace("[ImgAnimale]", $imgAnimale, $paginaHTML);
        $paginaHTML = str_replace("[data]", $dataPost, $paginaHTML);
        $paginaHTML = str_replace("[note]", $notePost, $paginaHTML);
        $paginaHTML = str_replace("[errors]", $errors, $paginaHTML);
        echo $paginaHTML;
        exit();
    }
    $errors = "";

    $connessioneOK = $connessione->openDBConnection();

    if (!$connessioneOK) {
        header("Location: errore_500.html");
        exit();
    }

    $risultato = $connessione->updatePrenotazione($idPrenotazione, $dataPost, $notePost);
    $connessione->closeConnection();

    if ($risultato) {
        header("Location: profilo_utente.php?update=1");
        exit();
    } else {
        //echo "Risultato false";
        header("Location: errore_500.html");
        exit();
    }
}

$paginaHTML = str_replace("[idPrenotazione]", htmlspecialchars($idPrenotazione), $paginaHTML);
$paginaHTML = str_replace("[NomeAnimale]", $nomeAnimale, $paginaHTML);
$paginaHTML = str_replace("[ImgAnimale]", $imgAnimale, $paginaHTML);
$paginaHTML = str_replace("[data]", htmlspecialchars($data), $paginaHTML);
$paginaHTML = str_replace("[note]", $note, $paginaHTML);
$paginaHTML = str_replace("[errors]", $errors, $paginaHTML);

echo $paginaHTML;

?>