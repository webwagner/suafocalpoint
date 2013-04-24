<?php
/**
* Verifica se o usu�rio est� visitando um perfil
*/
if(isset($_SESSION['usuario_visitado'])){  
    /**
    * Fun��o lista im�veis
    */        
    function listaImoveis( $tipo ){
        $mapper = new Mapper();
        $mapper->setDbTable(new Imovel());
        
        $where = 0;       
        $msg = '';
        
        /**
        * Seta o where do sql de acordo com o tipo
        * Caso seja imoveis_minha_rede pega os contatos e seus imoveis randonicamente
        */
        
        switch ($tipo){
          
            case 'meus_imoveis';
                $where = 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and vencimento_contrato = ""';
                $msg = '<p>Voc� ainda n�o possui im�veis cadastrados.</p><a href="'.$_SESSION['login'].'/cadastro-imovel" class="cadastre">Cadastre seu primeiro im�vel agora.</a></p>';   
                break;
            case 'imoveis_a_vencer':
                $where = 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= NOW()';
                $msg = '<p>Voc� n�o possui im�veis a vencer.</p>';
                $mapper->setOrder('str_to_date(vencimento_contrato, "%d/%m/%Y" ) ASC'); 
                break;   
            case 'imoveis_minha_rede':             
                $mapper_contatos = new Mapper();
                $mapper_contatos->setDbTable(new Contatos()); 
                $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'"');
                $mapper_contatos->setOrder('rand()');
                $mapper_contatos->setNumreg(10);
                $rows_contatos = $mapper_contatos->getRows();                   
                if(count($rows_contatos) > 0){
                    $id_contatos[] = '(';
                    foreach($rows_contatos as $row_contato){
                        if($row_contato->corretor_recebeu_id != $_SESSION['usuario_visitado']->id)
                            $id_contatos[] = 'id_corretor = '.$row_contato->corretor_recebeu_id.' or ';
                        if($row_contato->corretor_enviou_id != $_SESSION['usuario_visitado']->id)
                            $id_contatos[] = 'id_corretor = '.$row_contato->corretor_enviou_id.' or ';
                    }
                    $where = "vencimento_contrato = '' and ";
                    $where .= substr(implode('',$id_contatos),0,-4).')';
                    
                    $mapper->setOrder("rand()");
                }         
                $msg = '<p>Voc� n�o possui im�veis na sua rede.</p>';
                break;      
            case 'residencial_aluguel':
                $where = 'vencimento_contrato = "" and id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and aluguel = "SIM"';
                $msg = '<p>O Corretor n�o possui im�veis residenciais para aluguel.</p>';  
                break;    
            case 'residencial_compra':
                $where = 'vencimento_contrato = "" and id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and compra = "SIM"';
                $msg = '<p>O Corretor n�o possui im�veis residenciais para venda.</p>';  
                break;    
            case 'comercial_aluguel':
                $where = 'vencimento_contrato = "" and id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and aluguel = "SIM"';
                $msg = '<p>O Corretor n�o possui im�veis comerciais para aluguel.</p>';  
                break;    
            case 'comercial_compra':
                $where = 'vencimento_contrato = "" and id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and compra = "SIM"';
                $msg = '<p>O Corretor n�o possui im�veis comerciais para venda.</p>';  
                break;  
            case 'imoveis_visitado_recentes':
                $where = 'vencimento_contrato = "" and id_corretor = '.$_SESSION['usuario_visitado']->id;
                $msg = '<p>O Corretor n�o possui im�veis recentes.';   
                break;
            case 'imoveis_visitado_todos':
                $where = 'vencimento_contrato = "" and id_corretor = '.$_SESSION['usuario_visitado']->id;
                $msg = '<p>O Corretor n�o possui im�veis.';   
                $rand = true;
                break;
            
        }
  
        $mapper->setWhere($where); 
        $mapper->setNumreg(4);
        
        if(isset($rand))
            $mapper->setOrder ("rand()");
            
        $rows_meus_imoveis = $mapper->getRows();

        $meus_imoveis = '';

        if(count($rows_meus_imoveis) > 0){
            $meus_imoveis .= '<ul>';

            /**
            * Instancia a classe da uf do im�vel
            */
            $mapper_uf = new Mapper();
            $mapper_uf->setDbTable(new ImovelUf());

            /**
            * Instancia a classe da cidade do im�vel
            */
            $mapper_cidade = new Mapper();
            $mapper_cidade->setDbTable(new ImovelCidade());

            /**
            * Instancia a classe do corretor 
            */
            $mapper_corretor = new Mapper();
            $mapper_corretor->setDbTable(new Corretor());

            foreach($rows_meus_imoveis as $row_meus_imoveis){

                /**
                * Pega a uf do im�vel
                */
                if($row_meus_imoveis->uf_imovel != ""){
                    $mapper_uf->setWhere('id = '.$row_meus_imoveis->uf_imovel);

                    if($row_uf = $mapper_uf->getRow())
                        $uf = $row_uf->uf;
                    else
                        $uf = "";
                }

                /**
                * Pega a cidade do im�vel
                */
                if($row_meus_imoveis->cidade_imovel != ""){
                    $mapper_cidade->setWhere('id = '.$row_meus_imoveis->cidade_imovel);

                    if($row_cidade = $mapper_cidade->getRow())
                        $cidade = $row_cidade->cidade;
                    else
                        $cidade = "";
                }
                
                /**
                * Pega o corretor do im�vel
                */
                $mapper_corretor->setWhere('id = '.$row_meus_imoveis->id_corretor);
                $row_corretor = $mapper_corretor->getRow();

                /**
                * Pega a foto do im�vel
                */
                $mapper_foto = new Mapper();
                $mapper_foto->setDbTable(new ImovelAlbum());
                $mapper_foto->setWhere('imovel_id = '.$row_meus_imoveis->id.' and padrao = "sim"');
                $mapper_foto->setOrder("id ASC");
                $foto = $mapper_foto->getRow();

                if($foto){                 
                    $img = URL_ABSOLUTE.'static/uploads/imoveis/'.$row_corretor->login.'/'.$row_meus_imoveis->titulo_url.'/'.$foto->foto;                  
                    $imagem = '<a href="'.$row_corretor->login.'/imovel/'.$row_meus_imoveis->titulo_url.'">'.ImgRender($img, 169, 127, $row_meus_imoveis->titulo).'</a>';                              
                }
                else{          
                    $imagem = '<a href="'.$row_corretor->login.'/imovel/'.$row_meus_imoveis->titulo_url.'"><img src="static/img/img-imoveis.jpg" alt="'.$row_meus_imoveis->titulo.'" /></a>';
                }
                
                $meus_imoveis .= '<li class="box-imv-rede" style="height:auto;">
                    <a class="tit-box-imoveis" href="'.$row_corretor->login.'/imovel/'.$row_meus_imoveis->titulo_url.'">'.$row_meus_imoveis->codigo_imovel.' - '.txtReduce($row_meus_imoveis->titulo, 32).'</a>'.$imagem.'
                    <a href="'.$_SESSION['usuario_visitado']->login.'/imovel/'.$row_meus_imoveis->titulo_url.'" >
                        <span>'.$cidade.' / '.$uf.'</span>
                    </a>
                </li>';
            }
            $meus_imoveis .= '</ul>';
        }
        else{       
            $meus_imoveis .= $msg;
        }
        return $meus_imoveis;
    }
    
    /**
    * Fun��o que retorna as cidades onde o corretor tem imoveis cadastrados
    */
    function areasCobertura(){
        
        $mapper = new Mapper();   
        $mapper->setDbTable(new Imovel);
        
        $mapper_cidade = new Mapper();
        $mapper_cidade->setDbTable(new ImovelCidade());
        
        $mapper_uf = new Mapper();
        $mapper_uf->setDbTable(new ImovelUf());
        
        $rows = $mapper->getSql('SELECT cidade_imovel FROM imovel WHERE id_corretor = '.$_SESSION['usuario_visitado']->id.' GROUP BY cidade_imovel ORDER BY id DESC');
        
        $html = '';
        
        
        if(count($rows) > 0){
            
            foreach($rows as $row){
        
                if($row->cidade_imovel != ""){
                    $mapper_cidade->setWhere('id = '.$row->cidade_imovel);
                    
                    if($cidade = $mapper_cidade->getRow())
                        $city = $cidade->cidade;
                    else
                        $city = "";

                    $mapper_uf->setWhere('id = '.$cidade->id_uf);
                    
                    if($uf = $mapper_uf->getRow())
                        $estado = $uf->uf;
                    else
                        $estado = "";
                }

                $html .= '<p>'.$city.' - '.$estado.'</p><br clear="all" />';

            }
            
        }
       
        return $html;
        
    }
    /**
    * Se verdadeiro Usu�rio logado sen�o Usu�rio n�o logado
    */
    if(isset($_SESSION['usuario_logado'])){
        /**
        * Usu�rio visitando o proprio perfil
        */
        if($_SESSION['usuario_logado']->login == url()){
            
            // Busco o ultimo pagamento do corretor
            $mapper_pagamentos = new Mapper();
            $mapper_pagamentos->setDbTable(new Pagamento());
            $mapper_pagamentos->setWhere("corretor_id = '".$_SESSION['usuario_logado']->id."' and tipo = 1");
            $mapper_pagamentos->setOrder('data_proximo DESC');
            $mapper_pagamentos->setNumreg(1);
            
            if($rows_pagamentos = $mapper_pagamentos->getRows()){
                $data_atual = strtotime(date('Y-m-d'));
                $data_prox  = strtotime(substr($rows_pagamentos[0]->data_proximo, 0, 10));
                $diferenca  = ($data_prox - $data_atual);
                $dias       = (int)floor( $diferenca / (60 * 60 * 24));
            }
            
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
            if(!$cidade = $mapper->getRow())
                $cidade->id = 1;
                        
            /**
            * Lista os tipos de im�veis
            */
            $mapper = new Mapper();
            $mapper->setDbTable(new ImovelTipo());
            $mapper->setOrder('id ASC');
            $rows_tipo = $mapper->getRows();
            
            if(url(2) == "minha-pagina")
                include('views/meu-perfil-geral.php');              
            else
                include('views/meu-perfil.php');

        }
        
        /**
        * Usu�rio visitando o outro perfil
        */
        else{            
            /**
            * Verifica se s�o amigos
            */
            $mapper_contatos = new Mapper();
            $mapper_contatos->setDbTable(new Contatos());
            $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_logado']->id.'" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" and corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'"');
            $row3 = $mapper_contatos->getRow();

            /**
            * Se forem amigos inclui perfil privado sen�o inclui perfil publico
            */
            if($row3){             
                /**
                * Fun��o que lista os im�veis dos meus contatos
                */
//                function listaImovelContato( $tipo ){
//                    
//                   $mapper = new Mapper();
//                   $mapper->setDbTable(new Imovel); 
//                   
//                   /**
//                   * se o im�vel n�o for do corretor logado busco apenas os que t�m vencimento_contrato vazio
//                   */
//                   $where = "vencimento_contrato = '' and ";
//
//                   /**
//                   * Seta o where do sql de acordo com o tipo
//                   */
//                   switch ($tipo){
//                       
//                       case 'residencial_aluguel' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and aluguel = "SIM"';
//                           break;                 
//                       case 'residencial_venda' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and compra = "SIM"';
//                           break;        
//                       case 'comercial_aluguel' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and aluguel = "SIM"';
//                           break;                     
//                       case 'comercial_venda' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and compra = "SIM"';
//                           break;
//                       case 'residencial_aluguel_ativo' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and aluguel = "SIM" and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= CURDATE()';
//                           break;                 
//                       case 'residencial_venda_ativo' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and compra = "SIM" and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= CURDATE()';
//                           break;        
//                       case 'comercial_aluguel_ativo' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and aluguel = "SIM" and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= CURDATE()';
//                           break;                     
//                       case 'comercial_venda_ativo' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and compra = "SIM" and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= CURDATE()';
//                           break;
//                       
//                   }
//                    
//                   $mapper->setWhere($where);   
//                   $row_imovel_contato = $mapper->getRow();
//                   
//                   if(count($row_imovel_contato) > 0){     
//                       /**
//                       * Pega a cidade do im�vel
//                       */
//                       $mapper_cidade = new Mapper();
//                       $mapper_cidade->setDbTable(new ImovelCidade());
//                       $mapper_cidade->setWhere('id = '.$row_imovel_contato->cidade_imovel);
//                       $row_cidade_imovel_contato = $mapper_cidade->getRow();
//                       
//                       /**
//                       * Pega a foto do im�vel
//                       */
//                       $mapper_foto = new Mapper();
//                       $mapper_foto->setDbTable(new ImovelAlbum());
//                       $mapper_foto->setWhere('imovel_id = '.$row_imovel_contato->id.' and padrao = "sim"');
//                       $foto = $mapper_foto->getRow();
//                       
//                       if($foto){
//                           $img = URL_ABSOLUTE.'static/uploads/imoveis/'.$_SESSION['usuario_visitado']->login.'/'.$row_imovel_contato->titulo_url.'/'.$foto->foto;                   
//                           $imagem = ImgRender($img, 76, 74, $row_imovel_contato->titulo);           
//                       }
//                       else{       
//                           $imagem = '';                
//                       }
//                       
//                       $lista_imovel_contato = $imagem.'<span class="imovel"><span>'.txtReduce($row_imovel_contato->titulo, 22).'</span><font>'.txtReduce($row_cidade_imovel_contato->cidade, 20).'</font></span>';
//                   }
//                   else{                   
//                       $lista_imovel_contato = '';             
//                   }                 
//                   
//                   return $lista_imovel_contato;
//                   
//                }
                 
                /**
                * Fun��o que lista o total de im�veis em cada cidade de meus amigos
                */
//                function totalImovelContato( $tipo ){                   
//                
//                    $mapper = new Mapper();
//                    $mapper->setDbTable(new Imovel());
//                    
//                    /**
//                    * se o im�vel n�o for do corretor logado busco apenas os que t�m vencimento_contrato vazio
//                    */
//                    $where = "WHERE vencimento_contrato = '' and ";
//
//                    /**
//                    * Seta o where de acordo com o tipo
//                    */
//                    
//                    switch ($tipo){
//                       
//                       case 'residencial_aluguel' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and aluguel = "SIM"';
//                           break;  
//                       case 'residencial_venda' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and compra = "SIM"';
//                           break;
//                       case 'comercial_aluguel' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and aluguel = "SIM"';
//                           break;             
//                       case 'comercial_venda' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and compra = "SIM"';
//                           break;
//                       case 'residencial_aluguel_ativo' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and aluguel = "SIM" and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= CURDATE()';
//                           break;                 
//                       case 'residencial_venda_ativo' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and residencial = "SIM" and compra = "SIM" and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= CURDATE()';
//                           break;        
//                       case 'comercial_aluguel_ativo' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and aluguel = "SIM" and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= CURDATE()';
//                           break;                     
//                       case 'comercial_venda_ativo' :
//                           $where .= 'id_corretor = '.$_SESSION['usuario_visitado']->id.' and comercial = "SIM" and compra = "SIM" and str_to_date(vencimento_contrato, "%d/%m/%Y" ) >= CURDATE()';
//                           break;
//                   }
//                    
//                   $rows_total_imovel_contato = $mapper->getSql('SELECT COUNT(cidade_imovel) as quant, cidade_imovel FROM imovel '.$where.' GROUP BY cidade_imovel ORDER BY quant DESC LIMIT 2');
//                   $html_total_imovel_contato = '';
//                   
//                   foreach ($rows_total_imovel_contato as $row_total_imovel_contato){
//                       
//                       /**
//                       * Pega a cidade do im�vel
//                       */
//                       $mapper_cidade = new Mapper();        
//                       $mapper_cidade->setDbTable(new ImovelCidade);             
//                       $mapper_cidade->setWhere('id = '.$row_total_imovel_contato->cidade_imovel);          
//                       $row_cidade = $mapper_cidade->getRow();
//                       
//                       $html_total_imovel_contato .= '<div class="numeros"><span class="num">'.$row_total_imovel_contato->quant.'</span><span class="local">'.$row_cidade->cidade.'</span></div>';
//                       
//                   }                   
//                   
//                   return $html_total_imovel_contato;
//                
//                }
                
                include('views/meu-perfil-privado.php');           
            }
            else{    
                //Verifica se s�o do mesmo estado
                if($_SESSION['usuario_logado']->uf == $_SESSION['usuario_visitado']->uf)
                    include('views/meu-perfil-geral.php');   
                else
                    echo '<script>location.href = "home/pagina-nao-existe";</script>';   
            }
        }  
    }
    else{
        include('views/meu-perfil-publico.php');
    }    
}
else{   
    echo '<script>location.href = "home/pagina-nao-existe";</script>';    
}
    

