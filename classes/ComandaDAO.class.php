<?php
	require "CRUD_Comanda.class.php";
	
	Class ComandaDAO extends CRUD_Comanda{
		public function __construct(){
			$tabela = "tb_comandas";
	    	$campos = array("numero", "dt_cmd", "valor", "descr", "status_cmd", "dt_reg");
			parent::__construct($tabela, $campos);
		}
	}
?>