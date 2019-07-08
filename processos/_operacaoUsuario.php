<?php
	session_start();
	include "../classes/UsuarioDAO.class.php";

	if(isset($_POST['Musuario']) && isset($_POST['MusuarioNome']) && isset($_POST['ModalTipo'])){
		$usuario = $_POST['Musuario'];
		$nome = $_POST['MusuarioNome'];
		$senhaNova = $_POST['MsenhaNova'];
		$tipo = $_POST['ModalTipo'];

		$operacao = $_GET['operacao'];

		$atualizacao = array($usuario, $nome, $senhaNova, $tipo);

		$reg = new UsuarioDAO();

		if($operacao == "Apagar"){

			if($tipo == 'A'){
				if($reg->qtdAdmin() && $usuario != $_SESSION['usuario'])
					$reg->Delete($atualizacao[0]);
			} else 
				$reg->Delete($usuario);
		}

		else if($operacao == "Atualizar"){
			
			$reg->Update($atualizacao);

			//Se for o próprio usuário que estiver sendo alterado, derruba a seção.
			if(strcmp($usuario, $_SESSION['usuario']) == 0){
				//Altera o tipo de usuário somente se houver mais de um administrador no momento da troca.
				if($reg->qtdAdmin()){
					$reg->UpdateStatus($atualizacao);
				}
				unset($_SESSION['usuario']);
			    unset($_SESSION['tempo']);
			    session_destroy();
			    header("location:../index.php");
			} else {
				$reg->UpdateStatus($atualizacao);
			}
		}
		
		header("location:../views/gerenciar.php");

	} else {
		echo "Deu erro";
	}
?>