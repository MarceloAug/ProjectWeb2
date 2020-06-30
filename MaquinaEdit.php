<?php

	include_once('includes/verifyLogin.php');
	include_once('includes/tableContatoResp.php');

	if (empty($_GET['IsEdit']) || !isset($_GET['IsEdit'])) {
		$IsEdit = (bool)"0";
	} else {
		if (strtolower($_GET['IsEdit']) == "true" || $_GET['IsEdit'] == "1" || strtolower($_GET['IsEdit']) == "on") {
			$IsEdit = (bool)"1";
		} else {
			$IsEdit = (bool)"0";
		}
	}
	if (empty($_GET['Id'])||!isset($_GET['Id'])) {
		$Id = 0;
	} else {
		$Id = (int)$_GET['Id'];
	}
?>
<?php 
	require "header.php";
?>
	<main id="MainDiv" class="offset-2">
				<?php
				
				
					if (isset($_POST['salvar'])) {
						include_once("includes/tableCadMaq.php");
						if ($Id == 0) {
							//Insert
							$obj = new CadMaq();
							$resp = $obj->InsertCadMaq($_POST['nome'],$_POST['descricao'],$_POST['caracteristicas'],
														$_POST['patrimonio'],$_POST['periodoManutencao'],$_POST['avisoAntes'],'',$_POST['contatoNome']);

							if ($resp->HasError) {
								$_SESSION["MensagemFeedBack"] = $resp->ErrorMsg; 
							} else {
								$_SESSION["MensagemFeedBack"] = 'Máquina criada com sucesso!';
							}
							header('Location: MaquinasList.php');
						} elseif ($Id <> 0 && $IsEdit) {
							//Update
							$obj = new CadMaq();
							$resp = $obj->UpdateCadMaq($Id,$_POST['nome'],$_POST['descricao'],$_POST['caracteristicas'],
														$_POST['patrimonio'],$_POST['periodoManutencao'],$_POST['avisoAntes'],
														'');
							if ($resp->HasError) {
								$_SESSION["MensagemFeedBack"] = $resp->ErrorMsg; 
							} else {
								$_SESSION["MensagemFeedBack"] = 'Máquina alterada com sucesso!';
							}
							header('Location: MaquinasList.php');
						}

					} else {
						
					}
				?>

		<?php 
			if ($Id != 0) {
				include_once('includes/tableCadMaq.php');
				try {
					
					$object = new CadMaq();
					$resp = $object->getCadMaqById($Id);
					if ($resp->HasError) {
						throw new Exception($resp->ErrorMsg);
					}
				} catch (Exception $e) {
					include_once('includes/pageGenerateTitulo.php');
					generateTitulo($e->getMessage());
					die();
				}
			}

			//titulo da página
			include_once('includes/pageGenerateTitulo.php');
			if ($Id == 0) {
				generateTitulo("Adicionar Máquina");
			} else if ($Id <> 0 && $IsEdit) {
				generateTitulo("Editar Máquina ".$resp->MaqDados["Nome"]);
			} else if ($Id <> 0 && !$IsEdit) {
				generateTitulo("Máquina ".$resp->MaqDados["Nome"]);
			}
		?>
			<div class="customDiv">
				<form action=<?php echo '"MaquinaEdit.php?IsEdit='.$_GET['IsEdit'].'&Id='.$_GET['Id'].'"'; ?> method="POST">

				  <div class="form-group row">
				    <label for="input1" class="col-2 col-form-label required">Nome</label>
				    <div class="col-sm-10">
					    <input type="text" required
					      	<?php if ($Id <> 0 && !$IsEdit) {echo 'readonly';} ?> 
					      	class="form-control customInputForm" name='nome' id="input1" 
					      	value=<?php 
								      	if ($Id <> 0) {
								      		echo '"'.$resp->MaqDados["Nome"].'"'; 
								      	} else {
								      		echo '""'; 
								      	}
					      			?>
					    >
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="input2" class="col-2 col-form-label required">Descrição</label>
				    <div class="col-sm-10">
						<input type="text" required
							<?php if ($Id <> 0 && !$IsEdit) {echo 'readonly';} ?> 
							class="form-control customInputForm" name='descricao' id="input2" 
							value=<?php 
										if ($Id <> 0) {
											echo '"'.$resp->MaqDados["Descrição"].'"'; 
										} else {
											echo '""'; 
										}
									?>
						>
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="input2" class="col-2 col-form-label required">Características</label>
				    <div class="col-sm-10">
						<input type="text" required
							<?php if ($Id <> 0 && !$IsEdit) {echo 'readonly';} ?> 
							class="form-control customInputForm" name='caracteristicas' id="input3" 
							value=<?php 
										if ($Id <> 0) {
											echo '"'.$resp->MaqDados["Características"].'"'; 
										} else {
											echo '""'; 
										}
									?>
						>
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="input2" class="col-2 col-form-label required">Patrimônio</label>
				    <div class="col-sm-10">
						<input type="text" required
							<?php if ($Id <> 0 && !$IsEdit) {echo 'readonly';} ?> 
							class="form-control customInputForm" name='patrimonio' id="input4" 
							value=<?php 
										if ($Id <> 0) {
											echo '"'.$resp->MaqDados["Patrimônio"].'"'; 
										} else {
											echo '""'; 
										}
									?>
						>
				    </div>
				  </div>

				  <div class="form-group row">
				    <label for="input2" class="col-2 col-form-label required">Período de Manutenção (em dias)</label>
				    <div class="col-sm-10">
						<input type="number" required
							<?php /* if ($Id <> 0 && !$IsEdit) {echo 'readonly';}  */?> 
							class="form-control customInputForm" name='periodoManutencao' id="input5" 
							value=<?php 
										if ($Id <> 0) {
											echo '"'.$resp->MaqDados["Período de Manutenção (em dias)"].'"'; 
										} else {
											echo '""'; 
										}
									?>s
						>
				    </div>
					
				
				  </div> 
				
										
					 <div class="form-group row">
						<label for="input2" class="col-2 col-form-label required">Tempo, em dias, antes de mandar email de aviso</label>
						<div class="col-sm-10">
							<input type="number" required
								<?php if ($Id <> 0 && !$IsEdit) {echo 'readonly';} ?> 
								class="form-control customInputForm" name='avisoAntes' id="input6" 
								value=<?php 
											if ($Id <> 0) {
												echo '"'.$resp->MaqDados["Tempo, em dias, antes de mandar email de aviso"].'"'; 
											} else {
												echo '""'; 
											}
										?>
							>
						</div>
				  	</div>
											
			
				
				  <?php if ($Id == 0) { 
					?>
				<div class="form-group row">
						<label for="input1" class="col-2 col-form-label required">Nome do Responsável</label>
						<div class="col-sm-10">
							<select class= "col-4 form-control" required name="contatoNome">
							<option value="">Selecione um Responsável</option>
							<?php
								$responsavel = new ContatoResp();
								$arrayResp = $responsavel->getContatoResp();
								if(!empty($arrayResp)){
									foreach($arrayResp->responsaveis as $value)
										{
											?>
											<option value=<?=$value['Id'] ?>><?=$value['Nome']?></option>
											<?php   
										}
								}
							?>   
							</select>
						</div>
					</div>
					<?php
					  }
				  ?>
				  	<?php if (!empty($_GET['Id'])||!isset($_GET['Id'])) { ?>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#meuModal">Agendamento da Manutenção</button>	
					<?php } ?> 

				  <?php 
				  	if ($Id != 0) {

						echo '<h4 style="margin-top:20px;">Peças</h4>';

				  		include_once('includes/pageGenerateTableList.php');
				  		$cabecalho = array();
						$resp = array();

						$object = new CadMaq();
						$resp = $object->getPecasByCadMaqId($Id)->pecas;

						$url = 'Pecas';

						generateTableList($resp, $cabecalho, $url);




				  		echo '<h4 style="margin-top:20px;">Responsáveis</h4>';

				  		include_once('includes/pageGenerateTableList.php');
				  		$cabecalho = array();
						$resp = array();

						$object = new CadMaq();
						$resp = $object->getResponsaveisByCadMaqId($Id)->responsaveis;

						$url = 'Responsaveis';

						generateTableList($resp, $cabecalho, $url);




						echo '<h4 style="margin-top:20px;">Arquivos</h4>';

				  		include_once('includes/pageGenerateTableList.php');
				  		$cabecalho = array();
						$resp = array();

						$object = new CadMaq();
						$resp = $object->getArquivosByCadMaqId($Id)->arquivos;

						$url = 'Arquivos';

						generateTableList($resp, $cabecalho, $url);

				  	}
				  ?>

				  <br>
				  <?php if (($Id <> 0 && $IsEdit) || $Id == 0) {
				  	echo '<button type="submit" name="salvar" class="btn btn-primary" style="margin-bottom: 10px;">Salvar</button>';
				  } ?>
				  <a href="MaquinasList.php" class="btn btn-secondary" style="margin-bottom: 10px;">Voltar</a>
				</form>

			   	<!-- Optional JavaScript -->
				<!-- jQuery first, then Popper.js, then Bootstrap JS -->
				<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
				<!-- Modal -->
				<div id="meuModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
			
					<!-- Conteúdo do modal-->
						<div class="modal-content">
				
						<!-- Cabeçalho do modal -->
							<div class="modal-header">
								<h4 class="modal-title"><b>Hoje é <?php echo date("d/m/Y")?></b>. Faça o seu agendamento de manutenção</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
				
						<!-- Corpo do modal -->
						<div class="modal-body">
							<div class="container-fluid">
								<div class="row">
									<form action= "./Agendamento.php" method="POST">	
										<div class="col-sm-9">
										<div class="form-group row" name="Periodos">
											<div class="col-sm-auto">
												<b>A partir de</b> 
										</div>
											<input type="date" class="form-control customInputForm" name='DataInicial' id="DataInicial" value="" ?>
										</div>
										<div class="form-group">
											<label for="tipoPeriodoId"><b>Período</b></label>
											<select name="tipoPeriodoId" class="form-control">
												<option value="M">Mensal</option>
												<option value="T">Trimestral</option>
												<option value="S">Semestral</option>
												<option value="A">Anual</option>
											</select>
										</div>
										<div class="form-group">

											<label for="Quantidade">Qtd:</label>
											
											<input type="number" id="quantity" name="QuantidadePeriodo" min="1" max="12">
												
										</div>
											<div class = "form-row">
												<label for="tipoSemanaId"><b>Recorrência da Semana</b></label>
												<select    name="recorrencia">
													<option value="0">Semanalmente</option>
													<option value="1">1ª Semana</option>
													<option value="2">2ª Semana</option>
													<option value="3">3ª Semana</option>
													<option value="4">4ª Semana</option>
												</select>
											</div>
											

										</div>
											<div class="col-sm-auto" name="tipoDiaSemanaId">
											<div class = "form-row">
													<label for="tipoSemanaId"><b>Toda a:</b></label>
													<select    name="diaSemana">
														<option value="seg">Segunda-feira</option>
														<option value="ter">Terça-feira</option>
														<option value="Qua">Quarta-feira</option>
														<option value="Qui">Quinta-feira</option>
														<option value="Sex">Sexta-feira</option>
														<option value="Sab">Sexta-feira</option>
														<option value="Dom">Sexta-feira</option>
													</select>
												</div>
									</div>
							
									<!-- Rodapé do modal-->
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
										<button type="button" class="btn btn-primary">Salvar Alterações</button>
									</div>
								</form>
							</div>	
						</div>
					</div>
				</div>
			
			</div>
	</main>
<?php 
	require "footer.php";
?>