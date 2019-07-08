<?php
	require_once "ConexaoBD.class.php";

	Class CRUD_Comanda{
		protected $_conn;
		protected $_tbName;
		protected $_tbFields = array();

		public function __construct(string $tbName, array $tbFields){
			$connection = new ConexaoBD('localhost', 'oficina', 'gu3000265', 'senha123');
			
			$this->_conn = $connection->Connect();
			$this->_tbName = $tbName;
			$this->_tbFields = $tbFields;

			/* tbFields: 0 - "numero", 1 - "dt_cmd", 2 - "valor", 3 - "descr", 4 - "status_cmd", 5 - "dt_reg" */
		}

		//Registra nova comanda.
		public function DBInsert(array $values){
			try{
				$sql = "INSERT INTO ".$this->_tbName." VALUES (:cod_cmd, :dt_cmd, :vlr, :descr, :status_cmd, :dt_reg)";

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':cod_cmd', $values[0]);
				$stmt->bindValue(':dt_cmd', $values[1]);
				$stmt->bindValue(':vlr', $values[2]);
				$stmt->bindValue(':descr', $values[3]);
				$stmt->bindValue(':dt_reg', $values[4]);
				$stmt->bindValue(':status_cmd', $values[5]);

				$stmt->execute();

				//Inserção na tabela de histórico.

				$sql = "INSERT INTO tb_comandas_hist(numero, dt_cmd, valor, descr, status_cmd, dt_reg) VALUES (:cod_cmd, :dt_cmd, :vlr, :descr, :status_cmd, :dt_reg)";

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':cod_cmd', $values[0]);
				$stmt->bindValue(':dt_cmd', $values[1]);
				$stmt->bindValue(':vlr', $values[2]);
				$stmt->bindValue(':descr', $values[3]);
				$stmt->bindValue(':dt_reg', $values[4]);
				$stmt->bindValue(':status_cmd', $values[5]);

				$stmt->execute();

				return true;

			}catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao salvar. <strong>'.$ex->getMessage().'</strong></p>';
				return false;
			}
				
		}

		//Atualizar comandas.
		public function DBUpdate(array $values){
			try{
				$sql = "UPDATE ".$this->_tbName." SET ".$this->_tbFields[1]." = :dt_cmd, ".$this->_tbFields[2]." = :vlr, ".$this->_tbFields[3]." = :descr, ".$this->_tbFields[4]." = :status_cmd WHERE ".$this->_tbFields[0]." = :cod_cmd AND ".$this->_tbFields[1]." = :dt_cmd";

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':cod_cmd', $values[0]);
				$stmt->bindValue(':dt_cmd', $values[1]);
				$stmt->bindValue(':vlr', $values[2]);
				$stmt->bindValue(':descr', $values[3]);
				$stmt->bindValue(':status_cmd', $values[4]);

				$stmt->execute();

				//Atualização na tabela de histórico.

				$sql = "UPDATE tb_comandas_hist SET dt_cmd = :dt_cmd, valor = :vlr, descr = :descr, status_cmd = :status_cmd WHERE numero = :cod_cmd";

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':cod_cmd', $values[0]);
				$stmt->bindValue(':dt_cmd', $values[1]);
				$stmt->bindValue(':vlr', $values[2]);
				$stmt->bindValue(':descr', $values[3]);
				$stmt->bindValue(':status_cmd', $values[4]);

				$stmt->execute();
				return true;
			}catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao atualizar. <strong>'.$ex->getMessage().'</strong></p>';
				return false;
			}
		}

		//Apagar comandas.
		public function DBDelete(array $values, int $modo){
			$where = "";
			if ($modo == 2){
				$where .= " WHERE ".$this->_tbFields[0]." = :cod AND ".$this->_tbFields[1]." = :dt";
			}

			try{
				$sql = "DELETE FROM ".$this->_tbName.$where;

				$stmt = $this->_conn->prepare($sql);
				$stmt->bindValue(':cod', $values[0]);
				$stmt->bindValue(':dt', $values[1]);

				$stmt->execute();

				//Deleção da tabela de histórico.

				$sql = "DELETE FROM tb_comandas_hist WHERE numero = :cod AND dt_cmd = :dt";

				$stmt = $this->_conn->prepare($sql);
				$stmt->bindValue(':cod', $values[0]);
				$stmt->bindValue(':dt', $values[1]);

				$stmt->execute();

				return true;
			} catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao excluir. <strong>'.$ex->getMessage().'</strong></p>';
				return false;			
			}
		}

		//Listar comandas.
		public function DBSelectAll(){
			$sql = "SELECT ".$this->_tbFields[0].", ".$this->_tbFields[1].", ".$this->_tbFields[2].", ".$this->_tbFields[3].", ".$this->_tbFields[4].", (CASE WHEN ".$this->_tbFields[4]." = 'P' THEN 'Pendente' WHEN ".$this->_tbFields[4]." = 'C' THEN 'Compensada' ELSE 'Pendente/Boleto' END) AS status_nome FROM ".$this->_tbName;

			$stmt = $this->_conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));

			echo '<p class="bg-info text-white text-center">Há registro de '.$stmt->rowCount().' comanda(s). </p>';
			echo '<table id="myTable" class="table table-hover text-center">';
			echo '<thead><tr><th>Código</th><th>Data</th><th>Valor(R$)</th><th>Descrição</th><th>Status</th>';

			if($_SESSION['usuario_status'] == 'A')
				echo '<th class="acoes noprint">Ações</th>';

			echo '</tr></thead><tbody>';

			foreach($result as $value){

				//Converte e formata a data
				$data = date('d/m/Y', strtotime($value['dt_cmd']));

				echo '<tr>
						 <td>'.$value['numero'].'</td>
						 <td>'. $data.'</td>
						 <td>'.number_format($value['valor'], 2, ",", ".").'</td>
						 <td>'.$value['descr'].'</td>
						 <td>'.$value['status_nome'].'</td>';
						 
						 if($_SESSION['usuario_status'] == 'A'){
							 echo '<td class="acoes noprint"><a role="button" name="'.$value['dt_cmd'].'" class="btn btn-danger excluir" rel="'.$value['numero'].'" href="#">Excluir</a>
							 						 <a role="button" name="'.$value['dt_cmd'].'" class="btn btn-warning atualizar" rel="'.$value['numero'].'" href="#">Alterar</a></td>
						  	</tr>';
						 }
			}
			echo '</tbody></table>';
		}


		//Seleção individual de comanda - Modal
		public function DBSelect(array $values){
			$sql = "SELECT ".$this->_tbFields[0].", ".$this->_tbFields[1].", ".$this->_tbFields[2].", ".$this->_tbFields[3].", ".$this->_tbFields[4].", (CASE WHEN ".$this->_tbFields[4]." = 'P' THEN 'Pendente' WHEN ".$this->_tbFields[4]." = 'C' THEN 'Compensada' ELSE 'Pendente/Boleto' END) AS status_nome FROM ".$this->_tbName." WHERE ".$this->_tbFields[0]."=:cod AND ".$this->_tbFields[1]." = :dt";

			$stmt = $this->_conn->prepare($sql);
			$stmt->bindValue(":cod", $values[0]);
			$stmt->bindValue(":dt", $values[1]);
			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));

			return $result;
		}

		//Funções matemáticas para dashboard.
		public function DBCount($modo){
			switch ($modo) {
				case 0:
					$sql = "SELECT ROUND(SUM(valor), 2) AS valor FROM ". $this->_tbName;
					break;
				case 1:
					$sql = "SELECT COUNT(status_cmd) AS valor FROM ".$this->_tbName." WHERE ".$this->_tbFields[4]." = :cod";
					break;
				case 2:
					$sql = "SELECT COUNT(status_cmd) AS valor FROM ".$this->_tbName;
					break;
				case 3:
					$sql = "SELECT MAX(valor) AS valor FROM ".$this->_tbName;
					break;
				case 4:
					$sql = "SELECT MIN(valor) AS valor FROM ".$this->_tbName;
					break;
				case 5:
					$sql = "SELECT ROUND(SUM(valor), 2) AS valor FROM ".$this->_tbName." WHERE ".$this->_tbFields[4]." = :cod";
					break;
				default:
					return false;
					break;
			}
			
			$stmt = $this->_conn->prepare($sql);
			$stmt->bindValue(":cod", "C");
			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));
	
			foreach ($result as $value) {
				return $value['valor'];
			}
		}

		public function DBPrint(){
			$sql = "SELECT ".$this->_tbFields[0].", ".$this->_tbFields[1].", ".$this->_tbFields[2].", ".$this->_tbFields[3].", ".$this->_tbFields[4].", (CASE WHEN ".$this->_tbFields[4]." = 'P' THEN 'Pendente' WHEN ".$this->_tbFields[4]." = 'C' THEN 'Compensada' ELSE 'Pendente/Boleto' END) AS status_nome FROM ".$this->_tbName;

			$stmt = $this->_conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));

			echo '<p class="bg-info text-white text-center">Há registro de '.$stmt->rowCount().' comanda(s). </p>';
			echo '<table class="table table-bordered text-center">';
			echo '<tr><th>Código</th><th>Data</th><th>Valor(R$)</th><th>Descrição</th><th>Status</th></tr>';
			foreach ($result as $value) {
				$data = date('d/m/Y', strtotime($value['dt_cmd']));
				echo '<tr> 
						 <td>'.$value['numero'].'</td>
						 <td>'. $data.'</td>
						 <td>'.number_format($value['valor'], 2, ",", ".").'</td>
						 <td>'.$value['descr'].'</td>
						 <td>'.$value['status_nome'].'</td>
					  </tr>';
			}
			echo '</table>';
			
		}
	}
?>