<?php
if(!isset($_SESSION['login']))
    echo "<script>location.href = 'home'</script>";
    
/**
* Lista os im�veis a vencer e faz a Pagina��o
*/   
$mapper = new Mapper();
$mapper->setDbTable(new Imovel());
$mapper->setWhere('vencimento_contrato != "" and id_corretor = '.$_SESSION['usuario_logado']->id);  
$mapper->setOrder('str_to_date(vencimento_contrato, "%d/%m/%Y" ) ASC');

if(url(3))
    $n = url(3);
else
    $n = 0;

$quant_per_pag = 10;

$total = $mapper->getTotal();

$paginacao = new Paginacao($n, $total, $quant_per_pag);

$mapper->setInicial($paginacao->inicial());  
$mapper->setNumreg($quant_per_pag);                
$rows = $mapper->getRows();

if($total > $quant_per_pag)
    $html_paginacao = $paginacao->pagination();
else
    $html_paginacao = '';    

$mens = 'Voc� possui '.$total.' im�veis a vencer ou vencidos';
    
$lista_busca = '';

if($total > 0){                        
    /**
    * Instancia a classe da uf do im�vel
    */
    $mapper_uf = new Mapper();
    $mapper_uf->setDbTable(new ImovelUf());

    /**
    * Instancia a classe do bairro do im�vel
    */
    $mapper_bairro = new Mapper();
    $mapper_bairro->setDbTable(new ImovelBairro());

    /**
    * Instancia a classe da cidade do im�vel
    */
    $mapper_cidade = new Mapper();
    $mapper_cidade->setDbTable(new ImovelCidade());

    /**
    * Instancia a classe do tipo do im�vel
    */
    $mapper_tipo = new Mapper();
    $mapper_tipo->setDbTable(new ImovelTipo());

    /**
    * Instancia a classe do corretor do im�vel
    */
    $mapper_corretor = new Mapper();
    $class_corretor = new Corretor();
    $mapper_corretor->setDbTable($class_corretor);

    /**
    * Instancia a classe da foto do im�vel
    */
    $mapper_foto = new Mapper();
    $mapper_foto->setDbTable(new ImovelAlbum());                
    foreach($rows as $row){

        /**
        * Pega o bairro do im�vel
        */
        if($row->bairro_imovel != ""){
            $mapper_bairro->setWhere('id = '.$row->bairro_imovel);
            $bairro = $mapper_bairro->getRow()->bairro;
        }
        else{
            $bairro = "";
        }

        /**
        * Pega a uf do im�vel
        */
        if($row->uf_imovel != ""){
            $mapper_uf->setWhere('id = '.$row->uf_imovel);
            $uf = $mapper_uf->getRow()->uf;
        }
        else{
            $uf = "";
        }

        /**
        * Pega a cidade do im�vel
        */
        if($row->cidade_imovel != ""){
            $mapper_cidade->setWhere('id = '.$row->cidade_imovel);
            $cidade = $mapper_cidade->getRow()->cidade;
        }
        else{
            $cidade = "";
        }

        /**
        * Pega o tipo do im�vel
        */
        $mapper_tipo->setWhere('id = '.$row->tipo_imovel_id);
        $row_tipo = $mapper_tipo->getRow();

        /**
        * Pega o corretor do im�vel
        */
        $mapper_corretor->setWhere('id = '.$row->id_corretor);
        $row_corretor = $mapper_corretor->getRow();

        /**
        * Pega a foto do im�vel
        */
        $mapper_foto->setWhere('imovel_id = '.$row->id.' and padrao = "sim"');
        $mapper_foto->setOrder("id ASC");
        $foto = $mapper_foto->getRow();

        /**
        * Verifica se o im�vel tem foto
        */
        $imagem = '';

        if($foto)
            $imagem = '<a style="height: auto; text-indent: 0; margin: 0; color: #153F63;" href="'.$row_corretor->login.'/imovel/'.$row->titulo_url.'">'.ImgRender(URL_ABSOLUTE.'static/uploads/imoveis/'.$row_corretor->login.'/'.$row->titulo_url.'/'.$foto->foto, 175, 133, $row->titulo).'</a>';
        else
            $imagem = '<a style="height: auto; text-indent: 0; margin: 0; color: #153F63;" href="'.$row_corretor->login.'/imovel/'.$row->titulo_url.'"><img src="static/img/img-imoveis.jpg" alt="'.$row->titulo.'" /></a>'; 

        /**
        * Verifica se o im�vel � residencial
        */
        $residencial = '';   
        if($row->residencial == 'SIM'){             
            $residencial = '<span>Residencial: <font>';
            if($row->compra == "SIM"){ $residencial .= 'Venda'; }
            if($row->compra == "SIM" && $row->aluguel == "SIM"){ $residencial .= '-'; }
            if($row->aluguel == "SIM"){ $residencial .= 'Aluguel'; }
            $residencial .= '</font></span>';              
        }

        /**
        * Verifica se o im�vel � comercial
        */
        $comercial = '';  
        if($row->comercial == 'SIM'){               
            $comercial = '<span>Comercial: <font>';
            if($row->compra == "SIM"){ $comercial .= 'Venda'; }
            if($row->compra == "SIM" && $row->aluguel == "SIM"){ $comercial .= '-'; }
            if($row->aluguel == "SIM"){ $comercial .= 'Aluguel'; }
            $comercial .= '</font></span>';               
        }
        
        /**
        * Pega o pre�o de venda e aluguel
        */
        $preco_venda = "";
        $preco_aluguel = "";

        if($row->valor_aluguel)
            $preco_aluguel = "<span>Valor Aluguel: <font>".number_format($row->valor_aluguel,2,',','.')."</font></span>";

        if($row->valor_venda)
            $preco_venda = "<span>Valor Venda: <font>".number_format($row->valor_venda,2,',','.')."</font></span>";


        /**
        * Cria a variavel com o resultado da busca
        */
        $lista_busca .= '<div class="imovel-lbt">	
            <h2>T�rmino do Contrato: '.$row->vencimento_contrato.'</h2>'
            .$imagem.'    
            <p class="imovel-nome"><a style="height: auto; text-indent: 0; margin: 0; color: #153F63;" href="'.$row_corretor->login.'/imovel/'.$row->titulo_url.'">'.$row->codigo_imovel.' - '.$row->titulo.'</a></p>
            <p class="imovel-local">'.$cidade.' - '.$bairro.'/'.$uf.'</p>
            <p>
                <span>Tipo: <font>'.$row_tipo->nome.'</font></span>
                '.$residencial.$comercial.'
            </p>
            <p>
                <span>Quartos: <font>'.$row->quartos_atual.'</font></span>
                <span>�rea Constru�da: <font>'.$row->area_construida.'m�</font></span>
            </p>
            <p>
                '.$preco_aluguel.$preco_venda.'
            </p>
            <div style="float: left;">
                <a href="'.$_SESSION['login'].'/editar-imovel-dados/'.$row->titulo_url.'" class="editar">editar</a>    
            </div>
        </div>';
    }
}

include('views/lembrete-imoveis.php');