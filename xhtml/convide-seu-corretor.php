<link rel="stylesheet" href="css/interna.css" type="text/css" />
<div class="center">

    <div class="desc">
        <a href="?page=home" class="logo"><img src="img/logo.png" /></a>
    </div>
    
    <div class="bread">
    	<a href="?page=home">Home > </a><span>Convide seu corretor</span>
    </div>
    
    <div class="box-left">
    
    	<p class="blue">Compradores, Vendedores, Locadores e Locatários</p>
    
        <p>Utilize o formulário ao lado e indique seu corretor para nossa rede.</p>
        
        <p><strong>Você pode também visualizar os corretores cadastrados em nossa rede.</strong></p>
        
        <p>Selecione um bairro abaixo que então será exibida uma listagem com os corretores cadastrados que atuam no bairro selecionado:</p>
        
        <form action="?page=busca-corretor" method="post">
        
        	<label>
            
            	<select name="bairro">
                	<option>Nome Do Bairro</option>
                	<option>Nome Do Bairro</option>
                	<option>Nome Do Bairro</option>
                	<option>Nome Do Bairro</option>
                	<option>Nome Do Bairro</option>
                	<option>Nome Do Bairro</option>
                </select>
            
            </label>
            
            <input type="submit" value="" />
        
        </form>

    </div>
    
    <div class="box-right">
    
        <form action="?page=convide-seu-corretor-enviado" method="post" id="formulario">
        
            <label>
            	<span>* Seu Nome:</span>
                <input type="text" name="nome" class="validate[required] text-input" id="nome" />           
            </label>
        
            <label>
            	<span>* Seu Email:</span>
                <input type="text" name="email" class="validate[required,custom[email]]" id="email" />           
            </label>
        
            <label>
            	<span>* Nome do Corretor:</span>
                <input type="text" name="nome_corretor" class="validate[required] text-input" id="nome_corretor" />           
            </label>
        
            <label>
            	<span>* Email do Corretor:</span>
                <input type="text" name="email_corretor" class="validate[required,custom[email]]" id="email_corretor" />           
            </label>
        
            <label class="textarea">
            	<span>* Mensagem::</span>
                <textarea name="mensagem" class="validate[required] text-input" id="mensagem"></textarea>           
            </label>
            
            <br clear="all" />
            <input type="submit" value="" class="enviar-senha convide"/>
        
        </form>
        
    </div>
    

</div>