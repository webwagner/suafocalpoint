<?php

$retorno = '';

if($_POST){
    
    $email = getPost('email_esqueci');
    
    /**
    * Verefica se o email está cadastrado
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Corretor());   
    $mapper->setWhere('email = "'.$email.'"');
    $row = $mapper->getRow();

    /**
    * Se verdadeiro enviao email para nova senha se falso mensagem de usuário inexistente
    */
    if($row){
        $text = "<table><tr><td>Olá ".$row->nome."<br><a href='".URL."home/nova-senha/".$row->id."'>Clique aqui e insira sua nova senha.</td></tr></table>";
        $mails = array($email);
        $subject = "Nova Senha - Site Sua Focal Point";
        email($text, $subject, $mails,'home/esqueci-minha-senha-enviado');
    }
    else{
        $retorno = '<font color="red">Usuário não existe.</font>';
    }

}

include('views/esqueci-minha-senha.php'); 