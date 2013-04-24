<?php
if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";

/**
* Pega todos os imóveis do corretor
*/
$mapper_imoveis_incompletos = new Mapper();
$mapper_imoveis_incompletos->setDbTable(new Imovel());
$mapper_imoveis_incompletos->setWhere('id_corretor = '.$_SESSION['usuario_logado']->id.'');  
$imoveis = $mapper_imoveis_incompletos->getRows();

/**
* Pega todos os imóveis do corretor sem foto
*/
$mapper_album = new Mapper();
$mapper_album->setDbTable(new ImovelAlbum());

if($imoveis){
    foreach($imoveis as $imov){
        $mapper_album->setWhere('imovel_id = '.$imov->id.'');
        if(!$mapper_album->getRow())
            $imoveis_incompletos[] = $imov->id;
    }
}

if(isset($imoveis_incompletos) && count($imoveis_incompletos) >0){
    /**
    * Pega todos os imóveis incompletos fazendo paginação
    */
    $imoveis_incompletos = array_unique($imoveis_incompletos);

    $html_imoveis = '';
    $where = '';

    foreach($imoveis_incompletos as $imovel) 
        $where .= 'id = "'.$imovel.'" or ';

    $mapper_imoveis_incompletos->setWhere(substr($where,0,-4));

    if(url(3))
        $n = url(3);
    else
        $n = 0;

    $quant_per_pag = 10;
    $total = $mapper_imoveis_incompletos->getTotal();

    $paginacao = new Paginacao($n, $total, $quant_per_pag);

    $mapper_imoveis_incompletos->setInicial($paginacao->inicial());  
    $mapper_imoveis_incompletos->setNumreg($quant_per_pag);    
    $imoveis = $mapper_imoveis_incompletos->getRows();

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
    * Instancia a classe do tipo do imóvel
    */
    $mapper_tipo = new Mapper();
    $mapper_tipo->setDbTable(new ImovelTipo());

    foreach($imoveis as $imov){

        /**
        * Pega o bairro do imóvel
        */
        $mapper_bairro->setWhere('id = '.$imov->bairro_imovel);
        $row_bairro = $mapper_bairro->getRow();

        /**
        * Pega a uf do imóvel
        */
        $mapper_uf->setWhere('id = '.$imov->uf_imovel);
        $row_uf = $mapper_uf->getRow();

        /**
        * Pega a cidade do imóvel
        */
        $mapper_cidade->setWhere('id = '.$imov->cidade_imovel);
        $row_cidade = $mapper_cidade->getRow();

        /**
        * Pega o tipo do imóvel
        */
        $mapper_tipo->setWhere('id = '.$imov->tipo_imovel_id);
        $row_tipo = $mapper_tipo->getRow();

        /**
        * Verifica se o imóvel é residencial
        */
        $residencial = '';   
        if($imov->residencial == 'SIM'){             
            $residencial = '<span>Residencial: <font>';
            if($imov->compra == "SIM"){ $residencial .= 'Venda'; }
            if($imov->compra == "SIM" && $imov->aluguel == "SIM"){ $residencial .= '-'; }
            if($imov->aluguel == "SIM"){ $residencial .= 'Aluguel'; }
            $residencial .= '</font></span>';              
        }

        /**
        * Verifica se o imóvel é comercial
        */
        $comercial = '';  
        if($imov->comercial == 'SIM'){               
            $comercial = '<span>Comercial: <font>';
            if($imov->compra == "SIM"){ $comercial .= 'Venda'; }
            if($imov->compra == "SIM" && $imov->aluguel == "SIM"){ $comercial .= '-'; }
            if($imov->aluguel == "SIM"){ $comercial .= 'Aluguel'; }
            $comercial .= '</font></span>';               
        }

        $html_imoveis .= '<div class="imovel-lbt">     
                    <p class="imovel-nome">'.$imov->codigo_imovel.' - '.$imov->titulo.'</p>
                    <p class="imovel-local">'.$row_bairro->bairro.' - '.$row_cidade->cidade.'/'.$row_uf->uf.'</p> 
                    <p>
                        <span>Tipo: <font>'.$row_tipo->nome.'</font></span>
                        '.$residencial.$comercial.'
                    </p>
                    <p><a href="'.$_SESSION['login'].'/editar-imovel-dados/'.$imov->titulo_url.'" class="completar-c">completar cadastro</a></p>    
                   </div>';

    }

    if($total > $quant_per_pag)
        $html_paginacao = $paginacao->pagination();
    else
        $html_paginacao = '';

    include('views/imoveis-incompletos.php');
}
else{
    echo '<script>window.location.href = "'.$_SESSION['login'].'"</script>';    
}
