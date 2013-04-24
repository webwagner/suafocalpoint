<?php

$mapper = new Mapper();
$mapper->setDbTable(new Imovel());

$mapper_tipo = new Mapper();
$mapper_tipo->setDbTable(new ImovelTipo());

if(url(4))
    $n = url(4);
else
    $n = 0;

$url = '?pg='.$_GET['pg'].'&n=';
$quant_per_pag = 30;
$total = $mapper->getTotal();
$paginacao = new Paginacao($n, $total, $quant_per_pag);

$mapper->setInicial($paginacao->inicial());  
$mapper->setNumreg($quant_per_pag);                
$rows = $mapper->getRows();

$quantidade = count($rows);
$html_paginacao = $paginacao->pagination($url);
    
if(isset($_GET['act']) && $_GET['act'] == 'cadastrar'){
    if(isset($_GET['id'])){
        $mapper->setWhere('id = "'.$_GET['id'].'"');
        $row = $mapper->getRow();
        
        $mapper_corretor = new Mapper();
        $mapper_corretor->setDbTable(new Corretor());
        $mapper_corretor->setWhere("id = '".$row->id_corretor."'");
        if($mapper_corretor->getRow())
            $corretor = $mapper_corretor->getRow()->nome;
        else
            $corretor = "";
        
        $mapper_tipo->setWhere("id = '".$row->tipo_imovel_id."'");  
        if($mapper_tipo->getRow())
            $tipo = $mapper_tipo->getRow()->nome;
        else
            $tipo = "";
        
        $mapper_uf = new Mapper();
        $mapper_uf->setDbTable(new ImovelUf());
        $mapper_uf->setWhere("id = '".$row->uf_imovel."'");
        if($mapper_uf->getRow())
            $uf = $mapper_uf->getRow()->uf;
        else
            $uf = "";
        
        $mapper_cidade = new Mapper();
        $mapper_cidade->setDbTable(new ImovelCidade());
        $mapper_cidade->setWhere("id = '".$row->cidade_imovel."'");
        if($mapper_cidade->getRow())
            $cidade = $mapper_cidade->getRow()->cidade;
        else
            $cidade = "";
        
        $mapper_bairro = new Mapper();
        $mapper_bairro->setDbTable(new ImovelBairro());
        $mapper_bairro->setWhere("id = '".$row->bairro_imovel."'");
        if($mapper_bairro->getRow())
            $bairro = $mapper_bairro->getRow()->bairro;
        else
            $bairro = "";
    }
    
    include("views/imoveis_form.php");  
}
else if(isset($_GET['act']) && $_GET['act'] == 'deletar'){
    
    $mapper_corretor = new Mapper();
    $mapper_corretor->setDbTable(new Corretor());
    $mapper_corretor->setWhere("id = '".$mapper->getRow()->id_corretor."'");
        
    if(isset($_GET['id'])){
        $mapper->setWhere('id = "'.$_GET['id'].'"');

        if(is_dir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url)){
            foreach($fotos = scandir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url) as $foto) {
                if(is_file(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url.'/'.$foto))
                    unlink(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url.'/'.$foto);
            }
            rmdir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url);
        }

        $del = $mapper->delete();
    }
    else if($_POST){
        for($x=0;$x<count($_POST);$x++){
            $mapper->setWhere("id = ".$_POST['id_'.$x]);
            
            if(is_dir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url)){
                foreach($fotos = scandir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url) as $foto) {
                    if(is_file(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url.'/'.$foto))
                        unlink(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url.'/'.$foto);
                }
                    rmdir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url);
            }
            $del = $mapper->delete();
        }
    }
    
    if($del)
        $msg = 'Deletado com sucesso.';
    else 
        $msg = 'Erro ao deletar.';
    
    include("views/imoveis.php");  
    
    echo "<script>window.setTimeout('location.href=\"?pg=imoveis\"', 800);</script>";
}
else if(isset($_GET['act']) && $_GET['act'] == 'buscar'){
    if(isset($_POST['busca']))
        $_SESSION['busca'] = $_POST['busca'];
   
    $msg_busca = $_SESSION['busca'];
    
    $mapper->setWhere("nome LIKE '%".$_SESSION['busca']."%' || sigla LIKE '%".$_SESSION['busca']."%' || uf LIKE '%".$_SESSION['busca']."%' || cidade LIKE '%".$_SESSION['busca']."%'");
    
    $total = $mapper->getTotal();
    $paginacao = new Paginacao($n, $total, $quant_per_pag);

    $mapper->setInicial($paginacao->inicial());  
    $mapper->setNumreg($quant_per_pag);                
    $rows = $mapper->getRows();
    
    $url = '?pg='.$_GET['pg'].'&act=buscar&n=';
    $quantidade = count($rows);
    $html_paginacao = $paginacao->pagination($url);

    include("views/imoveis.php"); 
}
else{
    include("views/imoveis.php");  
}
