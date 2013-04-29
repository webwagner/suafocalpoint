<?php
include('inc/init.inc.php');

$mapper = new Mapper();
$mapper->setDbTable(new Alerta());
$rows = $mapper->getRows();

$diff    = 0;
$acertos = 0;
$texto   = "";

$text = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
            <tr>
                <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Alerta de Im&oacute;vel</td>
            </tr>
         </table>';

if (count($rows) > 0) {
    foreach ($rows as $row) {

        $data = explode("-", substr($row->data_cadastro_alerta, 0, 10));
        $data_expiracao = date("Y-m-d", mktime(0, 0, 0, $data[1] + 3, $data[2], $data[0]));

        $time1 = strtotime(date("Y-m-d"));
        $time2 = strtotime($data_expiracao);

        //Data de expiração passou
        if ($time1 >= $time2) {
            //Apago o alerta
            $mapper->setWhere("id = '" . $row->id . "'");
            $mapper->delete();
        } else {
            /**
             * Pega os contatos do corretor
             */
            $mapper_contatos = new Mapper();
            $mapper_contatos->setDbTable(new Contatos());
            $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "' . $row->id_corretor . '" or aceitou = "SIM" and corretor_recebeu_id = "' . $row->id_corretor . '"');

            if ($rows_contatos = $mapper_contatos->getRows()) {

                $contatos = "";

                foreach ($rows_contatos as $row_contatos) {
                    if ($row_contatos->corretor_enviou_id == $row->id_corretor)
                        $contatos.= $row_contatos->corretor_recebeu_id.',';
                    else
                        $contatos.= $row_contatos->corretor_enviou_id.',';
                }

                //Pega os imóveis do corretor do alerta
                $mapper_imoveis = new Mapper();
                $mapper_imoveis->setDbTable(new Imovel());
                $mapper_imoveis->setWhere("id_corretor IN ( ".$contatos.$row->id_corretor." )");
                
                if($rows_imoveis = $mapper_imoveis->getRows()){
                    
                    foreach ($rows_imoveis as $row_imovel) {

                        if ($row->tipo_imovel_id != ""){
                            $arr_tipo_imovel_id = explode(",", $row->tipo_imovel_id);
                            
                            if(!in_array($row_imovel->tipo_imovel_id, $arr_tipo_imovel_id))
                                $diff++;
                        }
                        
                        if ($row->residencial == 'SIM')
                            if ($row_imovel->residencial != 'SIM')
                                $diff++;

                        if ($row->comercial == 'SIM')
                            if ($row_imovel->comercial != 'SIM')
                                $diff++;

                        if ($row->comercial == 'SIM')
                            if ($row_imovel->comercial != 'SIM')
                                $diff++;

                        if ($row->aluguel == 'SIM')
                            if ($row_imovel->aluguel != 'SIM')
                                $diff++;

                        if ($row->valor_aluguel != 0.00)
                            if ($row->valor_aluguel < $row_imovel->valor_aluguel)
                                $diff++;

                        if ($row->valor_venda != 0.00)
                            if ($row->valor_venda < $row_imovel->valor_venda)
                                $diff++;

                        if ($row->quartos_atual != "")
                            if ($row->quartos_atual != $row_imovel->quartos_atual)
                                $diff++;

                        if ($row->area_construida_maior != 0)
                            if ($row->area_construida_maior > $row_imovel->area_construida)
                                $diff++;

                        if ($row->area_construida_menor != 0)
                            if ($row->area_construida_menor < $row_imovel->area_construida)
                                $diff++;

                        if ($row->portaria_24h == 'SIM')
                            if ($row_imovel->portaria_24h != 'SIM')
                                $diff++;

                        if ($row->varanda == 'SIM')
                            if ($row_imovel->varanda != 'SIM')
                                $diff++;

                        if ($row->mobiliado == 'SIM')
                            if ($row_imovel->mobiliado != 'SIM')
                                $diff++;

                        if ($row->piscina == 'SIM')
                            if ($row_imovel->piscina != 'SIM')
                                $diff++;

                        if ($row->nome_condominio != "")
                            if ($row->nome_condominio != $row_imovel->nome_condominio)
                                $diff++;

                        if ($row->uf_imovel != "")
                            if ($row->uf_imovel != $row_imovel->uf_imovel)
                                $diff++;

                        if ($row->cidade_imovel != "")
                            if ($row->cidade_imovel != $row_imovel->cidade_imovel)
                                $diff++;

                        if ($row->bairro_imovel != ""){
                            $arr_bairro = explode(",",$row->bairro_imovel);
                            
                            if(!in_array($row_imovel->bairro_imovel, $arr_bairro))
                                $diff++;
                        }
                          
                        //Achou o imovel
                        if ($diff == 0) {
                           
                            $acertos++;
                            
                            $mapper_corretor = new Mapper();
                            $mapper_corretor->setDbTable(new Corretor());
                            $mapper_corretor->setWhere("id = '".$row_imovel->id_corretor."'");
                            $corretor_imovel = $mapper_corretor->getRow();
        
                            /**
                            * Monta o Email
                            */   
                            $text .='<table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                                <tr>
                                    <td style="font-family: Arial; font-size: 13px;">
                                        O Im&oacute;vel <a href="'.URL.$corretor_imovel->login.'/imovel/'.$row_imovel->titulo_url.'">'.$row_imovel->titulo.'</a> atende as solicita&ccedil;&otilde;es<br />
                                        do seu alerta '.$row->titulo_alerta.'.
                                    </td>
                                </tr>
                            </table>';
                            
                            $mapper_corretor->setWhere("id = '".$row->id_corretor."'");
                            $corretor_alerta = $mapper_corretor->getRow();
                            
                            $email = array($corretor_alerta->email);
                            email($text, 'Alerta Imóvel', $email);
                            
                            $texto .= "Alerta em ".date('d/m/Y')." às ".date('H:i')."\r\n";
                            $texto .= "Im&oacute;vel: ".$row_imovel->titulo."\r\n";
                            $texto .= "Alerta: ".$row->titulo_alerta."\r\n\r\n";
                        }
                        
                        $diff = 0;
                    }
                }    
            }
        }
    }
}

if($acertos > 0){
    $file = fopen( URL_ABSOLUTE.'logs/job_alerta.txt','a' );
    $fp = fwrite( $file,$texto );
    fclose($file);
}
?>