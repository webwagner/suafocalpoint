<script>
$(document).ready(function() {
    $("#formulario").validate();
    
    $("#formulario").submit(function(){
       var valor = $("input:radio[name='plano_id']:checked").val();
       
       if(valor == 1){
           $(this).attr("action","home/inscreva-se/cadastro-realizado");
       }
       else{
           $(this).attr("action","home/inscreva-se/pagseguro")
       }
    })
})
</script>

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

            <li><a href="home/inscreva-se/escolha-seu-pacote">Escolha seu Pacote</a></li>
            
            <li class="hover">Escolha seu Plano</li>

            <li>Pronto</li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos negócios através da nossa rede.</p>

    </div>
    
    <div class="box-right">
    
        <form action="" method="post" id="formulario">
                        
            <div class="planos">
            	
                <span>Planos</span>
	
                <br clear="all" />        
                
                <?php 
                $x = 0;    
                foreach($planos as $row) :
                    $x++;
                    if($x == 1){
                        $class   = 'class="required"';
                        $checked = 'checked="checked"';
                    } else {
                        $class   = '';
                        $checked = '';
                    }
                ?>
                
                <div class="plano">
                    <div class="plano-title"><?php echo $row->nome;?></div>
                    <span>R$ <?php echo $row->valor;?></span>
                    <input <?php echo $class.$checked;?> type="radio" name="plano_id" value="<?php echo $row->id;?>" />
                </div>
                
                <?php endforeach;?>
                
            </div>
            
            <p class="confirm" style="text-align:left">Selecione a opção desejada e clique em 'Avançar'</p>
            
            <input type="submit" value="" class="enviar-senha avancar"/>
        
        </form>
        
    </div>
    

</div>