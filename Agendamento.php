<?php 



include_once("includes/tableMovMaq.php");
if (isset($_GET['Id'])) {
    $id = $_GET['Id'];
}


if(isset($_POST['DataInicial']) && isset($_POST['periodo']) && isset( $_POST['qtd']) && isset($_POST['recorrencia']) && isset($_POST['diaSemana'])){

    $maquina = new MovMaq();
    $maquina->Agendamento($id,$_POST['DataInicial'],$_POST['periodo'],$_POST['qtd'],$_POST['recorrencia'],$_POST['diaSemana']);
    header('Location: MaquinasList.php');    

}

?>
<?php 
	require "header.php";
?>
<main id="MainDiv" class="offset-2">
     
    <div class="container">
        
        // <form <?php echo '"Agendamento.php?Id='.$id.'"'; ?> method="POST">

        <h3>Agendamento</h3>

        <h5><b><br/>Hoje é <?php echo date("d/m/Y")?></b></h5>
        <h6>Vamos agendar seu agendamento de manutenção?<br/><br/></h6>	
        
            <div class="form-group row" >
                <label for="tipoPeriodoId" class="col-2 col-form-label required">Apartir de</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control customInputForm" name='DataInicial' id="DataInicial" value="">
                </div>
            </div>
               
        
            <div class="form-group row">
                <label class="col-2 col-form-label required" for="tipoPeriodoId">Período</label>
                <div class="col-sm-3">
                    <select name="periodo" class="form-control">
                        <option value="">Escolha o periodo</option>
                        <option value="1">Mensal</option>
                        <option value="3">Trimestral</option>
                        <option value="6">Semestral</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label required"  for="Quantidade">Quantidade</label>
                <div class="col-sm-3">
                    <input type="number" id="quantity" class = "col-4 form-control" name="qtd" min="1" max="12" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 col-form-label required" for="tipoSemanaId">Recorrência da Semana</label>
                <div class="col-sm-3">
                    <select name="recorrencia" class="form-control">
                        <option value="">Escolha a semana </option>
                        <option value="7">1ª Semana</option>
                        <option value="14">2ª Semana</option>
                        <option value="21">3ª Semana</option>
                        <option value="28">4ª Semana</option>
                    </select>
                </div>
            </div>
            
            <div class = "form-group row">
                <label class="col-2 col-form-label required" for="tipoSemanaId">Toda</label>
                <div class="col-sm-3">
                    <select name="diaSemana"  class="form-control">
                        <option value="">Selecione o dia da semana</option>
                        <option value="monday">Segunda-feira</option>
                        <option value="tuesday">Terça-feira</option>
                        <option value="wednesday">Quarta-feira</option>
                        <option value="thursday">Quinta-feira</option>
                        <option value="friday">Sexta-feira</option>
                        <option value="saturday">Sabado</option>
                        <option value="sunday">Domingo</option>
                    </select>
                </div>
            </div>

            &emsp; <button type="submit" class="btn btn-secondary" style="margin-bottom: 10px;">Voltar</button> &emsp; 
            &emsp; <button type="submit" class="btn btn-secondary" style="margin-bottom: 10px;">Salvar Alterações</button>
       
        </form>
    </div> 
</main>

