<?php
/**
* Pega o imóvel pela url
*/
$mapper = new Mapper();
$mapper->setDbTable(new Imovel);
$mapper->setWhere('titulo_url = "'.url(3).'"');

if($imovel = $mapper->getRow()){

    if($_POST){
        if($_POST['vencimento_contrato'] != ""){
            $_POST['data_volta_mercado']  = date("d/m/Y");
            $_POST['vencimento_contrato'] = "";
            
            $mapper = new Mapper();
            $mapper->setDbTable(new Imovel());
            $mapper->saveOrUpdate($_POST); 
            
            /**
            * Pega os contatos do corretor
            */ 
            $mapper_contatos = new Mapper();
            $mapper_contatos->setDbTable(new Contatos());
            $mapper_contatos->setWhere('aceitou = "SIM" and corretor_enviou_id = "'.$_SESSION['usuario_visitado']->id.'" or aceitou = "SIM" and corretor_recebeu_id = "'.$_SESSION['usuario_visitado']->id.'"');

            if($mapper_contatos->getRows()){
                $rows_contatos = $mapper_contatos->getRows();

                foreach($rows_contatos as $row_contatos){
                    if($row_contatos->corretor_enviou_id == $_SESSION['usuario_logado']->id)
                        $contatos[] = $row_contatos->corretor_recebeu_id;
                    else
                        $contatos[] = $row_contatos->corretor_enviou_id;
                }
            }

            if(count($contatos) > 0){
                $mapper_corretor = new Mapper();
                $mapper_corretor->setDbTable(new Corretor());

                foreach($contatos as $contato){
                    $mapper_corretor->setWhere('id = "'.$contato.'"');
                    $emails[] = $mapper_corretor->getRow()->email;
                }
            } 

            if($imovel->valor_venda != 0.00)
                $valor_venda = 'Valor Venda : R$'.number_format($imovel->valor_venda,2,',','.');
            else
                $valor_venda = '';

            if($imovel->valor_aluguel != 0.00)
                $valor_aluguel = 'Valor Aluguel : R$'.number_format($imovel->valor_aluguel,2,',','.');
            else
                $valor_aluguel = '';

            //Envia email para os contatos
            if(count($emails) > 0){
                $text = '<table cellpadding="0" cellspacing="0" border="0" style="background-color: #0B3458; width: 600px; height: 40px; padding-left: 14px;">
                    <tr>
                        <td style="color: #fff; font-family: Arial; font-size: 18px; font-weight: bold;">Imóvel Voltando ao Mercado</td>
                    </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0" border="0" style="border: 4px solid #0B3458; padding: 10px; width: 600px;">
                        <tr>
                            <td style="font-family: Arial; font-size: 13px;">
                                O Corretor '.$_SESSION['usuario_logado']->nome.' recolocou um imóvel no mercado:<br /><br />
                                Título: '.$imovel->titulo.'<br>
                                Código: '.$imovel->codigo_imovel.'<br>
                                '.$valor_aluguel.'<br>
                                '.$valor_venda.'<br><br>
                                <a style="display:block;" href="'.URL.$_SESSION['usuario_logado']->login.'/imovel/'.$imovel->titulo_url.'" target="_BLANK">Visualizar</a>
                            </td>
                        </tr>
                    </table>';

                email($text, 'Imóvel Voltando ao Mercado', $emails, '', 'bcc');
            }
        }
        $imovel = $mapper->getRow();
    }
        
    /**
    * Pega o tipo do imóvel
    */
    $mapper_tipo = new Mapper();
    $mapper_tipo->setDbTable(new ImovelTipo());
    $mapper_tipo->setWhere('id = "'.$imovel->tipo_imovel_id.'"');  
    $tipo = $mapper_tipo->getRow();
    
    /**
    * Pega a cidade do imóvel
    */
    if($imovel->cidade_imovel != ""){
        $mapper_city = new Mapper();
        $mapper_city->setDbTable(new ImovelCidade());
        $mapper_city->setWhere('id = "'.$imovel->cidade_imovel.'"');  
        $city = $mapper_city->getRow()->cidade;
    }
    else{
        $city = "";
    }
    
    /**
    * Pega a uf do imóvel
    */
    if($imovel->uf_imovel != ""){
        $mapper_uf = new Mapper();
        $mapper_uf->setDbTable(new ImovelUf());
        $mapper_uf->setWhere('id = "'.$imovel->uf_imovel.'"');  
        $uf = $mapper_uf->getRow()->uf;
    }
    else{
        $uf = "";
    }
    
    /**
    * Pega o bairro do imóvel
    */
    if($imovel->bairro_imovel != ""){
        $mapper_bairro = new Mapper();
        $mapper_bairro->setDbTable(new ImovelBairro());
        $mapper_bairro->setWhere('id = "'.$imovel->bairro_imovel.'"');  
        $bairro = $mapper_bairro->getRow()->bairro;
    }
    else{
        $bairro = "";
    }
    
    /**
    * Pega os id dos albuns que tem fotos
    */
    $mapper_fotos = new Mapper();
    $mapper_fotos->setDbTable(new ImovelAlbum()); 
    $rows_fotos = $mapper_fotos->getSql('SELECT * FROM imovel_album WHERE imovel_id = "'.$imovel->id.'" GROUP BY album_id ORDER BY id ASC');
    
    /**
    * Pega as fotos do imóvel
    */
    $mapper_album = new Mapper();
    $mapper_album->setDbTable(new Album());       
    
    $i = 0;  
    $html_fotos = '';

    foreach($rows_fotos as $row_fotos){

        $mapper_album->setWhere('id = '.$row_fotos->album_id);
        $albuns = $mapper_album->getRows();
        
        foreach($albuns as $album){
            
            $j = 0;
            
            $mapper_fotos->setWhere('imovel_id = "'.$imovel->id.'" and album_id = "'.$album->id.'"'); 
            $mapper_fotos->setOrder("id ASC");
            $rows_fotos2 = $mapper_fotos->getRows();  
            
            $i++;

            if($i == 1){
                $classe = 'class="hover"';  
                $style = 'style="display:block"';         
            }
            else{        
                $classe = '';              
                $style = '';               
            }       

            $html_fotos .= '<h2 id="first" '.$classe.'>'.strtoupper($album->nome).'</h2><div class="c-fotos" '.$style.'><div class="slideshow" id="slide_imoveis_fotos_'.$i.'"><ul>';
                               
            foreach($rows_fotos2 as $row_foto2){    
                
                $j++;
                
                if($album->nome != "Outros")
                    $legenda = "";
                else
                    $legenda = $row_foto2->legenda;
                
                if($j == 1)
                    $style1= 'class="show"';         
                else   
                    $style1 = 'class="hide"';               
                
                if($row_foto2->foto != "")             
                    $img = URL_ABSOLUTE.'static/uploads/imoveis/'.$_SESSION['usuario_visitado']->login.'/'.$imovel->titulo_url.'/'.$row_foto2->foto;             
                else                
                    $img = '<img src="static/img/img-imoveis.jpg" alt="'.$imovel->titulo.'" />';              

                if($_SESSION['usuario_logado']->logotipo != "")
                    $logotipo = URL_ABSOLUTE.'static/uploads/logotipos/'.$_SESSION['usuario_visitado']->login.'/'.$_SESSION['usuario_visitado']->logotipo;
                else
                    $logotipo = "";
                
                $html_fotos .= '<li id="ft_imov_'.$j.'" rel="'.$j.'" '.$style1.' ><a class="lightbox" title="'.$imovel->titulo.'" href="library/phpthumb/phpThumb.php?src='.$img.'&w=800&fltr[]=wmi|'.$logotipo.'|BL">'.ImgRender($img, 353, 249, $imovel->titulo, $logotipo).'</a><p style="margin-top:5px;">'.$legenda.'</p></li>';
            
            }
            
            $html_fotos .= '</ul>';
            
            if($j > 1){
                $html_fotos .= '<div class="control_slider"><a class="buttons prev" href="javascript:void(0)"></a>';
                $html_fotos .= '<a class="buttons next" href="javascript:void(0)"></a></div>';
            }
            
            $html_fotos .= '</div></div>';
        
        }
                
    }
    
    $voltar = "";
    $localizacao = "";
    
    if($imovel->endereco != "")
        $localizacao .= $imovel->endereco.', ';
    
    if($bairro != "")
        $localizacao .= $bairro.', ';
    
    if($city != "")
        $localizacao .= $city.', ';
    
    if($uf != "")
        $localizacao .= $uf.', ';
    
    if(isset($_SERVER['HTTP_REFERER'])){
        $url_anterior = explode('/',$_SERVER['HTTP_REFERER']);
    
        if (in_array("busca-imoveis", $url_anterior))
            $voltar = "<div id='box-voltar'><a id='voltar' href = '".$_SERVER['HTTP_REFERER']."'>voltar</a></div>";
    }

    include('views/imovel.php');

}
else
    echo '<script>location.href = "home/pagina-nao-existe";</script>';  



