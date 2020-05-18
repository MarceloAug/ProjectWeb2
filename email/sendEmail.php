<?php 
	
  //include_once('../includes/connection.php');
  //include_once("../includes/tableCadMaq.php");

    require_once 'PHPMailer-5.2.14/PHPMailerAutoload.php';

  //$maquina = new CadMaq();
  //$maqList = $maquina->getCadMaqManutencao();

//if(!empty($maqList)){

    //foreach($maqList->maq as $value){

      $M = new PHPMailer();

      # $M->SMTPDebug = 2; # Somente para debug
      $M->isSMTP(); # Informamos que é SMTP
      $M->Host = 'smtp.gmail.com'; # Colocamos o host de envio de e-mail.
      $M->SMTPAuth = true; # Informamos que terá autenticação de SMTP.
      $M->Username = '4mweb2@gmail.com'; # Usuário
      $M->Password = 'web212345'; # Senha
      $M->Port = 465; # Porta de disparo.
      $M->SMTPSecure = 'ssl'; # Caso tenha segurança.

      $M->From = '4mweb2@gmail.com'; # Remetente do disparo.
      $M->FromName = 'Suporte Novus'; # Nome do remetente.
      $M->addAddress('marcelomab09@gmail.com', 'Marcelo Bombril'); # Destinatário.
      $M->isHTML(); # Informamos que o corpo tem o formato HTML.
      $M->Subject = 'Manutencao de Maquina'; # Assunto da mensagem.
      # Corpo da mensagem:
      $M->Body = "<html><head></head><body><h1>Teste para manutenção de maquinas!!!</h1></body></html>";

      # Enviamos:
      if (!$M->send())
        echo "Não foi possível enviar a mensagem. Erro: " . $M->ErrorInfo; 
      else
        echo 'Mensagem Enviada com Sucesso';

  //}
//}