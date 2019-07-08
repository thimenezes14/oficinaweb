<?php
	include "../classes/Comanda.class.php";
		
	if(isset($_POST['cod_cmd']) && isset($_POST['dt_cmd']) && isset($_POST['vlr']) && isset($_POST['lista']) && isset($_GET['operacao'])){
		$cod_cmd = $_POST['cod_cmd'];
		$dt_cmd = $_POST['dt_cmd'];
		$vlr = $_POST['vlr'];
		$descr = $_POST['descr'];
		$status_cmd = $_POST['lista'];

		$operacao = $_GET['operacao'];
		$valores = array($cod_cmd, $dt_cmd, $vlr, $descr, $status_cmd);

		$crud = new Comanda($cod_cmd, $dt_cmd, $vlr, $descr, $status_cmd);

		print_r($atualizacao);

		if($operacao == "Apagar")
			$crud->removeComanda($valores, 1);
		else if($operacao == "Atualizar")
			$crud->atualizaComanda($valores);
		
		header("location:../views/comandas.php");

	}	
?>