<?php
if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

$html = '';

/**
* Lista os tipos de imóveis
*/
$mapper_tipo = new Mapper();
$mapper_tipo->setDbTable(new ImovelTipo());
$mapper_tipo->setOrder('id ASC');
$rows_tipo = $mapper_tipo->getRows();

/**
* Pega a uf do corretor
*/
$mapper = new Mapper();
$mapper->setDbTable(new ImovelUf());
$mapper->setWhere('uf = "'.$_SESSION['usuario_logado']->uf.'"');
if(!$uf_corretor = $mapper->getRow())
    $uf_corretor->id = 1;

/**
* Pega a cidade do corretor
*/
$mapper = new Mapper();
$mapper->setDbTable(new ImovelCidade());

if($uf_corretor->uf == "SP"){
    $mapper->setWhere('id_uf = "'.$uf_corretor->id.'"');
    $cidades_sp = $mapper->getRows();
}
    
$mapper->setWhere('cidade = "'.$_SESSION['usuario_logado']->cidade.'"');
if(!$cidade_corretor = $mapper->getRow())
    $cidade_corretor->id = 1;
 
/**
* apenas os que têm vencimento_contrato vazio
*/
$where = "vencimento_contrato = '' and ";

if($_POST){

    /**
    * Seta o Where do select conforme os campos buscados e não busca imóveis de quem fez a busca
    */
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());
    $where .= 'id_corretor <> "'.$_SESSION['usuario_logado']->id.'" and ';
    
    /**
    * Seta o Where do select conforme os campos buscados e não busca imóveis de quem fez a busca
    */
    if($_POST['tipo_busca'] == 1){      
        $where .= 'codigo_imovel = "'.$_POST['codigo'].'" and ';
    } else if($_POST['tipo_busca'] == 3){      
        $where .= 'titulo LIKE "%'.$_POST['titulo'].'%"  and ';
    } else{
        if(count($_POST['bairro']) > 0){
            $i = 0;
            $where .= '(';
            foreach($_POST['bairro'] as $bairro){
                if($bairro != ""){
                    $i++;
                    $where .= 'bairro_imovel = "'.$bairro.'" or ';
                }
            }
            
            if($i == 0){
                $where = substr($where,0 , -1);
            }
            else{
                $where = substr($where,0 , -4);
                $where .= ') and ';
            }

        }
        
        $where .= 'uf_imovel = "'.$_POST['uf'].'" and ';
        $where .= 'cidade_imovel = "'.$_POST['cidade'].'" and ';
        
        if(count($_POST['tipo']) > 0){
            foreach($_POST['tipo'] as $arr_tipo)
                if($arr_tipo != "")
                    $arr_tipo2[] = $arr_tipo;
            
            if(isset($arr_tipo2))
                $where .= 'tipo_imovel_id IN ('.implode(",", $arr_tipo2).') and ';
        }
        
        if(isset($_POST['residencial_compra']) || isset($_POST['residencial_aluguel'])){
            $where .= 'residencial = "SIM" and ';
            if(isset($_POST['residencial_compra'])){
                $where .= 'compra = "SIM" and ';
            }
            if(isset($_POST['residencial_aluguel'])){
                $where .= 'aluguel = "SIM" and ';
            }
        }
        
        if(isset($_POST['comercial_compra']) || isset($_POST['comercial_aluguel'])){
            $where .= 'comercial = "SIM" and ';
            if(isset($_POST['comercial_compra'])){
                $where .= 'compra = "SIM" and ';
            }
            if(isset($_POST['comercial_aluguel'])){
                $where .= 'aluguel = "SIM" and ';
            }
        }
        
        if($_POST['valor_aluguel'] != ""){
            $where .= 'valor_aluguel > 0.00 and valor_aluguel <= '.str_replace(',','.',str_replace('.','',$_POST['valor_aluguel'])).' and ';
        }
        if($_POST['valor_venda'] != ""){ 
            $where .= 'valor_venda > 0.00 and valor_venda <= '.str_replace(',','.',str_replace('.','',$_POST['valor_venda'])).' and '; 
        }
        if($_POST['valor_minimo_aluguel'] != ""){
            $where .= 'valor_aluguel >= '.str_replace(',','.',str_replace('.','',$_POST['valor_minimo_aluguel'])).' and ';
        }
        if($_POST['valor_minimo_venda'] != ""){ 
            $where .= 'valor_venda >= '.str_replace(',','.',str_replace('.','',$_POST['valor_minimo_venda'])).' and '; 
        }
        if($_POST['n_quartos'] != ''){
            $where .= 'quartos_atual >= "'.$_POST['n_quartos'].'" and ';
        }
        if($_POST['nome_condominio'] != ''){
            $where .= 'nome_condominio = "'.$_POST['nome_condominio'].'" and ';
        }
        if($_POST['area_construida_menor'] != ''){
            $where .= 'area_construida < "'.$_POST['area_construida_menor'].'" and ';        
        }
        if($_POST['area_construida_maior'] != ''){
            $where .= 'area_construida >= "'.$_POST['area_construida_maior'].'" and ';
        }
        if(isset($_POST['mobiliado'])){
            $where .= 'mobiliado = "SIM" and ';
        }
        if(isset($_POST['portaria_h'])){
            $where .= 'portaria_24h = "SIM" and ';
        }
        if(isset($_POST['varanda'])){
            $where .= 'varanda = "SIM" and ';
        }
        if(isset($_POST['piscina'])){
            $where .= 'piscina = "SIM" and';
        }
        
        $mapper_bairro = new Mapper();
        $mapper_bairro->setDbTable(new ImovelBairro());
        $mapper_bairro->setWhere('id_cidade = "'.$_POST['cidade'].'"');
        $mapper_bairro->setOrder('bairro ASC');
        $bairros = $mapper_bairro->getRows();
    }

    if(substr($where,0,-4) != "")
        $mapper->setWhere(substr($where,0,-4));
    else
        $mapper->setWhere("codigo_imovel = ''");
    
    if($rows = $mapper->getRows()){
        /**
        * Instancia a classe da uf do imóvel
        */
        $mapper_uf = new Mapper();
        $mapper_uf->setDbTable(new ImovelUf());
        
        /**
        * Instancia a classe do bairro do imóvel
        */
        $mapper_bairro = new Mapper();
        $mapper_bairro->setDbTable(new ImovelBairro());
        
        /**
        * Instancia a classe da cidade do imóvel
        */
        $mapper_cidade = new Mapper();
        $mapper_cidade->setDbTable(new ImovelCidade());
        
        /**
        * Instancia a classe do corretor do imóvel
        */
        $mapper_corretor = new Mapper();
        $mapper_corretor->setDbTable(new Corretor());
         
        $localizacao = '';
        
        foreach($rows as $row){       
            
            /**
            * Pega o corretor do imóvel
            */
            $mapper_corretor->setWhere('id = '.$row->id_corretor);
            $row_corretor = $mapper_corretor->getRow();
            
            /**
            * Pega o bairro do imóvel
            */
            if($row->bairro_imovel != ""){
                $mapper_bairro->setWhere('id = '.$row->bairro_imovel);
                $bairro = $mapper_bairro->getRow()->bairro;
            }
            else{
                $bairro = "";
            }
            
            /**
            * Pega a uf do imóvel
            */
            if($row->uf_imovel != ""){
                $mapper_uf->setWhere('id = '.$row->uf_imovel);
                $uf = $mapper_uf->getRow()->uf;
            }
            else{
                $uf = "";
            }
            
            /**
            * Pega a cidade do imóvel
            */
            if($row->cidade_imovel != ""){
                $mapper_cidade->setWhere('id = '.$row->cidade_imovel);
                $cidade = $mapper_cidade->getRow()->cidade;
            }
            else{
                $cidade = "";
            }
            
            if($row->endereco != "")
                $endereco = $row->endereco.',';
            else
                $endereco = '';
            
            if($row->cep != "")
                $cep = ' '.$row->cep;
            else
                $cep = '';
            
            if($localizacao != $endereco.$bairro.$cidade.$uf.$cep)
                $localizacao = $endereco.$bairro.','.$cidade.' - '.$uf.$cep;
            else
                $localizacao = '';
            
            if($localizacao != "")
                $html .= "<input type='hidden' class='enderecos' link='".URL.$row_corretor->login."/imovel/".$row->titulo_url."' titulo='".$row->titulo."' name='enderecos' value='".$localizacao."' />";
            
        }
    }
} else {
    $_POST['tipo_busca'] = 1;
}
    
include('views/busca-mapa.php');
