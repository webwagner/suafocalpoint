<?php

include('inc/init.inc.php');

$mapper = new Mapper();
$class = new Corretor();
$mapper->setDbTable($class);
$login = getGet('login');
$mapper->setWhere('login = "'.$login.'"');
$row = $mapper->getRow();

if($row){
    $retorno['valor'] = 'YES';
}
else{
    $retorno['valor'] = 'NO';
}

echo json_encode($retorno);