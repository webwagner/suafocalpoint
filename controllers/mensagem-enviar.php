<?php
if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

if($_POST){
    $date = date("d/m/Y H:i:s");
    
    $data = array("corretor_enviou_id" => $_POST['id_enviou'], "corretor_recebeu_id" => $_POST['id_recebeu'], "assunto" => $_POST['assunto'], "texto" => $_POST['texto'], "lida_enviou" => "SIM", "data" => $date, "solicitacao" => $_POST['solicitacao']);
    
    $mapper = new Mapper;
    $mapper->setDbTable(new Mensagens());
    $mapper->saveOrUpdate($data);
    
    echo '<script>location.href = "'.$_SESSION['login'].'/mensagem-sucesso";</script>';    
}
else{
    /**
    * pega o corretor
    */
    $mapper_corretor = new Mapper();
    $mapper_corretor->setDbTable(new Corretor);
    $mapper_corretor->setWhere('id = "'.url(3).'"');

    if($mapper_corretor->getRow()){
        
        $corretor = $mapper_corretor->getRow();

        if($corretor->foto_perfil != "")
           $foto = URL_ABSOLUTE.'static/uploads/fotos/'.$corretor->login.'/'.$corretor->foto_perfil;
        else
           $foto = URL_ABSOLUTE.'static/img/perfil-focalpoint.jpg';
        
        
        $img = ImgRender($foto, 55, 52, $corretor->nome);

        /**
        * pega o total de cada tipo de mensagem e soma 
        */
        $mapper = new Mapper();
        $mapper->setDbTable(new Mensagens());

        $mapper->setWhere('corretor_enviou_id = "'.$_SESSION['usuario_logado']->id.'"');
        $enviadas = $mapper->getTotal();

        $mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and solicitacao = "SIM"');
        $solicitacoes = $mapper->getTotal();

        $mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and solicitacao = "NAO"');
        $recebidas = $mapper->getTotal();

        $total_geral = $enviadas + $solicitacoes + $recebidas;
        
        if(url(4) == 'solicitacao'){
            $solicitacao = 'SIM';
            
            /**
            * pega o imóvel
            */
            $mapper_imovel = new Mapper();
            $mapper_imovel->setDbTable(new Imovel);
            $mapper_imovel->setWhere('id = "'.url(5).'"');
            
            if($mapper_imovel->getRow()){
                $imovel = $mapper_imovel->getRow();

                $assunto = 'Solicitação de visita ao imóvel '.$imovel->titulo;
                $mensagem = 'Olá '.$corretor->nome.' gostaria de solicitar uma visita ao imóvel '.$imovel->titulo;
            }
        }
        else{
            $solicitacao = 'NAO';
        }
        
        include('views/mensagem-enviar.php');
    }
    else{
        echo '<script>location.href = "home/pagina-nao-existe";</script>';   
    }
}