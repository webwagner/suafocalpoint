<?php
if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";
    
$msg = '';
$html_paginacao = '';   
$html_contatos = '';
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
* Pega os contatos
*/
$mapper = new Mapper();
$mapper->setDbTable(new Contatos());
$mapper->setWhere('(aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'") or (aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'")');
$contatos = $mapper->getRows();

/**
* Inicializa a classe de imóveis
*/
$mapper_imoveis = new Mapper();
$mapper_imoveis->setDbTable(new Imovel());
    
$id_contatos = array();

$total_contatos = count($contatos);

if($total_contatos > 0){

    $id_contatos[] = 'uf = "'.$_SESSION['usuario_logado']->uf.'" and ';

    if(url(3) == "letra")
        $id_contatos[] = 'nome LIKE "'.url(4).'%" and ';

    $id_contatos[] = '(';
    
    foreach($contatos as $row_contato){       

        if($row_contato->corretor_recebeu_id != $_SESSION['usuario_visitado']->id){     
            $id_contatos[] = 'id = '.$row_contato->corretor_recebeu_id.' or ';
            $amigos[] = $row_contato->corretor_recebeu_id;
        }
        if($row_contato->corretor_enviou_id != $_SESSION['usuario_visitado']->id){         
            $id_contatos[] = 'id = '.$row_contato->corretor_enviou_id.' or ';
            $amigos[] = $row_contato->corretor_enviou_id;
        }
        
    }
    
    $id_contatos[] = ')';
    
    if(url(3) == "especialidade"){
        unset($id_contatos);
        
        $id_contatos[] = 'uf = "'.$_SESSION['usuario_logado']->uf.'" and ';
        $id_contatos[] = '(';
        
        $q = 0;
        
        foreach($amigos as $id){
            $mapper_imoveis->setWhere('tipo_imovel_id = "'.url(4).'" and id_corretor = '.$id.'');
            if($mapper_imoveis->getRow()){
                $id_contatos[] = 'id = '.$id.' or ';
                $q++;
            }
        }
        
        if($q == 0){
            unset($id_contatos);
            $id_contatos[] = '(id = -1    ';
        }
        else{
             $id_contatos[] = ')';
        }
    }
    
    if(count($id_contatos) > 0){
   
        $where = substr(implode('',$id_contatos),0,-4).')';
        
        /**
        * Pega os corretores amigos, lista e pagina
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

        foreach($corretores as $row){

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
            </a></div>';

        }        
    }
    
    if(url(3) == "contatos")
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
        
}
else{
    $msg = 'Você não possui parceiros.';
}

include('views/contatos.php');
