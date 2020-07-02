<?php 

	include_once('connection.php');

	class MovMaq {

		public $HasError;
	    public $ErrorMsg;
	    public $MaqDados = array();
	    public $maq = array();

		private $db;

		public function __construct() {
			$this->db = new Connection();
			$this->db = $this->db->dbConnect();
		}

		function getMovMaq() {
			$st = $this->db->prepare("SELECT 
									MovMaq.Id \"Id\",
									CadMaq.Nome \"Nome da Máquina\",
									CadMaq.Descricao \"Descrição da Máquina\",
									MovMaq.DtMovto \"Data do Log\",
									MovMaq.Descricao \"Descrição do Log\",
									HistMov.Descricao \"Descrição do Histórico\" 
								FROM CadMaq
								INNER JOIN MovMaq ON CadMaq.Id = MovMaq.CadMaqId
								INNER JOIN HistMov ON HistMov.Id = MovMaq.HistMovId
								LEFT JOIN MovCadMaq ON MovMaq.Id = MovCadMaq.MovMaqId
								ORDER BY MovMaq.DtMovto DESC");

			if ($st->execute()) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->maq[] = $row;
				}
				if (empty($this->maq)) {
					$this->HasError = true;
					$this->ErrorMsg = "Erro - Lista de Logs de Máquinas vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		function getMovMaqById($Id) {
			if(!empty($Id)) {
				$st = $this->db->prepare("SELECT 
											CASE WHEN MovCadMaq.Id IS NULL THEN CadMaq.Nome
											ELSE MovCadMaq.Nome END \"NomeMaq\", 
											CASE WHEN MovCadMaq.Id IS NULL THEN CadMaq.Nome
											ELSE MovCadMaq.Descricao END \"DescMaq\" ,
											MovMaq.Descricao \"DescMov\" ,
											HistMov.Descricao \"DescHist\" ,
											MovMaq.DtMovto \"DtMov\",
											MovMaq.DtManutencao \"DtManutencao\",
											HistMov.Id \"HistMovId\"
										FROM CadMaq
										INNER JOIN MovMaq ON CadMaq.Id = MovMaq.CadMaqId
										INNER JOIN HistMov ON HistMov.Id = MovMaq.HistMovId
										LEFT JOIN MovCadMaq ON MovCadMaq.MovMaqId = MovMaq.Id
										WHERE MovMaq.Id = ?");
				$st->bindParam(1, $Id);
				$st->execute();

				if ($st->rowCount()==1) {
					$this->HasError = false;
					$this->MaqDados = $st->fetch(PDO::FETCH_ASSOC);
					return $this;
				} else {
					$this->HasError = true;
					$this->ErrorMsg = "Erro - Não existe Log com esse Id ($Id).";
					return $this;
				}
			} else {
				$this->HasError = true;
				$this->ErrorMsg = "Erro - Preencha o campo 'Id' na função 'getMaquinaDadosMov(Id)'.";
				return $this;
			}
		}
		
		function getMovMaqCustom($maqNome,$tipoHistId) {
			$st = $this->db->prepare("SELECT 
									MovMaq.Id \"Id\", 
									CASE WHEN MovCadMaq.Id IS NULL 
									THEN CadMaq.Nome
									ELSE MovCadMaq.Nome END \"Nome da Máquina\", 
									CASE WHEN MovCadMaq.Id IS NULL 
									THEN CadMaq.Descricao
									ELSE MovCadMaq.Descricao END \"Descrição da Máquina\" ,
									MovMaq.DtMovto \"Data do Log\",
									MovMaq.Descricao \"Descrição do Log\" ,
									HistMov.Descricao \"Descrição do Histórico\" 
								FROM CadMaq
								INNER JOIN MovMaq ON CadMaq.Id = MovMaq.CadMaqId
								INNER JOIN HistMov ON HistMov.Id = MovMaq.HistMovId
								LEFT JOIN MovCadMaq ON MovMaq.Id = MovCadMaq.MovMaqId
								WHERE (MovCadMaq.Nome like '%$maqNome%' OR CadMaq.Nome like '%$maqNome%')
								AND (HistMov.Id = '$tipoHistId' OR '$tipoHistId' = '')
								ORDER BY MovMaq.DtMovto DESC");
			
			$st->execute();
			if ($st->rowCount()==0) {
				$this->HasError = false;
				return $this;
			}
				

			if ($st->rowCount()>0) {
				while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
					$this->maq[] = $row;
				}
				if (empty($this->maq)) {
					$this->HasError = true;
					$this->ErrorMsg = "Erro - Lista de Logs de Máquinas vazia.";
					return $this;
				} else {
					$this->HasError = false;
					return $this;
				}
			}
		}

		function Agendamento($id,$data,$periodo,$qtd,$recorrencia,$dia){
			
			for($i=0;$i < $qtd; $i++){
				if(!isset($date)){
					$date =  date("Y-m-d",strtotime($data ."+".$periodo." month"));
				}else{

					$date =  date("Y-m-d",strtotime($date ."+".$periodo." month"));
				}
				
				$dateAux = date("Y-m-d",strtotime($date ."+".$recorrencia." days"));
			
				switch ($dia) {
					case 'monday':
						$dtManutencao = date('Y-m-d', strtotime($dateAux.' monday this week'));
						break;

					case "tuesday":
						$dtManutencao = date('Y-m-d', strtotime($dateAux.' tuesday this week'));
						break;

					case "wednesday":
						$dtManutencao = date('Y-m-d', strtotime($dateAux.' wednesday this week'));
						break;

					case "thursday":
						$dtManutencao = date('Y-m-d', strtotime($dateAux.' thursday this week'));
						break;

					case "friday":
						$dtManutencao = date('Y-m-d', strtotime($dateAux.' friday this week'));
						break;

					case "saturday":
						$dtManutencao = date('Y-m-d', strtotime($dateAux.' saturday this week'));
						break;

					case "sunday":
						$dtManutencao = date('Y-m-d', strtotime($dateAux.' sunday this week'));
						break;
				}
						$dateformat = date_create($dtManutencao);
						$dtManutencao = date_format($dateformat, 'Y-m-d H:i:s');
						$st = $this->db->prepare("INSERT INTO MovMaq (CadMaqId,HistMovId,Descricao,DtMovto,TipoManutencaoId,dtManutencao) 
						VALUES ('{$id}','MANUTENCAO','Manutencao de agendamento da maquina {$id}',CURRENT_TIMESTAMP(),'P','{$dtManutencao}')");

			
						$st->execute();
						
			}
		}


		function filtraManutencaoPeriodo($datade,$dataate,$tipoMan,$responsavel){
			
			
			$filtro = '';

			if(!empty($datade) && !empty($dataate)){
				if($filtro == ""){
					$filtro ="WHERE CAST(MovMaq.DtManutencao AS DATE) BETWEEN '{$datade}' and '{$dataate}'";
				}else{

					$filtro =  $filtro ." AND CAST(MovMaq.DtManutencao AS DATE) BETWEEN '{$datade}' and '{$dataate}'";
				}
			}

			if(!empty($tipoMan)){
				
				if($filtro == ""){
					$filtro =  "WHERE MovMaq.TipoManutencaoId = '{$tipoMan}'";
				}else{

					$filtro =  $filtro . " AND MovMaq.TipoManutencaoId = '{$tipoMan}'";
				}
				
			}

			if(!empty($responsavel)){
				if($filtro == ""){
					$filtro =  "WHERE CadMaqContatoResp.ContatoRespId = '{$responsavel}'"; 
				}else{

					$filtro = $filtro . " AND CadMaqContatoResp.ContatoRespId = '{$responsavel}'"; 
				}
			}
			
		
			$sql = "SELECT MovMaq.CadMaqId,MovMaq.Descricao,MovMaq.HistMovId, MovMaq.DtMovto, MovMaq.DtManutencao
			FROM MovMaq
			INNER JOIN CadMaqContatoResp ON MovMaq.CadMaqId = CadMaqContatoResp.CadMaqId " . $filtro;

		
		 
			$st = $this->db->prepare($sql);
		
			$st->execute();
		if ($st->rowCount()==0) {
			$this->HasError = false;
			return $this;
		}
		
		if ($st->rowCount()>0) {
			while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
				$this->maq[] = $row;
			}
			if (empty($this->maq)) {
				$this->HasError = true;
				$this->ErrorMsg = "Erro - Lista de Logs de Máquinas vazia.";
				return $this;
			} else {
				$this->HasError = false;
				return $this;
			}
		}
		
		
	}


	function filtraManutencao(){
          
		$st = $this->db->prepare("SELECT CadMaqId,Descricao,HistMovId, DtMovto, DtManutencao
								FROM MovMaq");
	
		$st->execute();
	if ($st->rowCount()==0) {
		$this->HasError = false;
		return $this;
	}
	
	if ($st->rowCount()>0) {
		while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
			$this->maq[] = $row;
		}
		if (empty($this->maq)) {
			$this->HasError = true;
			$this->ErrorMsg = "Erro - Não foi possível encontrar lista de manutenção.";
			return $this;
		} else {
			$this->HasError = false;
			return $this;
		}
	}
}


	}

?>