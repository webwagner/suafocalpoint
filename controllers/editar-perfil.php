<?php
/**
* Pega o perfil do corretor
*/
$mapper = new Mapper();
$mapper->setDbTable(new Corretor);
$mapper->setWhere('login = "'.$_SESSION['login'].'"');

$msg      = '';
$msgDesc  = '';
$msgPlano = '';
$valor_desconto = 0;

if(isset($_SESSION['usuario_visitado']->login) && $_SESSION['usuario_visitado']->login == $_SESSION['login']){
    if($dados = $mapper->getRow()){
        
        if($dados->foto_perfil != ""){
            $foto = URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['usuario_visitado']->login.'/'.$_SESSION['usuario_visitado']->foto_perfil;             
            $foto = ImgRender($foto, 92, 92, $dados->nome);
        }
        else{
            $foto = URL_ABSOLUTE.'static/img/perfil-focalpoint.jpg';             
            $foto = ImgRender($foto, 92, 92, $dados->nome);
        }
        
        if($dados->logotipo != ""){
            $logotipo = URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['usuario_visitado']->login.'/'.$_SESSION['usuario_visitado']->logotipo;             
            $logotipo = ImgRender($logotipo, 92, 92, $dados->nome);
        }
        else{
            $logotipo = URL_ABSOLUTE.'static/img/perfil-focalpoint.jpg';             
            $logotipo = ImgRender($logotipo, 92, 92, $dados->nome);
        }

        $ddd = '('.substr($dados->telefone,1,2).')';
        $tel = substr($dados->telefone,-9);
        $ddd_celular = '('.substr($dados->celular,1,2).')';
        $celular = substr($dados->celular,-9);

        /**
        * Pega todos os planos menos o grátis 
        */
        $mapper_plano = new Mapper();
        $mapper_plano->setDbTable(new Planos());
        $mapper_plano->setOrder('id ASC');
        $mapper_plano->setWhere('id <> 1');
        $planos = $mapper_plano->getRows();
        
        /**
        * Pega todos os pacotes
        */
        $mapper_pacote = new Mapper();
        $mapper_pacote->setDbTable(new Pacotes());
        $mapper_pacote->setOrder('id ASC');
        $pacotes = $mapper_pacote->getRows();
        
        /**
        * Pega o plano do corretor
        */
        $mapper_plano->setWhere('id = '.$dados->plano_id);
        $plano = $mapper_plano->getRow();
        
        //Verifico se o corretor possui desconto
        $mapper_desc = new Mapper();
        $mapper_desc->setDbTable(new Desconto());
        $mapper_desc->setWhere("id_corretor = '".$_SESSION['usuario_logado']->id."' and descontado = 'NAO'");

        //Pego o valor do desconto
        $mapper = new Mapper();
        $mapper->setDbTable(new Planos());
        $mapper->setWhere("nome = 'MENSAL'");
        $plano = $mapper->getRow();
        $valor_desc_base = ($plano->valor / 2);
                
        if($descontos = $mapper_desc->getRows()){            
            foreach($descontos as $desconto)
                $valor_desconto += $desconto->valor_desconto;
                        
            $msgDesc = 'Você possui um desconto de R$ '. number_format($valor_desconto,2,',','.').' por ter indicado corretor(es).';
        }
        
        if($_POST){      
            if(isset($_POST['telefone'])){
                $_POST['telefone'] = $_POST['ddd'].' '.$_POST['telefone'];
            }

            if(isset($_POST['celular'])){
                $_POST['celular'] = $_POST['ddd_celular'].' '.$_POST['celular'];
            }
            
            if(isset($_POST['telefone2'])){
                $_POST['telefone2'] = $_POST['ddd2'].' '.$_POST['telefone2'];
            }

            if(isset($_POST['celular2'])){
                $_POST['celular2'] = $_POST['ddd_celular2'].' '.$_POST['celular2'];
            }

            if(isset($_POST['plano_id'])){ 
                /**
                * Verifica se o corretor tem solicitação aberta
                */
                $mapper_pagamento = new Mapper();
                $mapper_pagamento->setDbTable(new Pagamento()); 
                $mapper_pagamento->setWhere("corretor_id = '".$_POST['id']."' AND tipo = 1 AND (retorno = 'Em Análise' OR retorno = 'Aguardando Pagto')");
                $pagamento = $mapper_pagamento->getRow();
                
                if(!$pagamento || ($pagamento->pagseguro_id == "" && $pagamento->retorno == "Aguardando Pagto")){
                   /**
                   * Excluo a solicitação anterior
                   */
                   if($pagamento){
                       $mapper_pagamento->setWhere("id = '".$pagamento->id."'");
                       $mapper_pagamento->delete();
                    }
                    
                    $mapper_plano->setWhere('id = '.$_POST['plano_id']);
                    $plano  = $mapper_plano->getRow();

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
                    $arr = array('corretor_id' => $dados->id, 'plano_pacote_id' => $_POST['plano_id'], 'retorno' => 'Aguardando Pagto', 'tipo' => 1, 'data_solicitacao' => date("Y-m-d H:i:s"), 'data_proximo' => $data_proximo);
                    $id_pag = $mapper_pagamento->saveOrUpdate($arr);

                    $titulo = 'Plano '.$plano->nome;
                    $preco  = $_POST['preco'][$_POST['plano_id']];
                    
                } else {
                    $msgPlano = '<p><font color="red">Você possui uma solicitação '.$pagamento->retorno.'. Entre em contato com o pagseguro.</font></p>';
                    unset($_POST['plano_id']);
                }
            }
            
            if(isset($_POST['pacote_id'])){       
                /**
                * Inseri o pagamento
                */
                $mapper = new Mapper();
                $mapper->setDbTable(new Pagamento());      
                $arr = array('corretor_id' => $dados->id, 'plano_pacote_id' => $_POST['pacote_id'], 'retorno' => 'Aguardando Pagto', 'tipo' => 2, 'data_solicitacao' => date("Y-m-d H:i:s"));
                $id_pag = $mapper->saveOrUpdate($arr);
                
                $mapper_pacote->setWhere('id = '.$_POST['pacote_id']);
                $pacote  = $mapper_pacote->getRow();
                $titulo  = $pacote->titulo;
                $preco   = $pacote->valor;
            }

            $msg = 'Perfil editado com suceso.';  

            $mapper = new Mapper();
            $mapper->setDbTable(new Corretor);
            $mapper->saveOrUpdate($_POST);
            
            $mapper->setWhere('login = "'.$_SESSION['login'].'"');
            $dados = $mapper->getRow();
            
            $ddd = '('.substr($dados->telefone,1,2).')';
            $tel = substr($dados->telefone,-9);
            $ddd_celular = '('.substr($dados->celular,1,2).')';
            $celular = substr($dados->celular,-9);

            $ddd2 = '('.substr($dados->telefone2,1,2).')';
            $tel2 = substr($dados->telefone2,-9);
            $ddd_celular2 = '('.substr($dados->celular2,1,2).')';
            $celular2 = substr($dados->celular2,-9);
            
        } else if($_FILES){
            if($_FILES['foto']['name'] != ""){
                $destino_f = URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['usuario_visitado']->login.'/';
                
                if(!is_dir($destino_f))
                    cria_dir($destino_f);
                
                $foto = upload('foto',$destino_f);
                
                if($dados->foto_perfil != "")
                    if(is_file($destino_f.$dados->foto_perfil))
                        unlink($destino_f.$dados->foto_perfil);

                $arr = array("id" => $dados->id, "foto_perfil" => $foto);
                
                $mapper = new Mapper();
                $mapper->setDbTable(new Corretor);
                $mapper->saveOrUpdate($arr);
            }
            
            if($_FILES['logotipo']['name'] != ""){
                $destino_f = URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['usuario_visitado']->login.'/';
                
                if(!is_dir($destino_f))
                    cria_dir($destino_f);
                
                $logotipo = upload('logotipo',$destino_f,true,100);
                
                if($dados->logotipo != "")
                    if(is_file($destino_f.$dados->logotipo))
                        unlink($destino_f.$dados->logotipo);

                $arr = array("id" => $dados->id, "logotipo" => $logotipo);
                
                $mapper = new Mapper();
                $mapper->setDbTable(new Corretor);
                $mapper->saveOrUpdate($arr);
            }
            
            echo '<script>location.href = "'.$_SESSION['usuario_visitado']->login.'/editar-perfil/dados-imagem";</script>'; 
        }        
        
        if((isset($_POST['plano_id'])) || isset($_POST['pacote_id']))
            include('views/pagseguro_editar.php');
        else if(is_file('views/'.url(3).'.php'))
            include('views/'.url(3).'.php');
        else
            echo '<script>location.href = "'.$_SESSION['login'].'";</script>'; 
    }
    else{
        echo '<script>location.href = "home/pagina-nao-existe";</script>'; 
    }
}
else{
    echo '<script>location.href = "home/pagina-nao-existe";</script>'; 
}