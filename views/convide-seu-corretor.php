<script type="text/javascript">
$(document).ready(function(){
    $("#formulario2").validate();
    $("#formulario").validate();
})
</script>

<div class="center">

    <div class="desc">
        <a href="home" class="logo"><img src="static/img/logo.png" /></a>
    </div>
    
    <div class="bread">
    	<a href="home">Home > </a><span>Convide seu corretor</span>
    </div>
    
<!--    <div class="box-left">
    
    	<p class="blue">Compradores, Vendedores, Locadores e Locatários</p>
    
        <p>Utilize o formulário ao lado e indique seu corretor para nossa rede.</p>
        
        <p><strong>Você pode também visualizar os corretores cadastrados em nossa rede.</strong></p>
        
        <p>Selecione um bairro abaixo que então será exibida uma listagem com os corretores cadastrados que atuam no bairro selecionado:</p>
        
        <form action="home/busca-corretor" method="post" id="formulario">
        
            <label style="float: left; width: 215px;">
            
            	<?php //echo $select_bairro;?>
            
            </label>
            
            <input type="submit" value="" />
        
        </form>

    </div>-->
    
    <div class="box-right" style="padding: 0; width: 100%;">

        <?php echo $msg;?>

        <p style="font-size:16px;">Compradores, Vendedores, Locadores e Locatários Utilize o formulário abaixo e indique seu corretor para nossa rede.</p>
        
        <form style="width: 600px;" action="" method="post" class="form-home" id="formulario2">
        
            <label>
            	<span>* Seu Nome:</span>
                <input type="text" name="nome" class="required" id="nome" />           
            </label>
        
            <label>
            	<span>* Seu Email:</span>
                <input type="text" name="email" class="required email" id="email" />           
            </label>
        
            <label>
            	<span>* Nome do Corretor:</span>
                <input type="text" name="nome_corretor" class="required" id="nome_corretor" />           
            </label>
        
            <label>
            	<span>* Email do Corretor:</span>
                <input type="text" name="email_corretor" class="required email" id="email_corretor" />           
            </label>
        
            <label class="textarea">
            	<span>* Mensagem::</span>
                <textarea name="mensagem" class="required" id="mensagem"></textarea>           
            </label>
            
            <br clear="all" />
            <input type="submit" value="" class="enviar-senha convide"/>
        
        </form>
        
    </div>
    

</div>