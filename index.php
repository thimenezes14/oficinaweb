<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
 <meta charset='utf-8' />
 <title>Autenticação</title>
 <link rel="icon" href="Imagens/logobrand.png" />
 <link rel='stylesheet' href='assets/bootstrap/css/bootstrap.min.css'>
 <link rel='stylesheet' href='estilos/autenticacao.css' />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="container pagina">
<?php
	require "classes/Usuario.class.php";

	date_default_timezone_set('America/Sao_Paulo');

	$dia = date('Y');

	$data = date('D');
    $mes = date('M');
    $dia = date('d');
    $ano = date('Y');
    
    $semana = array(
        'Sun' => 'domingo', 
        'Mon' => 'segunda-feira',
        'Tue' => 'terça-feira',
        'Wed' => 'quarta-feira',
        'Thu' => 'quinta-feira',
        'Fri' => 'sexta-feira',
        'Sat' => 'sábado'
    );
    
    $mes_extenso = array(
        'Jan' => 'janeiro',
        'Feb' => 'fevereiro',
        'Mar' => 'março',
        'Apr' => 'abril',
        'May' => 'maio',
        'Jun' => 'junho',
        'Jul' => 'julho',
        'Aug' => 'agosto',
        'Nov' => 'novembro',
        'Sep' => 'setembro',
        'Oct' => 'outubro',
        'Dec' => 'dezembro'
    );

	//$hoje = date('d-m-Y', strtotime('2019-01-31'));

	$hoje = date('d-m-Y');

	$final = date('t-m-Y');

	/*if($hoje == $final){
		echo 'Fim de mês';
	} else {
		echo 'Não';
	}*/

	if(isset($_POST["usuario"]) && isset($_POST["senha"])){
		$usuario = $_POST["usuario"];
		$senha = $_POST["senha"];

		$login = new Usuario("", $usuario, "", $senha, "");
		$redir = $login->checkLogin();

		if($redir){
			$_SESSION['usuario'] = $redir[0];
			$_SESSION['nome'] = $redir[1];
			$_SESSION['tempo'] = time();
			$_SESSION['usuario_status'] = $redir[2];
			header("location:views/index.php");
		} else {
			header("location:index.php");
		}
	}	
?>
	<div class="container login">
		<div class="container text-center">
			<div class="grid-imagens">
				<div class="imagens imagem-oficina-web"></div>
				<div class="imagens imagem-ratinho-logo"></div>
			</div>
			<br />
			<div class="container">
				<form class="form form-login" action="" method="post">
					<div class="row">
						<div class="col">
							<label for="usuario">
								<p><strong>Usuário </strong></p>
								<input class="form-control camposLogin" name="usuario" type="text" size="40" maxlength="20" required />
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label for="senha">
								<p><strong>Senha </strong></p>
								<input class="form-control camposLogin" name="senha" type="password" size="40" maxlength="20" required />
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<label>
								<input class="form-control btn botao" type="submit" value="ENTRAR">
							</label>
						</div>
					</div>
				</form>
			</div>
			<hr />
			<h6><strong><?php  echo 'Hoje é '.$semana["$data"].', dia '.$dia.' de '.$mes_extenso["$mes"].' de '.$ano.'.'; ?></strong></h6>
		</div>
	</div>
	<br />
</body>
</html>