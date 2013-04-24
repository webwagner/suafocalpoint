<script type="text/javascript" src="js/maskedinput-1.1.4.js"></script>	
<script type="text/javascript">
	jQuery(document).ready(function(){
		$("#telefone").mask("9999-9999");
		$("#fax").mask("9999-9999");
		$("#ddd").mask("(99)");
		$("#ddd_fax").mask("(99)");
	});

	fileInputs = function() {
	  var $this = $(this),
		  $val = $this.val(),
		  valArray = $val.split('\\'),
		  newVal = valArray[valArray.length-1],
		  $button = $this.siblings('.button'),
		  $fakeFile = $this.siblings('.file-holder');
	  if(newVal !== '') {
		$button.text('Photo Chosen');
		if($fakeFile.length === 0) {
		  $button.after('' + newVal + '');
		} else {
		  $fakeFile.text(newVal);
		}
	  }
	};
	
	$(document).ready(function() {
	  $('.file-wrapper input[type=file]')
	  .bind('change focus click', fileInputs);
	});
</script>

<link rel="stylesheet" href="css/interna.css" type="text/css" />
<div class="center">

    <div class="desc">
        <a href="?page=home"><img src="img/logo.jpg" /></a>
    </div>
    
    <div class="bread">
    	<a href="?page=home">Home > </a><span>Cadastro</span>
    </div>
    
    <div class="box-left">
    
    	<p class="blue">Faça seu cadastro em 4 passos simples <br />e comece a participar da nossa rede.</p>
        
        <ul>
        
        	<li class="hover"><a href="?page=inscreva-se">Preencha o Formulário</a></li>
        
        	<li><a href="?page=termo-de-uso">Termos de Uso</a></li>
        
        	<li><a href="?page=escolha-seu-plano">Escolha seu Plano</a></li>
        
        	<li><a href="?page=cadastro-realizado">Pronto</a></li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos negócios através da nossa rede.</p>

    </div>
    
    <div class="box-right">
    
        <form action="?page=termo-de-uso" method="post" id="formulario">
        
            <label class="cadastro">
            	<span>*Nome:</span>
                <input type="text" name="nome"class="validate[required] text-input" id="nome" />           
            </label>
        
            <label class="cadastro-m">
            	<span>N° CRECI:</span>
                <input type="text" name="creci" />           
            </label>
        
            <label class="cadastro">
            	<span>*CPF:</span>
                <input type="text" name="cpf" class="validate[required] text-input" id="cpf"/>           
            </label>
        
            <label class="cadastro-m">
            	<span>Nascimento:</span>
                <input type="text" name="nascimento" />           
            </label>
        
            <label>
            	<span>*Senha:</span>
                <input type="text" name="senha" class="validate[required] text-input" id="senha"/>           
            </label>
        
            <label>
            	<span>*Confirme sua Senha:</span>
                <input type="text" name="c_senha" class="validate[required] text-input" id="c_senha" />           
            </label>
        
            <label style="height:15px;">
            	<span>É corretor autônomo?</span>
            </label><br clear="all" />
            
            <div class="radio">
                <label>
                    <input type="radio" name="autonomo" value="1" />           
                    <span>Sim</span>
                </label>
            </div>
            
            <div class="radio">
                <label>
                    <input type="radio" name="autonomo" value="2" /> 
                    <span>Não</span>
                </label>
            </div>
        
            <label class="cadastro-all">
            	<span>*Endereço:</span>
                <input type="text" name="endereco" class="validate[required] text-input" id="endereco"/>           
            </label>
        
            <label class="cadastro-small">
            	<span>*Número:</span>
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
                	<option>São Paulo</option>
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
            
            <div class="foto">
                <span>Envie seu logotipo:</span>
                <img src="img/foto.jpg" width="92" height="92" alt="Sua Foto" title="Sua Foto" />
                <span class="tx">Selecione um arquivo de imagem de seu computador <font>(No máximo 2MB)</font></span>
                <span class="file-wrapper">
                  <input type="file" name="photo1" class="photo" />
                  <span class="button">Choose a Photo</span>
                </span>
            </div>
            
            <div class="foto">
                <span>Envie seu logotipo:</span>
                <img src="img/foto.jpg" width="92" height="92" alt="Sua Foto" title="Sua Foto" />
                <span class="tx">Selecione um arquivo de imagem de seu computador <font>(No máximo 2MB)</font></span>
                <span class="file-wrapper">
                  <input type="file" name="photo2" class="photo" />
                  <span class="button">Choose a Photo</span>
                </span>
            </div>                        

            <br clear="all" />
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
        
    </div>
    

</div>