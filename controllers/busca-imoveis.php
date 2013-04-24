<?php

if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

if($_POST)
    $_SESSION['busca'] = $_POST;

if($_SESSION['busca']){

    $busca_quartos = false;
    
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

    /**
    * Lista as ufs de imóveis
    */
    $mapper_uf = new Mapper();
    $mapper_uf->setDbTable(new ImovelUf());
    $mapper_uf->setOrder('uf ASC');
    $rows_uf = $mapper_uf->getRows();

    /**
    * Lista os tipos de imóveis
    */
    $mapper_tipo = new Mapper();
    $mapper_tipo->setDbTable(new ImovelTipo());
    $mapper_tipo->setOrder('id ASC');
    $rows_tipo = $mapper_tipo->getRows();
    
    /**
    * Seta o Where do select conforme os campos buscados e não busca imóveis de quem fez a busca
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());
    $where = '';
    
    /**
    * Seta o Where pegando o tipo de busca pela url
    */
    if(url(3) == 'meus'){
        $where .= 'id_corretor = "'.$_SESSION['usuario_logado']->id.'" and ';
    }
    else if(url(3) == 'contatos' || url(3) == 'todos'){
        $mapper_contatos = new Mapper();
        $mapper_contatos->setDbTable(new Contatos()); 
        $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'"');
        $rows_contatos = $mapper_contatos->getRows();
        
        if(count($rows_contatos) > 0){
            $id_contatos = '';
            
            foreach($rows_contatos as $row_contato){
                if($row_contato->corretor_recebeu_id != $_SESSION['usuario_visitado']->id)
                    $id_contatos .= $row_contato->corretor_recebeu_id.',';
                if($row_contato->corretor_enviou_id != $_SESSION['usuario_visitado']->id)
                    $id_contatos .= $row_contato->corretor_enviou_id.',';
            }
            $where .= 'id_corretor IN ('.$id_contatos.$_SESSION['usuario_logado']->id.') and ';
        }
        else{
            $where .= 'id_corretor IN ('.$id_contatos.$_SESSION['usuario_logado']->id.') and ';
        }
    }
    else{
        echo '<script>window.location.href = "'.$_SESSION['login'].'"</script>';    
    }
      
    /**
    * apenas os que têm vencimento_contrato vazio
    */
    $where .= "vencimento_contrato = '' and ";
    
    /**
    * Seta o Where do select conforme os campos buscados e não busca imóveis de quem fez a busca
    */
    if($_SESSION['busca']['tipo_busca'] == 1){      
        $where .= 'codigo_imovel = "'.$_SESSION['busca']['codigo'].'" and ';
    } else if($_SESSION['busca']['tipo_busca'] == 3){      
        $where .= 'titulo LIKE "%'.$_SESSION['busca']['titulo'].'%"  and ';
    } else{
        if($_SESSION['busca']['uf'] != ''){
            $where .= 'uf_imovel = "'.$_SESSION['busca']['uf'].'" and ';
            $mapper_uf->setWhere('id = "'.$_SESSION['busca']['uf'].'"');
            
            $mapper_cidade = new Mapper();
            $mapper_cidade->setDbTable(new ImovelCidade());
            $mapper_cidade->setWhere('id_uf = "'.$_SESSION['busca']['uf'].'"');
            $cidades = $mapper_cidade->getRows();
        }
        if($_SESSION['busca']['cidade'] != ''){
            $where .= 'cidade_imovel = "'.$_SESSION['busca']['cidade'].'" and ';
            
            $mapper_bairro = new Mapper();
            $mapper_bairro->setDbTable(new ImovelBairro());
            $mapper_bairro->setWhere('id_cidade = "'.$_SESSION['busca']['cidade'].'"');
            $mapper_bairro->setOrder('bairro ASC');
            $bairros = $mapper_bairro->getRows();
        }
        if(count($_SESSION['busca']['bairro']) > 0){
            $i = 0;
            $where .= '(';
            foreach($_SESSION['busca']['bairro'] as $bairro){
                if($bairro != ""){
                    $i++;
                    $where .= 'bairro_imovel = "'.$bairro.'" or ';
                }
            }
            
            if($i == 0){
                $where = substr($where,0 , -1);
            }
            else{
                $where = substr($where,0 , -4);
                $where .= ') and ';
            }

        }
        if(count($_SESSION['busca']['tipo']) > 0){
            foreach($_SESSION['busca']['tipo'] as $arr_tipo)
                if($arr_tipo != "")
                    $arr_tipo2[] = $arr_tipo;
            
            if(isset($arr_tipo2))
                $where .= 'tipo_imovel_id IN ('.implode(",", $arr_tipo2).') and ';
        }
        if(isset($_SESSION['busca']['residencial_compra']) || isset($_SESSION['busca']['residencial_aluguel'])){
            $where .= 'residencial = "SIM" and ';
            if(isset($_SESSION['busca']['residencial_compra'])){
                $where .= 'compra = "SIM" and ';
            }
            if(isset($_SESSION['busca']['residencial_aluguel'])){
                $where .= 'aluguel = "SIM" and ';
            }
        }
        
        if(isset($_SESSION['busca']['comercial_compra']) || isset($_SESSION['busca']['comercial_aluguel'])){
            $where .= 'comercial = "SIM" and ';
            if(isset($_SESSION['busca']['comercial_compra'])){
                $where .= 'compra = "SIM" and ';
            }
            if(isset($_SESSION['busca']['comercial_aluguel'])){
                $where .= 'aluguel = "SIM" and ';
            }
        }
        
        if($_SESSION['busca']['valor_aluguel'] != ""){
            $where .= 'valor_aluguel > 0.00 and valor_aluguel <= '.str_replace(',','.',str_replace('.','',$_SESSION['busca']['valor_aluguel'])).' and ';
        }
        if($_SESSION['busca']['valor_venda'] != ""){ 
            $where .= 'valor_venda > 0.00 and valor_venda <= '.str_replace(',','.',str_replace('.','',$_SESSION['busca']['valor_venda'])).' and '; 
        }
        if($_SESSION['busca']['valor_minimo_aluguel'] != ""){
            $where .= 'valor_aluguel >= '.str_replace(',','.',str_replace('.','',$_SESSION['busca']['valor_minimo_aluguel'])).' and ';
        }
        if($_SESSION['busca']['valor_minimo_venda'] != ""){ 
            $where .= 'valor_venda >= '.str_replace(',','.',str_replace('.','',$_SESSION['busca']['valor_minimo_venda'])).' and '; 
        }
        if($_SESSION['busca']['n_quartos'] != ''){
            $busca_quartos = true;
            $where .= 'quartos_atual >= "'.$_SESSION['busca']['n_quartos'].'" and ';
        }
        if($_SESSION['busca']['nome_condominio'] != ''){
            $where .= 'nome_condominio = "'.$_SESSION['busca']['nome_condominio'].'" and ';
        }
        if($_SESSION['busca']['area_construida_menor'] != ''){
            $where .= 'area_construida < "'.$_SESSION['busca']['area_construida_menor'].'" and ';        
        }
        if($_SESSION['busca']['area_construida_maior'] != ''){
            $where .= 'area_construida >= "'.$_SESSION['busca']['area_construida_maior'].'" and ';
        }
        if(isset($_SESSION['busca']['mobiliado'])){
            $where .= 'mobiliado = "SIM" and ';
        }
        if(isset($_SESSION['busca']['portaria_h'])){
            $where .= 'portaria_24h = "SIM" and ';
        }
        if(isset($_SESSION['busca']['varanda'])){
            $where .= 'varanda = "SIM" and ';
        }
        if(isset($_SESSION['busca']['piscina'])){
            $where .= 'piscina = "SIM" and';
        }
    }

    if(substr($where,0,-4) != "")
        $mapper->setWhere(substr($where,0,-4));
    else
        $mapper->setWhere("codigo_imovel = ''");

    /**
    * Lista os imóveis e faz a Paginação
    */        
    if(url(4))
        $n = url(4);
    else
        $n = 0;
       
    $quant_per_pag = 10;
   
    $total = $mapper->getTotal();
        
    $paginacao = new Paginacao($n, $total, $quant_per_pag);
    
    $mapper->setInicial($paginacao->inicial());  
    $mapper->setNumreg($quant_per_pag);  
    
    /**
    * Buscou por quartos, coloco para ordenar pelo menor
    */
    if($busca_quartos)
        $mapper->setOrder("quartos_atual ASC");
    
    $rows = $mapper->getRows();
       
    $url = url().'/'.url(2).'/'.url(3);
    
    if($total > $quant_per_pag)
        $html_paginacao = $paginacao->pagination($url);
    else
        $html_paginacao = '';    
        
    $mens = 'Sua busca retornou '.$total.' resultados';
    
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
            
            /**
            * Cria a variavel com o resultado da busca
            */
            $termino_contrato = '';  
            
            if($row_corretor->login != $_SESSION['login']){
                $link = '<a href="'.$_SESSION['login'].'/mensagem-enviar/'.$row_corretor->id.'/solicitacao/'.$row->id.'" class="sol-visita" style="text-indent: 0;">solicitar visita</a>';              
            }
            else{
                $link = '<a href="'.$_SESSION['login'].'/editar-imovel-dados/'.$row->titulo_url.'" class="editar">editar</a>';

                if($row->vencimento_contrato != "")
                    $termino_contrato = '<h2>Término do Contrato: '.$row->vencimento_contrato.'</h2>';    
            }
            
            $lista_busca .= '<div class="imovel-lbt">	
                '.$termino_contrato.$imagem.'    
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
    include('views/busca-imoveis.php');   
}
else{    
    echo '<script>window.location.href = "'.$_SESSION['login'].'"</script>';    
}

