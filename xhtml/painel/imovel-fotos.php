<div id="nav" style="width:270px;">

    <?php include 'nav-imovel.php';?>
    
</div>

<div id="content" style="width:670px;">
	
    <div class="page page-imovel">
	
        <div class="breadcumbs">
        
            <span>Cadastre seu im&oacute;vel</span>
            
        </div>
        
        <form action="?page=dados-contato" method="post" id="formulario">
        
            <div class="info">
            	<span class="num">1</span><p>Escolha as fotos no seu computador</p>
            </div>
            <div class="info">
            	<span class="num">2</span>
                <p>Voc&ecirc; poder&aacute; enviar at&eacute; 10 fotos e separ&aacute;-las em 7 &aacute;lbuns (limite de 1 fotos por &aacute;lbum)</p>
            </div>
            <div class="info">
            	<span class="num">3</span><p>Insira uma legenda</p>
            </div>
            <div class="info">
            	<span class="num">4</span><p>Selecione o &Aacute;lbum onde a imagem ser&aacute; exibida</p>
            </div>
            
            <div class="linha-form">&nbsp;</div>

            <div class="foto foto-c">
                <h3>Fotos</h3>
                <img src="imagens/foto_03.jpg" width="92" height="92" alt="Sua Foto" title="Sua Foto" />
                <span class="tx">Selecione até 10 arquivos de  imagem de seu computador<br /><font>(No máximo 2MB para cada foto)</font></span>
                <span class="file-wrapper">
                  <input type="file" name="photo1" class="photo" />
                  <span class="button">Choose a Photo</span>
                </span>
            </div>  
            
            <div class="header-fotos">
                <p>ARQUIVOS</p>
                <p class="escolha">ESCOLHA O ÁLBUM</p>
                <p class="legenda">LEGENDA PARA FOTO</p>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <div class="albuns">
                <label class="select cadastro-small cf">
                    <span>foto1.jpg</span>
                </label>
    
                <label class="imovel imovel-c end cf-select">
                    <select name="cidade" class="validate[required] text-input cidade">
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                        <option>Selecione o Álbum</option>
                    </select>
                </label>
            
                <label class="imovel imovel-c cf-end">
                    <input type="text" name="legenda" value="Quarto do Casal" onblur="if(this.value == ''){ this.value='Quarto do Casal' }" onfocus="if(this.value == 'Quarto do Casal'){ this.value='' }" class="mm" />           
                </label>
            </div>
            
            <input type="submit" value="" class="enviar-senha"/>
            
        </form>
    
    </div>

</div>
<script type="text/javascript">
	$(".cidade").selectbox().bind('change', function(){
		$('<div>Value of .cidade changed to: '+$(this).val()+'</div>').appendTo('#demo-default-usage .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
</script>

