<?php

require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
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
    header("Location: errore_403.php");
    exit();
}

$nomeAnimale = "";
$imgAnimale = "";
$errors = "";
$idAnimale = null;
$idUtente = null;
$dataPost = "";
$notePost = "";

$paginaHTML = file_get_contents('prenotazione.html');

$connessione = new DBAccess();


if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Se è GET
    if (!isset($_GET['id'])) {
        header("Location: errore_500.php");
        exit();
    }
    $idAnimale = intval($_GET['id']);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Se è POST (sumbit form)
    if (empty($_POST['idAnimale'])) {
        header("Location: errore_500.php");
        exit();
    }
    $idAnimale = intval($_POST['idAnimale']);
} else {
    header("Location: errore_500.php");
    exit();
}

$connessioneOK = $connessione->openDBConnection();

if (!$connessioneOK) {
    header("Location: errore_500.html");
    exit();
}

$animale = $connessione->getAnimale($idAnimale);
$connessione->closeConnection();

if ($animale == null) {
    header("Location: errore_500.html");
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
$idAnimale = is_null($animale['ID']) ? '' : $animale['ID'];
$idUtente = $_SESSION["logged_in_user"];
$imgAnimale = '<img src="./img/assets/' . $animale['Immagine'] . '" alt="' . $animale['Specie'] . ' di taglia ' . $animale['Taglia'] . '">';

// Invio form (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    // Prelevo i valori del form
    $dataPost = isset($_POST['date']) ? pulisciInput($_POST['date']) : '';
    $notePost = isset($_POST['note']) ? pulisciNote($_POST['note']) : '';

    $errors .= "<ul>";
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
    $errors .= "</ul>";

    if ($errors != "<ul></ul>") { // Se ci sono errori li mostro
        $paginaHTML = str_replace("[idAnimale]", $idAnimale, $paginaHTML);
        $paginaHTML = str_replace("[NomeAnimale]", $nomeAnimale, $paginaHTML);
        $paginaHTML = str_replace("[data]", $dataPost, $paginaHTML);
        $paginaHTML = str_replace("[note]", $notePost, $paginaHTML);
        $paginaHTML = str_replace("[ImgAnimale]", $imgAnimale, $paginaHTML);
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

    $risultato = $connessione->addPrenotazione($idUtente, $idAnimale, $dataPost, $notePost);
    $connessione->closeConnection();

    if ($risultato) {
        header("Location: dettagli_animale.php?id=" . $idAnimale . "&success=1");
        exit();
    } else {
        header("Location: errore_500.html");
        exit();
    }
}


$paginaHTML = str_replace("[idAnimale]", htmlspecialchars($idAnimale), $paginaHTML);
$paginaHTML = str_replace("[NomeAnimale]", $nomeAnimale, $paginaHTML);
$paginaHTML = str_replace("[data]", $dataPost, $paginaHTML);
$paginaHTML = str_replace("[note]", $notePost, $paginaHTML);
$paginaHTML = str_replace("[ImgAnimale]", $imgAnimale, $paginaHTML);
$paginaHTML = str_replace("[errors]", $errors, $paginaHTML);

echo $paginaHTML;

?>