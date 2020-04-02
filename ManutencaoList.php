<?php
        include_once('includes/connection.php');
        include_once('includes/tableMovMaq.php');



    if(!isset($_POST["datade"]) && !isset($_POST["dataate"])){

        $manutencao = new MovMaq;
        $manList = $manutencao->filtraManutencao();


    }else{

        $manutencao = new MovMaq;
        $manList = $manutencao->filtraManutencaoPeriodo($_POST["datade"],$_POST["dataate"]);   
    }

    ?>
    <?php 
        require "header.php";
    ?>
        <main id="MainDiv" class="offset-2">

            <div style="width: 85%; margin-left: auto; margin-right: auto;">


                <form action=<?php echo 'ManutencaoList.php'?> method="POST">

                <h3>Pesquisa por Manutenção</h3>
                <div class="form-group row">
                    <label for="input1" class="col-2 col-form-label"> Data Inicial</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control customInputForm" name='datade' id="input1" 
                        value="" ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="input1" class="col-2 col-form-label">Data Final</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control customInputForm" name='dataate' id="input1" 
                        value="" ?>
                    </div>
                </div>

                <button type="submit" value="salvar" class="btn btn-secondary" style="margin-bottom: 10px;">Pesquisar</button>
                </form>
            </div>

            <div class="container">
        <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id da maquina</th>
                            <th>Descrição</th>
                            <th>Historico De Movimentação</th>
                            <th>Data de Movimentação</th>
                            <th>Data de Manutenção</th>    
                        </tr>
                    </thead>
                    <tbody>
                <?php
                        foreach ($manList->maq as $e){
                ?>
                            <tr>
                                <td><?=$e['CadMaqId']?></td>
                                <td><?=$e['Descricao']?></td>
                                <td><?=$e['HistMovId']?></td>
                                <td><?=$e['DtMovto']?></td>
                                <td><?=$e['DtManutencao']?></td>
                                <td ></td>
                            </tr>
                <?php 
                        }
                ?>
                    </tbody>
                </table>
            </div>
        </main>
    <?php 
        require "footer.php";
    ?>