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
        
        	<div class="perfil">
            	<?php echo $img;?>
                <span><strong><?php echo $corretor->nome;?></strong></span>
            </div>
            
            <div class="msg">

                <div class="texto">
                    
                    <form action="<?php echo $_SESSION['login'];?>/mensagem-enviar" method="post">
                        <input type="hidden" name="id_enviou" value="<?php echo $_SESSION['usuario_logado']->id;?>" />
                        <input type="hidden" name="id_recebeu" value="<?php echo $corretor->id;?>" />
                        <input type="hidden" name="solicitacao" value="<?php echo $solicitacao;?>" />
                        <p><strong>ASSUNTO:</strong></p>
                        <input class="input-assunto" type="text" value="<?php echo (isset($assunto) ? $assunto : '');?>" name="assunto"> 
                        <p><strong>MENSAGEM:</strong></p>
                        <textarea name="texto"><?php echo (isset($mensagem) ? $mensagem : '');?></textarea>
                        <input type="submit" value="Enviar" />
                    </form>

                </div>
                
            
            </div>
        
        </div>
                    
            
    </div>
            
    
    
</div>