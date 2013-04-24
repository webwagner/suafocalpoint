<?php

/**
* pega as cidades pelo id do estado
*/
include('inc/init.inc.php');

$acao = isset($_GET['acao']) ? $_GET['acao'] : FALSE;

header('Content-Type: application/xml');

$xml = "<?xml version='1.0' encoding='iso-8859-1'?>\r\n";

switch ($acao){
    
    case 'buscaCidade':
        buscaCidade();
        break;
    
}

function buscaCidade(){
    
    global $xml;
    $xml .= '<cidades>';
    
    if(isset($_GET['uf'])){
        
        if(preg_match('/[^0-9]/',$_GET['uf'])){
            $mapper = new Mapper();
            $mapper->setDbTable(new ImovelUf());  
            $mapper->setWhere('uf = "'.$_GET['uf'].'"');       
            $row = $mapper->getRow();
            $uf = $row->id;
        }
        else{
            $uf = $_GET['uf'];
        }
        
    }
    else{
        $uf = 1;
    }

    $mapper = new Mapper();
    $mapper->setDbTable(new ImovelCidade());  
    $mapper->setWhere('id_uf = "'.$uf.'"');       
    $mapper->setOrder('cidade ASC');

    $rows = $mapper->getRows();

    foreach ($rows as $row){

        $xml .= '  <cidade>';
        $xml .= '    <id>' . $row->id . '</id>';
        $xml .= '    <nome>' . $row->cidade . '</nome>';
        $xml .= '  </cidade>';
        
    }

    $xml .= '</cidades>';
    echo $xml;
}


?>