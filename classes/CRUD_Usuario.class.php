<?php
	require_once "ConexaoBD.class.php";

	Class CRUD_Usuario{
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

			//tbFields = 0 - ID; 1 - login; 2 - Nome; 3 - Senha; 4 - Status.
		}

		//Insere novo usuário.
		public function Insert($login, $nome, $senha, $status){	
			try{
				$sql = "INSERT INTO ".$this->_tbName." (".$this->_tbFields[1].",".$this->_tbFields[2].",".$this->_tbFields[3].",".$this->_tbFields[4].") VALUES (:login, :nome, :senha, :status)";

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':login', $login);
				$stmt->bindValue(':nome', $nome);
				$stmt->bindValue(':senha', $senha);
				$stmt->bindValue(':status', $status);

				$stmt->execute();
				return true;

			}catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao salvar. <strong>'.$ex->getMessage().'</strong></p>';
				return false;
			}
				
		}

		//Atualização de dados gerais de usuário - gerenciamento de usuários.
		public function Update(array $values){
			try{
				
				$sql = "UPDATE ".$this->_tbName." SET ".$this->_tbFields[2]." = :nome, ".$this->_tbFields[3]." = :senha WHERE ".$this->_tbFields[1]." = :login";

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':login', $values[0]);
				$stmt->bindValue(':nome', $values[1]);
				$stmt->bindValue(':senha', $values[2]);

				$stmt->execute();
				return true;
			}catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao atualizar. <strong>'.$ex->getMessage().'</strong></p>';
				return false;
			}
		}

		//Atualiza status de usuário - gerenciamento de usuários.
		public function UpdateStatus(array $values){
			try{

				$sql = "UPDATE ".$this->_tbName." SET ".$this->_tbFields[4]." = :status WHERE ".$this->_tbFields[1]." = :login";

				$stmt = $this->_conn->prepare($sql);

				$stmt->bindValue(':login', $values[0]);
				$stmt->bindValue(':status', $values[3]);

				$stmt->execute();
				return true;
			}catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao atualizar. <strong>'.$ex->getMessage().'</strong></p>';
				return false;
			}
		}

		//Apaga usuário.
		public function Delete($usuario){
			try{
				$sql = "DELETE FROM ".$this->_tbName." WHERE ".$this->_tbFields[1]." = :login";

				$stmt = $this->_conn->prepare($sql);
				$stmt->bindValue(':login', $usuario);

				$stmt->execute();
				return true;
			} catch(PDOException $ex){
				echo '<p class="bg-danger text-center text-white">Erro ao excluir. <strong>'.$ex->getMessage().'</strong></p>';
				return false;			
			}
		}

		//Lista usuários.
		public function SelectAll(){
			$sql = "SELECT ".$this->_tbFields[1].", ".$this->_tbFields[2].", ".$this->_tbFields[4].", (CASE WHEN ".$this->_tbFields[4]." = 'A' THEN 'Administrador' WHEN ".$this->_tbFields[4]." = 'I' THEN 'Comum' END) AS tipo_usuario FROM ".$this->_tbName;

			$stmt = $this->_conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll((PDO::FETCH_ASSOC));


			echo '<p class="bg-info text-white text-center">Há registro de '.$stmt->rowCount().' usuário(s). </p>';
			echo '<table id="myTable" class="table table-hover">';
			echo '<thead><tr><th>Usuário</th><th>Nome</th><th>Status</th><th>Ações</th></tr></thead><tbody>';

			foreach($result as $value){

				echo ('<tr>
						 <td>'.$value['usuario_login'].'</td>
						 <td>'.$value['usuario_nome'].'</td>
						 <td>'.$value['tipo_usuario'].'</td>
						 <td><a role="button" id="excluir" class="btn btn-danger excluirUsuario" rel='.$value['usuario_login'].' href="#">Excluir</a>
						 <a role="button" id="atualizar" class="btn btn-warning atualizarUsuario" rel="'.$value['usuario_login'].'" href="#">Alterar</a></td>
					  	</tr>');
			}
			echo '</tbody></table>';
		}

		//Valida login e retorna informações para início de sessão.
		public function Select($login, $senha){
			$sql = "SELECT * FROM ".$this->_tbName." WHERE ".$this->_tbFields[1]." = :login AND ".$this->_tbFields[3]." = :senha";

			$stmt = $this->_conn->prepare($sql);
			$stmt->bindValue(":login", $login);
			$stmt->bindValue(":senha", $senha);
			if($stmt->execute()){
				$result = $stmt->FetchAll(PDO::FETCH_ASSOC);
				foreach ($result as $value) {
					return array($value['usuario_login'], $value['usuario_nome'], $value['usuario_status']);	
				}
			} else {
				return false;
			}
		}

		//Verifica se usuário já existe - para criação de novos usuários.
		public function Check($usuario){
			$sql = "SELECT * FROM ".$this->_tbName." WHERE ".$this->_tbFields[1]." = :login";

			$stmt = $this->_conn->prepare($sql);
			$stmt->bindValue(":login", $usuario);

			$stmt->execute();

			if ($stmt->rowCount() > 0)
				return false;
			else
				return true;
		}

		//Seleção completa de dados de determinado usuário.
		public function getUserInfo($usuario){
			$sql = "SELECT ".$this->_tbFields[0].", ".$this->_tbFields[1].", ".$this->_tbFields[2].", ".$this->_tbFields[3].", ".$this->_tbFields[4].", (CASE WHEN ".$this->_tbFields[4]."= 'A' THEN 'Administrador' WHEN ".$this->_tbFields[4]." = 'I' THEN 'Comum' END) AS tipo_usuario FROM ".$this->_tbName." WHERE usuario_login = :login";

			$stmt = $this->_conn->prepare($sql);
			$stmt->bindValue(":login", $usuario);
			
			$stmt->execute();
			
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		
		}

		//Retorna quantos usuários administradores existem no banco.
		public function qtdAdmin(){
			$sql = "SELECT * FROM ".$this->_tbName." WHERE ".$this->_tbFields[4]."='A'";

			$stmt = $this->_conn->prepare($sql);

			$stmt->execute();

			if($stmt->rowCount() > 1)
				return true;
			else 
				return false;
		}
	}
?>