<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/DataTables-1.10.19/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/Buttons-1.5.4/css/buttons.dataTables.min.css"/>
	<?php
		include "../processos/_menu.php";
	    $pagina->CabecalhoMenu("Menu de Pagamentos", "logobrand.png", $menu);
	?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
		    header("location:../index.php");
		}
		
		$_SESSION['tempo'] = time();

		require "../classes/Pagamento.class.php";

    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d');
	
	
		if(isset($_POST['pagador']) && isset($_POST['valor']) && isset($_POST['tipo_pgto']) && isset($_POST['data_op'])){

      $pagador = $_POST['pagador'];
      $valor = $_POST['valor'];
      $tipo_pgto = $_POST['tipo_pgto'];
      $descr_pgto = $_POST['descr_pgto'];
      $data_op = $_POST['data_op'];

      $mngt = new Pagamento("", $pagador, $valor, $tipo_pgto, $descr_pgto, $data_op);  
      
      if($mngt->addPagamento($pagador, $valor, $tipo_pgto, $descr_pgto, $data_op))
        header("location:pagamentos.php");
		}
	
	?>


	<div class="modal fade" id="modalPgto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
         <form id="MconfirmaPagamento" class="form-group" method="post" onkeydown="BloqEnter()" >
            <div class="modal-body">
              <div class="container">
                <label for="Mseq_pgto">
                  <p>Código Pagamento: </p>
                  <input class="form-control" id="Mseq_pgto" name="Mseq_pgto" type="number" required readonly="true" /> 
                </label>
                <label for="Mpagador">
                  <p>Nome Pagador: </p>
                  <input class="form-control" value="" id="Mpagador" name="Mpagador" type="text" size="31" maxlength="30" required readonly="true" />
                </label>
                <label for="Mvalor">
                  <p>Valor Pagamento: </p>
                  <input class="form-control" id="Mvalor" name="Mvalor" type="number" step="0.01" min="0" required readonly="true" />
                </label>
                <label for="Mtipo_pgto">
                  <p>Forma de Pagamento:</p>
                  <select class="lista_att form-control" name="Mtipo_pgto" id="Mtipo_pgto">
                    <option id="f1" value="A" selected>Dinheiro</option>
                    <option id="f2" value="B">Cartão de Crédito/Débito</option>
                    <option id="f3" value="C">Cheque</option>
                    <option id="f4" value="D">Depósito Bancário</option>
                  </select>
                </label>
                <br />
                <label for="Mforma_pgto">
                  <input class="form-control" name="Mforma_pgto" id="Mforma_pgto" type="text" size="21" maxlength="20" readonly="true" value="" />
                </label>
                <label for="Mdescr_pgto">
                  <p>Descrição (opcional): </p>
                  <input class="form-control" value="" id="Mdescr_pgto" name="Mdescr_pgto" type="text" size="51" maxlength="50" readonly="true" />
                </label>
                <label for="Mdata_op">
                  <p>Data do Pagamento:</p>
                  <input class="form-control" id="Mdata_op" name="Mdata_op" type="date" max=<?=$date ;?> readonly="true" required/>
                </label>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </form>
        </div>
      </div>
    </div>
	<div class="container">
    <hr />
		<div class="row">
			<div class="col">
				<h5 class="h5 text-center">Adicionar Pagamento: </h5>
        <p class="bg-danger text-white text-center" id="status"></p>
				<form class="text-center" id="reg_pgto" action="" method="post" onkeydown="BloqEnter()">
              <div class="container">
                <label for="pagador">
                  <p>Nome Pagador: </p>
                  <input class="form-control" id="pagador" name="pagador" type="text" size="31" maxlength="30"required/>
                </label>
                <label for="valor">
                  <p>Valor Pagamento: </p>
                  <input class="form-control" id="valor" name="valor" type="number" step="0.01" min="0" required/>
                </label>
                <label for="tipo_pgto">
                  <p>Forma de Pagamento:</p>
                  <select class="form-control" name="tipo_pgto" id="tipo_pgto">
                    <option id="f1" value="A" selected>Dinheiro</option>
                    <option id="f2" value="B">Cartão de Crédito/Débito</option>
                    <option id="f3" value="C">Cheque</option>
                    <option id="f4" value="D">Depósito Bancário</option>
                  </select>
                </label>
                <br />
                <label for="descr_pgto">
                  <p>Descrição (opcional): </p>
                  <input class="form-control" id="descr_pgto" name="descr_pgto" type="text" size="51" maxlength="50"/>
                </label>
                <label for="data_op">
                  <p>Data do Pagamento:</p>
                  <input class="form-control" id="data_op" name="data_op" type="date" value=<?=$date ;?> max=<?=$date ;?> required/>
                </label>
                <input class="btn btn-secondary" type="submit" value="Registrar Pagamento" />
              </div>
            </div>
				</form>
			</div>
    </div>
    <hr />
    <div class="row">
			<div class="col">
        <?php $mngt = new Pagamento("","","","","",""); ?>
        <div class="row">
          <div class="col-lg-6">
            <p>Valor total em CHEQUES: 
            <span><strong>R$ <?= number_format($mngt->CountPagamento(1), 2, ',', '.'); ?></strong></span></p>
          </div>
          <div class="col-lg-6">
            <p>Valor total em CARTÃO: 
            <span><strong>R$ <?= number_format($mngt->CountPagamento(2), 2, ',', '.'); ?></strong></span></p>
          </div>
        </div>
        <br />
        
        <a type="button" href="imprime_pagamentos.php" class="btn btn-danger">Imprimir Relatório de Pagamentos</a>

        <br />
				<h5 class="h5 text-center">Pagamentos realizados: </h5>
          <?php $mngt = new Pagamento("","","","","","");

            $mngt->listarPagamentos(); 

          ?>
			</div>
    </div>
		</div>

	</div>
	 <script type="text/javascript" src="../assets/DataTables/DataTables-1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets/DataTables/Buttons-1.5.4/js/dataTables.buttons.min.js"></script>
  <script>

		//Evita que o formulário envie dados ao pressionar a tecla ENTER.
		function BloqEnter(){
			var tecla=window.event.keyCode;
			if (tecla==13){
				event.keyCode=0; 
				event.returnValue = false;
			}
			
		}

	</script>
	<script>
		$(document).ready( function () {


      $('.excluirPagamento').click(function(){
        carregaPagina($(this).attr('rel'), "Apagar");
        $('.lista_att').css('display', 'none');
      });

      $('.atualizarPagamento').click(function(){
        carregaPagina($(this).attr('rel'), "Atualizar");
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
                  "sInfo": "Pagamentos cadastrados no sistema",
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

    function carregaPagina(pagamento, operacao){
      if(operacao == "Apagar"){
        $.ajax({
          url:"../processos/_carregaPagamento.php?pagamento=" + pagamento,
          datatype:"json",
          async: true,
          success: function(dados){
            var resultado = JSON.parse(dados);
            console.log(resultado);
           
            $('#MconfirmaPagamento').attr('action', '../processos/_operacaoPagamento.php?operacao=' + operacao);
            
            $('#Mseq_pgto').val(resultado[0].seq_pgto);
            $('#Mpagador').val(resultado[0].pagador);
            $('#Mvalor').val(resultado[0].valor);     
            $('#Mtipo_pgto').val(resultado[0].tipo_pgto);
            $('#Mforma_pgto').val(resultado[0].forma_pgto);
            $('#Mdescr_pgto').val(resultado[0].descr_pgto);
            $('#Mdata_op').val(resultado[0].data_pgto);

            $('#exampleModalLongTitle').html("Deseja excluir o pagamento de '" + resultado[0].pagador + "'?");
            $('#modalPgto').modal();
          },
          error: function erro(){
            console.log("Ocorreu um problema.");
          }
        });
      } else {
        $.ajax({
          url:"../processos/_carregaPagamento.php?pagamento=" + pagamento,
          datatype:"json",
          async: true,
          success: function(dados){
            var resultado = JSON.parse(dados);
            console.log(resultado);
            
            $('#MconfirmaPagamento').attr('action', '../processos/_operacaoPagamento.php?operacao=' + operacao);
           
            $('#Mseq_pgto').val(resultado[0].seq_pgto);
            $('#Mpagador').val(resultado[0].pagador);
            $('#Mvalor').val(resultado[0].valor);     
            $('#Mtipo_pgto').val(resultado[0].tipo_pgto);
            $('#Mforma_pgto').val(resultado[0].forma_pgto);
            $('#Mdescr_pgto').val(resultado[0].descr_pgto);
            $('#Mdata_op').val(resultado[0].data_pgto);

            $('#Mpagador').attr('readonly', false);
            $('#Mvalor').attr('readonly', false);     
            $('#Mdescr_pgto').attr('readonly', false);   
            $('#Mdata_op').attr('readonly', false);         

            $('#exampleModalLongTitle').html("Deseja atualizar o pagamento de '" + resultado[0].pagador + "'?");
            $('#modalPgto').modal();  
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