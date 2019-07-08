<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php
		include "../processos/_menu.php";
	    $pagina->CabecalhoMenu("MEUS DADOS", "logobrand.png", $menu);
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
		
		require "../classes/CRUD.class.php";
		
		//$login = new Usuario($usuario, $senha);

		$user = $_SESSION['usuario'];
			
	?>
	<h2 class="h2 text-center">Altere os dados se desejar abaixo: </h2>
        <p class="bg-danger text-white text-center" id="status"></p>
        <form id="confirmaUsuario" class="form-group" method="post" onkeydown="BloqEnter()">
          <p class="bg-danger text-white text-center" id="Mstatus"></p>
          <div class="container">
            <label for="Musuario">
              <p>Usuário: </p>
              <input class="form-control" value=<?=$user;?> id="Musuario" name="Musuario" type="text" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" readonly="true" />
            </label>
            <label for="MusuarioNome">
              <p>Nome: </p>
              <input class="form-control" id="MusuarioNome" name="MusuarioNome" type="text" size="21" maxlength="20" readonly="true" />
            </label>
            <label for="Msenha">
              <p>Senha: </p>
              <input class="form-control" value="" id="Msenha" name="Msenha" type="password" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" readonly="true" />
            </label>
            <br />
            <label class="lista_att" for="MsenhaNova">
              <p>Nova Senha: </p>
              <input class="form-control" id="MsenhaNova" name="MsenhaNova" type="password" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" />
            </label>
            <label class="lista_att" for="MsenhaNovaConf">
              <p>Confirmar Nova Senha: </p>
              <input class="form-control" id="MsenhaNovaConf" name="MsenhaNovaConf" type="password" size="21" maxlength="20" onkeydown="bloqueiaEspaco()" />
            </label>
              <input class="form-control" value="" id="ModalTipo" name="ModalTipo" type="text" size="21" maxlength="20" readonly="true" />
           
            <input class="btn btn-secondary alterar" type="submit" value="Alterar" />
          </div>
        </div>
        </form>
	<p class="bg-warning text-white" id="status"></p>
	<script>
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
	</script>
		<?php
			echo "<script>
					var usuario = document.getElementById('Musuario').value;
				  </script>"
		?>
	<script>
      	$(document).ready(function(){
			$.ajax({
	          url:"../processos/_carregaUsuario.php?usuario=" + usuario,
	          datatype:"json",
	          async: true,
	          success: function(dados){
	            console.log(dados);
	            var resultado = JSON.parse(dados);
	            console.log(resultado);
	            
	            $('#confirmaUsuario').attr('action', '../processos/_operacaoUsuario.php?operacao=Atualizar');
	           
	            $('#Musuario').val(resultado[0].usuario_login);
	            $('#MusuarioNome').val(resultado[0].usuario_nome);
	            $('#MusuarioNome').attr('readonly', false);
	            $('#Msenha').val(resultado[0].usuario_senha);
	            $('#MsenhaNova').val(resultado[0].usuario_senha);
	            $('#MsenhaNovaConf').val(resultado[0].usuario_senha);
	            $('#ModalTipo').val(resultado[0].usuario_status);
	            $('#ModalTipo').css('display', 'none');

	            $('#confirmaUsuario').on('submit', function(){
	              if(MvalidaTudo()){
	                this.submit();
	              } else {
	                return false;
	              }
	            }); 
	          },
	          error: function erro(){
	            console.log("Ocorreu um problema.");
	          }
	        });
      	});
	</script>
</body>
</html>