<?php

require_once "template.php";

$paginaHTML = file_get_contents('index.html');

$template = new Template();
$headerProcessato = $template->getHeader('index');
$footerProcessato = $template->getFooter();

$paginaHTML = str_replace('[header]', $headerProcessato, $paginaHTML);
$paginaHTML = str_replace('[footer]', $footerProcessato, $paginaHTML);

echo $paginaHTML;
?>