<!DOCTYPE html>
<head>
  	<link rel="stylesheet" type="text/css" href="../estilos/impressao.css" media="print" />
</head>
<body onload="print();">
<a type="button" href="comandas.php" class="no-print">Voltar</a>
<div class="pagina">
	<div class="print">
		<?php 
			session_start();
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

			include "../classes/CRUD.class.php";
		      
		      $tabela = "tb_comandas";
		      $campos = array("numero", "dt_cmd", "valor", "descr", "status_cmd", "dt_reg");

		      $crud = new CRUD($tabela, $campos);

		      echo "<h3>Total final bruto: <i>R$ ". number_format($crud->DBCount(0), 2, ',', '.') ."</i> | Total com desconto: <i>R$ ". number_format(($crud->DBCount(0)*0.9), 2, ',', '.') ."</i></h3><hr />";
		      
		      $crud->DBPrint();
		?>
	</div>
</div>
</body>
</html>