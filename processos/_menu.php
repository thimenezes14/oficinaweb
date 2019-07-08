<?php
	include "../classes/Pagina.class.php";

	$pagina = new Pagina();

	$menu[0]['url'] = "index.php";
    $menu[0]['nome_link'] = "Dashboard";
    $menu[1]['url'] = "pagamentos.php";
    $menu[1]['nome_link'] = "Pagamentos";
    $menu[2]['url'] = "comandas.php";
    $menu[2]['nome_link'] = "Comandas";
?>