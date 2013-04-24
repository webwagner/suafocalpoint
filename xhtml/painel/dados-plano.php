<div id="nav">

    <?php include 'nav-dados.php';?>
    
</div>

<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Alterar Plano</span>
        </div>
        
        <form action="?page=dados-contato" method="post" id="formulario">
        
            
          <div class="planos">
            	
                <span class="plano-escolhido">Plano Contratado: <strong>Mensal</strong></span>
	
                <br clear="all" />        
    
                <div class="plano plano-h" id="plano1">
                	<div class="plano-title">GR&Aacute;TIS</div>
                    <span>R$ 00,00 <br />(10 dias gratuitos)</span>
                    <label><input type="radio" name="plano" value="1" checked="checked" /></label>
                </div>
    
                <div class="plano" id="plano2">
                	<div class="plano-title">MENSAL</div>
                    <span>R$ 50,00<br /><br /></span>
                    <label><input type="radio" name="plano" value="2" /></label>
                </div>
    
                <div class="plano" id="plano3">
                	<div class="plano-title">SEMESTRAL</div>
                    <span>R$ 275,00<br />(15 dias gratuitos)</span>
                    <label><input type="radio" name="plano" value="3" /></label>        
                </div>
    
                <div class="plano" id="plano4">
                	<div class="plano-title">ANUAL</div>
                    <span>R$ 550,00<br />(30 dias gratuitos)</span>
                    <label><input type="radio" name="plano" value="4" /></label>        
                </div>
                
                
            </div>
            
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
    
    </div>

</div>
