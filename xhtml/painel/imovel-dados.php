<div id="nav" style="width:270px;">

    <?php include 'nav-imovel.php';?>
    
</div>

<div id="content" style="width:670px;">
	
    <div class="page page-imovel">
	
        <div class="breadcumbs">
        
            <span>Cadastre seu im&oacute;vel</span>
            
        </div>
        
        <form action="?page=dados-contato" method="post" id="formulario">
        
            <label class="imovel imovel-c">
            	<span>*Tipo:</span>
            	<select name="tipo" class="validate[required] text-input" id="tipo">
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                </select>
            </label>
        
            <label class="imovel imovel-c">
            	<span>*Vencimento do contrato</span>
                <input type="text" name="vencimento" />           
            </label>
            
          <div class="linha-form">&nbsp;</div>
            
            <div class="l-check">
            
                <div class="check">                
                    <label>
                        <input type="checkbox" />
                        <span>Residencial</span>
                    </label>
                    <label>
                        <input type="checkbox" />
                        <span>Comercial</span>
                    </label>
                </div>
                
                <div class="check">
                    <label>
                        <input type="checkbox" />
                        <span>Aluguel</span>
                    </label>
                    <label>
                        <input type="checkbox" />
                        <span>Compra</span>
                    </label>
                </div>
            
            </div>
            
            <div class="linha-form">&nbsp;</div>
        
            <label class="imovel imovel-c imovel-menor">
            	<span><strong>*Para Aluguel</strong><br />Aluguel em Reais - R$</span>
                <input type="text" name="vencimento" />           
            </label>
        
            <label class="imovel imovel-c imovel-menor">
            	<span><strong>*Para Venda</strong><br />Aluguel em Reais - R$</span>
                <input type="text" name="vencimento" />           
            </label>            
            
            <label class="cadastro-all">
            	<span class="blue">*T&iacute;tulo do Im&oacute;vel:</span>
                <input type="text" name="titulo" class="validate[required] text-input" id="titulo"/>           
            </label>
            
            <div class="linha-form">&nbsp;</div>
           
            <p class="inteiro"><strong>*Número de Quartos</strong></p>
            <label class="imovel imovel-c">
            	<span>*Atual:</span>
            	<select name="atual" class="validate[required] text-input" id="atual">
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                </select>
            </label>
        
            <label class="imovel imovel-c">
            	<span>*Original:</span>
            	<select name="atual" class="validate[required] text-input" id="original">
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                </select>
            </label>
            
            <div class="linha-form">&nbsp;</div>
        
            <label class="imovel imovel-c imovel-metragem">
            	<span><strong>*Área construída</strong><br /><font>(não incluindo varandas)</font></span>
                <input type="text" name="area_construida" /><span class="metro">m²</span>           
            </label>
        
            <label class="imovel imovel-c imovel-metragem">
            	<span><strong>*Área Externa</strong><br /><font>&nbsp;</font></span>
                <input type="text" name="area_externa" /><span class="metro">m²</span>               
            </label>
        
            <label class="imovel imovel-c imovel-metragem">
            	<span><strong>*Terreno</strong><br /><font>&nbsp;</font></span>
                <input type="text" name="terreno" /><span class="metro">m²</span>                     
            </label>
            
            <div class="linha-form">&nbsp;</div>
        
            <div class="imovel-radio">
            	<span><strong>*É mobiliado?</strong></span>
                <label>
                	<input name="mobiliado" value="1" type="radio" />
                    <span class="green">Sim</span>
                </label>
                <label>
                	<input name="mobiliado" value="2" type="radio" />
                    <span class="green">Não</span>
                </label>

            	<span>&nbsp;&nbsp;&nbsp;&nbsp;<strong>*Opcionais?</strong></span>
                <label>
                	<input name="portaria" value="" type="checkbox" />
                    <span class="ch green green-m">Portaria 24h</span>
                </label>
                <label>
                	<input name="varanda" value="" type="checkbox" />
                    <span class="ch green green-m">Varanda</span>
                </label>
                <label>
                	<input name="mobiliado" value="" type="checkbox" />
                    <span class="ch green green-m">Mobiliado</span>
                </label>
            </div>
            
            <div class="linha-form">&nbsp;</div>
        
            <div class="imovel-radio">
            	<span><strong>Piscina?</strong></span>
                <label>
                	<input name="mobiliado" value="1" type="radio" />
                    <span class="green">Sim</span>
                </label>
                <label>
                	<input name="mobiliado" value="2" type="radio" />
                    <span class="green">Não</span>
                </label>
        
                <label class="imovel imovel-c imovel-menor" style="width:400px; margin-left:35px;">
                    <span><strong>&nbsp;&nbsp;&nbsp;&nbsp;Nome do Condomínio</strong></span>
                    <input type="text" name="vencimento" class="cd"/>           
                </label>            
            </div>
            
            <div class="linha-form">&nbsp;</div>
        
            <p class="inteiro">
                <strong>Valor do IPTU</strong>
                <strong style="margin-left:190px;">Valor do Condomínio</strong>
            </p>
            
            <label class="imovel imovel-c">
            	<span class="gr">R$:</span>
                <input type="text" name="vencimento" class="mm" />           
            </label>
        
            <label class="imovel imovel-c">
            	<span class="gr">R$:</span>
                <input type="text" name="vencimento" class="mm" />           
            </label>
            
            <div class="linha-form">&nbsp;</div>
        
            <p class="inteiro">
                <strong>Localização</strong>
            </p>
            
            <label class="select cadastro-small">
                <select id="uf">
                    <option>UF</option>
                    <option>UF</option>
                    <option>UF</option>
                    <option>UF</option>
                    <option>UF</option>
                    <option>UF</option>
                </select>
            </label>

            <label class="imovel imovel-c end">
            	<select name="cidade" class="validate[required] text-input" id="cidade">
                	<option>Cidade</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                </select>
            </label>
        
            <label class="imovel imovel-c end">
            	<select name="bairro" class="validate[required] text-input" id="bairro">
                	<option>Bairro</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                	<option>Selecione</option>
                </select>
            </label>

            <input type="submit" value="" class="enviar-senha"/>
        
        </form>
    
    </div>

</div>
<script type="text/javascript">
	$("#tipo").selectbox().bind('change', function(){
		$('<div>Value of #cidade changed to: '+$(this).val()+'</div>').appendTo('#demo-default-usage .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#original").selectbox().bind('change', function(){
		$('<div>Value of #original changed to: '+$(this).val()+'</div>').appendTo('#demo-default-usage .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#atual").selectbox().bind('change', function(){
		$('<div>Value of #atual changed to: '+$(this).val()+'</div>').appendTo('#demo-default-usage .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#cidade").selectbox().bind('change', function(){
		$('<div>Value of #cidade changed to: '+$(this).val()+'</div>').appendTo('#demo-default-usage .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#bairro").selectbox().bind('change', function(){
		$('<div>Value of #bairro changed to: '+$(this).val()+'</div>').appendTo('#demo-default-ciuda .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#uf").selectboxB().bind('change', function(){
		$('<div>Value of #uf changed to: '+$(this).val()+'</div>').appendTo('#demo-default-ciuda .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
</script>

