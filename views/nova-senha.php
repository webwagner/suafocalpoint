<script>
$(document).ready(function() {
    $("#formulario").validate();
})
</script>
         
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
    
    	<h2><strong>Nova Senha</strong><br />Informe abaixo sua nova senha:</h2>
    
        <form action="" method="post" id="formulario">
        
            <label>
            	<span>* Nova Senha:</span>
                <input type="password" name="senha" class="required" id="senha" />           
            </label>
            <label>
            	<span>* Confirmar Senha:</span>
                <input type="password" name="senha-conf" equalTo="#senha" class="required" id="senha-conf" />           
            </label>
            <br clear="all" />
            <input type="submit" value="" class="enviar-senha"/>
        
        </form>
        
    </div>
    

</div>