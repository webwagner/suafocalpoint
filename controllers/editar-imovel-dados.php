<?php
if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

/**
* Pega os dados do imóvel para editar
*/
if(url(3) != 'editar-imovel-dados'){
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());    
    $mapper->setWhere('id_corretor = "'.$_SESSION['usuario_logado']->id.'" and titulo_url = "'.url(3).'"');
    if($mapper->getRow()){
        $dados_imovel = $mapper->getRow();
        
        /**
        * Lista os tipos de imóveis
        */
        $mapper = new Mapper();
        $mapper->setDbTable(new ImovelTipo());    
        $mapper->setOrder('id ASC');    
        $rows_tipo = $mapper->getRows(); 

        /**
        * Pega o tipo do imóvel
        */
        $mapper_t = new Mapper();
        $mapper_t->setDbTable(new ImovelTipo());    
        $mapper_t->setWhere('id = "'.$dados_imovel->tipo_imovel_id.'"'); 
        $tipo_imovel = $mapper_t->getRow();

        /**
        * Pega a UF do imóvel
        */
        $mapper_uf = new Mapper();
        $mapper_uf->setDbTable(new ImovelUf());    
        $mapper_uf->setWhere('id = "'.$dados_imovel->uf_imovel.'"'); 
        $uf = $mapper_uf->getRow();

        /**
        * Pega a cidade do imóvel
        */
        $mapper_cidade = new Mapper();
        $mapper_cidade->setDbTable(new ImovelCidade());    
        $mapper_cidade->setWhere('id = "'.$dados_imovel->cidade_imovel.'"'); 
        $cidade_imovel = $mapper_cidade->getRow();

        /**
        * Pega a cidade do corretor
        */
        $mapper_cidade = new Mapper();
        $mapper_cidade->setDbTable(new ImovelCidade());
        $mapper_cidade->setWhere("cidade = '".$_SESSION['usuario_logado']->cidade."'");
        $cidade = $mapper_cidade->getRow();
    
        /**
        * Pega o bairro do imóvel
        */
        $mapper_bairro = new Mapper();
        $mapper_bairro->setDbTable(new ImovelBairro());    
        $mapper_bairro->setWhere('id = "'.$dados_imovel->bairro_imovel.'"'); 
        $bairro_imovel = $mapper_bairro->getRow();
        
        /**
        * Faz o update dos dados
        */
        if($_POST){
    
            if($_POST['tipo_imovel_id'] == "")
                $_POST['tipo_imovel_id'] = $dados_imovel->tipo_imovel_id;

            if($_POST['quartos_atual'] == "")
                $_POST['quartos_atual'] = $dados_imovel->quartos_atual;

            if($_POST['quartos_original'] == "")
                $_POST['quartos_original'] = $dados_imovel->quartos_original;

            if($_POST['uf_imovel'] == "")
                $_POST['uf_imovel'] = $dados_imovel->uf_imovel;

            if($_POST['cidade_imovel'] == "")
                $_POST['cidade_imovel'] = $dados_imovel->cidade_imovel;

            if($_POST['bairro_imovel'] == "")
                $_POST['bairro_imovel'] = $dados_imovel->bairro_imovel;

            if(!isset($_POST['comercial']))
                $_POST['comercial'] = 'NAO';

            if(!isset($_POST['residencial']))
                $_POST['residencial'] = 'NAO';

            if(!isset($_POST['aluguel']))
                $_POST['aluguel'] = 'NAO';

            if(!isset($_POST['compra']))
                $_POST['compra'] = 'NAO';

            if(!isset($_POST['portaria_24h']))
                $_POST['portaria_24h'] = 'NAO';

            if(!isset($_POST['mobiliado']))
                $_POST['mobiliado'] = 'NAO';

            if(!isset($_POST['varanda']))
                $_POST['varanda'] = 'NAO';  
            
            $arr = array("valor_aluguel" => convertPreco($_POST['valor_aluguel1']), "valor_venda" => convertPreco($_POST['valor_venda1']), "valor_iptu" => convertPreco($_POST['valor_iptu1']), "valor_condominio" => convertPreco($_POST['valor_condominio1']));
            
            /**
            * Verifica se está mudando o titulo do imóvel
            * Se sim altera o titulo url e muda o nome da pasta que guarda as fotos do imóvel
            */
            if($_POST['titulo'] != $dados_imovel->titulo){
                $_POST['titulo_url'] = getUrl($dados_imovel->codigo_imovel).'-'.getUrl(trim($_POST['titulo']));
                
                if(is_dir('static/uploads/imoveis/'.$_SESSION['login'].'/'.$dados_imovel->titulo_url))
                    rename('static/uploads/imoveis/'.$_SESSION['login'].'/'.$dados_imovel->titulo_url, 'static/uploads/imoveis/'.$_SESSION['login'].'/'.getUrl($dados_imovel->codigo_imovel).'-'.getUrl($_POST['titulo']));
                
                $redirect = $_POST['titulo_url'];
            }
            else{
                $redirect = $dados_imovel->titulo_url;
            }
            
            $_POST['titulo'] = trim($_POST['titulo']);
            
            $arr1 = array_merge($arr, $_POST);
            
            $mapper = new Mapper();
            $mapper->setDbTable(new Imovel()); 
             
            $mapper->saveOrUpdate($arr1);
            
            echo '<script>location.href = "'.$_SESSION['login'].'/imovel/'.$redirect.'";</script>';
        }
    
        include('views/imovel-dados.php');
    }
    else{
        echo '<script>location.href = "home/pagina-nao-existe";</script>';
    }
}
else{
    echo '<script>location.href = "home/pagina-nao-existe";</script>';
}