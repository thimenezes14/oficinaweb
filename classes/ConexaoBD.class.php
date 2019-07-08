<?php
	Class ConexaoBD{
		protected $_hostname;
		protected $_dbname;
		protected $_user;
		protected $_pwd;

		public function __construct($host, $dbname, $user, $pwd){
			$this->_hostname = $host;
			$this->_dbname = $dbname;
			$this->_user = $user;
			$this->_pwd = $pwd;	
		}

		public function setHostname($host){
			$this->_hostname = $host;	
		}

		public function setDbname($dbname){
			$this->_dbname = $dbname;	
		}
		
		public function setUser($user){
			$this->_user = $user;	
		}

		public function setPassword($pwd){
			$this->_pwd = $pwd;	
		}

		public function Connect(){
			$dsn = 'mysql:host='.$this->_hostname.';dbname='.$this->_dbname.';charset=utf8';

			try{
				$pdo = new pdo($dsn, $this->_user, $this->_pwd);
				$pdo -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				//echo '<p class="bg-success text-white text-center">Conectado. </p>';
				return $pdo;
			} catch(PDOException $ex){
				echo '<p class="bg-warning text-white text-center">Erro de conexão. </p>';
				echo '<p class="bg-info text-white text-center">Erro: <strong>'.$ex->getMessage().'</strong></p>';
				return false;
			}		
		}
	}
?>