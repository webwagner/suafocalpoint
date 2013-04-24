<link rel="stylesheet" href="css/interna.css" type="text/css" />
<div class="center">

    <div class="desc">
        <a href="?page=home"><img src="img/logo.jpg" /></a>
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
            
            	<select>
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
    
        <form action="?page=convide-seu-corretor-enviado" method="post">
        
            <label class="cadastro">
            	<span>*Nome:</span>
                <input type="text" name="nome" />           
            </label>
            
            <label class="cadastro">
            	<span>*E-mail:</span>
                <input type="text" name="nome" />           
            </label>
        
            <label class="textarea">
            	<span>* Mensagem::</span>
                <textarea name="mensagem"></textarea>           
            </label>
            
            <br clear="all" />
            <input type="submit" value="" class="enviar-senha convide"/>
        
        </form>
        
    </div>
    

</div>