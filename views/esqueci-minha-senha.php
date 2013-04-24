<div class="center">

    <div class="desc">
        <a href="home"><img src="static/img/logo.jpg" /></a>
    </div>
    
    <div class="bread">
    	<a href="home">Home > </a><span>Esqueci minha Senha</span>
    </div>
    
    <div class="box-left">
    
    	<p class="blue">Perdeu sua Senha?</p>
    
        <p>Se você perdeu sua senha, pode usar esse formulário para gerar uma nova. Insira seu e-mail no campo ao lado.</p>
        
        <p><strong>Lembre-se: letras maiúsculas são diferentes de minúsculas.</strong></p>
        
        <p>Após completar o formulário, você receberá uma mensagem da Sua Focal Point com instruções de como recuperar sua senha.</p>

    </div>
    
    <div class="box-right">
    
    	<h2><strong>Esqueci a senha</strong><br />Informe abaixo seu email de cadastro:</h2>
    
        <form action="" method="post" id="formulario">
        
            <label>
            	<span>* Seu Email:</span>
                <input type="text" name="email_esqueci" class="required email" id="email_esqueci" />           
                <?php echo $retorno; ?>
            </label>
            <br clear="all" />
            <input type="submit" value="" class="enviar-senha"/>
        
        </form>
        
    </div>
    

</div>