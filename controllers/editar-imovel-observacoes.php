<?php
if(!isset($_SESSION['login']) || $_SESSION['login'] != $_SESSION['usuario_visitado']->login)
    echo "<script>location.href = 'home'</script>";

$msg = "";

/**
* Pega os dados do imóvel para editar
*/
if(url(3) != 'editar-imovel-dados'){
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());    
    $mapper->setWhere('id_corretor = "'.$_SESSION['usuario_logado']->id.'" and titulo_url = "'.url(3).'"');
    
    if($mapper->getRow()){
        $dados_imovel = $mapper->getRow();
        
        $id = $dados_imovel->id;
        
        /**
        * Faz o update dos dados
        */
        if(isset($_POST['cep'])){   
            //Retirou a data de vencimento(Volta ao mercado)
            if($dados_imovel->vencimento_contrato != ""){
                if($_POST['vencimento_contrato'] == ""){
                    $_POST['data_volta_mercado'] = date("d/m/Y");
                    
                    /**
                    * Pega os contatos do corretor
                    */ 
                    $mapper_contatos = new Mapper();
                    $mapper_contatos->setDbTable(new Contatos());
                    $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'"');

                    if($mapper_contatos->getRows()){
                        $rows_contatos = $mapper_contatos->getRows();

                        foreach($rows_contatos as $row_contatos){
                            if($row_contatos->corretor_enviou_id == $_SESSION['usuario_logado']->id)
                                $contatos[] = $row_contatos->corretor_recebeu_id;
                            else
                                $contatos[] = $row_contatos->corretor_enviou_id;
                        }
                    }

                    if(count($contatos) > 0){
                        $mapper_corretor = new Mapper();
                        $mapper_corretor->setDbTable(new Corretor());

                        foreach($contatos as $contato){
                            $mapper_corretor->setWhere('id = "'.$contato.'"');
                            $emails[] = $mapper_corretor->getRow()->email;
                        }
                    } 
                    
                    if($dados_imovel->valor_venda != 0.00)
                        $valor_venda = 'Valor Venda : R$'.number_format($dados_imovel->valor_venda,2,',','.');
                    else
                        $valor_venda = '';

                    if($dados_imovel->valor_aluguel != 0.00)
                        $valor_aluguel = 'Valor Aluguel : R$'.number_format($dados_imovel->valor_aluguel,2,',','.');
                    else
                        $valor_aluguel = '';
                    
                    //Envia email para os contatos
                    if(count($emails) > 0){
                        $text = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
                            <tr>
                                <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Imóvel Voltando ao Mercado</td>
                            </tr>
                            </table>
                            <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                                <tr>
                                    <td style="font-family: Arial; font-size: 13px;">
                                        O Corretor '.$_SESSION['usuario_logado']->nome.' recolocou um imóvel no mercado:<br /><br />
                                        Título: '.$dados_imovel->titulo.'<br>
                                        Código: '.$dados_imovel->codigo_imovel.'<br>
                                        '.$valor_aluguel.'<br>
                                        '.$valor_venda.'<br><br>
                                        <a style="display:block;" href="'.URL.$_SESSION['usuario_logado']->login.'/imovel/'.$dados_imovel->titulo_url.'" target="_BLANK">Visualizar</a>
                                    </td>
                                </tr>
                            </table>';

                        email($text, 'Imóvel Voltando ao Mercado', $emails, '', 'bcc');
                    }
                }
            }
            
            $mapper = new Mapper();
            $mapper->setDbTable(new Imovel());
            $mapper->saveOrUpdate($_POST); 
            
            echo '<script>location.href = "'.$_SESSION['login'].'/imovel/'.$dados_imovel->titulo_url.'";</script>';
        }

        include('views/imovel-obs.php');
    }
    else{
        echo '<script>location.href = "home/pagina-nao-existe";</script>';
    }
}
else{
    echo '<script>location.href = "home/pagina-nao-existe";</script>';
}