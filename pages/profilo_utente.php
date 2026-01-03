<?php

require_once ".." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('profilo_utente.html');

$success = "";

if (isset($_GET['success'])) {
    if($_GET['success'] == 1) {
        $success = "<p>Modifica dell'appuntamento avvenuta con successo.</p>";
    }
}

$paginaHTML = str_replace("[success]", $success, $paginaHTML);

echo $paginaHTML;

?>