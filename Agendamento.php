<?php 
if(isset($_POST['DataInicial'])){
    

}
?>
<?php 
	require "header.php";
?>
<main id="MainDiv" class="offset-2">
     <div class="customDiv">
        <h4 class="modal-title"><b>Hoje é <?php echo date("d/m/Y")?></b>. Faça o seu agendamento de manutenção</h4>
                       
        <form action= "./Agendamento.php" method="POST">	
        
            <div class="form-group" >
                <div class="col-sm-auto">
                <label for="tipoPeriodoId"><b>Apartir de</b></label>
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

            <div class="form-group">
                <label for="tipoSemanaId"><b>Recorrência da Semana</b></label>
                <select    name="recorrencia">
                    <option value="0">Semanalmente</option>
                    <option value="1">1ª Semana</option>
                    <option value="2">2ª Semana</option>
                    <option value="3">3ª Semana</option>
                    <option value="4">4ª Semana</option>
                </select>
            </div>
            
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

            <button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
       
        </form>
     </div> 
</main>

