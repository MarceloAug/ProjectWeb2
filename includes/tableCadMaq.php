<?php 

	include_once('connection.php');

	class CadMaq {

		public $HasError;
	    public $ErrorMsg;
	    public $MaqDados = array();
	    public $maq = array();
	    public $responsaveis = array();
	    public $arquivos = array();
	    public $pecas = array();

		private $db;

		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}

		function getCadMaq() {
			$st = $this->db->prepare("SELECT 
										Id \"Id\", 
										Nome \"Nome\", 
										Descricao \"Descrição\",
										Caracteristicas \"Características\",
										Patrimonio \"Patrimônio\"
									FROM CadMaq");
			if ($st->execute()) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->maq[] = $row;
				}
				if (empty($this->maq)) {
					$this->HasError = true;
					$this->ErrorMsg = "Erro - Lista de Máquinas Cadastradas vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		function getCadMaqEmDia() {
			/* $st = $this->db->prepare("SELECT 
										Id \"Id\", 
										Nome \"Nome\", 
										Descricao \"Descrição\",
										Caracteristicas \"Características\",
										Patrimonio \"Patrimônio\",
										EnderecoEmailAviso \"Endereço de Email para enviar o aviso\"
									FROM CadMaq
									WHERE datediff(CURRENT_DATE(),(SELECT MAX(MovMaq.DtManutencao) FROM MovMaq WHERE MovMaq.CadMaqId = CadMaq.Id)) < (CadMaq.PeriodoManutencaoDays - CadMaq.AvisoAntesDays)"); */

			$st = $this->db->prepare("SELECT 
										Id , 
										Nome , 
										Descricao ,
										Caracteristicas,
										Patrimonio
									FROM CadMaq
									WHERE datediff(CURRENT_DATE(),(SELECT MAX(MovMaq.DtManutencao) FROM MovMaq WHERE MovMaq.CadMaqId = CadMaq.Id)) < (CadMaq.PeriodoManutencaoDays - CadMaq.AvisoAntesDays)");
			if ($st->execute()) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->maq[] = $row;
				}
				if (empty($this->maq)) {
					$this->HasError = true;
					$this->ErrorMsg = "Lista de Máquinas Em Dia vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		function getCadMaqManutencao() {
			$st = $this->db->prepare("SELECT 
										Id \"Id\", 
										Nome \"Nome\", 
										Descricao \"Descrição\",
										Caracteristicas \"Características\",
										Patrimonio \"Patrimônio\"
									FROM CadMaq
									WHERE datediff(CURRENT_DATE(),(SELECT MAX(MovMaq.DtManutencao) FROM MovMaq WHERE MovMaq.CadMaqId = CadMaq.Id)) > (CadMaq.PeriodoManutencaoDays - CadMaq.AvisoAntesDays)
									AND datediff(CURRENT_DATE(),(SELECT MAX(MovMaq.DtManutencao) FROM MovMaq WHERE MovMaq.CadMaqId = CadMaq.Id)) < (CadMaq.PeriodoManutencaoDays)");
			if ($st->execute()) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->maq[] = $row;
				}
				if (empty($this->maq)) {
					$this->HasError = true;
					$this->ErrorMsg = "Lista de Máquinas em Período de Manutenção vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		function getCadMaqAtrasados() {
			$st = $this->db->prepare("SELECT 
										Id \"Id\", 
										Nome \"Nome\", 
										Descricao \"Descrição\",
										Caracteristicas \"Características\",
										Patrimonio \"Patrimônio\"
									FROM CadMaq
									WHERE datediff(CURRENT_DATE(),(SELECT MAX(MovMaq.DtManutencao) FROM MovMaq WHERE MovMaq.CadMaqId = CadMaq.Id)) > (CadMaq.PeriodoManutencaoDays)");
			if ($st->execute()) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->maq[] = $row;
				}
				if (empty($this->maq)) {
					$this->HasError = true;
					$this->ErrorMsg = "Lista de Máquinas Atrasadas vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		public function getResponsaveisByCadMaqId($CadMaqId) {
			$st = $this->db->prepare("SELECT 
										ContatoResp.Id \"Id\", 
										ContatoResp.Nome \"Nome\", 
										ContatoResp.Email \"Email\",
										ContatoResp.Telefone \"Telefone\",
										ContatoResp.InfoAdicional \"InfoAdicional\"
									FROM ContatoResp
									INNER JOIN CadMaqContatoResp ON CadMaqContatoResp.ContatoRespId = ContatoResp.Id
									WHERE CadMaqContatoResp.CadMaqId = :CadMaqId");
			$st->bindParam(':CadMaqId', $CadMaqId);
			if ($st->execute()) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->responsaveis[] = $row;
				}
				if (empty($this->responsaveis)) {
					$this->HasError = true;
					$this->ErrorMsg = "Erro - Lista de Responsáveis da Máquina vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		public function getArquivosByCadMaqId($CadMaqId) {
			$st = $this->db->prepare("SELECT 
										Arquivo.Id \"Id\", 
										Arquivo.Descricao \"Descrição\", 
										Arquivo.DataInclusao \"Data de Inclusão\",
										Arquivo.Extensao \"Extensão\",
										Arquivo.NomeOriginal \"Nome Original\"
									FROM Arquivo
									WHERE Arquivo.CadMaqId = :CadMaqId");
			$st->bindParam(':CadMaqId', $CadMaqId);
			if ($st->execute()) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->arquivos[] = $row;
				}
				if (empty($this->arquivos)) {
					$this->HasError = true;
					$this->ErrorMsg = "Erro - Lista de Arquivos da Máquina vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		public function getPecasByCadMaqId($CadMaqId) {
			$st = $this->db->prepare("SELECT 
										CadMaqPecasReposicao.Id, 
										PecasReposicao.Nome ,
										PecasReposicao.Descricao ,
										CadMaqPecasReposicao.QtdeMinima , 
										PecasReposicao.QtdeEstoque ,
										PecasReposicao.CodPecaERP
									FROM CadMaqPecasReposicao
									INNER JOIN PecasReposicao ON PecasReposicao.Id = CadMaqPecasReposicao.PecasReposicaoId
						WHERE CadMaqPecasReposicao.CadMaqId = '{$CadMaqId}'");

		
			if ($st->execute()) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->pecas[] = $row;
				}
				if (empty($this->pecas)) {
					$this->HasError = true;
					$this->ErrorMsg = "Erro - Lista de Peças da Máquina vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		public function getCadMaqById($Id) {
			if(!empty($Id)) {
				$st = $this->db->prepare("SELECT 
											Nome \"Nome\", 
											Descricao \"Descrição\",
											Caracteristicas \"Características\",
											Patrimonio \"Patrimônio\",
											PeriodoManutencaoDays \"Período de Manutenção (em dias)\",
											AvisoAntesDays \"Tempo, em dias, antes de mandar email de aviso\"
										FROM CadMaq 
										WHERE Id = '{$Id}'");
				//$st->bindParam(1, $Id);
				$st->execute();

				if ($st->rowCount()==1) {
					$this->HasError = false;
					$this->MaqDados = $st->fetch(PDO::FETCH_ASSOC);
					return $this;
				} else {
					$this->HasError = true;
					$this->ErrorMsg = "Erro - Não existe máquina com esse Id ($Id).";
					return $this;
				}
			} else {
				$this->HasError = true;
				$this->ErrorMsg = "Erro - Preencha o campo 'Id' na função 'getCadMaqById(Id)'.";
				return $this;
			}
		}

		public function InsertCadMaq($nome, $descricao, $carac, $patrim, $periodoManut, $avisoAntes, $emailAviso,
									$ContatoNome) {

									
			if(!empty($nome) && !empty($descricao) && !empty($carac) && !empty($patrim) && !empty($periodoManut) && !empty($avisoAntes)) {
				try {
					
					$select = $this->db->prepare("SELECT Id FROM ContatoResp WHERE Id = '{$ContatoNome}'");
					$select->execute();

					if ($select->rowCount()<>1) {
						$this->HasError = true;
						if ($select->rowCount()==0) {
							$this->ErrorMsg = "Não existe responsável com esse nome!";
						} else {
							$this->ErrorMsg = "Existe mais de um responsável com esse nome!";
						}
						return $this;
					}

					$ContatoRespId = $select->fetchColumn();

					$st = $this->db->prepare("INSERT INTO CadMaq 
												(Nome, Descricao, Caracteristicas, Patrimonio, 
												PeriodoManutencaoDays, AvisoAntesDays) 
											VALUES 
												('{$nome}', '{$descricao}','{$carac}', '{$patrim}', 
												'{$periodoManut}', '{$avisoAntes}')");

				
					$st->execute();

					$IdMaquina = $this->db->lastInsertId();

					//criando novo movimento criação
					$st = $this->db->prepare("INSERT INTO MovMaq (CadMaqId,HistMovId,Descricao,DtMovto,TipoManutencaoId) 
											VALUES (LAST_INSERT_ID(),'CRIACAO',:descricao,CURRENT_TIMESTAMP(),NULL)");
					$movdesc = 'Criada a nova máquina '.$nome;
					$st->bindParam(':descricao', $movdesc);
					$st->execute();

					//criando o movimento com os dados da tabela de cadastro
					$st = $this->db->prepare("INSERT INTO MovCadMaq 
												(MovMaqId, Nome, Descricao, Caracteristicas, Patrimonio, 
												PeriodoManutencaoDays, AvisoAntesDays, EnderecoEmailAviso) 
											VALUES 
												(LAST_INSERT_ID(), :maqnome, :maqdesc, :carac, :patrim, 
												:periodoManut, :avisoAntes, :emailAviso)");
					$st->bindParam(':maqnome', $nome);
					$st->bindParam(':maqdesc', $descricao);
					$st->bindParam(':carac', $carac);
					$st->bindParam(':patrim', $patrim);
					$st->bindParam(':periodoManut', $periodoManut);
					$st->bindParam(':avisoAntes', $avisoAntes);
					$st->execute();


					//vinculando o Contato com a Máquina
					$st = $this->db->prepare("INSERT INTO CadMaqContatoResp 
												(CadMaqId, ContatoRespId) 
											VALUES 
												({$IdMaquina}, {$ContatoRespId})");
					$st->execute();

					$this->HasError = false;
					return $this;
				} catch (Exception $e) {
					$this->HasError = true;
					$this->ErrorMsg = "Não foi possível cadastrar a nova Máquina.";
					return $this;
				}
			} else {
				$this->HasError = true;
				$this->ErrorMsg = "Há campos sem conteúdo!";
				return $this;
			}
		}

		public function UpdateCadMaq($Id, $nome, $descricao, $carac, $patrim, $periodoManut, $avisoAntes, $emailAviso) {
			if(!empty($Id) && !empty($nome) && !empty($descricao) && !empty($carac) 
				&& !empty($patrim) && !empty($periodoManut) && !empty($avisoAntes)) {
				try {
					$st = $this->db->prepare("UPDATE CadMaq 
											SET Nome = :maqnome, 
												Descricao = :maqdesc,
												Caracteristicas = :carac,
												Patrimonio = :patrim,
												PeriodoManutencaoDays = :periodoManut,
												AvisoAntesDays = :avisoAntes
											WHERE Id = :Id");
					$st->bindParam(':Id', $Id);
					$st->bindParam(':maqnome', $nome);
					$st->bindParam(':maqdesc', $descricao);
					$st->bindParam(':carac', $carac);
					$st->bindParam(':patrim', $patrim);
					$st->bindParam(':periodoManut', $periodoManut);
					$st->bindParam(':avisoAntes', $avisoAntes);
					$st->execute();


					//criando novo movimento alteração
					$st = $this->db->prepare("INSERT INTO MovMaq (CadMaqId,HistMovId,Descricao,DtMovto,TipoManutencaoId) 
											VALUES (:Id,'ALTERACAO',:descricao,CURRENT_TIMESTAMP(),NULL)");
					$movdesc = 'Alterada a máquina '.$nome;
					$st->bindParam(':Id', $Id);
					$st->bindParam(':descricao', $movdesc);
					$st->execute();


					//criando o movimento com os dados da tabela de cadastro
					$st = $this->db->prepare("INSERT INTO MovCadMaq 
												(MovMaqId, Nome, Descricao, Caracteristicas, Patrimonio, 
												PeriodoManutencaoDays, AvisoAntesDays, EnderecoEmailAviso) 
											VALUES 
												(LAST_INSERT_ID(), :maqnome, :maqdesc, :carac, :patrim, 
												:periodoManut, :avisoAntes, :emailAviso)");
					$st->bindParam(':maqnome', $nome);
					$st->bindParam(':maqdesc', $descricao);
					$st->bindParam(':carac', $carac);
					$st->bindParam(':patrim', $patrim);
					$st->bindParam(':periodoManut', $periodoManut);
					$st->bindParam(':avisoAntes', $avisoAntes);
					$st->bindParam(':emailAviso', $emailAviso);
					$st->execute();


					$this->HasError = false;
					return $this;
				} catch (Exception $e) {
					$this->HasError = true;
					$this->ErrorMsg = "Não foi possível alterar o cadastro da Máquina.";
					return $this;
				}
			} else {
				$this->HasError = true;
				$this->ErrorMsg = "Há campos sem conteúdo!";
				return $this;
			}
		}

		public function DeletarMaquina($Id) {
			
			if(!empty($Id)) {
	
				try {
										
						//delete das dependencias
						$st = $this->db->prepare("delete from MovCadMaq 
												  ");
						$st->bindParam(':Id', $Id);
						$st->execute();
	
						$st = $this->db->prepare("delete from CadMaqPecasReposicao
													WHERE CadMaqId = :Id");
						$st->bindParam(':Id', $Id);
						$st->execute();
	
						$st = $this->db->prepare("delete from MovMaq
													WHERE CadMaqId = :Id");
						$st->bindParam(':Id', $Id);
						$st->execute();
						
						
	
						$st = $this->db->prepare("delete from CadMaqContatoResp 
												  WHERE CadMaqId = :Id");
						$st->bindParam(':Id', $Id);
						$st->execute();
	
						
	
						
					
						//Finalmente delete do registro da tabela cadmaq da lista de maquinas
	
						$st = $this->db->prepare("delete from CadMaq
												  WHERE Id = :Id");
						$st->bindParam(':Id', $Id);
						$st->execute();
						
	
						$this->HasError = false;
						return $this;
					
					   
				} catch (Exception $e) {
				
					$this->HasError = true;
					$this->ErrorMsg = "Não foi possível Excluir o cadastro da Peça.";
					return $this;
				}
	
			} else {
				$this->HasError = true;
				$this->ErrorMsg = "Há dados vinculados a esta peça!";
				return $this;
			}
		}

		public function getCadMaqContato() {
		
			$st = $this->db->prepare("SELECT CadMaqContatoResp.CadMaqId,CadMaqContatoResp.ContatoRespId,ContatoResp.Email,ContatoResp.Nome,MovMaq.DtManutencao,CadMaq.Nome AS NomeMaq
											FROM  CadMaqContatoResp
										INNER JOIN ContatoResp ON CadMaqContatoResp.ContatoRespId = ContatoResp.Id
										INNER JOIN CadMaq ON CadMaqContatoResp.CadMaqId = CadMaq.Id
										INNER JOIN MovMaq ON MovMaq.CadMaqId = CadMaq.Id
									WHERE MovMaq.HistMovId = 'MANUTENCAO' AND datediff((SELECT MAX(MovMaq.DtManutencao) FROM MovMaq WHERE MovMaq.CadMaqId = CadMaq.Id),CURRENT_DATE()) > (CadMaq.PeriodoManutencaoDays - CadMaq.AvisoAntesDays)
									AND datediff(CURRENT_DATE(),(SELECT MAX(MovMaq.DtManutencao) FROM MovMaq WHERE MovMaq.CadMaqId = CadMaq.Id)) < (CadMaq.PeriodoManutencaoDays)");
			//$st->bindParam(1, $Id);
			$st->execute();

		
			$this->HasError = false;

			while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
				$this->maq[] = $row;
			}
			return $this;
		
			
		}

	}

?>