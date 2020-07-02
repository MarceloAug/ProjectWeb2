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
     <div class="customDiv">
        <h4 class="modal-title"><b>Hoje é <?php echo date("d/m/Y")?></b>. Faça o seu agendamento de manutenção</h4>
                       
        <form <?php echo '"Agendamento.php?Id='.$id.'"'; ?> method="POST">	
        
            <div class="form-group" >
                <div class="col-sm-auto">
                <label for="tipoPeriodoId"><b>Apartir de</b></label>
                    <input type="date" class="form-control customInputForm" name='DataInicial' id="DataInicial" value=""  required?>
            </div>
               
        
            <div class="form-group">
                <label for="tipoPeriodoId"><b>Período</b></label>
                <select name="periodo" class="form-control" required>
                    <option value="">EScolha o periodo</option>
                    <option value="1">Mensal</option>
                    <option value="3">Trimestral</option>
                    <option value="6">Semestral</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Quantidade">Qtd:</label>
                <input type="number" id="quantity" name="qtd" min="1" max="12" required>
            </div>

            <div class="form-group">
                <label for="tipoSemanaId"><b>Recorrência da Semana</b></label>
                <select    name="recorrencia" required >
                    <option value="">Escolha a semana </option>
                    <option value="7">1ª Semana</option>
                    <option value="14">2ª Semana</option>
                    <option value="21">3ª Semana</option>
                    <option value="28">4ª Semana</option>
                </select>
            </div>
            
            <div class = "form-row">
                <label for="tipoSemanaId"><b>Toda a:</b></label>
                <select    name="diaSemana" required >
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

            <button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
       
        </form>
     </div> 
</main>

