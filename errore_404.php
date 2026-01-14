<?php

require_once "template.php";

$paginaHTML = file_get_contents('errore_404.html');

$template = new Template();
$headerProcessato = $template->getHeader('errore_404');
$footerProcessato = $template->getFooter();

$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

echo $paginaHTML;
?>