<?php

if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

/**
* Pega a uf do corretor
*/
$mapper = new Mapper();
$mapper->setDbTable(new ImovelUf());
$mapper->setWhere('uf = "'.$_SESSION['usuario_logado']->uf.'"');
if(!$uf_corretor = $mapper->getRow())
    $uf_corretor->id = 1;

/**
* Pega a cidade do corretor
*/
$mapper = new Mapper();
$mapper->setDbTable(new ImovelCidade());

if($uf_corretor->uf == "SP"){
    $mapper->setWhere('id_uf = "'.$uf_corretor->id.'"');
    $cidades_sp = $mapper->getRows();
}

$mapper->setWhere('cidade = "'.$_SESSION['usuario_logado']->cidade.'"');
if(!$cidade_corretor = $mapper->getRow())
    $cidade_corretor->id = 1;
    
$mapper_bairro = new Mapper();
$mapper_bairro->setDbTable(new ImovelBairro());
$mapper_bairro->setWhere('id_cidade = "'.$cidade_corretor->id.'"');
$mapper_bairro->setOrder('bairro ASC');
$bairros = $mapper_bairro->getRows();

/**
* Lista os tipos de imóveis
*/
$mapper = new Mapper();
$mapper->setDbTable(new ImovelTipo());
$mapper->setOrder('id ASC');
$rows_tipo = $mapper->getRows();
   
$tipo = url(3);

/**
* apenas os que têm vencimento_contrato vazio
*/
$where = "vencimento_contrato = '' and ";
    
/**
* Seta o where do sql de acordo com o tipo
*/
switch ($tipo){

   case 'imoveis-todos' :
       $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id;
       $rand = true;
       break;
   case 'imoveis-recentes' :
       $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id;
       break;
   case 'todos':             
       $mapper_contatos = new Mapper();
       $mapper_contatos->setDbTable(new Contatos()); 
       $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'"');
       $rows_contatos = $mapper_contatos->getRows();                   
       if(count($rows_contatos) > 0){
           $id_contatos[] = "(";
           foreach($rows_contatos as $row_contato){
               if($row_contato->corretor_recebeu_id != $_SESSION['usuario_visitado']->id)
                   $id_contatos[] = 'id_corretor = '.$row_contato->corretor_recebeu_id.' or ';
               if($row_contato->corretor_enviou_id != $_SESSION['usuario_visitado']->id)
                   $id_contatos[] = 'id_corretor = '.$row_contato->corretor_enviou_id.' or ';
           }
           $where .= substr(implode('',$id_contatos),0,-4).' or id_corretor = '.$_SESSION['usuario_visitado']->id.")";
       }         
       else{
            $where = "id_corretor = '".$_SESSION['usuario_visitado']->id."'";
       }
       break;
   default :
       $where .= '';
     
}

