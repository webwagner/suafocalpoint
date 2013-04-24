<script type="text/javascript">
$(document).ready(function() {
    $("#formulario").validate();
})
</script>

<div class="center">

    <div class="desc">
        <a href="home" class="logo"><img src="static/img/logo.png" /></a>
    </div>

    <div class="bread">
    	<a href="home">Home > </a><span>Convide seu corretor</span>
    </div>

    <div class="box-right" style="padding: 0;">

    	<div class="corretores">

            <h2>Corretores da Nossa Rede que Atuam no Bairro <strong><?php echo $nome_bairro->bairro;?></strong></h2>

            <div id='box-voltar'><a id='voltar' href="<?php echo URL;?>home/conheca-corretores">voltar</a></div>
            <?php echo $lista_corretor;?>

        </div>

    </div>


</div>