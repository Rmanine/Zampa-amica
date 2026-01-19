<?php

require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "session.php";
require_once "." . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "dbConnection.php";
require_once "template.php";

use DB\DBAccess;

session_start();

$paginaHTML = file_get_contents('i_nostri_animali.html');

$connessione = new DBAccess();

$stringaAnimali = '';
$nomeAnimale = '';
$filtri = [
	'tipo' => $_GET['tipo'] ?? 'all',
	'eta' => $_GET['eta'] ?? 'all',
	'sesso' => $_GET['sesso'] ?? 'all',
	'taglia' => $_GET['taglia'] ?? 'all'
];
$filtriAttivi = '';
$filtriAttiviArray = [];

function getTagliaFemminile($taglia)
{
	if ($taglia == "Piccolo") {
		return "piccola";
	}
	if ($taglia == "Medio") {
		return "media";
	}
	if ($taglia == "Grande") {
		return "grande";
	}
	return $taglia;
}

function getIconGenere($genere)
{
	$generi = array(
		'Femmina' => 'img/female-icon.svg',
		'Maschio' => 'img/male-icon.svg'
	);
	return $generi[$genere];
}

if ($filtri['tipo'] !== 'all') {
    $filtriAttiviArray[] = 'Tipo (' . $filtri['tipo'] . ')';
}
if ($filtri['sesso'] !== 'all') {
    $filtriAttiviArray[] = 'Sesso (' . $filtri['sesso'] . ')';
}
if ($filtri['taglia'] !== 'all') {
    $filtriAttiviArray[] = 'Taglia (' . $filtri['taglia'] . ')';
}
if ($filtri['eta'] !== 'all') {
    $filtriAttiviArray[] = 'Et&agrave; (' . $filtri['eta'] . ')';
}

if (!empty($filtriAttiviArray)) {
    $filtriAttivi .= '<span class="importante">Filtri attivi</span>: ' . implode(', ', $filtriAttiviArray);
} else {
    $filtriAttivi = 'Nessun filtro attivo';
}

$connessioneOK = $connessione->openDBConnection();
if ($connessioneOK) {
	$animali = $connessione->getList($filtri);
	$connessione->closeConnection();

	if ($animali && is_array($animali)) {
		$stringaAnimali .= '<ul class="galleria">';
		foreach ($animali as $animale) {
			if ($animale['Lingua'] == 'en') {
				$nomeAnimale = '<span lang=\'en\'>' . $animale['Nome'] . '</span>';
			} else {
				$nomeAnimale = $animale['Nome'];
			}
			$stringaAnimali .= '<li class="elemento-galleria">';
			$stringaAnimali .= '<a href="dettagli_animale.php?id=' . $animale['ID'] . '">';
			if($animale['Specie'] == "Cane"){
				$stringaAnimali .= '<img width="250" height="250" src="./img/assets/' . $animale['Immagine'] . '" alt="' . $animale['Specie'] . ' di taglia ' . getTagliaFemminile($animale['Taglia']) . '" />';
			} else {
				$stringaAnimali .= '<img width="250" height="250" src="./img/assets/' . $animale['Immagine'] . '" alt="' . $animale['Specie'] . '" />';
			}
			$stringaAnimali .= '<footer>';
			$stringaAnimali .= '<h3 class="label-elemento">' . $nomeAnimale . '</h3>';
			$stringaAnimali .= '<img width="20" height="20" class="genere" src="./' . getIconGenere($animale['Genere']) . '" alt="' . $animale['Genere'] . '" />';
			$stringaAnimali .= '</footer>';
			$stringaAnimali .= '</a>';
			$stringaAnimali .= '</li>';
		}
		$stringaAnimali .= '</ul>';
	} else {
		if(!empty($filtriAttiviArray)){
			$stringaAnimali = '<p class="galleria no-result">Non abbiamo trovato animali con le caratteristiche che hai scelto. Prova a modificare i filtri: potresti scoprire nuovi amici in cerca di una casa.</p>';
		} else {
			$stringaAnimali = '<p class="galleria no-result">Nessun animale presente</p>';
		}
	}
} else {
	//$stringaAnimali = '<p>I sistemi sono momentaneamente fuori servizio, ci stiamo occupando del problema. Riprova più tardi oppure contattaci a questa email miao@gmail.com</p>';
	header("Location: errore_500.html");
    exit();
}

$template = new Template();
$headerProcessato = $template->getHeader('i_nostri_animali');
$footerProcessato = $template->getFooter();
$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

$paginaHTML = str_replace('[listaAnimali]', $stringaAnimali, $paginaHTML);
$paginaHTML = str_replace('[filtriAttivi]', $filtriAttivi, $paginaHTML);
echo $paginaHTML;

?>