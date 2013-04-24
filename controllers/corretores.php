<?php

if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";
    
$html_paginacao = '';   
$html_contatos = '';
$msg = '';
$total = 0;
$url = url().'/'.url(2).'/'.url(3).'/'.url(4);
$uri = explode('/',$_SERVER['REQUEST_URI']);

/**
* Pega as especialidades
*/
$mapper_imovel_tipo = new Mapper();
$mapper_imovel_tipo->setDbTable(new ImovelTipo());
$especialidades = $mapper_imovel_tipo->getRows();

/**
* Inicializa a classe de imóveis
*/
$mapper_imoveis = new Mapper();
$mapper_imoveis->setDbTable(new Imovel());

/**
* Cria a condição para a query
*/
if(url(3) == "letra"){
    $where = 'uf = "'.$_SESSION['usuario_logado']->uf.'" and (nome LIKE "'.url(4).'%" OR empresa LIKE "'.url(4).'%" OR pessoa_contato LIKE "'.url(4).'%") and id <> '.$_SESSION['usuario_visitado']->id.'';
}
else if(url(3) == "especialidade"){
    $mapper_uf = new Mapper();
    $mapper_uf->setDbTable(new ImovelUf());
    $mapper_uf->setWhere("uf = '".$_SESSION['usuario_logado']->uf."'");
    $uf = $mapper_uf->getRow();
    
    $mapper_imoveis->setWhere('uf_imovel = "'.$uf->id.'" and tipo_imovel_id = "'.url(4).'" and id_corretor <> "'.$_SESSION['usuario_visitado']->id.'"');
    $rows = $mapper_imoveis->getRows();
    if(count($rows) > 0){
        $where = 'uf = "'.$_SESSION['usuario_logado']->uf.'" and (';
        foreach ($rows as $row){
            $where .= 'id = '.$row->id_corretor.' or ';
        }
        $where = substr($where,0,-4).')';
    }
    else{
        $where = 'id = -1';
    }
}     
else{
    $where = 'uf = "'.$_SESSION['usuario_logado']->uf.'" and id <> '.$_SESSION['usuario_visitado']->id.'';
    $url = '';
}

if(isset($where)){
    /**
    * Pega os corretores
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Corretor());
    $mapper->setWhere($where);

    if(isset($uri[6]))
        $n = $uri[6];
    else if(isset($uri[4]))
        $n = $uri[4];
    else
        $n = 0;

    $quant_per_pag = 10;

    $total = $mapper->getTotal();

    $paginacao = new Paginacao($n, $total, $quant_per_pag);

    $mapper->setInicial($paginacao->inicial());  
    $mapper->setNumreg($quant_per_pag);  
    $corretores = $mapper->getRows();

    if($total > $quant_per_pag)
        $html_paginacao = $paginacao->pagination($url);
    
    /**
    * Inicializa a classe contatos
    */
    $mapper_contatos = new Mapper();
    $mapper_contatos->setDbTable(new Contatos());

    foreach($corretores as $row){
       
       /**
       * Verifica se são amigos
       */
       $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" and corretor_recebeu_id = "'.$row->id.'" or aceitou = "NAO" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" and corretor_recebeu_id = "'.$row->id.'"  or aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'" and corretor_enviou_id = "'.$row->id.'" or aceitou = "NAO" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'" and corretor_enviou_id = "'.$row->id.'"'); 
       $amigos = $mapper_contatos->getRow();
       
       if(!$amigos)
           $add = '<a href="javascript:void(0)" id="'.$row->id.'" rel="'.$row->nome.'" class="add-contato">ADICIONAR CONTATO</a><br clear="all" />';
       else
           $add = '';
       
       $mapper_imoveis->setWhere('id_corretor = "'.$row->id.'"');
       $total_imoveis_contato = $mapper_imoveis->getTotal();

       if($row->empresa != "")
           $empresa =  '<span class="nome">'.$row->empresa.'</span><br />';
       else
           $empresa = '';

       if($row->creci != "")
           $creci =  '<div class="n-creci">CRECI N&ordm; '.$row->creci.'</div>';
       else
           $creci = '';
       
       if($row->website != "")
           $website =  'Website: '.$row->website.'<br />';
       else
           $website = '';

       if($row->foto_perfil != "")
           $foto = URL_ABSOLUTE.'static/uploads/fotos/'.$row->login.'/'.$row->foto_perfil;
       else
           $foto = URL_ABSOLUTE.'static/img/perfil-focalpoint.jpg';

       $html_contatos .= '<div class="contato"><a href="'.$row->login.'">
          '.ImgRender($foto, 96, 91, $row->nome).'
          <div class="desc">
            <p>
                <span class="nome"><strong>'.$row->nome.'</strong> <font>('.$total_imoveis_contato.' im&oacute;veis)</font></span><br />   
                '.$empresa.'
            </p>
            <p class="dn">
                Endere&ccedil;o: '.$row->rua.', '.$row->numero.' - '.$row->bairro.' - '.$row->cidade.'/'.$row->uf.'<br />
                Email: '.$row->email.'<br />
                '.$website.'
                Tel.: '.$row->telefone.'
            </p>
            </div>            
          '.$creci.'
        </a>'.$add.'</div>';

    }
}
    
if(url(3) == "corretores")
    $msg .= 'Sua busca retornou '.$total.' resultado(s).';
else if(url(3) == "letra")
    $msg .= 'Você buscou por parceiros que iniciam com a letra '.url(4).'<br />Sua busca retornou '.$total.' resultado(s).';
else if(url(3) == "estado")
    $msg .= 'Você buscou por parceiros do '.url(4).'<br />Sua busca retornou '.$total.' resultado(s).';
else if(url(3) == "especialidade"){
    $mapper_imovel_tipo->setWhere('id = "'.url(4).'"');
    $imov_tipo = $mapper_imovel_tipo->getRow();
    $msg .= 'Você buscou por parceiros com a especialidade '.$imov_tipo->nome.'<br />Sua busca retornou '.$total.' resultado(s).';
}
    
include('views/corretores.php');
