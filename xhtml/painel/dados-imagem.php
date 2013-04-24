<div id="nav">

    <?php include 'nav-dados.php';?>
    
</div>

<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Imagem de exibição</span>
        </div>
        
        <form action="?page=dados-contato" method="post" id="formulario">
        
            <div class="foto">
                <span>Envie seu logotipo:</span>
                <img src="imagens/foto.jpg" width="92" height="92" alt="Sua Foto" title="Sua Foto" />
                <span class="tx">Selecione um arquivo de imagem de seu computador <font>(No máximo 2MB)</font></span>
                <span class="file-wrapper">
                  <input type="file" name="photo1" class="photo" />
                  <span class="button">Choose a Photo</span>
                </span>
            </div>  
                                  
            <div class="foto">
                <span>Envie seu logotipo:</span>
                <img src="imagens/foto.jpg" width="92" height="92" alt="Sua Foto" title="Sua Foto" />
                <span class="tx">Selecione um arquivo de imagem de seu computador <font>(No máximo 2MB)</font></span>
                <span class="file-wrapper">
                  <input type="file" name="photo2" class="photo" />
                  <span class="button">Choose a Photo</span>
                </span>
            </div>                        

            <br clear="all" />
            <br clear="all" />
            <br clear="all" />
            <br clear="all" />
            <br clear="all" />
            <br clear="all" />
            
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
    
    </div>

</div>
