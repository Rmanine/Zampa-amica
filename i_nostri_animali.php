<?php

require_once "." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "session.php";
require_once "." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "dbConnection.php";

use DB\DBAccess;

session_start();

$paginaHTML = file_get_contents('i_nostri_animali.html');

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$stringaAnimali = '';
$filtri = [
    'tipo'   => $_GET['tipo']   ?? 'all',
    'eta'    => $_GET['eta']    ?? 'all',
    'sesso'  => $_GET['sesso']  ?? 'all',
    'taglia' => $_GET['taglia'] ?? 'all'
];

function getIconGenere($genere) {
	$generi = array(
		'Femmina' => 'img/female-icon.svg',
		'Maschio' => 'img/male-icon.svg'
	);
	return $generi[$genere];
}

if ($connessioneOK) {
	$animali = $connessione->getList($filtri);
	$connessione->closeConnection();
	
	if ($animali && is_array($animali)) {
		$stringaAnimali .= '<ul class="galleria">';
				foreach ($animali as $animale) {
					$stringaAnimali .= '<li class="elemento-galleria">';
					$stringaAnimali .= '<a href="dettagli_animale.php?id=' . $animale['ID'] . '">';
					$stringaAnimali .= '<img src="./img/assets/' . $animale['Immagine'] . '" alt="' . 'di nome' . $animale['Nome'] . '" >';
					$stringaAnimali .= '<div>';
					$stringaAnimali .= '<p class="label-elemento">' . htmlspecialchars($animale['Nome']) . '</p>';
					$stringaAnimali .= '<img class="genere" src="./' . getIconGenere($animale['Genere']) . '" alt="' . $animale['Genere'] . '">';
					$stringaAnimali .= '</div>';
					$stringaAnimali .= '</a>';
					$stringaAnimali .= '</li>';
				}
		$stringaAnimali .= '</ul>';
	}
	else {
		$stringaAnimali = '<p>Nessun animale presente</p>';
	}
} else {
	$stringaAnimali = '<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio. Riprova più tardi, contattaci a questa email miao@gmail.com</p>';
	//possibilità di mettere pagina 404
}

$paginaHTML = str_replace('[listaAnimali]', $stringaAnimali, $paginaHTML);
echo $paginaHTML;

?>