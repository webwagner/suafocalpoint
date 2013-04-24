<?php
if(!isset($_SESSION['login']) || $_SESSION['login'] != $_SESSION['usuario_visitado']->login)
    echo "<script>location.href = 'home'</script>";

/**
* Pega os dados do imóvel para editar
*/
if(url(3) != 'editar-imovel-fotos'){
    $mapper = new Mapper();
    $mapper->setDbTable(new Imovel());    
    $mapper->setWhere('id_corretor = "'.$_SESSION['usuario_logado']->id.'" and titulo_url = "'.url(3).'"');
    if($mapper->getRow()){
        $dados_imovel = $mapper->getRow();
        
        $id = $dados_imovel->id;
        $titulo_imovel = $dados_imovel->titulo_url;
        
        /**
        * Salva os albuns
        */
        if(isset($_POST['id_cad_foto'])){
            $id = $_POST['id_cad_foto'];
    
            if(isset($_POST['id_foto'])){  

                $id_padrao = "";
                
                if(isset($_POST['padrao']))
                    $id_padrao = implode("",$_POST['padrao']);
                
                $quant = count($_POST['id_foto']);
                
                for($x=0;$x<$quant;$x++){
                    /**
                    * Coloca legenda e albúm nas fotos
                    */
                    
                    $padrao = 'nao';
                    
                    if($id_padrao != "")
                        if($_POST['id_foto'][$x] == $id_padrao)
                            $padrao = 'sim';
                    
                    $arr = array('id' => $_POST['id_foto'][$x], 'album_id' => $_POST['album'][$x], 'legenda' => $_POST['legenda'][$x], 'padrao' => $padrao);
                    $mapper = new Mapper();
                    $mapper->setDbTable(new ImovelAlbum());
                    $mapper->saveOrUpdate($arr);

                }
            }
            
            echo '<script>location.href = "'.$_SESSION['login'].'/imovel/'.$titulo_imovel.'";</script>';
        }
        
        /**
        * Deleta o albúm
        */
        if(isset($_POST['id_album_del'])){
            $mapper = new Mapper();
            $mapper->setDbTable(new ImovelAlbum());
            $mapper->setWhere('id = "'.$_POST['id_album_del'].'"');
            $album = $mapper->getRow();
            
            if(is_file('static/uploads/imoveis/'.$_SESSION['login'].'/'.$dados_imovel->titulo_url.'/'.$album->foto))
                unlink('static/uploads/imoveis/'.$_SESSION['login'].'/'.$dados_imovel->titulo_url.'/'.$album->foto);
            
            $mapper->delete();
        }
        
        include('views/imovel-fotos.php');
    }
    else{
        echo '<script>location.href = "home/pagina-nao-existe";</script>';
    }
}
else{
    echo '<script>location.href = "home/pagina-nao-existe";</script>';
}

