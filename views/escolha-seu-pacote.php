<div class="center">

    <div class="desc">
        <a href="home"><img src="static/img/logo.jpg" /></a>
    </div>
    
    <div class="bread bread-none">
    	&nbsp;
    </div>
    
    <div class="box-left">
    
    	<p class="blue">Faça seu cadastro em 4 passos simples <br />e comece a participar da nossa rede.</p>
        
        <ul class="cad-corretor">
        
            <li><a href="home/inscreva-se/dados-cadastro">Preencha o Formulário</a></li>

            <li><a href="home/inscreva-se/termo-de-uso">Termos de Uso</a></li>

            <li class="hover"><a href="home/inscreva-se/escolha-seu-pacote">Escolha seu Pacote</a></li>
            
            <li>Escolha seu plano</li>

            <li>Pronto</li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos negócios através da nossa rede.</p>

    </div>
    
    <div class="box-right">
    
        <form action="home/inscreva-se/escolha-seu-plano" method="post" id="formulario">
                        
            <div class="planos">
            	
                <span>Pacotes</span>
	
                <br clear="all" />  
                <input type="hidden" value="1" name="pacote" />
                
                <?php 
                foreach($pacotes as $row) :?>
                
                <div class="pacote">
                    <input type="radio" name="pacote_id" value="<?php echo $row->id;?>" />
                    <div class="box-pacote">
                        <h3><?php echo $row->titulo;?></h3>
                        <h4><?php echo $row->descricao;?></h4>
                        <p><span>R$ <strong><?php echo $row->valor;?></strong></span></p>
                    </div>
                </div>
                
                <?php endforeach;?>
                
            </div>
            
            <p class="confirm" style="text-align:left">Caso deseje algum pacote escolha e clique em 'Avançar' ou somente clique em 'Avançar'</p>
            
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
        
    </div>
    

</div>