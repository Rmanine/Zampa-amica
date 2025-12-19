<?php

require_once ".." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'pages'. DIRECTORY_SEPARATOR . 'i_nostri_animali.html');

$connessione = new DBAccess();
$connessioneOK = $connessione->openDBConnection();

$animali = '';
$stringaAnimali = '';

if ($connessioneOK) {
	$animali = $connessione->getList(); 
	$connessione->closeConnection();
	
	if ($animali && is_array($animali)) {
		$stringaAnimali .= '<ul class="galleria">';
			foreach ($animali as $animale) {

				$stringaAnimali .= '<li class="elemento-galleria">' . '<img src="../' . $animale['Immagine'] . '" alt="" >';
				$stringaAnimali .= '<div>' . $animale['Nome'] . '</div>';
				$stringaAnimali .= '</li>'; 
			}
		$stringaAnimali .= '</ul>';
	}
	else {
		$stringaAnimali = '<p>Nessun animale presente</p>';
	}

} else {
	$stringaAnimali = '<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio. Riprova più tardi, contattaci a questa email miao@gmail.com</p>';
}

$paginaHTML = str_replace("[listaAnimali]", $stringaAnimali, $paginaHTML);
echo $paginaHTML;

?>