<div class="center">

    <div class="desc">
        <a href="home"><img src="static/img/logo.jpg" /></a>
    </div>
    
    <div class="bread">
    	<a href="home">Home > </a><span>Esqueci minha Senha</span>
    </div>
    
    <div class="box-left">
    
    	<p class="blue">Perdeu sua Senha?</p>
    
        <p>Se voc� perdeu sua senha, pode usar esse formul�rio para gerar uma nova. Insira seu e-mail no campo ao lado.</p>
        
        <p><strong>Lembre-se: letras mai�sculas s�o diferentes de min�sculas.</strong></p>
        
        <p>Ap�s completar o formul�rio, voc� receber� uma mensagem da Sua Focal Point com instru��es de como recuperar sua senha.</p>

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