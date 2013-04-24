<script type="text/javascript" src="<?php echo URL;?>static/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/maskedinput-1.1.4.js"></script>	
<script>
$(document).ready(function() {
    	
    $("#formulario").validate({
        rules: {
                'email': {
                    required: true,
                    email: true
                }
            },
        messages: {
            email: {
                required: "Campo obrigatório.",
                email: "Email inválido"
            }
        }
    });
    
    $("#email").focusout(function() {
       if($(this).val() != ''){
           var email = $(this).val();
           $.getJSON('verifica-corretor.php',{campo : 'email', valor : email, valor_atual : "<?php echo $dados->email;?>"} ,function(txt){
                if(txt.valor == 'YES'){
                    $("#campo_existe2").show();
                    $('#email').val('');
                    $('#email').focus();
                }
                else{
                    $("#campo_existe2").hide();
                }
           })
       }
   });
   
   $("#nascimento").mask("99/99/9999"); 
    
})
</script>

<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Dados Gerais</span>
        </div>
        
        <?php echo $msg;?>
        
        <form action="" method="post" id="formulario">
            
            <input name="id" type="hidden" value="<?php echo $dados->id;?>" />
            
            <label class="cadastro">
            	<span>*Nome:</span>
                <input type="text" name="nome" class="required" id="nome" value="<?php echo ($dados->nome != "" ? $dados->nome : "");?>" />           
            </label>
        
            <label class="cadastro-m">
            	<span>N&deg;CRECI:</span>
                <input type="text" name="creci" id="creci" value="<?php echo ($dados->creci != "" ? $dados->creci : "");?>" />           
            </label>
        
            <label style="height: auto; margin-bottom: 10px;" class="cadastro">
            	<span>E-mail:</span>
                <input type="text" name="email" class="required" id="email" value="<?php echo ($dados->email != "" ? $dados->email : "");?>" />           
                <span id="campo_existe2">Email já existe. Insira um outro email.</span>
            </label>
        
            <label class="cadastro">
                <?php if($dados->cnpj == "") :?> 
            	<span>Nascimento:</span>
                <?php else :?>
                <span>Fundação:</span>
                <?php endif;?>
                <input type="text" name="data_nascimento" class="text-input" id="nascimento" value="<?php echo ($dados->data_nascimento != "" ? $dados->data_nascimento : "");?>" />           
            </label>

           <?php if($dados->cnpj == "") :?> 
            <label class="l-radio">
            	<span>Sexo</span>
            </label>
            
            <div class="radio">
                <label>
                    <input type="radio" name="sexo" value="Masculino" <?php echo ($dados->sexo == "Masculino" ? "checked='checked'" : "");?> class="required text-input" id="sexo" />           
                    <span style="position: absolute;">Masculino</span>
                </label>
            </div>
            
            <div class="radio">
                <label>
                    <input type="radio" name="sexo" value="Feminino" class="required text-input" id="sexo" <?php echo ($dados->sexo == "Feminino" ? "checked='checked'" : "");?> /> 
                    <span style="position: absolute;">Feminino</span>
                </label>
            </div>
            <?php else:?>
            <label class="cadastro">
            	<span>*Pessoa de Contato:</span>
                <input type="text" name="pessoa_contato" class="text-input required" id="pessoa_contato" value="<?php echo ($dados->pessoa_contato != "" ? $dados->pessoa_contato : "");?>" />           
            </label>
            <?php endif;?>
            
            <label class="cadastro-all" style="height:40px;">
            	<span>Você aceita que seus dados sejam listados em nossa página inicial no link Conheça Corretores?</span>
            </label><br clear="all" />
            
            <div class="radio" style="margin:0;">
                <label>
                    <input <?php echo ($dados->dados_listados == "SIM" ? "checked='checked'" : "");?> type="radio" name="dados_listados" checked="checked" value="SIM" />           
                    <span>Sim</span>
                </label>
            </div>
            
            <div class="radio" style="margin:0;">
                <label>
                    <input <?php echo ($dados->dados_listados == "NAO" ? "checked='checked'" : "");?> type="radio" name="dados_listados" value="NAO" /> 
                    <span>Não</span>
                </label>
            </div><br clear="all" /><br clear="all" />

            <br clear="all" />
            
            <input type="submit" value="" class="enviar-senha salvar"/>
        
        </form>
    
    </div>

</div>
