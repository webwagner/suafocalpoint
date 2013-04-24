<?php 

include('views/nova-senha.php'); 

/**
* Verifica se existe usuário com a senha vinda por get
*/
$mapper = new Mapper();
$mapper->setDbTable(new Corretor());
$mapper->setWhere('id = "'.url(3).'"');
$row = $mapper->getRow();

/**
* Se não direciona pra home se sim altera a senha
*/
if(!$row)
    echo "<script>location.href = '".URL."home'</script>";
    
if($_POST){
    $data = array("id"=>$row->id, "senha" => md5(getPost('senha')));
    $mapper->saveOrUpdate($data);
    
    session_destroy();
    
    echo "<script>alert('Senha alterada com sucesso!'); location.href = '".URL."home';</script>";
}