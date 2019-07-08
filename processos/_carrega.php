<?php
    include "../classes/CRUD.class.php";
		
	$tabela = "tb_comandas";
	$campos = array("numero", "dt_cmd", "valor", "descr", "status_cmd", "dt_reg");

	$crud = new CRUD($tabela, $campos);

	$codigo = $_GET['codigo'];
	$datacmd = $_GET['datacmd'];

	$selecao = array($codigo, $datacmd);
	$result = $crud->DBSelect($selecao);
	print json_encode($result);
?>