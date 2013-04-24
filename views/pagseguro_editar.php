<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Alterar Plano</span>
        </div>
   
        <p style="text-transform:uppercase; margin-top: 20px; float: left;"><strong>Você será redirecionado para o pagseguro em <span id="count"></span> segundos.</strong></p>

        <form id="formulario_pagseguro" name="pagseguro" method="post" action="https://pagseguro.uol.com.br/checkout/checkout.jhtml">
            <input type="hidden" name="encoding" value="UTF-8">
            <input type="hidden" name="email_cobranca" value="norma@focalpointbrasil.com">
            <input type="hidden" name="tipo" value="CP">
            <input type="hidden" name="moeda" value="BRL">
            <input type="hidden" name="item_id_1" value="<?php echo $id_pag;?>">
            <input type="hidden" name="item_descr_1" value="<?php echo $titulo;?> - Sua Focal Point">
            <input type="hidden" name="item_quant_1" value="1">
            <input type="hidden" name="item_valor_1" value="<?php echo $preco;?>">
            <input type="hidden" name="item_frete_1" value="0">
            <input type="hidden" name="item_peso_1" value="0">
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
            document.forms['pagseguro'].submit();
        }
    }
    redireciona();

</script>