<link rel="stylesheet" href="css/interna.css" type="text/css" />
<div class="center">

    <div class="desc">
        <a href="?page=home"><img src="img/logo.jpg" /></a>
    </div>
    
    <div class="bread">
    	<a href="?page=home">Home > </a><span>Esqueci minha Senha</span>
    </div>
    
    <div class="box-left">
    
    	<p class="blue">Perdeu sua Senha?</p>
    
        <p>Se você perdeu sua senha, pode usar esse formulário para gerar uma nova. Insira seu e-mail no campo ao lado.</p>
        
        <p><strong>Lembre-se: letras maiúsculas são diferentes de minúsculas.</strong></p>
        
        <p>Após completar o formulário, você receberá uma mensagem da Sua Focal Point com instruções de como recuperar sua senha.</p>

    </div>
    
    <div class="box-right">
    
    	<h2><strong>Esqueci a senha</strong><br />Informe abaixo seu email de cadastro:</h2>
    
        <form action="?page=esqueci-minha-senha-enviado" method="post" id="formulario">
        
            <label>
            	<span>* Seu Email:</span>
                <input type="text" name="email" class="validate[required,custom[email]]" id="email" />           
            </label>
            
            <br clear="all" />
            <input type="submit" value="" class="enviar-senha"/>
        
        </form>
        
    </div>
    

</div>