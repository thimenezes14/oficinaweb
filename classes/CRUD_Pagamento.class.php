<?php
	require_once "ConexaoBD.class.php";

	Class CRUD_Pagamento{
		protected $_conn;
		protected $_stmt;
		protected $_result;
		protected $_tbName;
		protected $_tbFields = array();

		public function __construct(string $tbName, array $tbFields){
			$connection = new ConexaoBD('localhost', 'oficina', 'gu3000265', 'senha123');
			
			$this->_conn = $connection->Connect();

			$this->_tbName = $tbName;
			$this->_tbFields = $tbFields;

			//tbFields = 0 - seq_pgto; 1 - pagador; 2 - valor; 3 - tipo_pgto; 4 - descr.
		}

		//Adiciona novo pagamento.
		public function Insert($pagador, $valor, $tipo_pgto, $descr, $data_pgto){	
			try{
		
				$sql = "INSERT INTO ".$this->_tbName." (".$this->_tbFields[1].",".$this->_tbFields[2].",".$this->_tbFields[3].",".$this->_tbFields[4].",".$this->_tbFields[5].") VALUES (:pagador, :valor, :tipo_pgto, :descr, :data_op)";

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':pagador', $pagador);
				$stmt->bindValue(':valor', $valor);
				$stmt->bindValue(':tipo_pgto', $tipo_pgto);
				$stmt->bindValue(':descr', $descr);
				$stmt->bindValue(':data_op', $data_pgto);

				$stmt->execute();
				return true;

			}catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao salvar. <strong>'.$ex->getMessage().'</strong></p>';
				return false;
			}
				
		}

		//Atualização de dados gerais de pagamentos - menu de pagamentos.
		public function Update(array $values){
			try{
				$sql = "UPDATE ".$this->_tbName." SET ".$this->_tbFields[1]." = :pagador, ".$this->_tbFields[2]." = :valor, ".$this->_tbFields[3]." = :tipo_pgto, ".$this->_tbFields[4]." = :descr, ".$this->_tbFields[5]." = :data_op WHERE ".$this->_tbFields[0]." = :seq_pgto";

				print_r($sql);

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':seq_pgto', $values[0]);
				$stmt->bindValue(':pagador', $values[1]);
				$stmt->bindValue(':valor', $values[2]);
				$stmt->bindValue(':tipo_pgto', $values[3]);
				$stmt->bindValue(':descr', $values[4]);
				$stmt->bindValue(':data_op', $values[5]);

				$stmt->execute();
				return true;
			}catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao atualizar. <strong>'.$ex->getMessage().'</strong></p>';
				return false;
			}
		}


		//Apaga pagamento.
		public function Delete(array $values){
			try{
				$sql = "DELETE FROM ".$this->_tbName." WHERE ".$this->_tbFields[0]." = :seq_pgto";

				$stmt = $this->_conn->prepare($sql);
				$stmt->bindValue(':seq_pgto', $values[0]);

				$stmt->execute();
				return true;
			} catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao excluir. <strong>'.$ex->getMessage().'</strong></p>';
				return false;			
			}
		}

		//Lista pagamentos.
		public function SelectAll(){
			$sql = "SELECT ".$this->_tbFields[0].", ".$this->_tbFields[1].", ".$this->_tbFields[2].", ".$this->_tbFields[3].", (CASE WHEN ".$this->_tbFields[3]." = 'A' THEN 'Dinheiro' WHEN ".$this->_tbFields[3]." = 'B' THEN 'Cartão Crédito/Débito' WHEN ".$this->_tbFields[3]." = 'C' THEN 'Cheque' WHEN ".$this->_tbFields[3]." = 'D' THEN 'Depósito Bancário' END) AS forma_pgto, ".$this->_tbFields[4].", ".$this->_tbFields[5]." FROM ".$this->_tbName;

			$stmt = $this->_conn->prepare($sql);
			
			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));


			echo '<p class="bg-info text-white text-center">Há registro de '.$stmt->rowCount().' pagamento(s). </p>';
			echo '<table id="myTable" class="table table-hover">';
			echo '<thead><tr><th>Seq.</th><th>Nome Pagador</th><th>Valor Total</th><th>Forma</th><th>Descrição</th><th>Data</th><th>Ações</th></tr></thead><tbody>';

			foreach($result as $value){

				$data = date('d/m/Y', strtotime($value['data_pgto']));

				echo ('<tr>
						 <td>'.$value['seq_pgto'].'</td>
						 <td>'.$value['pagador'].'</td>
						 <td>'.number_format($value['valor'], 2, ',', '.').'</td>
						 <td>'.$value['forma_pgto'].'</td>
						 <td>'.$value['descr_pgto'].'</td>
						 <td>'.$data.'</td>
						 <td><a role="button" class="btn btn-danger excluirPagamento" rel='.$value['seq_pgto'].' href="#">Excluir</a>
						 <a role="button" class="btn btn-warning atualizarPagamento" rel='.$value['seq_pgto'].' href="#">Alterar</a></td>
					  	</tr>');
			}
			echo '</tbody></table>';
		}

		public function Select(int $value){
			$sql = "SELECT ".$this->_tbFields[0].", ".$this->_tbFields[1].", ".$this->_tbFields[2].", ".$this->_tbFields[3].", (CASE WHEN ".$this->_tbFields[3]." = 'A' THEN 'Dinheiro' WHEN ".$this->_tbFields[3]." = 'B' THEN 'Cartão Crédito/Débito' WHEN ".$this->_tbFields[3]." = 'C' THEN 'Cheque' WHEN ".$this->_tbFields[3]." = 'D' THEN 'Depósito Bancário' END) AS forma_pgto, ".$this->_tbFields[4].", ".$this->_tbFields[5]." FROM ".$this->_tbName." WHERE ".$this->_tbFields[0]." = ".$value;


			$stmt = $this->_conn->prepare($sql);
			$stmt->bindValue(':seq_pgto', $value);

			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));

			return $result;
		}

		public function Count(int $modo){
			switch ($modo) {
				case 1:
					#Valor total dos pagamentos em cheque.
					$sql = "SELECT ROUND(SUM(valor), 2) AS valor FROM ". $this->_tbName." WHERE ".$this->_tbFields[3]." = 'C'";
					break;
				case 2:
					#Valor total dos pagamentos em cartão de crédito.
					$sql = "SELECT ROUND(SUM(valor)*0.95, 2) AS valor FROM ".$this->_tbName." WHERE ".$this->_tbFields[3]." = 'B'";
					break;
				case 3:
					#Valor total dos pagamentos em dinheiro.
					$sql = "SELECT ROUND(SUM(valor), 2) AS valor FROM ".$this->_tbName." WHERE ".$this->_tbFields[3]." = 'A'";
					break;
			}

			$stmt = $this->_conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));
	
			foreach ($result as $value) {
				return $value['valor'];
			}
			
		}

		public function Print(){
			$sql = "SELECT ".$this->_tbFields[0].", ".$this->_tbFields[1].", ".$this->_tbFields[2].", ".$this->_tbFields[3].", (CASE WHEN ".$this->_tbFields[3]." = 'A' THEN 'Dinheiro' WHEN ".$this->_tbFields[3]." = 'B' THEN 'Cartão Crédito/Débito' WHEN ".$this->_tbFields[3]." = 'C' THEN 'Cheque' WHEN ".$this->_tbFields[3]." = 'D' THEN 'Depósito Bancário' END) AS forma_pgto, ".$this->_tbFields[4].", ".$this->_tbFields[5]." FROM ".$this->_tbName." ORDER BY ".$this->_tbFields[5];

			$stmt = $this->_conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));

			echo '<p class="bg-info text-white text-center">Há registro de '.$stmt->rowCount().' pagamento(s). </p>';
			echo '<table class="table table-bordered text-center tabela">';
			echo '<tr><th>Pagador</th><th>Valor Total</th><th>Forma</th><th>Descrição</th><th>Data</th></tr>';
			foreach ($result as $value) {

				$data = date('d/m/Y', strtotime($value['data_pgto']));

				echo ('<tr>
						 <td>'.$value['pagador'].'</td>
						 <td>'.number_format($value['valor'], 2, ',', '.').'</td>
						 <td>'.$value['forma_pgto'].'</td>
						 <td>'.$value['descr_pgto'].'</td>
						 <td>'.$data.'</td>
					  	</tr>');
			
			}
			echo '</table>';
		}

	}

?>