<div id="content">
    
    <div class="page page-fale-conosco">
	
        <div class="breadcumbs">
            <span>Fale Conosco</span>
        </div>
        
        <div id="box-rede-contatos" class="busca-codigo-av busca-contatos convidar busca-fale-conosco">

          <p class="all-green">Nos envie suas d&uacute;vidas, cr&iacute;ticas e sugest&otilde;es:</p>

            <form>
            
                <span>*Nome</span><span>Email</span>
                
                <div id="repetir" class="repetir-c">
                    <input type="text" name="nome1"  class="input"/>
                    <input type="text" name="email1" class="input" />
                    <input type="hidden" id="quantidade-campos" value="" name="quantidade" class="input"  />
                </div>
                
                <label class="cadastro-all textarea txt-fc">
                    <span>Mensagem:</span>
                    <textarea>Ol&aacute;, Leandra Soares gostaria de convid&aacute;-lo(a) partttta participar da rede Sua Focal Point.</textarea>           
              </label>
                
                <input type="submit" value="" class="bt enviar-fc" />
                            
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