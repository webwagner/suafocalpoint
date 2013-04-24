<?php

include('inc/init.inc.php');
    
if (!empty($_FILES)) {
    $destino = 'static/uploads/imoveis/'.$_SESSION['login']; 
    $destino_f = $destino.'/'.$_POST['titulo'];

    if(!is_dir($destino))
        cria_dir($destino);
    
    if(!is_dir($destino_f))
        cria_dir($destino_f);
        
    $imagem = upload($_FILES['imagem'],$destino_f);
    
    $mapper = new Mapper();
    $class = new ImovelAlbum();
    $mapper->setDbTable($class);
    
    $arr = array('imovel_id' => $_POST['id_imovel'],'foto' => $imagem);
    
    $mapper->saveOrUpdate($arr);  
}
