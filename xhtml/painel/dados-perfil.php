<div id="nav">

    <?php include 'nav-dados.php';?>
    
</div>

<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Dados Gerais</span>
        </div>
        
        <form action="?page=dados-contato" method="post" id="formulario">
        
            <label class="cadastro">
            	<span>*Nome:</span>
                <input type="text" name="nome"class="validate[required] text-input" id="nome" />           
            </label>
        
            <label class="cadastro-m">
            	<span>N&deg;CRECI:</span>
                <input type="text" name="creci" />           
            </label>
        
            <label class="cadastro">
            	<span>E-mail:</span>
                <input type="text" name="email" />           
            </label>
        
           	 <label class="cadastro-m">
            	<span>*Senha:</span>
                <input type="text" name="senha" class="validate[required] text-input" id="senha"/>           
            </label>
        
            <label class="cadastro">
            	<span>Nascimento:</span>
                <input type="text" name="nascimento" />           
            </label>

            <label class="l-radio">
            	<span>Sexo</span>
            </label>
            
            <div class="radio">
                <label>
                    <input type="radio" name="autonomo" value="1" />           
                    <span>Masculino</span>
                </label>
            </div>
            
            <div class="radio">
                <label>
                    <input type="radio" name="autonomo" value="2" /> 
                    <span>Feminino</span>
                </label>
            </div>

            <br clear="all" />
            
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
    
    </div>

</div>
