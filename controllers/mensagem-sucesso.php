<?php
/**
* pega o total de cada tipo de mensagem e soma 
*/
$mapper = new Mapper();
$mapper->setDbTable(new Mensagens());

$mapper->setWhere('corretor_enviou_id = "'.$_SESSION['usuario_logado']->id.'"');
$enviadas = $mapper->getTotal();

$mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and solicitacao = "SIM"');
$solicitacoes = $mapper->getTotal();

$mapper->setWhere('corretor_recebeu_id = "'.$_SESSION['usuario_logado']->id.'" and solicitacao = "NAO"');
$recebidas = $mapper->getTotal();

$total_geral = $enviadas + $solicitacoes + $recebidas;

include('views/mensagem-sucesso.php');

