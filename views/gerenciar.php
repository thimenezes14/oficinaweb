<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/DataTables-1.10.19/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" type="text/css" href="../assets/DataTables/Buttons-1.5.4/css/buttons.dataTables.min.css"/>
	<?php
		include "../processos/_menu.php";
	    $pagina->CabecalhoMenu("MEUS DADOS", "logobrand.png", $menu);
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

		require "../classes/Usuario.class.php";

		$mngt = new Usuario("", "", "", "", "");		
	
		if(isset($_POST['usuario']) && isset($_POST['usuarioNome']) && isset($_POST['senha']) && isset($_POST['senhaConf']) && isset($_POST['tipo'])){

			$usuario = $_POST['usuario'];
      $nome = $_POST['usuarioNome'];
			$senha = $_POST['senha'];
			$tipo = $_POST['tipo'];

			$cadastro = new Usuario("", $usuario, $nome, $senha, $tipo);

      if($cadastro->checkUsuario()){
        
        $insere = $cadastro->insereUsuario();
        header("location:gerenciar.php");
      } else {
        echo '<p class="bg-danger text-center text-white">Erro ao salvar. <strong>Usuário já existe!</strong></p>';
      }
		}
	
	?>
	<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
         <form id="confirmaUsuario" class="form-group" method="post" onkeydown="BloqEnter()">
            <div class="modal-body">
              <p class="bg-danger text-white text-center" id="Mstatus"></p>
              <div class="container">
                <label for="Musuario">
                  <p>Usuário: </p>
                  <input class="form-control" value="" id="Musuario" name="Musuario" type="text" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" readonly="true" />
                </label>
                <label for="MusuarioNome">
                  <p>Nome: </p>
                  <input class="form-control" id="MusuarioNome" name="MusuarioNome" type="text" size="21" maxlength="20" readonly="true" />
                </label>
                <br />
                <br />
                <label for="Msenha">
                  <p>Senha: </p>
                  <input class="form-control" value="" id="Msenha" name="Msenha" type="password" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" readonly="true" />
                </label>
                <label class="lista_att" for="MsenhaNova">
                  <p>Nova Senha: </p>
                  <input class="form-control" id="MsenhaNova" name="MsenhaNova" type="password" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" />
                </label>
                <label class="lista_att" for="MsenhaNovaConf">
                  <p>Confirmar Nova Senha: </p>
                  <input class="form-control" id="MsenhaNovaConf" name="MsenhaNovaConf" type="password" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" />
                </label>
                <label for="Mtipo">
                  <p>Tipo de Usuário: </p>
                  <input class="form-control" value="" id="Mtipo" name="Mtipo" type="text" size="21" maxlength="20" readonly="true" />
                </label>
                <br />
                <label class="lista_att" for="ModalTipo">
                  <select class="form-control" name="ModalTipo" id="ModalTipo">
                    <option id="t1" value="I">Comum</option>
                    <option id="t2" value="A">Administrador</option>
                  </select>
                </label>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button id="valida" type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </form>
        </div>
      </div>
    </div>
	<div class="container">
		<div class="row">
			<div class="col">
				<h2 class="h2 text-center">Cadastrar Novo Usuário: </h2>
        <p class="bg-danger text-white text-center" id="status"></p>
				<form class="text-center" id="reg_usuario" action="" method="post" onkeydown="BloqEnter()" onsubmit="return validaTudo()">
					<div class="container">
						<label for="usuario">
							<p>Usuário (sem espaços): </p>
							<input class="form-control" id="usuario" name="usuario" type="text" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" />
						</label>
            <label for="usuarioNome">
              <p>Nome: </p>
              <input class="form-control" id="usuarioNome" name="usuarioNome" type="text" size="20" maxlength="50" />
            </label>
						<label for="senha">
							<p>Senha: </p>
							<input class="form-control" id="senha" name="senha" type="password" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" />
						</label>
						<label for="senhaConf">
							<p>Confirmar Senha: </p>
							<input class="form-control" id="senhaConf" name="senhaConf" type="password" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" />
						</label>
						<label for="tipo">
              <p>Tipo de usuário: </p>
              <select class="form-control" name="tipo" id="tipo">
                <option value="I" selected>Comum</option>
                <option value="A">Administrador</option>
              </select>
            </label>
						<input class="btn btn-secondary" type="submit" value="Criar Usuário" />
					</div>
				</form>
			</div>
    </div>
    <div class="row">
			<div class="col">
				<h2 class="h2 text-center">Usuários Cadastrados: </h2>
          <?php $mngt->listarUsuarios(); ?>
			</div>
    </div>
		</div>

	</div>
	 <script type="text/javascript" src="../assets/DataTables/DataTables-1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="../assets/DataTables/Buttons-1.5.4/js/dataTables.buttons.min.js"></script>
  <script>
		function validaTudo(){
      var login = document.getElementById("usuario").value;
      var nome = document.getElementById("usuarioNome").value;
			var senha = document.getElementById("senha").value;
      var senhaConf = document.getElementById("senhaConf").value;

      if(login.length < 3){
        document.getElementById("status").innerHTML = "Usuário deve conter ao menos 3 letras.";
        return false;
      }

      if(nome.length < 3){
        document.getElementById("status").innerHTML = "Nome deve conter ao menos 3 letras.";
        return false;
      }

      if(senha.length < 5){
        document.getElementById("status").innerHTML = "Senha deve conter pelo menos 5 caracteres.";
        return false;
      }
			if(senha == senhaConf){
				return true;
			} else {
				document.getElementById("status").innerHTML = "Senhas diferem entre si. Tente novamente.";
				return false;
			}
		}

    function MvalidaTudo(){
      var login = document.getElementById("Musuario").value;
      var nome = document.getElementById("MusuarioNome").value;
      var senha = document.getElementById("MsenhaNova").value;
      var senhaConf = document.getElementById("MsenhaNovaConf").value;

      if(login.length < 3){
        document.getElementById("Mstatus").innerHTML = "Usuário deve conter ao menos 3 letras.";
        return false;
      }

      if(nome.length < 3){
        document.getElementById("Mstatus").innerHTML = "Nome deve conter ao menos 3 letras.";
        return false;
      }

      if(senha.length < 5){
        document.getElementById("Mstatus").innerHTML = "Senha deve conter pelo menos 5 caracteres.";
        return false;
      } 

      if(senha != senhaConf){
        document.getElementById("Mstatus").innerHTML = "Senhas diferem entre si. Tente novamente.";
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

    function bloqueiaEspaco(){
      var tecla=window.event.keyCode;
      if (tecla==32){
        event.keyCode=0; 
        event.returnValue = false;
      }
      
    }
	</script>
	<script>
		$(document).ready( function () {


      $('.excluirUsuario').click(function(){
        carregaPagina($(this).attr('rel'), "Apagar");
        $('.lista_att').css('display', 'none');
      });

      $('.atualizarUsuario').click(function(){
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
            "aaSorting": [[0, 'asc']],
            "bFilter": true,
            "bPaginate": true,
            "oLanguage": {
                  "sEmptyTable": "Nenhum registro encontrado",
                  "sInfo": "Usuários cadastrados no sistema",
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

    function carregaPagina(usuario, operacao){
      if(operacao == "Apagar"){
        $.ajax({
          url:"../processos/_carregaUsuario.php?usuario=" + usuario,
          datatype:"json",
          async: true,
          success: function(dados){
            var resultado = JSON.parse(dados);
            //console.log(resultado);
           
            $('#confirmaUsuario').attr('action', '../processos/_operacaoUsuario.php?operacao=' + operacao);
            $('#Musuario').val(resultado[0].usuario_login);
            
            $('#MusuarioNome').val(resultado[0].usuario_nome);     
            $('#Msenha').val(resultado[0].usuario_senha);
            $('#ModalTipo').val(resultado[0].usuario_status);
            $('#Mtipo').val(resultado[0].tipo_usuario);

            if($('#ModalTipo').val() == 'I'){
              $('#t1').attr('selected', true);
            } else {
              $('#t2').attr('selected', true);
            }

            $('#exampleModalLongTitle').html("Deseja excluir o usuário '" + resultado[0].usuario_login + "'?");
            $('#modalUser').modal();
          },
          error: function erro(){
            console.log("Ocorreu um problema.");
          }
        });
      } else {
        $.ajax({
          url:"../processos/_carregaUsuario.php?usuario=" + usuario,
          datatype:"json",
          async: true,
          success: function(dados){
            console.log(dados);
            var resultado = JSON.parse(dados);
            //console.log(resultado);
            
            $('#confirmaUsuario').attr('action', '../processos/_operacaoUsuario.php?operacao=' + operacao);
           
            $('#Musuario').val(resultado[0].usuario_login);
            $('#MusuarioNome').val(resultado[0].usuario_nome);
            $('#MusuarioNome').attr('readonly', false);
            $('#Msenha').val(resultado[0].usuario_senha);
            $('#MsenhaNova').val(resultado[0].usuario_senha);
            $('#MsenhaNovaConf').val(resultado[0].usuario_senha);
            $('#ModalTipo').val(resultado[0].usuario_status);
            $('#Mtipo').val(resultado[0].tipo_usuario);

            if($('#ModalTipo').val() == 'I'){
              $('#t1').attr('selected', true);
            } else {
              $('#t2').attr('selected', true);
            }

            $('#confirmaUsuario').on('submit', function(){
              if(MvalidaTudo()){
                this.submit();
              } else {
                return false;
              }
            });

            $('#exampleModalLongTitle').html("Deseja atualizar o usuário '" + resultado[0].usuario_login + "'?");
            $('#modalUser').modal();  
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