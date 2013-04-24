<?php

$msg = '';

if($_POST){
    $text = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
        <tr>
            <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Sua Focal Point - Fale Conosco</td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
        <tr>
            <td style="font-family: Arial; font-size: 13px;"><b>Nome:</b> '.$_POST['nome'].'</td>
        </tr>
        <tr>
            <td style="font-family: Arial; font-size: 13px;"><b>Email:</b> '.$_POST['email'].'</td>
        </tr>
        <tr>
            <td style="font-family: Arial; font-size: 13px;"><b>Mensagem:</b> '.$_POST['mensagem'].'</td>
        </tr>
    </table>';

    $mails = array('webwagner@hotmail.com','ron@focalpointbrasil.com');

    if(email($text, 'Fale Conosco - '.SITE, $mails))
        $msg = '<p style="float:none;color:blue;">Obrigado!</p>
                <p style="float:none;color:blue;">Mensagem enviada com sucesso!</p>
                <p style="float:none;color:blue; margin-bottom:20px;">Em breve entraremos em contato.</p>';
}

if(url(1) <> 'home')
    include('views/fale-conosco-logado.php'); 
else
    include('views/fale-conosco.php'); 

