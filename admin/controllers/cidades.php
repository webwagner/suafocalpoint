<?php

$mapper = new Mapper();
$mapper->setDbTable(new ImovelCidade());
$mapper->setOrder('id_uf ASC');

$mapper_uf = new Mapper();
$mapper_uf->setDbTable(new ImovelUf());

if(url(4))
    $n = url(4);
else
    $n = 0;

$url = '?pg='.$_GET['pg'].'&n=';
$quant_per_pag = 20;
$total = $mapper->getTotal();
$paginacao = new Paginacao($n, $total, $quant_per_pag);

$mapper->setInicial($paginacao->inicial());  
$mapper->setNumreg($quant_per_pag);                
$rows = $mapper->getRows();

$quantidade = count($rows);
$html_paginacao = $paginacao->pagination($url);
    
if(isset($_GET['act']) && $_GET['act'] == 'cadastrar'){
    $mapper_uf = new Mapper();
    $mapper_uf->setDbTable(new ImovelUf());
    $mapper_uf->setOrder('uf ASC');

    if(isset($_GET['id'])){
        $mapper->setWhere('id = "'.$_GET['id'].'"');
        $row = $mapper->getRow();
        
        $mapper_uf->setWhere('id = "'.$row->id_uf.'"');
        $row_uf = $mapper_uf->getRow();
        
        $mapper_uf->setWhere('id <> "'.$row_uf->id.'"');
    }
    
    $rows = $mapper_uf->getRows();
    
    include("views/cidades_form.php");  
}
else if(isset($_GET['act']) && $_GET['act'] == 'salvar' && $_POST){
    if($mapper->saveOrUpdate($_POST))
        if(isset($_POST['id']))
            $msg = 'Atualizado com sucesso.';
        else
            $msg = 'Cadastrado com sucesso.';
    else 
        $msg = 'Erro ao cadastrar.'; 
    
    include("views/cidades.php"); 
    
    echo "<script>window.setTimeout('location.href=\"?pg=cidades\"', 800);</script>";
}
else if(isset($_GET['act']) && $_GET['act'] == 'deletar'){
    
    if(isset($_GET['id'])){
        $mapper->setWhere('id = "'.$_GET['id'].'"');
        $del = $mapper->delete();
    }
    else if($_POST){
        for($x=0;$x<count($_POST);$x++){
            $mapper->setWhere("id = ".$_POST['id_'.$x]);
            $del = $mapper->delete();
        }
    }
    
    if($del)
        $msg = 'Deletado com sucesso.';
    else 
        $msg = 'Erro ao deletar.';
    
    include("views/cidades.php");  
    
    echo "<script>window.setTimeout('location.href=\"?pg=cidades\"', 800);</script>";
}
else if(isset($_GET['act']) && $_GET['act'] == 'buscar'){
    if(isset($_POST['busca']))
        $_SESSION['busca'] = $_POST['busca'];
   
    $msg_busca = $_SESSION['busca'];
    
    $mapper->setWhere("cidade LIKE '%".$_SESSION['busca']."%'");
    
    $total = $mapper->getTotal();
    $paginacao = new Paginacao($n, $total, $quant_per_pag);

    $mapper->setInicial($paginacao->inicial());  
    $mapper->setNumreg($quant_per_pag);                
    $rows = $mapper->getRows();
    
    $url = '?pg='.$_GET['pg'].'&act=buscar&n=';
    $quantidade = count($rows);
    $html_paginacao = $paginacao->pagination($url);

    include("views/cidades.php"); 
}
else{
    include("views/cidades.php");  
}
