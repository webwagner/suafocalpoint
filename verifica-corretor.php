<?php
/**
* faz verificações na tabela corretor
*/
include('inc/init.inc.php');

$mapper = new Mapper();
$mapper->setDbTable(new Corretor());

if(!getGet('valor_atual'))
    $mapper->setWhere(getGet('campo').' = '.'"'.getGet('valor').'"');
else
    $mapper->setWhere(getGet('campo').' = '.'"'.getGet('valor').'" and '.getGet('campo').' <> "'.getGet('valor_atual').'"');

$row = $mapper->getRow();

if($row){
    $retorno['valor'] = 'YES';
}
else{
    $retorno['valor'] = 'NO';
}

echo json_encode($retorno);