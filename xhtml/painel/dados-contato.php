<div id="nav">

    <?php include 'nav-dados.php';?>
    
</div>

<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Dados de Contato</span>
        </div>
        
  <form action="?page=dados-imagem" method="post" id="formulario">
        
        
            <label class="cadastro-all">
            	<span>*Empresa:</span>
                <input type="text" name="endereco" class="validate[required] text-input" id="endereco"/>           
            </label>

            <label class="cadastro-all">
                <span>*Endere&ccedil;o:</span>
                <input type="text" name="endereco" class="validate[required] text-input" id="endereco"/>           
            </label>
        	<br clear="all" />
            <label class="cadastro-small">
            	<span>*N&uacute;mero:</span>
                <input type="text" name="numero" class="validate[required] text-input" id="numero"/>           
            </label>
        
            <label class="cadastro-m" style="width:250px;">
            	<span>Complemento:</span>
                <input type="text" name="complemento" />           
            </label>
        
            <label class="cadastro-m">
            	<span>*Bairro:</span>
                <input type="text" name="bairro" class="validate[required] text-input" id="bairro"/>           
            </label>
        	<br clear="all" />
            <label class="cadastro-small" style="margin-right:10px;">
            	<span>*Estado:</span>
            	<select name="estado" class="validate[required] text-input" id="estado">
                	<option>RJ</option>
                	<option>SP</option>
                </select>
            </label>

            <label class="cadastro-m" style="margin:0; width:250px;">
            	<span>*Cidade:</span>
            	<select name="cidade" class="validate[required] text-input" id="cidade">
                	<option>Rio de Janeiro</option>
                	<option>S&atilde;o Paulo</option>
                </select>
            </label><br clear="all" />
        
            <label class="cadastro-ddd">
            	<span>*Telefone:</span>
                <input type="text" name="ddd" class="validate[required] text-input" id="ddd" />           
            </label>
        
            <label class="cadastro-m-ddd">
            	<span>&nbsp;</span>
                <input type="text" name="telefone" class="validate[required] text-input" id="telefone"/>           
            </label>
        
            <label class="cadastro-ddd">
            	<span>*Fax:</span>
                <input type="text" name="ddd_fax" class="validate[required] text-input" id="ddd_fax" />           
            </label>
        
            <label class="cadastro-m-ddd" style="margin-right:0">
            	<span>&nbsp;</span>
                <input type="text" name="fax"  class="validate[required] text-input" id="fax"/>           
            </label>
            
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
    
    </div>

</div>

<script type="text/javascript">
	$("#cidade").selectbox().bind('change', function(){
		$('<div>Value of #cidade changed to: '+$(this).val()+'</div>').appendTo('#demo-default-usage .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
	$("#estado").selectboxB().bind('change', function(){
		$('<div>Value of #uf changed to: '+$(this).val()+'</div>').appendTo('#demo-default-ciuda .demoTarget').fadeOut(5000, function(){
			$(this).remove();
		});
	});
</script>

