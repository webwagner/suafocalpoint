<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Imagem de exibição</span>
        </div>
        
        <?php echo $msg;?>
        
        <form action="" method="post" id="formulario" enctype="multipart/form-data">
        
            <div class="foto">
                <span class="span-cad-album">Envie sua foto/logotipo:</span>
                <?php echo $foto;?>
                <span class="tx span-cad-album">Selecione um arquivo de imagem de seu computador <font>(No máximo 2MB)</font></span>
                <span class="file-wrapper">
                  <input type="file" name="foto" class="photo" />
                  <span class="button">Choose a Photo</span>
                </span>
            </div>  
                                  
            <br clear="all" />
            <br clear="all" />
            <br clear="all" />
            <br clear="all" />
            <br clear="all" />
            <br clear="all" />
            
            <input type="submit" value="" class="enviar-senha salvar"/>
        
        </form>
    
    </div>

</div>
