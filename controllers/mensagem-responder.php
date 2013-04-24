<?php

if($_POST){
    /**
    * cria a mensagem de resposta
    */
    $date = date("d/m/Y H:i:s");
    $data = array("corretor_enviou_id" => $_POST['corretor_envia'], "corretor_recebeu_id" => $_POST['corretor_recebe'], "solicitacao" => $_POST['solicitacao'], "assunto" => $_POST['assunto'], "texto" => $_POST['texto'], "lida_recebeu" => "NAO", "lida_enviou" => "SIM", "data" => $date, "exclui_recebeu" => "NAO", "exclui_enviou" => "NAO");

    $mapper = new Mapper();
    $mapper->setDbTable(new Mensagens());
    $mapper->saveOrUpdate($data);
    
    echo '<script>location.href = "'.$_SESSION['login'].'/mensagem-sucesso";</script>';    
}
else{
    echo '<script>location.href = "home/pagina-nao-existe";</script>';    
}

