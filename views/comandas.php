<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/DataTables-1.10.19/css/jquery.dataTables.min.css" />
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/Buttons-1.5.4/css/buttons.dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="../estilos/impressao.css" media="print" />

	<?php
		include "../processos/_menu.php";
	    $pagina->CabecalhoMenu("Menu de Comandas", "logobrand.png", $menu);
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php
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

   		date_default_timezone_set('America/Sao_Paulo');
   		$date = date('Y-m-d');

  		include "../classes/CRUD.class.php";
      
      $tabela = "tb_comandas";
      $campos = array("numero", "dt_cmd", "valor", "descr", "status_cmd", "dt_reg");

      $crud = new CRUD($tabela, $campos);

		if(isset($_POST['r-dt_reg']) && isset($_POST['r-dt_cmd']) && isset($_POST['r-cod_cmd']) && isset($_POST['r-vlr'])){
			
			$cod_cmd = $_POST['r-cod_cmd'];
			$dt_cmd = $_POST['r-dt_cmd'];
			$vlr = $_POST['r-vlr'];
			$descr = $_POST['r-descr'];
			$dt_reg = $_POST['r-dt_reg'];
			$status_cmd = $_POST['r-lista'];

			$registro = array($cod_cmd, $dt_cmd, $vlr, $descr, $dt_reg, $status_cmd);
			
			if($crud->DBInsert($registro)){
				header("location:comandas.php");
			}		
		}

	    
	?>
	<hr />
  <div class="no-print">
  	<h5 class="text-center">Informações para registro</h5>
  	<form class="text-center" name="reg_comanda" action="" method="post" onkeydown="BloqEnter()" onsubmit=" return validaTudo()">
  		<div class="container">
  			<label for="dt_reg">
  				<p>Data de registro: </p>
  				<input class="form-control" id="r-dt_reg" name="r-dt_reg" type="date" value=<?= $date;?> readonly="true" />
  			</label>
  			<label for="dt_cmd">
  				<p>Data da comanda: </p>
  				<input class="form-control" id="r-dt_cmd" name="r-dt_cmd" type="date" value=<?= $date;?> max=<?= $date;?> required/>
  			</label>
  			<label for="cod_cmd">
  				<p>Código: </p>
  				<input class="form-control" id="r-cod_cmd" name="r-cod_cmd" type="number" min="0" max="999999" onkeyup="temSeis(this.value)" required>
  			</label>
  			<label for="vlr">
  				<p>Valor (R$): </p>
  				<input class="form-control" id="r-vlr" name="r-vlr" type="number" min="0" max="9999.99" step="0.01" required/>
  			</label>
  			<br />
  			<label for="descr">
  				<p>Descrição (opcional): </p>
  				<input class="form-control" id="r-descr" name="r-descr" type="text" size="50" maxlength="49" />
  			</label>
  			<label class="lista_att" for="lista">
  				<p>Status: </p>
                  <select class="form-control" id="r-lista" name="r-lista">
                    <option id="1" value="P" selected>Pendente</option>
                    <option id="2" value="C">Compensada</option>
                    <option id="3" value="B">Pendente/Boleto</option>
                  </select>
              </label>
              <br />
  			<input class="btn btn-secondary" type="submit" value="Registrar Comanda" />
  		</div>
  	</form>
  	<hr />
  </div>
  
  <a type="button" href="imprime_comandas.php" class="btn btn-danger">Imprimir Relatório de Comandas</a>
	
  <h5 class="text-center">Comandas Registradas</h5>
	<p class="bg-warning text-white" id="status"></p>
  	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="confirma" class="form-group" action="" method="post">
            <div class="modal-body">
              <label for="dt_cmd">
              <p>Data da comanda: </p>
              <input class="form-control" id="dt_cmd" name="dt_cmd" type="date" value="" required readonly="true"/>
              </label>
              <label for="cod_cmd">
                <p>Código: </p>
                <input class="form-control" id="cod_cmd" name="cod_cmd" type="number" min="0" max="999999" value="" onkeyup="temSeis(this.value)" required readonly="true">
              </label>
              <label for="vlr">
                <p>Valor (R$): </p>
                <input class="form-control" id="vlr" name="vlr" type="number" min="0" max="9999.99" value="" step="0.01" required readonly="true"/>
              </label>
              <label for="descr">
                <p>Descrição (opcional): </p>
                <input class="form-control" id="descr" name="descr" type="text" size="50" maxlength="49" value="" readonly="true" />
              </label>
              <label for="status_cmd">
                <p>Status: </p>
                <input class="form-control" id="status_cmd" name="status_cmd" type="text" value="" required readonly="true" />
              </label>
              <label class="lista_att" for="lista">
                <p class="h6">Atenção: não se esqueça de olhar abaixo o status para o qual deseja mudar.</p>
                <select class="form-control" id="lista" name="lista">
                  <option id="1" value="P">Pendente</option>
                  <option id="2" value="C">Compensada</option>
                  <option id="3" value="B">Pendente/Boleto</option>
                </select>
              </label>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </form>
        </div>
      </div>
    </div>
    <?php $crud->DBSelectAll(); ?>
	<script type="text/javascript" src="../assets/DataTables/DataTables-1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets/DataTables/Buttons-1.5.4/js/dataTables.buttons.min.js"></script>
	<script>
		$(document).ready( function () {


      $('.excluir').click(function(){
        carregaPagina($(this).attr('rel'), $(this).attr('name'), "Apagar");
        $('.lista_att').css('display', 'none');
      });
      $('.atualizar').click(function(){
        carregaPagina($(this).attr('rel'), $(this).attr('name'), "Atualizar");
        $('.lista_att').css('display', 'block');
      });

	    $('#myTable').DataTable({
	    	responsive: true,
	    	"aoColumnDefs": [
                { 
                  "bSortable": true, "aTargets": [ 0 ],
                }
            ],
            "aaSorting": [[0, 'desc']],
            "bFilter": true,
            "bPaginate": true,
            "oLanguage": {
                  "sEmptyTable": "Nenhum registro encontrado",
                  "sInfo": "Comandas cadastradas no sistema",
                  "sInfoEmpty": "Mostrando 0 até de 0 registros",
				"sInfoFiltered": "(Filtrados de _MAX_ registros)", 
                  "sInfoPostFix": "",
                  "sInfoThousands": ".",
                  "sLengthMenu": "_MENU_ ",
                  "sLoadingRecords": "Carregando...",
                  "sProcessing": "Processando...",
                  "sZeroRecords": "Nenhum registro encontrado",
                  "sSearch": "Pesquisar",
                  "oPaginate": {
                      "sNext": "Próximo",
                      "sPrevious": "Anterior",
                      "sFirst": "Primeiro",
                      "sLast": "Último"
                  },
                  "oAria": {
                      "sSortAscending": ": Ordenar colunas de forma ascendente",
                      "sSortDescending": ": Ordenar colunas de forma descendente"
                  }
                }
  	    });
		} );

    function carregaPagina(codigo, data, operacao){
      console.log(codigo);
      if(operacao == "Apagar"){
        $.ajax({
          url:"../processos/_carrega.php?codigo=" + codigo + "&datacmd=" + data,
          datatype:"json",
          async: true,
          success: function(dados){
            console.log(dados);
            var resultado = JSON.parse(dados);
            $('#confirma').attr('action', '../processos/_operacao.php?operacao=' + operacao);
            $('#cod_cmd').val(resultado[0].numero);
            $('#dt_cmd').val(resultado[0].dt_cmd);
            $('#vlr').val(resultado[0].valor);
            $('#descr').val(resultado[0].descr);
            $('#status_cmd').val(resultado[0].status_nome);
            $('#exampleModalLongTitle').html("Deseja excluir a comanda " + resultado[0].numero + "?");
            $('#exampleModalCenter').modal();
          },
          error: function erro(){
            console.log("Ocorreu um problema.");
          }
        });
      } else {
        $.ajax({
          url:"../processos/_carrega.php?codigo=" + codigo + "&datacmd=" + data,
          datatype:"json",
          async: true,
          success: function(dados){
            //console.log(dados);
            var resultado = JSON.parse(dados);
            $('#confirma').attr('action', '../processos/_operacao.php?operacao=' + operacao);
            $('#cod_cmd').val(resultado[0].numero);
            $('#dt_cmd').val(resultado[0].dt_cmd);
            $('#vlr').val(resultado[0].valor);
            $('#descr').val(resultado[0].descr);
            $('#status_cmd').val(resultado[0].status_nome);
            $('#descr').attr('readonly', false);
            $('#lista').attr('disabled', false);

            if($('#status_cmd').val() == "Pendente"){
              $('#1').attr('selected', true);
            } else 
              if($('#status_cmd').val() == "Compensada"){
              $('#2').attr('selected', true);
            } else {
              $('#3').attr('selected', true);
            }

            $('#dt_cmd').attr('max', <?=$date;?>);
            $('#vlr').attr('readonly', false);

            $('#exampleModalLongTitle').html("Deseja atualizar a comanda " + resultado[0].numero + "?");
            $('#exampleModalCenter').modal();  
          },
          error: function erro(){
            console.log("Ocorreu um problema.");
          }
        });
      }        

    }
	</script>
</body>
</html>