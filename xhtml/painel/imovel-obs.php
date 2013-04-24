<div id="nav" style="width:270px;">

    <?php include 'nav-imovel.php';?>
    
</div>

<div id="content" style="width:670px;">
	
    <div class="page page-imovel">
	
        <div class="breadcumbs">
        
            <span>Cadastre seu im&oacute;vel</span>
            
        </div>
        
        <form action="?page=dados-contato" method="post" id="formulario">
        
            <label class="imovel">
            	<span>CEP:</span>
                <input type="text" name="nome"class="validate[required] text-input" id="nome" />           
            </label>
        
            <label class="imovel">
            	<span>Endere&ccedil;o do Im&oacute;vel:</span>
                <input type="text" name="creci" />           
            </label>
        
            <label class="imovel">
            	<span>Telefone do Propriet&aacute;rio:</span>
                <input type="text" name="nome"class="validate[required] text-input" id="nome" />           
            </label>
        
            <label class="imovel">
            	<span>Email do Propriet&aacute;rio:</span>
                <input type="text" name="creci" />           
            </label>
        
            <label class="imovel">
            	<span>Endere&ccedil;o do Propriet&aacute;rio:</span>
                <input type="text" name="nome"class="validate[required] text-input" id="nome" />           
            </label>
        
            <label class="imovel">
            	<span>Bairro:</span>
                <input type="text" name="creci" />           
            </label>
        
            <label class="imovel">
            	<span>Cidade:</span>
                <input type="text" name="nome"class="validate[required] text-input" id="nome" />           
            </label>
        
            <label class="imovel">
            	<span>CEP:</span>
                <input type="text" name="creci" />           
            </label>
        
            <label class="textarea">
            	<span>Observa&ccedil;&otilde;es::</span><br />
                <textarea name="mensagem" class="validate[required] text-input" id="mensagem" style="height:150px; width:550px"></textarea>           
            </label>

            <input type="submit" value="" class="enviar-senha"/>
        
        </form>
    
    </div>

</div>
