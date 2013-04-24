<?php
/**
* salva as imagens do imovel
*/
include('inc/init.inc.php');

if (!empty($_FILES)) {
    
    $mapper = new Mapper();
    $mapper->setDbTable(new ImovelAlbum());  
    $mapper->setWhere('imovel_id = "'.$_POST['id_imovel'].'"');
    
    if($mapper->getTotal())
        $total = $mapper->getTotal() + count($_FILES);
    else
        $total = 0;
    
    if($total <= 10){
        
        //Remove o EXIF da imagem
        $cmd = "/usr/bin/mogrify -strip ".$_FILES['Filedata']['tmp_name'];
        exec($cmd, $exec_output, $exec_retval);
        //
        
        $tempFile = $_FILES['Filedata']['tmp_name'];
        
        $destino = URL_ABSOLUTE.'static/uploads/imoveis/'.$_POST['login'];
        $destino_f = $destino.'/'.$_POST['titulo'].'/';

        if(!is_dir($destino))
            cria_dir($destino);

        if(!is_dir($destino_f))
            cria_dir($destino_f);

        $img = upload('Filedata',$destino_f);
        $targetFile =  $destino_f.'/'.$img;

        $arr = array('imovel_id' => $_POST['id_imovel'],'foto' => $img, 'album_id' => 8, 'legenda' => 'Fotos'); 
        $id = $mapper->saveOrUpdate($arr);

        move_uploaded_file($tempFile,$targetFile);

        //echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
        echo $_POST['id_imovel'].','.$id;
    }
    else{
        echo "maximo";
    }
    
}
