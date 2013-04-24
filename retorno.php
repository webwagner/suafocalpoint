<?php
/**
* retorno do pagseguro
*/
include('inc/init.inc.php');

header('Content-Type: text/html; charset=ISO-8859-1');

define('TOKEN', 'D4784131065A402DB34FB3D1DD7D8F3A');

class PagSeguroNpi {
	
    private $timeout = 20; // Timeout em segundos

    public function notificationPost() {
        $postdata = 'Comando=validar&Token='.TOKEN;
        foreach ($_POST as $key => $value) {
            $valued    = $this->clearStr($value);
            $postdata .= "&$key=$valued";
        }
        return $this->verify($postdata);
    }

    private function clearStr($str) {
        if (!get_magic_quotes_gpc()) {
                $str = addslashes($str);
        }
        return $str;
    }

    private function verify($data) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = trim(curl_exec($curl));
        curl_close($curl);
        return $result;
    }

}

if (count($_POST) > 0) {	
    $npi    = new PagSeguroNpi();   
    $result = $npi->notificationPost();
    
    $transacaoID   = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';
    $status        = isset($_POST['StatusTransacao']) ? $_POST['StatusTransacao'] : '';
    $tipoPagamento = isset($_POST['TipoPagamento']) ? $_POST['TipoPagamento'] : '';
    $valor1        = isset($_POST['ProdValor_1']) ? $_POST['ProdValor_1'] : '';
    $id1           = isset($_POST['ProdID_1']) ? $_POST['ProdID_1'] : '';
   
    if(isset($_POST['ProdID_2'])){
        $valor2 = isset($_POST['ProdValor_2']) ? $_POST['ProdValor_2'] : '';
        $id2    = isset($_POST['ProdID_2']) ? $_POST['ProdID_2'] : '';
    }
    
    /**
    * Completo: Pagamento completo
    * Aguardando Pagto: Aguardando pagamento do cliente
    * Aprovado: Pagamento aprovado, aguardando compensação
    * Em Análise: Pagamento aprovado, em análise pelo PagSeguro
    * Cancelado: Pagamento cancelado pelo PagSeguro
    */ 
    
    /**
    * Cria pagseguro.txt
    */
    $text = "Pagamento feito em ".date('d/m/Y')." às ".date('H:i')."\r\n";
    $text .= "O status foi: ".$result."\r\n";
    $text .= "A status de pagamento foi: ".$status."\r\n";
    $text .= "O valor foi: ".$valor1."\r\n";
    $text .= "O id foi: ".$id1."\r\n";
    
    if(isset($id2)){
        $text .= "O valor2 foi: ".$valor2."\r\n";
        $text .= "O id2 foi: ".$id2."\r\n";
    }
    
    $text .= "\r\n";
    
    $file = fopen( 'logs/pagseguro.txt','a' );
    $fp = fwrite( $file,$text );
    fclose($file);
      
    $mapper = new Mapper();
    $mapper->setDbTable(new Pagamento());
    
    /**
    * Edita a tabela pagamento
    */	
    $arr = array('id' => $id1, 'pagseguro_id' => $transacaoID, 'retorno' => $status, 'data_pagamento' => date("Y-m-d H:i:s"), 'forma_pagamento' => $tipoPagamento);
    $mapper->saveOrUpdate($arr);
    
    if(isset($id2)){
        $arr = array('id' => $id2, 'pagseguro_id' => $transacaoID, 'retorno' => $status, 'data_pagamento' => date("Y-m-d H:i:s"), 'forma_pagamento' => $tipoPagamento);
        $mapper->saveOrUpdate($arr);
    }
    
    /**
    * Se o pagamento for feito Verifica se a indicação e inseri o desconto e ativa o corretor
    */	
    if($status == "Completo" || $status == "Aprovado"){
    //if($status == "Cancelado" || $status == "Em Análise"){

        $mapper->setWhere('id = "'.$id1.'"');
        $pagamento = $mapper->getRow();

        //Apenas para pagamento de planos
        if($pagamento->tipo == 1){
            //Verifica se o corretor foi indicado
            $mapper = new Mapper();
            $mapper->setDbTable(new Indicacao());
            $mapper->setWhere('id_indicado = "'.$pagamento->corretor_id.'"');

            if($indicacao = $mapper->getRow()){            
                $mapper->saveOrUpdate(array("id" => $indicacao->id, "pago" => "SIM"));

                //Pego o valor do desconto
                $mapper = new Mapper();
                $mapper->setDbTable(new Planos());
                $mapper->setWhere("nome = 'MENSAL'");
                $plano = $mapper->getRow();
                $valor = ($plano->valor / 2);
                
                //Salvo o desconto para o corretor que indicou
                $mapper = new Mapper();
                $mapper->setDbTable(new Desconto());
                $mapper->saveOrUpdate(array("id_corretor" => $indicacao->id_indicou, "valor_desconto" => $valor, "descontado" => "NAO"));
            }
            
            //Ativa o corretor
            $mapper = new Mapper();
            $mapper->setDbTable(new Corretor());
            $mapper->saveOrUpdate(array("id" => $pagamento->corretor_id, "ativado" => "SIM"));
        }
    }
} 
else {	
    echo '<script>location.href = "'.URL.'home/retorno-pagseguro";</script>';   
}
?>