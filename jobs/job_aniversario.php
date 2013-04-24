<?php
include('/new/inc/init.inc.php');

$mapper = new Mapper();
$mapper->setDbTable(new Corretor());
$mapper->setWhere('concat(substring(data_nascimento,1,2),"/",substring(data_nascimento,4,2)) = concat(substring(CURDATE(),9,2),"/",substring(CURDATE(),6,2))');

$arr = array();
$texto = "";

if ($rows = $mapper->getRows()) {
    $x = 0;

    foreach ($rows as $row) {
        $arr_dados[$row->id]['nome'] = $row->nome;
        $arr_dados[$row->id]['login'] = $row->login;
        
        /**
         * Pega os contatos do corretor
         */
        $mapper_contatos = new Mapper();
        $mapper_contatos->setDbTable(new Contatos());
        $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "' . $row->id . '" or aceitou = "SIM" and corretor_recebeu_id = "' . $row->id . '"');

        if ($rows_contatos = $mapper_contatos->getRows()) {

            foreach ($rows_contatos as $row_contato) {
                if ($row_contato->corretor_enviou_id == $row->id)
                    $arr[$row_contato->corretor_recebeu_id][$x] = $row->id;
                else
                    $arr[$row_contato->corretor_enviou_id][$x] = $row->id;
            }
        }

        $x++;
    }
}

if (count($arr) > 0) {
    $texto = "E-mails enviados de aniversário ".date('d/m/Y')." às ".date('H:i')."\r\n";
    
    foreach ($arr as $key => $val) {
        $mapper->setWhere("id = '".$key."'");
        $row = $mapper->getRow();
        
        $text = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
            <tr>
                <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Corretores que fazem aniversário hoje</td>
            </tr>
         </table>';
        $email = array($row->email);
        
        $texto .= "E-mail: ".$row->email.'\r\n';
        
        foreach ($val as $vl) {
            $text .= '<table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                        <tr>
                            <td style="font-family: Arial; font-size: 13px;">
                                O Corretor <a href="'.URL.$arr_dados[$vl]['login'].'">'.$arr_dados[$vl]['nome'].'</a> faz aniversário hoje.<br />
                                Clique <a href="'.URL.$row->login.'/mensagem-enviar/'.$vl.'">aqui</a> e envie uma mensagem parabenizando. 
                            </td>
                        </tr>
                     </table>';
            
            $texto .= "Aniversariantes: ".$arr_dados[$vl]['nome']."\r\n";
        }
        
        email($text, 'Aniversariantes do dia - ' . SITE, $email);
    }
    
    $texto .= "\r\n";
}

$file = fopen( URL_ABSOLUTE.'logs/job_aniversario.txt','a' );
$fp = fwrite( $file,$texto );
fclose($file);
?>
