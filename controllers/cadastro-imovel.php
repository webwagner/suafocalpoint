<?php

if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

$msg = '';

if(isset($_POST['tipo_imovel_id'])){ 
    
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());   
    
    /**
    * Pega o codigo do ultimo imovel do corretor
    */ 
    $mapper->setWhere('id_corretor = "'.$_SESSION['usuario_logado']->id.'"');
    $mapper->setOrder('CAST(SUBSTRING( codigo_imovel, 4 ) AS UNSIGNED) DESC');

    if($codImovel = $mapper->getRow())
        $codigo = $_SESSION['usuario_logado']->sigla.((int) substr($codImovel->codigo_imovel,3) + 1);
    else
        $codigo = $_SESSION['usuario_logado']->sigla.'1';
    
    $titulo_imovel = getUrl($codigo).'-'.getUrl(trim($_POST['titulo']));
    $_POST['titulo'] = trim($_POST['titulo']);
    
    /**
    * Inseri o imóvel
    */
    $arr = array('codigo_imovel' => $codigo, 'titulo_url' => $titulo_imovel, "valor_aluguel" => convertPreco($_POST['valor_aluguel1']), "valor_venda" => convertPreco($_POST['valor_venda1']), "valor_iptu" => convertPreco($_POST['valor_iptu1']), "valor_condominio" => convertPreco($_POST['valor_condominio1']));
    $arr1 = array_merge($arr, $_POST);

    $id = $mapper->saveOrUpdate($arr1);

    include('views/imovel-fotos.php');
        
}
else if(isset($_POST['id_album_del'])){   
    /**
    * Pega o imóvel
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());    
    $mapper->setWhere('id_corretor = "'.$_SESSION['usuario_logado']->id.'" and titulo_url = "'.$_POST['titulo_imovel'].'"');
    $dados_imovel = $mapper->getRow();

    $id = $dados_imovel->id;
    $titulo_imovel = $dados_imovel->titulo_url;

    /**
    * Deleta o albúm
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new ImovelAlbum());
    $mapper->setWhere('id = "'.$_POST['id_album_del'].'"');
    $album = $mapper->getRow();
    
    if($album){
        if(is_file('static/uploads/imoveis/'.$_SESSION['login'].'/'.$dados_imovel->titulo_url.'/'.$album->foto))
            unlink('static/uploads/imoveis/'.$_SESSION['login'].'/'.$dados_imovel->titulo_url.'/'.$album->foto);
    }
    
    $mapper->delete();
    
    include('views/imovel-fotos.php');
  
}
else if(isset($_POST['id_cad_foto'])){
    $id = $_POST['id_cad_foto'];
    
    if(isset($_POST['id_foto'])){  
        
        $id_padrao = "";
                
        if(isset($_POST['padrao']))
            $id_padrao = implode("",$_POST['padrao']);
                
        for($x=0;$x<count($_POST['id_foto']);$x++){
            
            $padrao = 'nao';
            
            if($id_padrao != "")
                if($_POST['id_foto'][$x] == $id_padrao)
                    $padrao = 'sim';
                        
            /**
            * Coloca legenda e albúm nas fotos
            */
            $arr = array('id' => $_POST['id_foto'][$x], 'album_id' => $_POST['album'][$x], 'legenda' => $_POST['legenda'][$x], 'padrao' => $padrao);
            $mapper = new Mapper();
            $mapper->setDbTable(new ImovelAlbum());
            $mapper->saveOrUpdate($arr);

        }
    }
    include('views/imovel-obs.php');
}
else if(isset($_POST['cep'])){   
    /**
    * Inseri a última parte de cadastro do imóvel
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());
    $mapper->saveOrUpdate($_POST);
    
    $mapper->setWhere('id = "'.$_POST['id'].'"');
    $imovel = $mapper->getRow();
    
    if($imovel->valor_venda != 0.00)
        $valor_venda = 'Valor Venda : R$'.number_format($imovel->valor_venda,2,',','.');
    else
        $valor_venda = '';
    
    if($imovel->valor_aluguel != 0.00)
        $valor_aluguel = 'Valor Aluguel : R$'.number_format($imovel->valor_aluguel,2,',','.');
    else
        $valor_aluguel = '';
        
    $contatos = array();
    
    if($_POST['email_proprietario'] != ""){
        $email = array($_POST['email_proprietario']);
        
        $text = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
        <tr>
            <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Imóvel Cadastrado</td>
        </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
            <tr>
                <td style="font-family: Arial; font-size: 13px;">
                    O Corretor '.$_SESSION['usuario_logado']->nome.' cadastrou um imóvel:<br /><br />
                    Título: '.$imovel->titulo.'<br>
                    Código: '.$imovel->codigo_imovel.'<br>
                    '.$valor_aluguel.'<br>
                    '.$valor_venda.'<br>
                </td>
            </tr>
        </table>';
        email($text, 'Cadastro de Imóvel - O Corretor '.$_SESSION['usuario_logado']->nome.' cadastrou um imóvel.', $email, '', 'bcc');
    }
    
    
    if($_POST['vencimento_contrato'] == ""){
        /**
        * Pega os contatos do corretor
        */ 
        $mapper_contatos = new Mapper();
        $mapper_contatos->setDbTable(new Contatos());
        $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'"');

        if($mapper_contatos->getRows()){
            $rows_contatos = $mapper_contatos->getRows();

            foreach($rows_contatos as $row_contatos){
                if($row_contatos->corretor_enviou_id == $_SESSION['usuario_logado']->id)
                    $contatos[] = $row_contatos->corretor_recebeu_id;
                else
                    $contatos[] = $row_contatos->corretor_enviou_id;
            }
        }

        if(count($contatos) > 0){
            $mapper_corretor = new Mapper();
            $mapper_corretor->setDbTable(new Corretor());

            foreach($contatos as $contato){
                $mapper_corretor->setWhere('id = "'.$contato.'"');
                $emails[] = $mapper_corretor->getRow()->email;
            }
        } else{
            $emails = array();
        }

        if(count($emails) > 0){
            $text = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
                <tr>
                    <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Imóvel Cadastrado</td>
                </tr>
                </table>
                <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                    <tr>
                        <td style="font-family: Arial; font-size: 13px;">
                            O Corretor '.$_SESSION['usuario_logado']->nome.' cadastrou um imóvel:<br /><br />
                            Título: '.$imovel->titulo.'<br>
                            Código: '.$imovel->codigo_imovel.'<br>
                            '.$valor_aluguel.'<br>
                            '.$valor_venda.'<br><br>
                            <a style="display:block;" href="'.URL.$_SESSION['usuario_logado']->login.'/imovel/'.$imovel->titulo_url.'" target="_BLANK">Visualizar</a>
                        </td>
                    </tr>
                </table>';

            email($text, 'Cadastro de Imóvel - O Corretor '.$_SESSION['usuario_logado']->nome.' cadastrou um imóvel.', $emails, '', 'bcc');
        }
    }
    
    echo "<script>location.href = '".URL.$_SESSION['login']."'</script>";
    
}
else{  
    /**
    * Lista os tipos de imóveis
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new ImovelTipo());    
    $mapper->setOrder('id ASC');    
    $rows_tipo = $mapper->getRows(); 
    
    /**
    * Pega a cidade do corretor
    */
    $mapper_cidade = new Mapper();
    $mapper_cidade->setDbTable(new ImovelCidade());
    $mapper_cidade->setWhere("cidade = '".$_SESSION['usuario_logado']->cidade."'");
    $cidade = $mapper_cidade->getRow();
    
    /**
    * Pega a uf do corretor
    */
    $mapper_uf = new Mapper();
    $mapper_uf->setDbTable(new ImovelUf());
    $mapper_uf->setWhere("uf = '".$_SESSION['usuario_logado']->uf."'");
    $uf = $mapper_uf->getRow();
    
    include('views/imovel-dados.php');
}