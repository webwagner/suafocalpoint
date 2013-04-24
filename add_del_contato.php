<?php

include('inc/init.inc.php');

/**
* adiciona ou deleta um contato
*/
$mapper = new Mapper();
$mapper->setDbTable(new Contatos());

if($_GET['type'] == 'add'){
    
    if(isset($_GET['id'])){
        $data = array("id" => $_GET['id'], "aceitou" => "SIM");
        $send_email = false;
    }
    else{
        $data = array("corretor_enviou_id" => $_GET['id_enviou'], "corretor_recebeu_id" => $_GET['id_recebeu'], "aceitou" => "NAO");
        $send_email = true;
    }
    
    if($mapper->saveOrUpdate($data)){
        
        if($send_email){
            $mapper = new Mapper();
            $mapper->setDbTable(new Corretor);
            $mapper->setWhere("id = '".$_GET['id_recebeu']."'");
            $corretor1 = $mapper->getRow();

            $mapper->setWhere("id = '".$_GET['id_enviou']."'");
            $corretor2 = $mapper->getRow();

            $assinatura = "<br>Sua Focal Point: Rede de Ferramentas para Corretores - <a href='http://www.suafocalpoint.com/new'>http://www.suafocalpoint.com</a>";

            $text1 = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
            <tr>
                <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Sua Focal Point - Solicitação de contato</td>
            </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                <tr>
                    <td style="font-family: Arial; font-size: 13px;">O corretor '.$corretor2->nome.' lhe fez uma solicitação de contato no dia '.date("d-m-Y").' às '.date("H:i").'</td>
                </tr>
            </table>';
            $mail1 = array($corretor1->email);   
            $subject1 = "Mensagem - Site Sua Focal Point";   
            email($text1.$assinatura, $subject1, $mail1);

            $text2 = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
            <tr>
                <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Sua Focal Point - Solicitação de contato</td>
            </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                <tr>
                    <td style="font-family: Arial; font-size: 13px;">Sua solicitação de contato foi enviada ao corretor '.$corretor1->nome.' no dia '.date("d-m-Y").' às '.date("H:i").'</td>
                </tr>
            </table>';
            $mail2 = array($corretor2->email);   
            $subject2 = "Mensagem - Site Sua Focal Point";   
            email($text2.$assinatura, $subject1, $mail2);
        }
        
        $retorno['valor'] = 'YES';
    }
    else{
        $retorno['valor'] = 'NO';
    }
}

else if($_GET['type'] == 'del'){
    if(isset($_GET['id'])){
        $mapper->setWhere('id = "'.$_GET['id'].'"');
        $send_email = false;
    }
    else{
        $mapper->setWhere('(corretor_enviou_id = "'.$_GET['id_enviou'].'" and corretor_recebeu_id = "'.$_GET['id_recebeu'].'") or (corretor_recebeu_id = "'.$_GET['id_enviou'].'" and corretor_enviou_id = "'.$_GET['id_recebeu'].'")');
        $send_email = true;
    }

    if($mapper->delete()){
        if($send_email){
            $mapper = new Mapper();
            $mapper->setDbTable(new Corretor);
            $mapper->setWhere("id = '".$_GET['id_recebeu']."'");
            $corretor1 = $mapper->getRow();

            $mapper->setWhere("id = '".$_GET['id_enviou']."'");
            $corretor2 = $mapper->getRow();

            $text1 = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
            <tr>
                <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Sua Focal Point - Desligamento de contato</td>
            </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                <tr>
                    <td style="font-family: Arial; font-size: 13px;">"O usuário '.$corretor1->nome.' desligou-se da sua rede de parceiros no dia '.date("d-m-Y").' às '.date("H:i").'"</td>
                </tr>
            </table>';
            $mail1 = array($corretor2->email);   
            $subject1 = "Mensagem - Site Sua Focal Point";   
            email($text1, $subject1, $mail1);

            $text2 = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
            <tr>
                <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Sua Focal Point - Desligamento de contato</td>
            </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                <tr>
                    <td style="font-family: Arial; font-size: 13px;">O usuário '.$corretor2->nome.' desligou-se da sua rede de parceiros no dia '.date("d-m-Y").' às '.date("H:i").'</td>
                </tr>
            </table>';
            $mail2 = array($corretor1->email);   
            $subject2 = "Mensagem - Site Sua Focal Point";   
            email($text2, $subject1, $mail2);
        }
        $retorno['valor'] = 'YES';
    }
    else{
        $retorno['valor'] = 'NO';
    }
}

echo json_encode($retorno);