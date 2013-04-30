<?php
include('/home/suafocalpoint/public_html/new/inc/init.inc.php');

$mapper = new Mapper();
$mapper->setDbTable(new Imovel());
$mapper->setWhere("vencimento_contrato = '".date('d/m/Y')."'");
$rows = $mapper->getRows();

$mapper_c = new Mapper();
$mapper_c->setDbTable(new Corretor());

$texto = "";

if(count($rows) > 0){
    
    $texto = "Imoveis com data de vencimento em ".date('d/m/Y')." às ".date('H:i')."\r\n";

    foreach($rows as $row){
        
        $mapper_c->setWhere("id = '".$row->id_corretor."'");
        $corretor = $mapper_c->getRow();
        
        if($corretor->email != ""){
            
            $email = array($corretor->email);
        
            $text = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
            <tr>
                <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Imóvel Vencendo o Contrato</td>
            </tr>
            </table>
            <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                <tr>
                    <td style="font-family: Arial; font-size: 13px;">
                        O Imóvel <a href="'.URL.$corretor->login.'/imovel/'.$row->titulo_url.'">'.$row->titulo.'</a> está com o contrato vencendo hoje,<br />
                        ligue para o proprietário para saber se o imóvel está vago novamente.
                    </td>
                </tr>
            </table>';
            email($text, 'Vencimento Imóvel - '.SITE, $email, '', 'bcc');
            
            $texto .= "E-mail: ".$corretor->email."\r\n";
            $texto .= "Imóvel: ".$row->titulo."\r\n\r\n";
            
        }
    }
    
    $file = fopen( URL_ABSOLUTE.'logs/job_vencimento.txt','a' );
    $fp = fwrite( $file,$texto );
    fclose($file);
    
}
     
?>