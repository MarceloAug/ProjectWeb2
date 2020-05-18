<?php


include_once('./includes/tablePecasReposicao.php');
include_once('./includes/tableCadMaq.php');
include_once('./includes/tableUsuario.php');
include_once('./includes/tableContatoResp.php');    
include_once('./includes/tableArquivo.php');    
   //recebe a URL pagina que estava aberta e manda a ID para sua determinada funcao de exclusao(cada classe tem sua propria exclusao)

                //deletar as pecas
if($_GET['url']=="PecasEdit.php"){
    
        $deleta=new PecasReposicao();
        $deleta->DeletarPeca($_GET['Id']);
        //volta
        header('location: PecasList.php');

     }if($_GET['url']=='MaquinaEdit.php'){

        $deleta=new CadMaq();
        $deleta->DeletarMaquina($_GET['Id']);
        //volta
        header('location: MaquinasList.php');

    }if($_GET['url']=='UsuarioEdit.php'){

        $deleta=new Usuario();
        $deleta->DeletarUsuario($_GET['Id']);
        //volta
        header('location: UsuariosList.php');

    }if($_GET['url']=='ContatoRespEdit.php'){

        $deleta=new ContatoResp();
        $deleta->DeletarResponsavel($_GET['Id']);
        
        //volta
        header('location: ContatoRespList.php');

    }

    if($_GET['url']=='Arquivos'){

        $deleta=new Arquivo();
        $deleta->DeletarArquivo($_GET['Id']);
        
        //volta
        header("Location: ".$_SERVER['HTTP_REFERER']."");

    }



?>