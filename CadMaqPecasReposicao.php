<?php

	include_once('includes/verifyLogin.php');
	include_once('includes/tablePecasReposicao.php');

	
	if (empty($_GET['Id'])||!isset($_GET['Id'])) {
		$Id = 0;
	} else {
		$Id = (int)$_GET['Id'];
	}
	if ($Id == 0) {
		header('Location: MaquinasList.php');
	}
?>
<?php 
	require "header.php";
?>
	<main id="MainDiv" class="offset-2">
				<?php 
					if (isset($_POST['salvar'])) {
						include_once("includes/tableCadMaqPecasReposicao.php");
						
						$obj = new CadMaqPecasReposicao();
						
						$resp = $obj->InsertCadMaqPecasReposicao($Id,$_POST['nome'],$_POST['qtdeMinima']);

						if ($resp->HasError) {
							$_SESSION["MensagemFeedBack"] = $resp->ErrorMsg; 
						} else {
							$_SESSION["MensagemFeedBack"] = 'Peça vinculada com sucesso!';
						}
						header('Location: MaquinasList.php');
					} else {
						
					}
				?>

		<?php 			
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

			//titulo da página
			include_once('includes/pageGenerateTitulo.php');			
			generateTitulo("Vincular peça de reposição à máquina ".$resp->MaqDados["Nome"]);			
		?>

			<div class="customDiv">

				<form action=<?php echo '"CadMaqPecasReposicao.php?Id='.$_GET['Id'].'"';?> method="POST">

			
				<div class="form-group row">
						<label for="input2" class="col-2 col-form-label required">Nome da peça</label>
						<div class="col-sm-10">
						<select class= "col-4 form-control" required name="nome">
						<option value="">Selecione uma peça</option>
						<?php
							$peca = new PecasReposicao();
							$arrayPecas = $peca->getPecasReposicao();//busca as peças do banco de dados 
							if(!empty($arrayPecas)){//verifica se retornou algo do banco
								foreach($arrayPecas->pecas as $value)//para cada item que veio do banco cria uma option
									{
										?>
										<option value0=<?=$value['Nome'] ?>><?=$value['Nome']?></option>
										<?php   
									}
							}
						?>   
						</select>
						</div>
					</div>


					<div class="form-group row">
						<label for="input1" class="col-2 col-form-label required">Quantidade Mínima</label>
						<div class="col-sm-10">
						    <input type="number" class="form-control customInputForm" name='qtdeMinima' id="input2">
						</div>
					</div>

				  <br>
				  <button type="submit" name="salvar" class="btn btn-primary" style="margin-bottom: 10px;">Adicionar Peça</button>
				  <a href="MaquinasList.php" class="btn btn-secondary" style="margin-bottom: 10px;">Voltar</a>
				</form>
				
			</div>
	</main>
<?php 
	require "footer.php";
?>