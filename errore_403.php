<?php

require_once "template.php";

$paginaHTML = file_get_contents('errore_403.html');

$template = new Template();
$headerProcessato = $template->getHeader('errore_403');
$footerProcessato = $template->getFooter();

$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

echo $paginaHTML;
?>