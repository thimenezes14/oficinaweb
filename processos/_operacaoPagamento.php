<?php
	include "../classes/PagamentoDAO.class.php";
		
	if(isset($_POST['Mseq_pgto']) && isset($_POST['Mpagador']) && isset($_POST['Mvalor']) && isset($_POST['Mtipo_pgto']) && isset($_POST['Mdata_op']) && isset($_GET['operacao'])){
		
		$Mseq_pgto = $_POST['Mseq_pgto'];
		$Mpagador = $_POST['Mpagador'];
		$Mvalor = $_POST['Mvalor'];
		$Mtipo_pgto = $_POST['Mtipo_pgto'];
		$Mdescr_pgto = $_POST['Mdescr_pgto'];
		$Mdata_op = $_POST['Mdata_op'];
		

		$operacao = $_GET['operacao'];
		$atualizacao = array($Mseq_pgto, $Mpagador, $Mvalor, $Mtipo_pgto, $Mdescr_pgto, $Mdata_op);

		print_r($atualizacao);

		$pgto = new PagamentoDAO();

		if($operacao == "Apagar")
			$pgto->Delete($atualizacao);
		
		if($operacao == "Atualizar")
			$pgto->Update($atualizacao);
		
		header("location:../views/pagamentos.php");

	}	
?>