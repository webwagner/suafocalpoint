<?php
include('/new/inc/init.inc.php');

/**
 * Inativa corretores com pagamento em atraso de 10 dias
 */
$tolerancia = 10;
$texto = "";

// Busco os pagamentos que vencem nesta data
$mapper = new Mapper();
$mapper->setDbTable(new Pagamento());
$mapper->setWhere("substring(DATE_ADD(data_proximo, INTERVAL ".$tolerancia." DAY),1,10) = curdate() and tipo = 1");
$rows = $mapper->getRows();

$mapper_corretor = new Mapper();
$mapper_corretor->setDbTable(new Corretor());

foreach($rows as $row){
    $mapper->setWhere("corretor_id = '".$row->corretor_id."' and data_proximo > '".$row->data_proximo."' and tipo = 1 and (retorno = 'Completo' or retorno = 'Aprovado')");

    //Verifico se o corretor tem pagamento feito apos esta data
    if(!$mapper->getRow()){
        $arr = array("id" => $row->corretor_id, "ativado" => "NAO");

        if($mapper_corretor->saveOrUpdate($arr))
            $texto .= date("d-m-Y H:i:s")." Corretor ".$row->corretor_id." desativado \r\n";

        unset($arr);
    }
}

$file = fopen( URL_ABSOLUTE.'logs/job_pagamento.txt','a' );
$fp = fwrite( $file,$texto );
fclose($file);
?>
