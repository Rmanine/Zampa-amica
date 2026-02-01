<?php

require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
require_once "template.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('dettagli_animale.html');

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$stringaAnimale = '';
$animaleVisualizzato = '';
$titoloAnimale = '';
$nomeAnimale = '';
$id = (int) $_GET['id'] ?? 0;
$stringaPrenota = '';
$success = '';

session_start();
$_SESSION['return_url'] = $_SERVER['REQUEST_URI']; // Permette di tornare indietro a questa pagina, se l'utente fa l'accesso
if (isset($_SESSION["logged_in_user"])) {
    $stringaPrenota .= '<a class="stile-bottone-2" href="./prenotazione.php?id=' . $id . '">Prenota un incontro</a>';
} else {
    $stringaPrenota .= '<p>Per prenotare un incontro è necessario effettuare l\'accesso.</p>';
    $stringaPrenota .= '<a class="stile-bottone-2" href="./accedi.php">Accedi</a>';
}
if (isset($_GET['success'])) {
    if ($_GET['success'] == 1) {
        $success = '<p class="success" role="alert">Prenotazione avvenuta con successo.</p>';
    }
}

function createStringaEtaAnimale($etaAnimale)
{
    $stringaEta = '';
    if ($etaAnimale < 12) {
        $stringaEta .= $etaAnimale;
        if ($stringaEta == 1) {
            $stringaEta .= ' mese';
        } else {
            $stringaEta .= ' mesi';
        }
    } elseif ($etaAnimale >= 12) {
        $stringaEta = intdiv(intval($etaAnimale), 12);
        if ($stringaEta == 1) {
            $stringaEta .= ' anno';
        } else {
            $stringaEta .= ' anni';
        }
    }
    return $stringaEta;
}

if ($connessioneOK && $id !== 0) {
    $animale = $connessione->getAnimale($id);
    $connessione->closeConnection();

    if ($animale && is_array($animale)) {
        if ($animale['Lingua'] == 'en') {
            $nomeAnimale = '<span lang="en">' . $animale['Nome'] . '</span>';
        } else {
            $nomeAnimale = $animale['Nome'];
        }
        $animaleVisualizzato = $animale['Nome'];
        $titoloAnimale = '<h1>' . $nomeAnimale . '</h1>';

        $stringaAnimale .= '<div>';
        if (empty($animale['Immagine']) || !file_exists('./img/assets/' . $animale['Immagine'])) {
            $stringaAnimale .= '<img src="./img/assets/noimg.jpg" alt=""/>';
        } else {
            $stringaAnimale .= '<img src="./img/assets/' . $animale['Immagine'] . '" alt="" />';
        }
        $stringaAnimale .= '</div>';

        $stringaAnimale .= '<div>';
        $stringaAnimale .= '<dl>';
        $stringaAnimale .= '<dt>Specie: </dt>';
        $stringaAnimale .= '<dd>' . $animale['Specie'] . '</dd>';
        $stringaAnimale .= '<dt>Et&agrave;: </dt>';
        $stringaAnimale .= '<dd>' . createStringaEtaAnimale($animale['EtaMesi']) . '</dd>';
        $stringaAnimale .= '<dt>Sesso: </dt>';
        $stringaAnimale .= '<dd>' . $animale['Genere'] . '</dd>';
        if (!is_null($animale['Taglia'])) {
            $stringaAnimale .= '<dt>Taglia: </dt>';
            $stringaAnimale .= '<dd>' . $animale['Taglia'] . '</dd>';
        }
        $stringaAnimale .= '<dt>Descrizione: </dt>';
        $stringaAnimale .= '<dd>' . $animale['Descrizione'] . '</dd>';
        $stringaAnimale .= '</dl>';
        $stringaAnimale .= '</div>';
    } else {
        $stringaAnimale = '<p>Le informazioni per questo amico a quattro zampe non sono disponibili</p>';
    }
} else {
    header("Location: errore_500.html");
    exit();
}

$template = new Template();
$headerProcessato = $template->getHeader('dettagli_animali');
$footerProcessato = $template->getFooter();
$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

$paginaHTML = str_replace('[AnimaleCorrente]', $animaleVisualizzato, $paginaHTML);
$paginaHTML = str_replace('[AnimaleTitolo]', $titoloAnimale, $paginaHTML);
$paginaHTML = str_replace('[Animale]', $stringaAnimale, $paginaHTML);
$paginaHTML = str_replace('[idAnimale]', $id, $paginaHTML);
$paginaHTML = str_replace('[Prenota]', $stringaPrenota, $paginaHTML);
$paginaHTML = str_replace("[success]", $success, $paginaHTML);
echo $paginaHTML;

?>