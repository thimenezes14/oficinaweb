<?php
	require "CRUD_Pagamento.class.php";
	
	Class PagamentoDAO extends CRUD_Pagamento{
		public function __construct(){
			$tabela = "tb_pagamentos";
      		$campos = array("seq_pgto", "pagador","valor", "tipo_pgto", "descr_pgto", "data_pgto");
			parent::__construct($tabela, $campos);
		}
	}
?>