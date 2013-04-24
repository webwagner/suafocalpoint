<?php

$url_uf = "";
$url_ci = "";

$url = explode("conheca-corretores",$_SERVER['REQUEST_URI']);

if($url[1] != ""){
    if($url1 = explode("/",$url[1])){
        $url_uf = $url1[1];
        
        if(isset($url1[2]))
            $url_ci = $url1[2];
    }
}

/**
* Faz um select com todos os bairros de imoveis
*/
$mapper = new Mapper();
$mapper->setDbTable(new Imovel);
$rows = $mapper->getSql('SELECT uf_imovel FROM imovel GROUP BY uf_imovel');
$mapper_estado = new Mapper();
$mapper_estado->setDbTable(new ImovelUf());

$select_estado = '<select id="estado" name="estado" class="required"><option value="">Selecione</option>';
foreach($rows as $row){

    $mapper_estado->setWhere('id = '.$row->uf_imovel);
    $estado = $mapper_estado->getRow();
    
    if($url_uf == $estado->id)
        $select_estado .= '<option selected="selected" value="'.$estado->id.'">'.$estado->uf.'</option>';
    else
        $select_estado .= '<option value="'.$estado->id.'">'.$estado->uf.'</option>';

}
$select_estado .= '</select>';

$select_cidade = '<select name="cidade" id="cidade" class="required"><option value="">Selecione</option></select>';
$select_bairro = '<select name="bairro" id="bairro" class="required"><option value="">Selecione</option></select>';

if($url_uf != ""){
       
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel);
    $rows = $mapper->getSql('SELECT cidade_imovel FROM imovel WHERE uf_imovel = '.$url_uf.' GROUP BY cidade_imovel');

    if(count($rows) > 0){
        
        foreach($rows as $row)
            $arr_cidades[] = $row->cidade_imovel;
    
        $mapper_cidade = new Mapper();
        $mapper_cidade->setDbTable(new ImovelCidade());
        $mapper_cidade->setWhere("id_uf = '".$url_uf."'");
        $cidades = $mapper_cidade->getRows();  
        
        $select_cidade = '<select name="cidade" id="cidade" class="required"><option value="">Selecione</option>';
        foreach($cidades as $cidade){
            
            if(in_array($cidade->id, $arr_cidades)){
                if($url_ci == $cidade->id)
                    $select_cidade .= '<option selected="selected" value="'.$cidade->id.'">'.$cidade->cidade.'</option>';
                else
                    $select_cidade .= '<option value="'.$cidade->id.'">'.$cidade->cidade.'</option>';
            }
            
        }
        $select_cidade .= '</select>';
    
    }

}

if($url_ci != ""){
    
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel);
    $rows = $mapper->getSql('SELECT bairro_imovel FROM imovel WHERE uf_imovel = '.$url_uf.' AND cidade_imovel = '.$url_ci.' GROUP BY bairro_imovel');
    
    if(count($rows) > 0){
        
        foreach($rows as $row)
            $arr_bairros[] = $row->bairro_imovel;
        
        $mapper_bairro = new Mapper();
        $mapper_bairro->setDbTable(new ImovelBairro());
        $mapper_bairro->setWhere("id_cidade = '".$url_ci."'");
        $bairros = $mapper_bairro->getRows();  
        
        $select_bairro = '<select name="bairro" id="bairro" class="required"><option value="">Selecione</option>';
        
        foreach($bairros as $bairro)
            if(in_array($bairro->id, $arr_bairros))
                    $select_bairro .= '<option value="'.$bairro->id.'">'.$bairro->bairro.'</option>';
            
        $select_bairro .= '</select>';
        
    }
}

include('views/conheca-corretores.php');