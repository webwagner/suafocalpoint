<script type="text/javascript">
	jQuery(document).ready(function(){
		$('#select').change(function() {
			
		   $('#form3').hide();
		   
		   $('#form' + $(this).find('option:selected').attr('id')).show();
		   
		});
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
    
    	<p class="blue">Faça seu cadastro em 4 passos simples <br />e com?ece a participar da nossa rede.</p>
        
        <ul>
        
        	<li><a href="?page=inscreva-se">Preencha o Formulário</a></li>
        
        	<li class="hover"><a href="?page=termo-de-uso">Termos de Uso</a></li>
        
        	<li><a href="?page=escolha-seu-plano">Escolha seu Plano</a></li>
        
        	<li><a href="?page=cadastro-realizado">Pronto</a></li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos negócios através da nossa rede.</p>

    </div>
    
    <div class="box-right">
    
        <form action="?page=escolha-seu-plano" method="post" id="formulario">
        
            <label class="cadastro-all">
            	<span>Como conheceu nossa rede?<br />
                    <em style="font-size:11px">Caso tenha sido indicado por um corretor cadastrado, selecione a opção indicação e insira o código dele.</em>
                </span>
            	<select name="cidade" class="validate[required] text-input" id="select">
                    <option value="">Selecione</option>
                    <option value="Facebook" id="1">Facebook</option>
                    <option value="Twitter" id="2">Twitter</option>
                    <option value="Orkut" id="4">Orkut</option>
                    <option value="Busdoor" id="5">Busdoor</option>
                    <option value="Outdoor" id="6">Outdoor</option>
                    <option value="Painel" id="7">Painel</option>
                    <option value="Revista" id="8">Revista</option>
                    <option value="Jornal" id="9">Jornal</option>
                    <option value="Panfletos" id="10">Panfletos</option>
                    <option value="Folder" id="11">Folder</option>
                    <option value="Email Marketing" id="12">Email Marketing</option>
                    <option value="Indica??o de Amigos" id="13">Indica&ccedil;&atilde;o de Amigos</option>
                    <option value="Outros" id="3">Outros</option>
                </select>
            </label><br clear="all" />

            <label class="cadastro-m" id="form3" style="margin:0; width:250px; display:none;">
            	<span>&nbsp;</span>
                <input type="text" name="nome"/>           
            </label><br clear="all" />
        
            <label class="cadastro-all" style="height:40px;">
            	<span>Você aceita que seus dados sejam listados em nossa página inicial no link Indicação Corretor?</span>
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
            </div><br clear="all" /><br clear="all" />
        
            <label class="cadastro-all" style="height:40px;">
            	<span>Digite abaixo sua sigla com 3 caracteres (somente letras) que identificará imóveis<br />cadastrados por você:<br /><em style="font-size:11px">Ex.: RRD</em></span>
            </label><br clear="all" />
        
            <label class="cadastro-m" style="margin:10px 0 0 0; width:100px;">
                <input type="text" name="autonomo" maxlength="3" class="validate[required] text-input" id="sigla"/> 
            </label>
        
            <label class="textarea termo">
            	<span>Termos de uso:</span>
                <textarea name="termos"></textarea>           
            </label>
            
            <p class="confirm">Ao clicar em 'Avançar', você estará aceitando os Termos de uso acima.</p>


            <br clear="all" />
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
        
    </div>
    

</div>