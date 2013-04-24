<div id="nav">

    <?php include 'nav.php';?>
    
</div>

<div id="content">
    
    <div class="page page-contatos">
	
        <div class="breadcumbs">
            <span>Convide seus parceiros</span>
        </div>
        
        <div id="box-rede-contatos" class="busca-codigo-av busca-contatos convidar">

          <p class="all-green">Insira abaixo endere&ccedil;os de email de seus amigos e convide-os para a Sua Focal Point</p>

            <p class="normal">Na mensagem padr&atilde;o a ser enviada ter&aacute; um c&oacute;digo de identifica&ccedil;&atilde;o do seu perfil. No momento que seu contato realizar o cadastro e informar seu c&oacute;digo voc&ecirc; ganhar&aacute; uma mensalidade gratuita. Aproveite que nosso programa de afiliados funcionar&aacute; por tempo limitado.</p>

            <form>
            
                
                <span>*Nome</span><span>Email</span>
                
              <div id="repetir" class="repetir-c">
                    <input type="text" name="nome1"  class="input"/>
                    <input type="text" name="email1" class="input" />
                    <input type="hidden" id="quantidade-campos" value="" name="quantidade" class="input"  />
                </div>
                
                <a href="#box-rede-contatos" id="add-campo" class="cc">+ Clique aqui para convidar mais amigos</a>

                <label class="cadastro-all textarea txt-all">
                    <span>Mensagem:</span>
                    <textarea></textarea>           
                </label>

              <input type="submit" value="" class="bt bt-cc" />
                            
            </form>
            
        </div>
    
    </div>
    
    
</div>
<script type="text/javascript">
	$("#especialidade").selectbox().bind('change', function(){
		$('<div>Value of #especialidade changed to: '+$(this).val()+'</div>').appendTo('#demo-default-usage .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#estado").selectbox().bind('change', function(){
		$('<div>Value of #estado changed to: '+$(this).val()+'</div>').appendTo('#demo-default-ciuda .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
</script>