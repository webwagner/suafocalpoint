<?php

$retorno = '';

if($_POST){
    
    $email = getPost('email_esqueci');
    
    /**
    * Verefica se o email est� cadastrado
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Corretor());   
    $mapper->setWhere('email = "'.$email.'"');
    $row = $mapper->getRow();

    /**
    * Se verdadeiro enviao email para nova senha se falso mensagem de usu�rio inexistente
    */
    if($row){
        $text = "<table><tr><td>Ol� ".$row->nome."<br><a href='".URL."home/nova-senha/".$row->id."'>Clique aqui e insira sua nova senha.</td></tr></table>";
        $mails = array($email);
        $subject = "Nova Senha - Site Sua Focal Point";
        email($text, $subject, $mails,'home/esqueci-minha-senha-enviado');
    }
    else{
        $retorno = '<font color="red">Usu�rio n�o existe.</font>';
    }

}

include('views/esqueci-minha-senha.php'); 