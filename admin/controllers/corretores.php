<?php
$mapper = new Mapper();
$mapper->setDbTable(new Corretor());

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
        
        $mapper_plano = new Mapper();
        $mapper_plano->setDbTable(new Planos());
        $mapper_plano->setWhere("id = '".$row->plano_id."'");
        
        if($mapper_plano->getRow())
            $plano = $mapper_plano->getRow()->nome;
        else
            $plano = "";
    }
    
    include("views/corretores_form.php");  
}
else if(isset($_GET['act']) && $_GET['act'] == 'ativar' || isset($_GET['act']) && $_GET['act'] == 'desativar'){
    if(isset($_GET['id'])){
        if($_GET['act'] == "ativar"){
            $set = "SIM";
            $ret = "Ativado";
        }
        else{
            $set = "NAO";
            $ret = "Desativado";
        }
        
        $mapper->setWhere('id = "'.$_GET['id'].'"');
        
        if($mapper->saveOrUpdate(array("id" => $_GET['id'], "ativado" => $set)))
            $msg = $ret.' com sucesso';
        else 
            $msg = 'Erro ao '.$ret.'.';

        include("views/corretores.php");  

        echo "<script>window.setTimeout('location.href=\"?pg=corretores\"', 800);</script>";
    }
}
else if(isset($_GET['act']) && $_GET['act'] == 'deletar'){
    
    if(isset($_GET['id'])){
        $mapper->setWhere('id = "'.$_GET['id'].'"');

        if(is_dir(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login)){
            foreach($fotos = scandir(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login) as $foto) {
                if(is_file(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login."/".$foto))
                    unlink(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login."/".$foto);
            }
            rmdir(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login);
        }
        
        if(is_dir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login)){
            foreach($pastas = scandir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login) as $pasta) {
                foreach($fotos = scandir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login.'/'.$pasta) as $foto){
                    if(is_file(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login.'/'.$pasta.'/'.$foto))
                        unlink(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login.'/'.$pasta.'/'.$foto);
                }
                @rmdir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login.'/'.$pasta);
            }
            rmdir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login);
        }
        
        $del = $mapper->delete();
    }
    else if($_POST){
        for($x=0;$x<count($_POST);$x++){
            $mapper->setWhere("id = ".$_POST['id_'.$x]);
            
            if(is_dir(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login)){
                foreach($fotos = scandir(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login) as $foto) {
                    if(is_file(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login."/".$foto))
                        unlink(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login."/".$foto);
                }
                rmdir(URL_ABSOLUTE."static/uploads/fotos/".$mapper->getRow()->login);
            }

            if(is_dir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login)){
                foreach($pastas = scandir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login) as $pasta) {
                    foreach($fotos = scandir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login.'/'.$pasta) as $foto){
                        if(is_file(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login.'/'.$pasta.'/'.$foto))
                            unlink(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login.'/'.$pasta.'/'.$foto);
                    }
                    @rmdir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login.'/'.$pasta);
                }
                rmdir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper->getRow()->login);
            }

            $del = $mapper->delete();
        }
    }
    
    if($del)
        $msg = 'Deletado com sucesso.';
    else 
        $msg = 'Erro ao deletar.';
    
    include("views/corretores.php");  
    
    echo "<script>window.setTimeout('location.href=\"?pg=corretores\"', 800);</script>";
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

    include("views/corretores.php"); 
}
else{
    include("views/corretores.php");  
}
