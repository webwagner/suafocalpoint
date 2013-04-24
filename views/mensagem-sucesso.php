<div id="content">
    
    <div class="page page-contatos">
	
        <div class="breadcumbs">
        
            <span>Mensagens (<?php echo $total_geral;?>)</span>
            
            <div class="notificacoes">
            
                <span class="exibir">Exibir:</span>
                <span class="mensagens"><a href="<?php echo $_SESSION['login'];?>/mensagens/recebidas">Mensagens</a> <font>(<?php echo $recebidas;?>)</font></span>
                <span class="solicitacoes"><a href="<?php echo $_SESSION['login'];?>/mensagens/solicitacoes">Solicita&ccedil;&otilde;es de Visitas</a> <font>(<?php echo $solicitacoes;?>)</font></span>
                <span class="enviadas"><a href="<?php echo $_SESSION['login'];?>/mensagens/enviadas">Enviadas</a> <font>(<?php echo $enviadas;?>)</font></span>
            
            </div>
            
        </div>
        
        <div class="minha-msg">
       
            <p>Mensagem enviada com sucesso.</p>
        
        </div>
                    
            
    </div>
            
    
    
</div>