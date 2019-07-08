<?php
	class Pagina{
		function Cabecalho($menu){	
		echo "	  
			<div class='p-2 dropdown'>
				<button class='btn btn-warning dropdown-toggle' type='button' data-toggle='dropdown'><strong>GERENCIAMENTO</strong></button>
				<ul class='dropdown-menu'>";
				foreach($menu as $item){
					if($_SESSION['usuario_status'] == 'I' && $item["url"] == "../views/gerenciar.php"){
						echo "<li><a class='nav-item nav-link active disabled' href='". $item["url"] ."'>". $item["nome_link"] ."</a></li>";
					} else {
						echo "<li><a class='nav-item nav-link active' href='". $item["url"] ."'>". $item["nome_link"] ."</a></li>";	
					}
				}
				echo "</ul>
			</div>			
				";
		}

		function CabecalhoMenu($titulo, $icone, $menu){
			echo "
				<!DOCTYPE html>
				<html>
				  <head>
				  	<title>".$titulo."</title>
				  	<link rel='icon' href='../imagens/".$icone."' sizes='16x16'/>
					<meta charset='utf-8'/>
					<link rel='stylesheet' href='../assets/Bootstrap/css/bootstrap.min.css'> 
					<link rel='stylesheet' href='../estilos/estilo.css' />
					<script type='text/javascript' src='../assets/jQuery/jQuery-3.3.1/jquery-3.3.1.min.js'></script>
					<script type='text/javascript' src='../assets/Popper/popper.min.js'></script>
					<script src='../assets/bootstrap/js/bootstrap.min.js'></script>
				  </head>
				<body>
				  	<div class='container border m-2 mx-auto fundo text-center'>
				  	  <img class='img-responsive' src='../Imagens/logo_oficina_web.png' width='25%' />
				  	  <br />
				  	  <hr />
				  	  <h5 class='text-center'>Bem-vindo(a), <strong>".$_SESSION['nome']."</strong>! (".$_SESSION['usuario'].")</h5>		  
					  <nav class='navbar navbar-expand-lg navbar-light'>
						  <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNavAltMarkup' aria-controls='navbarNavAltMarkup' aria-expanded='false' aria-label='Toggle navigation'>
						    <span class='navbar-toggler-icon'></span>
						  </button>
						  <div class='collapse navbar-collapse' id='navbarNavAltMarkup'>
						    <div class='navbar-nav'>";
						    foreach($menu as $item){
						    		if($_SESSION['usuario_status'] == 'I' && $item["url"] == "comandas.php"){
						    			echo "<li><a class='nav-item nav-link active disabled' href='". $item["url"] ."'>". $item["nome_link"] ."</a></li>";	
						    		}else 	
										echo "<li><a class='nav-item nav-link active' href='". $item["url"] ."'>". $item["nome_link"] ."</a></li>";	
								}

							echo "
						    	<li style='float:right'><a class='nav-item nav-link' href='../processos/_sair.php'>SAIR</a></li>
						    </div>";
						    	include "../processos/_menuUsuario.php";
						    echo "
						  </div>
						</nav>
						<h1 class='p-2 m-2 textocabecalho text-center'>". $titulo ."</h1>		
					";
		}

	}
?>