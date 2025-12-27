<?php

require_once "../php/session.php";
require_once "../php/wishlist.php";
require_once ".." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "dbConnection.php";

use DB\DBAccess;

session_start();

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'pages'. DIRECTORY_SEPARATOR . 'i_nostri_animali.html');
$stringaAnimali = '';

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

function getIconGenere($genere) {
	$generi = array(
		'Femmina' => 'img/female-icon.png',
		'Maschio' => 'img/male-icon.png'
	);
	return $generi[$genere];
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

if (isset($_POST['liked_item']) && isset($_SESSION['logged_in_user'])) {
	$connessione = new DBAccess();
	$connessioneOK = $connessione->openDBConnection();

	if ($connessioneOK) {
		$wishlist = new WishList($connessione);
		$wishlist->addLikedItem(
    		intval($_POST['liked_item']),
    		intval($_SESSION['logged_in_user'])
		);
		$connessione->closeConnection();
	}
	else {
		//possibilità di mettere pagina 404
	}
}

$paginaHTML = str_replace('[listaAnimali]', $stringaAnimali, $paginaHTML);
echo $paginaHTML;

?>