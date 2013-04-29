<?php
if(isset($_POST['nome'])){    
    
    if(isset($_SESSION['dados']['uf'])){
        if($_POST['uf'] == ""){
            $estado = $_SESSION['dados']['uf']; 
        }
        else{
            /**
            * Pega o estado pelo id
            */
            $mapper = new Mapper();       
            $mapper->setDbTable(new ImovelUf());   
            $mapper->setWhere('id = '.$_POST['uf']);    
            $estado = $mapper->getRow();
            $estado = $estado->uf;
        }
    }
    else{
        /**
        * Pega o estado pelo id
        */
        $mapper = new Mapper();       
        $mapper->setDbTable(new ImovelUf());   
        $mapper->setWhere('id = '.$_POST['uf']);    
        $estado = $mapper->getRow();
        $estado = $estado->uf;
    }
    
    if(isset($_SESSION['dados']['uf'])){
        if($_POST['cidade'] == ""){
            $cidade = $_SESSION['dados']['cidade']; 
        }
        else{
            /**
            * Pega a cidade pelo id
            */
            $mapper = new Mapper();   
            $mapper->setDbTable(new ImovelCidade());   
            $mapper->setWhere('id = '.$_POST['cidade']);   
            $cidade = $mapper->getRow();
            $cidade = $cidade->cidade;
        }
    }
    else{
        /**
        * Pega a cidade pelo id
        */
        $mapper = new Mapper();   
        $mapper->setDbTable(new ImovelCidade());   
        $mapper->setWhere('id = '.$_POST['cidade']);   
        $cidade = $mapper->getRow();
        $cidade = $cidade->cidade;
    }

    $login = getUrl(trim($_POST['login']));

    if(isset($_SESSION['dados']['foto_perfil'])){
        $destino_f = URL_ABSOLUTE.'static/uploads/fotos/'.$login;
        
        if($_FILES['foto']['name'] != ''){
            if($_SESSION['dados']['foto_perfil'] != "")
                if(is_file(URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['dados']['login_corretor'].'/'.$_SESSION['dados']['foto_perfil']))
                    unlink(URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['dados']['login_corretor'].'/'.$_SESSION['dados']['foto_perfil']);

            if($_SESSION['dados']['login_corretor'] != $login)  
                if(is_dir(URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['dados']['login_corretor']))
                    rename(URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['dados']['login_corretor'],$destino_f);
            
            if(!is_dir($destino_f))
                cria_dir($destino_f);

            $foto = upload('foto',$destino_f.'/');
        }
        else{
            $foto = $_SESSION['dados']['foto_perfil'];
            
            if($_SESSION['dados']['login_corretor'] != $login)  
                if(is_dir(URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['dados']['login_corretor']))
                    rename(URL_ABSOLUTE.'static/uploads/fotos/'.$_SESSION['dados']['login_corretor'],$destino_f);
            
        }
    }
    else{
        if($_FILES['foto']['name'] != ''){
            $destino_f = URL_ABSOLUTE.'static/uploads/fotos/'.$login;

            if(!is_dir($destino_f))
                cria_dir($destino_f);

            $foto = upload('foto',$destino_f.'/');

        }
        else{    
            $foto = '';       
        }
    }
    
    if(isset($_SESSION['dados']['logotipo'])){
        $destino_f = URL_ABSOLUTE.'static/uploads/logotipos/'.$login;
        
        if($_FILES['logotipo']['name'] != ''){
            if($_SESSION['dados']['logotipo'] != "")
                if(is_file(URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['dados']['login_corretor'].'/'.$_SESSION['dados']['logotipo']))
                    unlink(URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['dados']['login_corretor'].'/'.$_SESSION['dados']['logotipo']);

            if($_SESSION['dados']['login_corretor'] != $login)  
                if(is_dir(URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['dados']['login_corretor']))
                    rename(URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['dados']['login_corretor'],$destino_f);
            
            if(!is_dir($destino_f))
                cria_dir($destino_f);

            $logotipo = upload('logotipo',$destino_f.'/');
        }
        else{
            $logotipo = $_SESSION['dados']['logotipo'];
            
            if($_SESSION['dados']['login_corretor'] != $login)  
                if(is_dir(URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['dados']['login_corretor']))
                    rename(URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['dados']['login_corretor'],$destino_f);
            
        }
    }
    else{
        if($_FILES['foto']['name'] != ''){
            $destino_f = URL_ABSOLUTE.'static/uploads/logotipos/'.$login;

            if(!is_dir($destino_f))
                cria_dir($destino_f);

            $logotipo = upload('logotipo',$destino_f.'/');

        }
        else{    
            $logotipo = '';       
        }
    }

    $arr = array(
                'nome' => $_POST['nome'], 
                'creci' => $_POST['creci'], 
                'login_corretor' => $login, 
                'email' => $_POST['email'], 
                'empresa' => $_POST['empresa'], 
                'data_nascimento' => $_POST['data_nascimento'],
                'senha' => $_POST['senha'],
                'cep' => $_POST['cep'],
                'rua' => $_POST['rua'],
                'numero' => $_POST['numero'],
                'complemento' => $_POST['complemento'],
                'bairro' => $_POST['bairro'],
                'uf' => $estado,
                'cidade' => $cidade,
                'telefone' => $_POST['ddd'].' '.$_POST['telefone'],
                'celular' => $_POST['ddd_celular'].' '.$_POST['celular'],
                'telefone2' => $_POST['ddd2'].' '.$_POST['telefone2'],
                'celular2' => $_POST['ddd_celular2'].' '.$_POST['celular2'],
                'foto_perfil' => $foto,
                'logotipo' => $logotipo,
                'ativado' => 'NAO',
                'website' => $_POST['website'],
          );   
    
     if($_POST['pessoa'] == 'fisica'){
         $arr['cpf']      = $_POST['cpf'];
         $arr['sexo']     = $_POST['sexo'];
         $arr['autonomo'] = $_POST['autonomo'];
     } else {
         $arr['cnpj']           =  $_POST['cnpj'];
         $arr['pessoa_contato'] = $_POST['pessoa_contato'];
     }
    
    $_SESSION['dados'] = $arr;
    
    /**
    * Verifica se a indicação e a inseri
    */
    if($_POST['indicacao'] != ""){
        $arr_ind = array("id_indicou" => $_POST['indicacao']);
    
        $_SESSION['dados'] = array_merge($_SESSION['dados'], $arr_ind);
    }

}
elseif(isset($_POST['sigla'])){

    if($_POST['outros'] != "")
        $como_conheceu = $_POST['como_conheceu'].' '.$_POST['outros'];
    else
        $como_conheceu = $_POST['como_conheceu'];
        
    $arr = array(
                'como_conheceu' => $como_conheceu, 
                'dados_listados' => $_POST['dados_listados'], 
                'sigla' => strtoupper($_POST['sigla'])
          );
    
    $_SESSION['dados'] = array_merge($_SESSION['dados'],$arr);

}
elseif(isset($_POST['pacote'])){
    unset($_SESSION['dados']['pacote_id']);
    
    if(isset($_POST['pacote_id'])){
        $arr = array('pacote_id' => $_POST['pacote_id']);
        
        if(isset($_SESSION['dados']))
            $_SESSION['dados'] = array_merge($_SESSION['dados'],$arr);
    } 
}
elseif(isset($_POST['plano_id'])){
    
    $login = $_SESSION['dados']['login_corretor'];
    unset($_SESSION['dados']['login_corretor']);
    
    $senha = md5($_SESSION['dados']['senha']);
    unset($_SESSION['dados']['senha']);
    
    if(isset($_SESSION['dados']['id_indicou'])){
        $id_indicou = $_SESSION['dados']['id_indicou'];
        
        unset($_SESSION['dados']['id_indicou']);
    }
    else{
        $id_indicou = "";
    }
    
    $arr = array('plano_id' => $_POST['plano_id'], 'senha' => $senha, 'login' => $login);
    
    $_SESSION['dados'] = array_merge($_SESSION['dados'],$arr);
    
    /**
    * Inseri o corretor
    */
    $mapper = new Mapper();    
    $mapper->setDbTable(new Corretor());   
    $id = $mapper->saveOrUpdate($_SESSION['dados']);
    
    /**
    * Inseri a indicacao
    */
    if($id_indicou != ""){
        $mapper = new Mapper();
        $mapper->setDbTable(new Indicacao());
        $mapper->saveOrUpdate(array("id_indicou" => $id_indicou, "id_indicado" => $id, "pago" => "NAO"));
    }

    /**
    * Envia o Email de confirmação
    */   
    $text = "<table>
                <tr><td>
                    <img src='".URL."static/img/confirmacao_cadastro.png' alt='Suafocalpoint' />
                </td></tr>
                <tr><td>
                    Olá ".$_SESSION['dados']['nome']."<br><br> Parabéns! Você se registrou com sucesso em Sua Focal Point e está pronto para ser o PONTO FOCAL de seus clientes e potenciais clientes.<br><br>Você também pode começar a construir sua rede de negócios, convidando colegas com os quais você já tenha uma relação de trabalho e confiança.<br><br>Convide-os para participar de Sua Focal Point e lembre-os de utilizar o link que receberão por e-mail, para que você possa obter o desconto de meio mês (50%) ao expandir a sua rede!<br><br>
                </td></tr>
                <tr><td>
                    <a href='".URL."'><img src='".URL."static/img/bt_confirmacao_cadastro.png' alt='Suafocalpoint' /></a>
                </td></tr>
            </table>";
    
    $mails = array($_SESSION['dados']['email']);   
    $subject = "Cadastro - Site Sua Focal Point";   
    email($text, $subject, $mails);
    
    session_destroy();

}

