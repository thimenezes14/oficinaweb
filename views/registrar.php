<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php
		include "../processos/_menu.php";
	    $pagina->CabecalhoMenu("REGISTRAR COMANDA", "logobrand.png", $menu);
	?>
</head>
<body>
	<?php
		
		if($_SESSION['usuario_status'] == 'I'){
			header("location:index.php");	
		}

		if(!isset($_SESSION['usuario'])){
			
			unset($_SESSION['usuario']);
			session_destroy();
			header("location:../index.php");
		}

		if (isset($_SESSION['tempo']) && (time() - $_SESSION['tempo'] > 300)) {

		    unset($_SESSION['usuario']);
		    unset($_SESSION['tempo']);
		    session_destroy();
		    header("location:registrar.php");
		}
		
		$_SESSION['tempo'] = time();
		
		include "../classes/CRUD.class.php";
		
		$tabela = "tb_comandas";
		$campos = array("numero", "dt_cmd", "valor", "descr", "status_cmd", "dt_reg");

		$tabela_h = "tb_comandas";
		$campos_h = array("mes", "ano", "numero", "dt_cmd", "valor", "descr", "status_cmd", "dt_reg");

		$crud = new CRUD($tabela, $campos);
		$crud_h = new CRUD($tabela_h, $campos_h);

		date_default_timezone_set('America/Sao_Paulo');
		$date = date('Y-m-d H:i');


		if(isset($_POST['dt_reg']) && isset($_POST['dt_cmd']) && isset($_POST['cod_cmd']) && isset($_POST['vlr'])){
			
			$cod_cmd = $_POST['cod_cmd'];
			$dt_cmd = $_POST['dt_cmd'];
			$vlr = $_POST['vlr'];
			$descr = $_POST['descr'];
			$dt_reg = $_POST['dt_reg'];
			$status_cmd = $_POST['lista'];

			$registro = array($cod_cmd, $dt_cmd, $vlr, $descr, $dt_reg, $status_cmd);
			
			if($crud->DBInsert($registro)){
				header("location:registrar.php");
			}		
		}
			
	?>
	<form class="text-center" name="reg_comanda" action="" method="post" onkeydown="BloqEnter()" onsubmit=" return validaTudo()">
		<div class="container">
			<label for="dt_reg">
				<p>Data de registro: </p>
				<input class="form-control" id="dt_reg" name="dt_reg" type="date" value=<?= $date;?> readonly="true" />
			</label>
			<label for="dt_cmd">
				<p>Data da comanda: </p>
				<input class="form-control" id="dt_cmd" name="dt_cmd" type="date" value=<?= $date;?> max=<?= $date;?> required/>
			</label>
			<label for="cod_cmd">
				<p>Código: </p>
				<input class="form-control" id="cod_cmd" name="cod_cmd" type="number" min="0" max="999999" onkeyup="temSeis(this.value)" required>
			</label>
			<label for="vlr">
				<p>Valor (R$): </p>
				<input class="form-control" id="vlr" name="vlr" type="number" min="0" max="9999.99" step="0.01" required/>
			</label>
			<label for="descr">
				<p>Descrição (opcional): </p>
				<input class="form-control" id="descr" name="descr" type="text" size="50" maxlength="49" />
			</label>
			<label class="lista_att" for="lista">
				<p>Status: </p>
                <select class="form-control" id="lista" name="lista">
                  <option id="1" value="P" selected>Pendente</option>
                  <option id="2" value="C">Compensada</option>
                  <option id="3" value="B">Pendente/Boleto</option>
                </select>
            </label>
			<input class="btn btn-secondary" type="submit" value="Registrar Comanda" />
		</div>
	</form>
	<p class="bg-warning text-white" id="status"></p>
	<script>
		//Valida os campos verificando se o número da comanda possui seis dígitos.
		function validaTudo(){
			var codigo = document.getElementById("cod_cmd");
			
			if(temSeis(codigo.value)){
				return true;
			}
			else{
				document.getElementById("status").innerHTML = "Tente novamente";
				return false;
			}
		}

		//Verifica se o campo possui seis dígitos.
		function temSeis(v){
			if(v.length < 6){
				return false;
			} else {
				return true;
			}
		}

		//Evita que o formulário envie dados ao pressionar a tecla ENTER.
		function BloqEnter(){
			var tecla=window.event.keyCode;
			if (tecla==13){
				event.keyCode=0; 
				event.returnValue = false;
			}
			
		}
	</script>
</body>
</html>