<?php
	require "PagamentoDAO.class.php";
	Class Pagamento{
		private $_seq_pgto;
		private $_pagador;
		private $_valor;
		private $_tipo_pgto;
		private $_descr;
		private $_data_op;

		public function __construct($seq_pgto, $pagador, $valor, $tipo_pgto, $descr, $data_op){
			$this->_seq_pgto = $seq_pgto;
			$this->_pagador = $pagador;
			$this->_valor = $valor;
			$this->_tipo_pgto = $tipo_pgto;
			$this->_descr = $descr;
			$this->_data_op = $data_op;
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

		public function rmvPagamento(){
			$resultado = new PagamentoDAO();

			if($resultado->Delete($this->_seq_pgto))
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

		public function imprimePagamento(){
			$resultado = new PagamentoDAO();

			$resultado->Print();
		}

	}
?>