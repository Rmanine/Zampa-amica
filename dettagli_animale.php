<?php

require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('dettagli_animale.html');

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$stringaAnimale = '';
$animaleVisualizzato = '';
$id = (int)$_GET['id'] ?? 0;

function  createStringaEtaAnimale($etaAnimale) {
    $stringaEta = '';
    if ($etaAnimale < 12) {
        $stringaEta .= $etaAnimale . ' mesi';
    }
    elseif ($etaAnimale >= 12) {
        $stringaEta = intdiv(intval($etaAnimale), 12) . ' anni';
    }
    return $stringaEta;
}

if ($connessioneOK && $id !== 0) {
    $animale = $connessione->getAnimale($id);
    $connessione->closeConnection();

    if ($animale && is_array($animale)) {
        $animaleVisualizzato = $animale['Nome'];

        $stringaAnimale .= '<article class="card">';
        $stringaAnimale .= '<img src="./img/assets/' . $animale['Immagine'] . '" alt="' . $animale['Specie'] . 'di nome' . $animale['Nome'] . '">';
        $stringaAnimale .= '<p class="label-elemento">' . $animale['Nome'] . '</p>';
        $stringaAnimale .= '</article>';

        $stringaAnimale .= '<div class="terzo-contenuto-sottocontenuto">';
        $stringaAnimale .= '<ul>';
        $stringaAnimale .= '<li>Specie: ' . $animale['Specie'] . '</li>';
        $stringaAnimale .= '<li>Età: ' . createStringaEtaAnimale($animale['EtaMesi']) . '</li>';
        $stringaAnimale .= '<li>Sesso: ' . $animale['Genere'] . '</li>';
        $stringaAnimale .= '<li>Taglia: ' . $animale['Taglia'] . '</li>';
        $stringaAnimale .= '</ul>';
        $stringaAnimale .= '<p>' . nl2br($animale['Descrizione']) . '</p>';
        $stringaAnimale .= '</div>';
    } else {
        $stringaAnimale = '<p>Le informazioni per questo amico a quattro zampe non sono disponibili</p>';
    }
} else {
    $stringaAnimale = '<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio. Riprova più tardi, contattaci a questa email miao@gmail.com</p>';
}

$paginaHTML = str_replace('[Animale]', $stringaAnimale, $paginaHTML);
$paginaHTML = str_replace('[AnimaleCorrente]', $animaleVisualizzato, $paginaHTML);
$paginaHTML = str_replace('[idAnimale]', $id, $paginaHTML);
echo $paginaHTML;

?>