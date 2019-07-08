<?php
	require "UsuarioDAO.class.php";
	Class Usuario{
		private $_id;
		private $_login;
		private $_nome;
		private $_senha;
		private $_status;

		public function __construct($id, $login, $nome, $senha, $status){
			$this->_id = $id;
			$this->_login = $login;
			$this->_nome = $nome;
			$this->_senha = $senha;
			$this->_status = $status;
		}

		public function checkLogin(){
			$resultado = new UsuarioDAO();
			
			$status = $resultado->Select($this->_login, $this->_senha);

			if($status)
				return $status;
			else
				return false;
		}

		public function checkUsuario(){
			$resultado = new UsuarioDAO();
			
			if($resultado->Check($this->_login))
				return true;
			else
				return false;
		}

		public function listarUsuarios(){
			$resultado = new UsuarioDAO();

			$usuarios = $resultado->SelectAll();

		}

		public function insereUsuario(){
			$resultado = new UsuarioDAO();

			if($resultado->Insert($this->_login, $this->_nome, $this->_senha, $this->_status))
				return true;
			else{
				return false;
			}
		}


	}
?>