if(is_file('views/'.url(3).'.php')){

    if(url(3) == 'dados-cadastro'){
        $indicacao = ''; 
        
        if(url(4) != "dados-cadastro"){
            $mapper = new Mapper();
            $mapper->setDbTable(new Corretor()); 
            $mapper->setWhere('sigla = "'.url(4).'"');

            if($mapper->getRow()){
                $corretor = $mapper->getRow();
                $indicacao = $corretor->id;
            }  
        }
        
         /**
        * Lista os estados
        */
        $mapper = new Mapper();
        $mapper->setDbTable(new ImovelUf());   
        $mapper->setOrder('id ASC');   
        $rows = $mapper->getRows();
    }
    elseif(url(3) == "termo-de-uso"){
        /**
        * Lista comoconheceu
        */
        $mapper_comoconheceu = new Mapper();
        $mapper_comoconheceu->setDbTable(new Comoconheceu());
        $mapper_comoconheceu->setOrder('id ASC');
        $rows_comoconheceu = $mapper_comoconheceu->getRows();
    }
    elseif(url(3) == "escolha-seu-pacote"){       
        /**
        * Lista planos
        */
        $mapper = new Mapper();          
        $mapper->setDbTable(new Pacotes());   
        $mapper->setOrder('id ASC');    
        $pacotes = $mapper->getRows();
    }
    elseif(url(3) == "escolha-seu-plano"){       
        /**
        * Lista planos
        */
        $mapper = new Mapper();          
        $mapper->setDbTable(new Planos());   
        $mapper->setOrder('id ASC');    
        $planos = $mapper->getRows();
    }
    elseif(url(3) == "pagseguro"){
        /**
        * Pega o plano
        */
        $mapper = new Mapper();
        $mapper->setDbTable(new Planos());       
        $mapper->setWhere('id = '.$_POST['plano_id']);      
        $plano = $mapper->getRow();
        
        /**
        * Calculo da data do próximo pagamento
        */
        $data_proximo = date('Y-m-d H:i:s', strtotime("+".$plano->dias." days"));
        
        /**
        * Inseri o pagamento
        */
        $mapper = new Mapper();
        $mapper->setDbTable(new Pagamento());      
        $arr = array('corretor_id' => $id, 'plano_pacote_id' => $_POST['plano_id'], 'retorno' => 'Aguardando Pagto', 'tipo' => 1, 'data_solicitacao' => date("Y-m-d H:i:s"), 'data_proximo' => $data_proximo);
        $id_pag = $mapper->saveOrUpdate($arr);
        
        if(isset($_SESSION['dados']['pacote_id'])){
            $mapper = new Mapper();
            $mapper->setDbTable(new Pagamento());      
            $arr = array('corretor_id' => $id, 'plano_pacote_id' => $_SESSION['dados']['pacote_id'], 'retorno' => 'Aguardando Pagto', 'tipo' => 2, 'data_solicitacao' => date("Y-m-d H:i:s"));
            $id_pag2 = $mapper->saveOrUpdate($arr);
            
            /**
            * Pega o o pacote
            */
            $mapper = new Mapper();
            $mapper->setDbTable(new Pacotes());       
            $mapper->setWhere('id = '.$_SESSION['dados']['pacote_id']);      
            $pacote = $mapper->getRow();
        }
        
    }
    
    if(!isset($_SESSION['dados']))
        include('views/dados-cadastro.php');
    else
        include('views/'.url(3).'.php');
}
else{  
    echo '<script>location.href = "home/pagina-nao-existe";</script>';  
}