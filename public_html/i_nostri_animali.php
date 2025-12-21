<?php

require_once ".." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'pages'. DIRECTORY_SEPARATOR . 'i_nostri_animali.html');

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$stringaAnimali = '';

function getIconGenere($genere) {
	$generi = array(
		'Femmina' => 'img/female-icon.png',
		'Maschio' => 'img/male-icon.png'
	);
	return $generi[$genere] ?? '';
}

if ($connessioneOK) {
	$animali = $connessione->getList(); 
	$connessione->closeConnection();
	
	if ($animali && is_array($animali)) {
		$stringaAnimali .= '<ul class="galleria">';
				foreach ($animali as $animale) {
					$stringaAnimali .= '<li class="elemento-galleria">';
					$stringaAnimali .= '<a href="dettagli_animale.php?id=' . $animale['ID'] . '">';
					$stringaAnimali .= '<img src="../' . $animale['Immagine'] . '" alt="' . $animale['Specie'] . '" >';
					$stringaAnimali .= '<div>';
					$stringaAnimali .= '<p class="label-elemento">' . htmlspecialchars($animale['Nome']) . '</p>';
					$stringaAnimali .= '<img class="genere" src="../' . getIconGenere($animale['Genere']) . '" alt="' . $animale['Genere'] . '">';
					$stringaAnimali .= '</div>';
					$stringaAnimali .= '</li>';
					 $stringaAnimali .= '</a>';
				}
		$stringaAnimali .= '</ul>';
	}
	else {
		$stringaAnimali = '<p>Nessun animale presente</p>';
	}

} else {
	$stringaAnimali = '<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio. Riprova più tardi, contattaci a questa email miao@gmail.com</p>';
}

$paginaHTML = str_replace('[listaAnimali]', $stringaAnimali, $paginaHTML);
echo $paginaHTML;

?>