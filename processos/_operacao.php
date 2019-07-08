<?php
	include "../classes/CRUD.class.php";

	$tabela = "tb_comandas";
	$campos = array("numero", "dt_cmd", "valor", "descr", "status_cmd", "dt_reg");

	$crud = new CRUD($tabela, $campos);
		
	if(isset($_POST['cod_cmd']) && isset($_POST['dt_cmd']) && isset($_POST['vlr']) && isset($_POST['lista']) && isset($_GET['operacao'])){
		$cod_cmd = $_POST['cod_cmd'];
		$dt_cmd = $_POST['dt_cmd'];
		$vlr = $_POST['vlr'];
		$descr = $_POST['descr'];
		$status_cmd = $_POST['lista'];

		$operacao = $_GET['operacao'];
		$atualizacao = array($cod_cmd, $dt_cmd, $vlr, $descr, $status_cmd);

		print_r($atualizacao);

		if($operacao == "Apagar")
			$crud->DBDelete($atualizacao);
		else if($operacao == "Atualizar")
			$crud->DBUpdate($atualizacao);
		
		header("location:../views/comandas.php");

	}	
?>