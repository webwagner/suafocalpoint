<?php
include('inc/init.inc.php');

$ids = explode(',',$_GET['id']);

$mapper = new Mapper();
$mapper->setDbTable(new Mensagens());

/**
* verifica se recebeu ids de mensagens
*/
if(count($ids) > 0){
    foreach ($ids as $id){
        
        /**
        * exclui a mensagem ou marca como lida ou não lida
        */
        if($_GET['type'] == 'excluir'){
            $mapper->setWhere('id = "'.$id.'"');
            $mensagem = $mapper->getRow();
            
            /**
            * se a mensagem já foi marcada como excluida por quem enviou ou recebeu deleta senão marca como excluida
            */
            if($mensagem->exclui_recebeu == "SIM" || $mensagem->exclui_enviou == "SIM"){
                $mapper->delete();
            }
            else{
                if($mensagem->corretor_enviou_id == $_GET['id_corretor'])
                    $data = array("id" => $id, "exclui_enviou" => "SIM");
                else
                    $data = array("id" => $id, "exclui_recebeu" => "SIM");
                
                $mapper->saveOrUpdate($data); 
            }
        }
        else if($_GET['type'] == 'lida-recebeu'){
            $data = array("id" => $id, "lida_recebeu" => "SIM");
            $mapper->saveOrUpdate($data);
        }
        else if($_GET['type'] == 'nao-lida-recebeu'){
            $data = array("id" => $id, "lida_recebeu" => "NAO");
            $mapper->saveOrUpdate($data);
        }
        else if($_GET['type'] == 'lida-enviou'){
            $data = array("id" => $id, "lida_enviou" => "SIM");
            $mapper->saveOrUpdate($data);
        }
        else if($_GET['type'] == 'nao-lida-enviou'){
            $data = array("id" => $id, "lida_enviou" => "NAO");
            $mapper->saveOrUpdate($data);
        }

    }
    $retorno['valor'] = 'YES';
}
else{
    $retorno['valor'] = 'NO';
}

echo json_encode($retorno);