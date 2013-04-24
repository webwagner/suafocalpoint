<?php
if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

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

/**
* pega a mensagem
*/
$mapper->setWhere('id = "'.url(3).'"');

if($mapper->getRow()){
    $mensagem = $mapper->getRow();
    
    /**
    * se for mensagem enviada pega o corretor que recebeu senão pega o corretor que enviou
    */
    $mapper_corretor = new Mapper();
    $mapper_corretor->setDbTable(new Corretor);

    if($_SESSION['usuario_logado']->id == $mensagem->corretor_enviou_id){
        $mapper_corretor->setWhere('id = "'.$mensagem->corretor_recebeu_id.'"');
        $id_recebe = $mensagem->corretor_recebeu_id;
        
        /**
        * seta a mensagem para lida
        */
        if($mensagem->lida_enviou == "NAO")
            $mapper->saveOrUpdate (array("id" =>$mensagem->id, "lida_enviou" => "SIM"));
    }
    else{
        $mapper_corretor->setWhere('id = "'.$mensagem->corretor_enviou_id.'"');
        $id_recebe = $mensagem->corretor_enviou_id;
        
        /**
        * seta a mensagem para lida
        */
        if($mensagem->lida_recebeu == "NAO")
            $mapper->saveOrUpdate (array("id" =>$mensagem->id, "lida_recebeu" => "SIM"));
    }
    
    $corretor = $mapper_corretor->getRow();
    
    if($corretor->foto_perfil != "")
       $foto = URL_ABSOLUTE.'static/uploads/fotos/'.$corretor->login.'/'.$corretor->foto_perfil;
    else
       $foto = URL_ABSOLUTE.'static/img/perfil-focalpoint.jpg';
    
    $img = ImgRender($foto, 55, 52, $corretor->nome);
    
    include('views/mensagem.php');
}
else{
    echo '<script>location.href = "home/pagina-nao-existe";</script>';    
}

