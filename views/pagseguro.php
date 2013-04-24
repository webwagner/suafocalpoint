
<div class="center">

    <div class="desc">
        <a href="home"><img src="static/img/logo.jpg" /></a>
    </div>
    
    <div class="bread">
    	<a href="home">Home > </a><span>Cadastro</span>
    </div>
    
    <div class="box-left">
    
    	<p class="blue">Faça seu cadastro em 4 passos simples <br />e comece a participar da nossa rede.</p>
        
        <ul class="cad-corretor">
        
            <li>Preencha o Formulário</li>

            <li>Termos de Uso</li>

            <li>Escolha seu Pacote</li>
            
            <li>Escolha seu Plano</li>

            <li class="hover">Pronto</li>
        
        </ul>
    
        <p>Procure preencher todos os campos para deixar seu perfil completo e ampliar suas possibilidades de gerar novos negócios através da nossa rede.</p>

    </div>
    
    <div class="box-right">
    
        <p align="center" style="text-transform:uppercase"><strong>Você será redirecionado para o pagseguro em <span id="count"></span> segundos.</strong></p>
        
        <form id="formulario_pagseguro" name="pagseguro" method="post" action="https://pagseguro.uol.com.br/checkout/checkout.jhtml">
            <input type="hidden" name="encoding" value="UTF-8">
            <input type="hidden" name="email_cobranca" value="norma@focalpointbrasil.com">
            <input type="hidden" name="tipo" value="CP">
            <input type="hidden" name="moeda" value="BRL">
            
            <input type="hidden" name="item_id_1" value="<?php echo $id_pag;?>">
            <input type="hidden" name="item_descr_1" value="Plano <?php echo $plano->nome;?> - Sua Focal Point">
            <input type="hidden" name="item_quant_1" value="1">
            <input type="hidden" name="item_valor_1" value="<?php echo $plano->valor;?>">
            <input type="hidden" name="item_frete_1" value="0">
            <input type="hidden" name="item_peso_1" value="0">
            
            <?php if(isset($pacote)) :?>
            <input type="hidden" name="item_id_2" value="<?php echo $id_pag2;?>">
            <input type="hidden" name="item_descr_2" value="<?php echo $pacote->titulo;?> - Sua Focal Point">
            <input type="hidden" name="item_quant_2" value="1">
            <input type="hidden" name="item_valor_2" value="<?php echo $pacote->valor;?>">
            <input type="hidden" name="item_frete_2" value="0">
            <input type="hidden" name="item_peso_2" value="0">
            <?php endif;?>
            
            <input type="hidden" name="tipo_frete" value="EN">
        </form>
    </div>
    

</div>

<script>
    var contador = 3;

    function redireciona() {
        document.getElementById("count").innerHTML = contador--;
        if (contador > 0) { 
            setTimeout(redireciona, 1000); 
        }
        else { 
            //document.forms[0].submit(); 
            document.forms['pagseguro'].submit();
        }
    }
    redireciona();

</script>