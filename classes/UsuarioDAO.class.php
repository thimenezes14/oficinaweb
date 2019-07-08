<?php
	require "CRUD_Usuario.class.php";
	
	Class UsuarioDAO extends CRUD_Usuario{
		public function __construct(){
			$tabela = "tb_usuario";
      		$campos = array("usuario_id", "usuario_login","usuario_nome", "usuario_senha", "usuario_status");
			parent::__construct($tabela, $campos);
		}
	}
?>