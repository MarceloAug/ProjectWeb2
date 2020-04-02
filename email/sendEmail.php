<?php 
	
  include_once('../includes/connection.php');
  include_once("../includes/tableCadMaq.php");

  $maquina = new CadMaq();
  $maqList = $maquina->getCadMaqManutencao();

if(!empty($maqList)){

    foreach($maqList->maq as $value){

            
            // emails para quem será enviado o formulário
            $emailenviar = "marcelomab09@gmail.com";
            $destino = $value['EnderecoEmailAviso'];
            $assunto = "Manutenção de maquina ".  $value['EnderecoEmailAviso'];
            $msg = "A maquina ".$value['Nome']." irá ter uma manutenção em ". $value['AvisoAntesDays'] . " dias ";
       


            
            // É necessário indicar que o formato do e-mail é html
            
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: marcelomab09@gmail.com';
            //$headers .= "Bcc: $EmailPadrao\r\n";
            
            $enviaremail = mail($destino, $assunto, $msg, $headers);
            if($enviaremail){
               echo "email enviado com sucesso";
            }else{
                echo "deu erro";
            
            }
            // $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
            // echo " <meta http-equiv='refresh' content='10;URL=contato.php'>";
            // } else {
            // $mgm = "ERRO AO ENVIAR E-MAIL!";
            // echo "";
            // }
                    
    
    }
}
			
	
?>
=======

<?php 
	
	include_once('../includes/connection.php');
	include_once("../includes/tableCadMaq.php");
  
	$maquina = new CadMaq();
	$maqList = $maquina->getCadMaqManutencao();
  
  if(!empty($maqList)){
  
	  foreach($maqList->maq as $value){
  
			  
			  // emails para quem será enviado o formulário
			  $emailenviar = "marcelomab09@gmail.com";
			  $destino = $value['EnderecoEmailAviso'];
			  $assunto = "Manutenção de maquina ".  $value['EnderecoEmailAviso'];
			  $msg = "A maquina ".$value['Nome']." irá ter uma manutenção em ". $value['AvisoAntesDays'] . " dias ";
		 
  
  
			  
			  // É necessário indicar que o formato do e-mail é html
			  
			  $headers  = 'MIME-Version: 1.0' . "\r\n";
			  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			  $headers .= 'From: marcelomab09@gmail.com';
			  //$headers .= "Bcc: $EmailPadrao\r\n";
			  
			  $enviaremail = mail($destino, $assunto, $msg, $headers);
			  if($enviaremail){
				 echo "email enviado com sucesso";
			  }else{
				  echo "deu erro";
			  
			  }
			  // $mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
			  // echo " <meta http-equiv='refresh' content='10;URL=contato.php'>";
			  // } else {
			  // $mgm = "ERRO AO ENVIAR E-MAIL!";
			  // echo "";
			  // }
					  
	  
	  }
  }
			  
	  
  ?>
>>>>>>> Marcelo-Branch
