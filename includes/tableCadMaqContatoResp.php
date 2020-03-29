<?php 

	include_once('connection.php');

	class CadMaqContatoResp {

		public $HasError;
	    public $ErrorMsg;
	    
		private $db;

		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}

		public function InsertCadMaqContatoResp($cadMaqId,$idResp) {
		
			
			if(!empty($cadMaqId) && !empty($idResp)) {
				
				try {
					$select = $this->db->prepare("SELECT Id FROM ContatoResp WHERE Id = :idResp ");
					$select->bindParam(':idResp', $idResp);
					$select->execute();

					if ($select->rowCount()<>1) {
						$this->HasError = true;
						if ($select->rowCount()==0) {
							$this->ErrorMsg = "Não existe Responsável com esse nome!";
						} else {
							$this->ErrorMsg = "Existe mais de uma Responsável com esse nome!";
						}
						return $this;
					}

					$st = $this->db->prepare("INSERT INTO CadMaqContatoResp 
												(CadMaqId, ContatoRespId) 
											VALUES 
												(:cadMaqId, :contatoRespId)");
					$st->bindParam(':cadMaqId', $cadMaqId);
					$st->bindParam(':contatoRespId', $idResp);
					
					$st->execute();

					$this->HasError = false;
					return $this;
				} catch (Exception $e) {
					$this->HasError = true;
					$this->ErrorMsg = "Não foi possível vincular o Responsável à máquina.";
					return $this;
				}
			} else {
				$this->HasError = true;
				$this->ErrorMsg = "Há campos sem conteúdo!";
				return $this;
			}
		}

	}

?>