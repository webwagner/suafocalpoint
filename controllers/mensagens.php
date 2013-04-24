<?php
if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

$pessoa = 'DE';

/**
* pega o total de cada tipo de mensagem e soma 
*/
$mapper = new Mapper();
$mapper->setDbTable(new Mensagens());

$mapper->setWhere('corretor_enviou_id = "'.$_SESSION['usuario_logado']->id.'" and exclui_enviou = "NAO"');
$enviadas = $mapper->getTotal();

$mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and solicitacao = "SIM" and exclui_recebeu = "NAO"');
$solicitacoes = $mapper->getTotal();

$mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and solicitacao = "NAO" and exclui_recebeu = "NAO"');
$recebidas = $mapper->getTotal();

$mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and lida_recebeu = "NAO" and exclui_recebeu = "NAO"');
$total_recebidas_naolidas = $mapper->getTotal();

/**
* lista as mensagens do corretor paginando
*/
$mapper = new Mapper();
$mapper->setDbTable(new Mensagens());

if(url(3) == 'enviadas'){
    $mapper->setWhere('corretor_enviou_id = "'.$_SESSION['usuario_logado']->id.'" and exclui_enviou = "NAO"');
    $url = $_SESSION['login'].'/mensagens/enviadas';
    $pessoa = 'PARA';
}
else if(url(3) == 'solicitacoes'){
    $mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and solicitacao = "SIM" and exclui_recebeu = "NAO"');
    $url = $_SESSION['login'].'/mensagens/solicitacoes';
}
else{
    $mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and solicitacao = "NAO" and exclui_recebeu = "NAO"');
        $url = $_SESSION['login'].'/mensagens/recebidas';

}

$total = $mapper->getTotal();

if($total > 0){
    if(url(4))
        $n = url(4);
    else
        $n = 0;

    $quant_per_pag = 10;    
    $paginacao = new Paginacao($n, $total, $quant_per_pag);  

    $mapper->setInicial($paginacao->inicial());  
    $mapper->setNumreg($quant_per_pag);                
    $rows = $mapper->getRows();
        
    if($total > $quant_per_pag)
        $html_paginacao = $paginacao->pagination($url);
    else
        $html_paginacao = ''; 
    
    $html_mensagens = '';
    
    /**
    * Inicializa a classe do corretor
    */
    $mapper_corretor = new Mapper();
    $mapper_corretor->setDbTable(new Corretor);
    
    foreach($rows as $row){
        
        /**
        * se for mensagem enviada pega o corretor que recebeu senão pega o corretor que enviou
        */
        if(url(3) == 'enviadas'){
            $mapper_corretor->setWhere('id = "'.$row->corretor_recebeu_id.'"');
            $lida = $row->lida_enviou;
            $lida_env_rec = 'enviou';
        }
        else{
            $mapper_corretor->setWhere('id = "'.$row->corretor_enviou_id.'"');
            $lida = $row->lida_recebeu;
            $lida_env_rec = 'recebeu';
        }
        
        $corretor = $mapper_corretor->getRow();
        
        if($lida == "SIM")
            $classe = 'iten-off';
        else
            $classe = '';
        
        if(strlen($row->texto) >= 50)
            $texto = txtReduce($row->texto,50);
        else
            $texto = $row->texto;
            
        if($corretor->foto_perfil != "")
           $foto = URL_ABSOLUTE.'static/uploads/fotos/'.$corretor->login.'/'.$corretor->foto_perfil;
        else
           $foto = URL_ABSOLUTE.'static/img/perfil-focalpoint.jpg';

        $html_mensagens .= '<tr class="iten '.$classe.'">
                <td><input type="checkbox" class="checks" name="id2" value="'.$row->id.'" /></td>
                <td><a href="'.$corretor->login.'">'.ImgRender($foto, 55, 52, $corretor->nome).'<span>'.$corretor->nome.'</span></a></td>
                <td class="assunto"><a href="'.$_SESSION['login'].'/mensagem/'.$row->id.'"><strong>'.$row->assunto.'</strong><br />'.$texto.'</a></td>
                <td>'.$row->data.'</td>
              </tr>';
                
    }    
}
else{
    $html_mensagens = '';
    $html_paginacao = '';
    $lida_env_rec = '';
}

include('views/mensagens.php');