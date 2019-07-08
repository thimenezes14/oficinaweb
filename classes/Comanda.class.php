<?php
	require "ComandaDAO.class.php";
	Class Comanda{
		private $_numero;
		private $_dt_cmd;
		private $_valor;
		private $_descr;
		private $_status_cmd;
		private $_dt_reg;

		public function __construct($numero, $dt_cmd, $valor, $descr, $descr, $dt_reg){
			$this->_numero = $numero;
			$this->_dt_cmd = $dt_cmd;
			$this->_valor = $valor;
			$this->_descr = $descr;
			$this->_descr = $descr;
			$this->_dt_reg = $dt_reg;
		}

		public function listarPagamentos(){
			$resultado = new PagamentoDAO();

			$pagamentos = $resultado->SelectAll();

		}

		public function selectPagamentos(){
			$resultado = new PagamentoDAO();

			$pagamentos = $resultado->Select($this->_seq_pgto);

		}

		public function addPagamento(){
			$resultado = new PagamentoDAO();

			if($resultado->Insert($this->_pagador, $this->_valor, $this->_tipo_pgto, $this->_descr, $this->_data_op))
				return true;
			else{
				return false;
			}
		}

		public function uptPagamento(){
			$resultado = new PagamentoDAO();

			$pagamento = array($this->_seq_pgto, $this->_pagador, $this->_valor, $this->_tipo_pgto, $this->_descr, $this->_data_op);

			if($resultado->Update($pagamento))
				return true;
			else{
				return false;
			}
		}

		public function removeComanda(int $modo){
			$resultado = new ComandaDAO();

			if($resultado->DBDelete($this->_seq_pgto, $modo))
				return true;
			else{
				return false;
			}
		}

		public function countPagamento($modo){
			$resultado = new PagamentoDAO();

			$cont = $resultado->Count($modo);
			return $cont;
		}

	}
?>