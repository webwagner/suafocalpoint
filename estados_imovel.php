<?php
/**
* pega as cidades e bairros do imovel
*/
include('inc/init.inc.php');

$acao = isset($_GET['acao']) ? $_GET['acao'] : FALSE;

header('Content-Type: application/xml');

$xml = "<?xml version='1.0' encoding='iso-8859-1'?>\r\n";

switch ($acao){
    
    case 'buscaCidade':
        buscaCidade();
        break;

    case 'buscaBairro':
        buscaBairro();
        break;
        
}

function buscaCidade(){
    
        global $xml;

        $mapper = new Mapper();
        $mapper->setDbTable(new ImovelCidade());
        
	$uf = isset($_GET['uf']) ? (int)$_GET['uf'] : 1;
	
	$xml .= '<cidades>';
             
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

function buscaBairro(){
        
        global $xml;

        $id_corretor = $_GET['id_corretor'];
	$cidade = isset($_GET['cidade']) ? (int)$_GET['cidade'] : 1;

        $mapper = new Mapper();
        $mapper->setDbTable(new ImovelBairro());
 
        $mapper_imovel = new Mapper();
        $mapper_imovel->setDbTable(new Imovel());
        $mapper_imovel->setWhere('id_corretor = "'.$id_corretor.'" and cidade_imovel = "'.$cidade.'"');
        
        $bairros = array();
        
        if($mapper_imovel->getRows()){
            foreach($mapper_imovel->getRows() as $imoveis){
                if(!in_array($imoveis->bairro_imovel, $bairros)){
                    if($imoveis->bairro_imovel != "")
                        $bairros[] = $imoveis->bairro_imovel;
                }
            }
        }

	$xml .= '<bairros>';
             
        $where = "";
        
        if(count($bairros) > 0){
            foreach($bairros as $bairro){
                $mapper->setWhere('id = "'.$bairro.'"');
                $b = $mapper->getRow();

                $xml .= '  <bairro>';
                $xml .= '    <id>' . $b->id . '</id>';
                $xml .= '    <nome>' . $b->bairro . '</nome>';
                $xml .= '  </bairro>';

                $where .= 'id <> "'.$b->id.'" and ';
            }
             
        }   
        
        $where .= 'id_cidade = "'.$cidade.'"';
        
        $mapper->setWhere($where);                
        $mapper->setOrder('bairro ASC');

        $rows = $mapper->getRows();
	
	foreach ($rows as $row){

		$xml .= '  <bairro>';
		$xml .= '    <id>' . $row->id . '</id>';
		$xml .= '    <nome>' . $row->bairro . '</nome>';
		$xml .= '  </bairro>';
                
        }
        
	$xml .= '</bairros>';
	echo $xml;
}

?>