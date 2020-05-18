<?php

ignore_user_abort(true);
set_time_limit(0);

$path = $_SERVER['DOCUMENT_ROOT']."/ProjectWeb2/arquivos/"; //diretorio deve existir dentro da pasta principal do projeto(pasta arquivos)

$dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $_GET['download_file']); //validacao do nome
$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL); //filtro para remover caracteres invalidos
$fullPath = $path.$dl_file;

if ($fd = fopen ($fullPath, "r")) {//read//
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);  //controle das extensoes
    switch ($ext) {                               //dependendo da opcao o content type abre direto no navegador
        case "pdf":
            header("Content-type: application/pdf");
            header("Content-Disposition: inline; filename=\"".$_GET['nome']."\"");
            @readfile('files/nome.pdf');
        break;
        case "jpg":
            header("Content-type: image/jpg");
            header("Content-Disposition: inline; filename=\"".$_GET['nome']."\"");
            @readfile('files/nome.jpg');
        break;
        case "txt":
            header("Content-type: text/txt");
            header("Content-Disposition: inline; filename=\"".$_GET['nome']."\"");
            @readfile('files/nome.txt');
        break;
        case "png":
            header("Content-type: image/png");
            header("Content-Disposition: inline; filename=\"".$_GET['nome']."\"");
            @readfile('files/nome.png');
        break;
       
        default;
            header("Content-type: application/octet-stream");
            header("Content-Disposition: filename=\"".$_GET['nome']."\"");
        break;
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); 
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
fclose ($fd);
exit;