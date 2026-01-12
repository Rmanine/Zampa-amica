<?php

require_once "template.php";

$paginaHTML = file_get_contents('chi_siamo.html');

$template = new Template();
$headerProcessato = $template->getHeader('chi_siamo');
$footerProcessato = $template->getFooter();

$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

echo $paginaHTML;
?>