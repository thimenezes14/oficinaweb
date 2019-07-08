<?php
    include "../classes/UsuarioDAO.class.php";

	$usuario = $_GET['usuario'];
	
 	$reg = new UsuarioDAO();
 	$result = $reg->getUserInfo($usuario);

	print json_encode($result);
?>