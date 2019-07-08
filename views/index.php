<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php
		include "../processos/_menu.php";
	    $pagina->CabecalhoMenu("Dashboard", "logobrand.png", $menu);
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php
		include "../classes/CRUD.class.php";
		include "../classes/PagamentoDAO.class.php";
		
		if(!isset($_SESSION['usuario'])){
			
			unset($_SESSION['usuario']);
			unset($_SESSION['tempo']);
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

		
		$tabela = "tb_comandas";
		$campos = array("numero", "dt_cmd", "valor", "descr", "status_cmd", "dt_reg");

		$crud = new CRUD($tabela, $campos);

		$info = array('total' => $crud->DBCount(0), 'comp' => $crud->DBCount(1), 'cmdtotal' => $crud->DBCount(2), 'maior' => $crud->DBCount(3), 'menor' => $crud->DBCount(4), 'liquidado' => $crud->DBCount(5));

		$pend = $crud->DBCount(2) - $crud->DBCount(1);

		###########

		$pgto = new PagamentoDAO();


	?>
	<form class="form text-center">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 dashboard">
				<p>TOTAL DO MÊS</p>
				<span class="campoDashboard">R$ <?=number_format($info['total'] * 0.9, 2, ",", "."); ?></span>
			</div>
			<div class="col-lg-6 dashboard">
				<p>COMPENSADO</p>
				<span class="campoDashboard"><?=$info['cmdtotal'] == 0 ? '-' : number_format((($info['comp']/$info['cmdtotal'])*100), 1, ",", ".").' %'; ?></span>
			</div>
			<div class="col-lg-6 dashboard">
				<p>TOTAL DE PAGAMENTOS</p>
				<span class="campoDashboard">R$ <?=number_format(($pgto->Count(1) + $pgto->Count(2) + $pgto->Count(3)), 2, ",", "."); ?></span>
			</div>
			<div class="col-lg-6 dashboard">
				<p>TOTAL LÍQUIDO</p>
				<span class="campoDashboard">R$ <?=number_format($pgto->Count(1) + $pgto->Count(2) + $pgto->Count(3) - ($info['total'] * 0.9), 2, ",", "."); ?></span>
			</div>
		</div>
	  </form>
	  <hr class="border"/>
	  <div class="row grafico">
	  	<div class="col">
			<canvas id="line-chart"></canvas>
	  	</div>
	  	<br />
	  </div>
	</div>
	<script src="../assets/ChartJS/Chart.min.js"></script>
	<?php echo "<script>
		var ctx = document.getElementById('line-chart').getContext('2d');
		var myPieChart = new Chart(ctx,{
		    type: 'doughnut',
		    data: {
			    datasets: [{
			        data: [".$info['comp'].", ".$pend."],
			        backgroundColor: [
			        	'rgb(255, 255, 0)',
			        	'rgb(100, 100, 100)',
			        ]
			    }],

			    // These labels appear in the legend and in the tooltips when hovering different arcs
			    labels: [
			        'Comandas Compensadas',
			        'Comandas Pendentes'

			    ]
			},
			options: {
				legend:{
					labels: {
						fontColor: 'white',
					}
				}
			}
		    
		});
	</script>"; ?>
</body>
</html>