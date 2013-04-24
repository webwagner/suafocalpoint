<?php

if(!isset($_SESSION['login']) || !isset($_SESSION['usuario_visitado']->login)){
    echo "<script>location.href = 'home'</script>";
}
elseif($_SESSION['usuario_visitado']->login != $_SESSION['login']){
    echo "<script>location.href = '".$_SESSION['login']."'</script>";
}
else{
    $msg = '';
    
    $id_corretor = $_SESSION['usuario_logado']->id;
            
    $mapper = new Mapper();
    $mapper->setDbTable(new Alerta());
    $mapper->setWhere('id_corretor = "'.$id_corretor.'"');
    $total = $mapper->getTotal();
    
    /**
    * Pega a cidade do corretor
    */
    $mapper_cidade = new Mapper();
    $mapper_cidade->setDbTable(new ImovelCidade());
    $mapper_cidade->setWhere('cidade = "'.$_SESSION['usuario_logado']->cidade.'"');
    if(!$cidade_corretor = $mapper_cidade->getRow())
        $cidade_corretor->id = 1;
    
    /**
    * Pega o estado do corretor
    */
    $mapper_estado = new Mapper();
    $mapper_estado->setDbTable(new ImovelUf());
    $mapper_estado->setWhere('uf = "'.$_SESSION['usuario_logado']->uf.'"');
    if(!$estado_corretor = $mapper_estado->getRow())
        $estado_corretor->id = 1;
    
    $mapper_bairro = new Mapper();
    $mapper_bairro->setDbTable(new ImovelBairro());
    $mapper_bairro->setWhere('id_cidade = '.$cidade_corretor->id);
    $mapper_bairro->setOrder('bairro ASC');
    $bairros = $mapper_bairro->getRows();

    $arr_bairros = array();
    $arr_tipos   = array();
    
    if($_POST){
        if(isset($_POST['id'])){
            if($_POST['acao'] == 'excluir'){
                $mapper->setWhere('id = "'.$_POST['id'].'"');
                $mapper->delete();

                $msg = "Alerta deletado com sucesso.";
            }
            else{
                $mapper->setWhere('id = "'.$_POST['id'].'"');
                $alerta = $mapper->getRow();
                
                /**
                * Pega o tipo do imóvel
                */
                if($alerta->tipo_imovel_id != "")
                    $arr_tipos = explode(",",$alerta->tipo_imovel_id);

                /**
                * Pega o bairro do imóvel
                */
                if($alerta->bairro_imovel != "")
                    $arr_bairros = explode(",",$alerta->bairro_imovel);
            }
        }
        else{
            if($total < 10){                   
                /**
                * Salva o alerta
                */
                if(!isset($_POST['comercial']))
                $_POST['comercial'] = 'NAO';

                if(!isset($_POST['residencial']))
                    $_POST['residencial'] = 'NAO';

                if(!isset($_POST['aluguel']))
                    $_POST['aluguel'] = 'NAO';

                if(!isset($_POST['compra']))
                    $_POST['compra'] = 'NAO';

                if(!isset($_POST['portaria_24h']))
                    $_POST['portaria_24h'] = 'NAO';

                if(!isset($_POST['mobiliado']))
                    $_POST['mobiliado'] = 'NAO';

                if(!isset($_POST['varanda']))
                    $_POST['varanda'] = 'NAO';

                if(!isset($_POST['piscina']))
                    $_POST['piscina'] = 'NAO';

                $arr_valores = array("valor_aluguel"  => convertPreco($_POST['valor_aluguel']), 
                                      "valor_venda"   => convertPreco($_POST['valor_venda']),
                                      "valor_minimo_aluguel"  => convertPreco($_POST['valor_minimo_aluguel']), 
                                      "valor_minimo_venda"   => convertPreco($_POST['valor_minimo_venda']),
                                      "cidade_imovel" => $cidade_corretor->id,
                                      "uf_imovel"     => $estado_corretor->id
                                     ); 	

                if(isset($_POST['id_alerta'])){
                    $arr_id = array("id" => $_POST['id_alerta']);

                    $arr = array_merge($arr_id, $_POST);
                }
                else{
                    $arr = $_POST;
                }

                if(count($_POST['bairro']) > 0){
                    $bairros = "";
                    foreach($_POST['bairro'] as $bairro){
                        $bairros .= $bairro.',';
                    }
                    $arr_bairro['bairro_imovel'] = substr($bairros, 0, -1);
                    $arr = array_merge($arr,$arr_bairro);
                }
                
                if(count($_POST['tipo_imovel_id']) > 0){
                    $tipos = "";
                    foreach($_POST['tipo_imovel_id'] as $tipo)
                        if($tipo != "")
                            $tipos .= $tipo.',';
                    
                    $arr_tipo['tipo_imovel_id'] = substr($tipos, 0, -1);
                    $arr = array_merge($arr,$arr_tipo);
                }

                $arr_f = array_merge($arr,$arr_valores);

                $mapper->saveOrUpdate($arr_f);

                $msg = 'Alerta salvo com sucesso.';

            }
            else{
                $msg = 'Você já atingiu o limite de 10 alertas por vez.';
            }
        }
    }
    
    $mapper->setWhere('id_corretor = "'.$id_corretor.'"');
    $rows  = $mapper->getRows();
     
    if(count($rows) == 0)
        $msg = "Você não possui alerta.";

    /**
    * Lista os tipos de imóveis
    */
    $mapper_tipo = new Mapper();
    $mapper_tipo->setDbTable(new ImovelTipo());
    $mapper_tipo->setOrder('id ASC');
    $rows_tipo = $mapper_tipo->getRows();

    include('views/alerta.php');  
 
}