if($where != ""){
    /**
    * Lista os imóveis do contato
    */  
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());
    $mapper->setWhere($where);

    if(url(4))
        $n = url(4);
    else
        $n = 0;

    $quant_per_pag = 10;

    $total = $mapper->getTotal();

    $paginacao = new Paginacao($n, $total, $quant_per_pag);

    $mapper->setInicial($paginacao->inicial());  
    $mapper->setNumreg($quant_per_pag);      
    
    if(isset($rand))
        $mapper->setOrder ("rand()");
    
    $rows = $mapper->getRows();
    
    $url = url().'/'.url(2).'/'.url(3);

    if($total > $quant_per_pag)
        $html_paginacao = $paginacao->pagination($url);
    else
        $html_paginacao = '';    

    $lista_busca = '';

    if($total > 0){                        
        /**
        * Instancia a classe da uf do imóvel
        */
        $mapper_uf = new Mapper();
        $mapper_uf->setDbTable(new ImovelUf());

        /**
        * Instancia a classe do bairro do imóvel
        */
        $mapper_bairro = new Mapper();
        $mapper_bairro->setDbTable(new ImovelBairro());

        /**
        * Instancia a classe da cidade do imóvel
        */
        $mapper_cidade = new Mapper();
        $mapper_cidade->setDbTable(new ImovelCidade());

        /**
        * Instancia a classe do tipo do imóvel
        */
        $mapper_tipo = new Mapper();
        $mapper_tipo->setDbTable(new ImovelTipo());

        /**
        * Instancia a classe do corretor do imóvel
        */
        $mapper_corretor = new Mapper();
        $class_corretor = new Corretor();
        $mapper_corretor->setDbTable($class_corretor);

        /**
        * Instancia a classe da foto do imóvel
        */
        $mapper_foto = new Mapper();
        $mapper_foto->setDbTable(new ImovelAlbum());                
        foreach($rows as $row){

            /**
            * Pega o bairro do imóvel
            */
            if($row->bairro_imovel != ""){
                $mapper_bairro->setWhere('id = '.$row->bairro_imovel);
                $bairro = $mapper_bairro->getRow()->bairro;
            }
            else{
                $bairro = "";
            }
            
            /**
            * Pega a uf do imóvel
            */
            if($row->uf_imovel != ""){
                $mapper_uf->setWhere('id = '.$row->uf_imovel);
                $uf = $mapper_uf->getRow()->uf;
            }
            else{
                $uf = "";
            }
            
            /**
            * Pega a cidade do imóvel
            */
            if($row->cidade_imovel != ""){
                $mapper_cidade->setWhere('id = '.$row->cidade_imovel);
                $cidade = $mapper_cidade->getRow()->cidade;
            }
            else{
                $cidade = "";
            }
            
            /**
            * Pega o tipo do imóvel
            */
            $mapper_tipo->setWhere('id = '.$row->tipo_imovel_id);
            $row_tipo = $mapper_tipo->getRow();

            /**
            * Pega o corretor do imóvel
            */
            $mapper_corretor->setWhere('id = '.$row->id_corretor);
            $row_corretor = $mapper_corretor->getRow();

            /**
            * Pega a foto do imóvel
            */
            $mapper_foto->setWhere('imovel_id = '.$row->id.' and padrao = "sim"');
            $mapper_foto->setOrder("id ASC");
            $foto = $mapper_foto->getRow();

            /**
            * Verifica se o imóvel tem foto
            */
            $imagem = '';

            if($foto)
                $imagem = '<a style="height: auto; text-indent: 0; margin: 0; color: #153F63;" href="'.$row_corretor->login.'/imovel/'.$row->titulo_url.'">'.ImgRender(URL_ABSOLUTE.'static/uploads/imoveis/'.$row_corretor->login.'/'.$row->titulo_url.'/'.$foto->foto, 175, 133, $row->titulo).'</a>';
            else
                $imagem = '<a style="height: auto; text-indent: 0; margin: 0; color: #153F63;" href="'.$row_corretor->login.'/imovel/'.$row->titulo_url.'"><img src="static/img/img-imoveis.jpg" alt="'.$row->titulo.'" /></a>'; 

            /**
            * Verifica se o imóvel é residencial
            */
            $residencial = '';   
            if($row->residencial == 'SIM'){             
                $residencial = '<span>Residencial: <font>';
                if($row->compra == "SIM"){ $residencial .= 'Venda'; }
                if($row->compra == "SIM" && $row->aluguel == "SIM"){ $residencial .= '-'; }
                if($row->aluguel == "SIM"){ $residencial .= 'Aluguel'; }
                $residencial .= '</font></span>';              
            }

            /**
            * Verifica se o imóvel é comercial
            */
            $comercial = '';  
            if($row->comercial == 'SIM'){               
                $comercial = '<span>Comercial: <font>';
                if($row->compra == "SIM"){ $comercial .= 'Venda'; }
                if($row->compra == "SIM" && $row->aluguel == "SIM"){ $comercial .= '-'; }
                if($row->aluguel == "SIM"){ $comercial .= 'Aluguel'; }
                $comercial .= '</font></span>';               
            }
            
            /**
            * Pega o preço de venda e aluguel
            */
            $preco_venda = "";
            $preco_aluguel = "";
            
            if($row->valor_aluguel)
                $preco_aluguel = "<span>Valor Aluguel: <font>".number_format($row->valor_aluguel,2,',','.')."</font></span>";
            
            if($row->valor_venda)
                $preco_venda = "<span>Valor Venda: <font>".number_format($row->valor_venda,2,',','.')."</font></span>";
                        
            if($row_corretor->login != $_SESSION['login'])
                $link = '<a href="'.$_SESSION['login'].'/mensagem-enviar/'.$row_corretor->id.'/solicitacao/'.$row->id.'" class="sol-visita" style="text-indent: 0;">solicitar visita</a>';
            else
                $link = '<a href="'.$_SESSION['login'].'/editar-imovel-dados/'.$row->titulo_url.'" class="editar">editar</a>';
            
            /**
            * Cria a variavel com o resultado da busca
            */
            $lista_busca .= '<div class="imovel-lbt">'
                .$imagem.'    
                <p class="imovel-nome"><a style="height: auto; text-indent: 0; margin: 0; color: #153F63;" href="'.$row_corretor->login.'/imovel/'.$row->titulo_url.'">'.$row->codigo_imovel.' - '.$row->titulo.'</a></p>
                <p class="imovel-local">'.$cidade.' - '.$bairro.'/'.$uf.'</p>
                <p>
                    <span>Tipo: <font>'.$row_tipo->nome.'</font></span>
                    '.$residencial.$comercial.'
                </p>
                <p>
                    <span>Quartos: <font>'.$row->quartos_atual.'</font></span>
                    <span>Área Construída: <font>'.$row->area_construida.'m²</font></span>
                </p>
                <p>
                    '.$preco_aluguel.$preco_venda.'
                </p>
                <div style="float: left;">
                    '.$link.'
                </div>
            </div>';
        }
    }
    else{
        $lista_busca = '<p>Você não possui imóveis em sua rede.</p>';
    }
    
    include('views/imoveis-contato.php');
}
else{
    echo "<script>location.href = '".$_SESSION['login']."';</script>";
}