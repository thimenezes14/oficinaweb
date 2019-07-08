<!DOCTYPE html>
<head>
  	<link rel="stylesheet" type="text/css" href="../estilos/impressao.css" media="print" />
</head>
<body onload="print();">
<a type="button" href="pagamentos.php" class="no-print">Voltar</a>
<div class="pagina">
	<div class="print">
		<?php 
			session_start();
			echo '<link rel="stylesheet" href="#" media="print">';
			if(!isset($_SESSION['usuario'])){
		        unset($_SESSION['usuario']);
		        session_destroy();
		        header("location:../index.php");
		      }

		      if (isset($_SESSION['tempo']) && (time() - $_SESSION['tempo'] > 300)) {

				    unset($_SESSION['usuario']);
				    unset($_SESSION['tempo']);
				    session_destroy();
				    header("location:../index.php");
			    }
		      
		      $_SESSION['tempo'] = time();

			include "../classes/Pagamento.class.php";
		      
		      $crud = new Pagamento("", "", "", "", "", "");
		      $total = $crud->countPagamento(1) + $crud->countPagamento(2) + $crud->countPagamento(3);

		      echo "<h3>Total em cheques: <i>R$ ". number_format($crud->countPagamento(1), 2, ',', '.') ."</i> | Total em cartões: <i>R$ ". number_format(($crud->countPagamento(2)), 2, ',', '.')."</i></i> | Total em dinheiro: <i>R$ ".number_format(($crud->countPagamento(3)), 2, ',', '.')."</i></h3>";
				
			  echo "<h2>TOTAL DE PAGAMENTOS: <i>R$ ". number_format($total, 2, ',', '.')."</i></h2><hr />";

		      $crud->imprimePagamento();

		?>
	</div>
</div>
</body>
</html>
