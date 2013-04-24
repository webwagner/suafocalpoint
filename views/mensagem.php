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
                <span><strong><?php echo $corretor->nome;?></strong><br /><?php echo $mensagem->data;?></span>
                <a class="voltar-msg" href="javascript:history.back()"> < Voltar para Mensagens</a>
            </div>
            
            <div class="msg">
            
            	<div class="mn">
                    <p>Assunto:</p>
                    <p>Mensagem:</p>
                </div>
                
                <div class="texto">
                
                    <p><strong><?php echo $mensagem->assunto;?></strong></p>
    
                    <?php echo $mensagem->texto;?>
                    
                    <form action="<?php echo $_SESSION['login'];?>/mensagem-responder" method="post">
                        <p><strong>RESPONDER:</strong></p>
                        <textarea name="texto"></textarea>
                        <input type="hidden" name="assunto" value="<?php echo $mensagem->assunto;?>" />
                        <input type="hidden" name="solicitacao" value="<?php echo $mensagem->solicitacao;?>" />
                        <input type="hidden" name="corretor_recebe" value="<?php echo $id_recebe;?>" />
                        <input type="hidden" name="corretor_envia" value="<?php echo $_SESSION['usuario_logado']->id;?>" />
                        <input type="submit" value="Responder" />
                    </form>

                </div>
                
            
            </div>
        
        </div>
                    
            
    </div>
            
    
    
</div>