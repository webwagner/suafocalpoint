<?php
	echo $_POST['plano'];
	if($_POST['plano']!=1){
		$frase = '<p align="center" style="margin-bottom:0"><strong>Assim que o pagamento for identificado,</strong></p>
        <p align="center" style="margin-top:0"><strong>você estará recebendo um email com informações da ativação do seu cadastro.</strong></p>';
	}else{
		$frase = '<p align="center" style="margin-bottom:0"><strong>Em poucos minutos,</strong></p>
        <p align="center" style="margin-top:0"><strong>você estará recebendo um email com informações da ativação do seu cadastro.</strong></p>';
	}
?>
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
        
        	<li><a href="?page=inscreva-se">Preencha o Formulário</a></li>
        
        	<li><a href="?page=termo-de-uso">Termos de Uso</a></li>
        
        	<li><a href="?page=escolha-seu-plano">Escolha seu Plano</a></li>
        
        	<li class="hover"><a href="?page=cadastro-realizado">Pronto</a></li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos negócios através da nossa rede.</p>

    </div>
    
    <div class="box-right">
    
        <p align="center" style="text-transform:uppercase"><strong>Parabéns, seu cadastro foi realizado com sucesso!</strong></p>
        <?php echo $frase;?>
        <p align="center"><a href="index.php" class="voltar-inicio">Voltar ao início</a></p>
        <br clear="all" />
        <p align="center"><a href="?page=duvidas-frequentes" class="faq">DÚVIDAS FREQUENTES</a></p>
        
    </div>
    

</div>