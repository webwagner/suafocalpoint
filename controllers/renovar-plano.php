<?php
if(isset($_POST['id']) && isset($_POST['plano_id'])){
    /**
    * Busca as solicitações abertas para o corretor
    */
    $mapper_pagamento = new Mapper();
    $mapper_pagamento->setDbTable(new Pagamento()); 
    $mapper_pagamento->setWhere("corretor_id = '".$_POST['id']."' AND tipo = 1 AND (retorno = 'Em Análise' OR retorno = 'Aguardando Pagto')");
    $pagamento = $mapper_pagamento->getRow();
    
    if(!$pagamento || ($pagamento->pagseguro_id == "" && $pagamento->retorno == "Aguardando Pagto")){
        /**
        * Pega o plano escolhido pelo corretor
        */
        $mapper = new Mapper();
        $mapper->setDbTable(new Planos());
        $mapper->setWhere('id = "'.$_POST['plano_id'].'"');
        
        /**
        * Verifica se o plano existe
        */
        if($plano = $mapper->getRow()){
            $titulo = 'Plano '.$plano->nome;
            $preco  = $plano->valor;

            $mapper = new Mapper();
            $mapper->setDbTable(new Corretor());    
            $mapper->setWhere("id = '".$_POST['id']."'");
            
            /**
            * Verifica se o corretor existe
            */
            if($mapper->getRow()){
                /**
                * Altera o plano do correto
                */
                $arr = array('id' => $_POST['id'], 'plano_id' => $_POST['plano_id']);
                $mapper->saveOrUpdate($arr);

                /**
                * Excluo a solicitação anterior
                */
                if($pagamento){
                    $mapper_pagamento->setWhere("id = '".$pagamento->id."'");
                    $mapper_pagamento->delete();
                }
                
                /**
                * Verifico se o corretor está com plano em vigencia
                */
                $mapper_pagamento->setWhere("corretor_id = '".$_POST['id']."' and data_proximo > curdate() and tipo = 1 and (retorno = 'Completo' or retorno = 'Aprovado')");
                if($row_pagamento = $mapper_pagamento->getRow()){
                    /**
                    * Calculo da data do próximo pagamento baseada no pagamento vigente
                    */
                    $data_proximo = date('Y-m-d H:i:s', strtotime("+".$plano->dias." days",strtotime($row_pagamento->data_proximo)));

                } else {
                    /**
                    * Calculo da data do próximo pagamento baseada na data atual
                    */
                    $data_proximo = date('Y-m-d H:i:s', strtotime("+".$plano->dias." days"));
                }

                /**
                * Inseri o pagamento
                */  
                $mapper_pagamento = new Mapper();
                $mapper_pagamento->setDbTable(new Pagamento()); 
                $arr = array('corretor_id' => $_POST['id'], 'plano_pacote_id' => $_POST['plano_id'], 'retorno' => 'Aguardando Pagto', 'tipo' => 1, 'data_solicitacao' => date("Y-m-d H:i:s"), 'data_proximo' => $data_proximo);
                $id_pag = $mapper_pagamento->saveOrUpdate($arr);

                //if($_POST['desconto'] != ""){
                //    $val_plano = (int) $plano->valor;
                //    $preco = number_format(($val_plano - (($val_plano * $_POST['desconto']) / 100)),2,',','.');
                //}

                include('views/pagseguro_renovar.php');
            } else {
                header("Location:".URL."home/pagina-nao-existe");    
            }
        } else {
             header("Location:".URL."home/pagina-nao-existe");    
        }
    } else {
        $msg = '<p><font color="#124B9A">Você possui uma solicitação '.$pagamento->retorno.'. Entre em contato com o pagseguro.</font></p>';
        include('views/renovar-plano.php');
    }
} else{
    //Verifico se o corretor existe
    $mapper = new Mapper();
    $mapper->setDbTable(new Corretor());
    $mapper->setWhere("login = '".url(3)."'");
    
    if($row = $mapper->getRow()){
        /**
        * Busca as solicitações abertas para o corretor
        */
        $mapper_pagamento = new Mapper();
        $mapper_pagamento->setDbTable(new Pagamento()); 
        $mapper_pagamento->setWhere("corretor_id = '".$row->id."' AND tipo = 1 AND (retorno = 'Em Análise' OR retorno = 'Aguardando Pagto')");
        $pagamento = $mapper_pagamento->getRow();
        
        /**
        * Verifica se o corretor tem solicitação aberta ou se tem solicitação que ainda não foi ao pagseguro
        */
        if(!$pagamento || ($pagamento->pagseguro_id == "" && $pagamento->retorno == "Aguardando Pagto")){
            $msg  = '';
            $valor_desconto = 0;
            
            //Verifico se o corretor possui desconto
            $mapper = new Mapper();
            $mapper->setDbTable(new Desconto());
            $mapper->setWhere("id_corretor = '".$row->id."' and descontado = 'NAO'");

//            if($desconto = $mapper->getRow()){
//                $desc = (int) $desconto->valor_desconto;
//                $msg  = '<p><font color="#124B9A">Você possui um desconto de '.$desconto->valor_desconto.' por ter indicado um corretor.</font></p>';
//            }
            
            if($descontos = $mapper->getRows()){            
                foreach($descontos as $desconto)
                    $valor_desconto += $desconto->valor_desconto;

                //Pego o valor do desconto
                $mapper = new Mapper();
                $mapper->setDbTable(new Planos());
                $mapper->setWhere("nome = 'MENSAL'");
                $plano = $mapper->getRow();
                $valor_desc_base = ($plano->valor / 2);
        
                $msg  = '<p><font color="#124B9A">Você possui um desconto de R$ '.number_format($valor_desconto,2,',','.').' por ter indicado corretor(es).</font></p>';
            }

            /**
            * Pega o plano do corretor
            */
            $mapper = new Mapper();
            $mapper->setDbTable(new Planos());
            $mapper->setWhere('id = "'.$row->plano_id.'"');

            $plano = $mapper->getRow();
            $plano_contratado = $plano->nome;

            /**
            * Pega todos os planos 
            */
            $mapper = new Mapper();
            $mapper->setDbTable(new Planos());
            $mapper->setOrder('id ASC');
            $planos = $mapper->getRows();

            $html_plano = '';

            foreach($planos as $plano){
                $preco = $plano->valor;
                
                if($valor_desconto > 0){
                    //Desconto maximo possivel
                    if($plano->nome == "MENSAL")
                        $desconto_max = $valor_desc_base;
                    else if($plano->nome == "SEMESTRAL")
                        $desconto_max = ($valor_desc_base * 6);
                    else
                        $desconto_max = ($valor_desc_base * 12);

                    if($valor_desconto > $desconto_max)
                        $preco = $desconto_max;
                    else
                        $preco = ((int) $plano->valor - $valor_desconto);

                    $preco = number_format($preco,2,',','.');
                }
                    
//                $preco = $plano->valor;
//
//                if($desc != ""){
//                    $val_plano = (int) $plano->valor;
//                    $preco = number_format(($val_plano - (($val_plano*$desc)/100)),2,',','.');
//                }

                if($plano_contratado == $plano->nome){
                    $classe = 'plano-h';
                    $check = 'checked="checked"';
                }   
                else{
                    $classe = '';
                    $check = '';
                }

                $html_plano .= '<div class="plano '.$classe.'">
                                    <div class="plano-title">'.$plano->nome.'</div>
                                    <span>R$ '.$preco.'</span>
                                    <input '.$check.' type="radio" name="plano_id" value="'.$plano->id.'" />
                                </div>
                                <input type="hidden" name="preco['.$plano->id.']" value="'.$preco.'" />';
            }
        } else {
            $msg = '<p><font color="red">Você possui uma solicitação '.$pagamento->retorno.'. Entre em contato com o pagseguro.</font></p>';
        }
    
        include('views/renovar-plano.php');
    } else {
        header("Location:".URL."home/pagina-nao-existe");    
    }
}


