<?php
	require_once "../classes/Pagina.class.php";

	$btn_meuUsuario = new Pagina();

	$menu_Usuario[0]['url'] = "../views/dados.php";
    $menu_Usuario[0]['nome_link'] = "Meus Dados";
    $menu_Usuario[1]['url'] = "../views/gerenciar.php";
    $menu_Usuario[1]['nome_link'] = "Gerenciar Usuários";

    $btn_meuUsuario->Cabecalho($menu_Usuario);
?>