<?php

include('inc/init.inc.php');

/**
* deleta um imóvel
*/
$mapper = new Mapper();
$mapper->setDbTable(new Imovel());

$mapper_corretor = new Mapper();
$mapper_corretor->setDbTable(new Corretor());
$mapper_corretor->setWhere("login = '".$_GET['corretor']."'");

$mapper->setWhere('titulo_url = "'.$_GET['imovel'].'"');

if(is_dir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url)){
    foreach($fotos = scandir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url) as $foto) {
        if(is_file(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url.'/'.$foto))
            unlink(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url.'/'.$foto);
    }
    rmdir(URL_ABSOLUTE."static/uploads/imoveis/".$mapper_corretor->getRow()->login."/".$mapper->getRow()->titulo_url);
}

$del = $mapper->delete();


if($del){
    $retorno['valor'] = 'YES';
}
else{
    $retorno['valor'] = 'NO';
}
    
echo json_encode($retorno);