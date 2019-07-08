<?php
    include "../classes/PagamentoDAO.class.php";
		

	$pgto = new PagamentoDAO();

	$pagamento = $_GET['pagamento'];

	$result = $pgto->Select($pagamento);
	print json_encode($result);
?>