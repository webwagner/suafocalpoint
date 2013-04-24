<div class="center">
    <div class="desc">
        <a href="home" class="logo"><img src="static/img/logo.png" /></a>
    </div>
    <div class="bread">
        <a href="home">Home > </a><span>Renovar Plano</span>
    </div>

    <div class="box-left" style="width: 100%; background: none;">
        <?php echo $msg;?>
        
        <?php if(isset($html_plano)) :?>
        <form action="" method="post" id="formulario">
            <input name="id" type="hidden" value="<?php echo $row->id; ?>" />
            <input name="desconto" type="hidden" value="<?php echo $desc; ?>" />
            
            <div class="planos" style="float: left;">
                <span class="plano-escolhido">Plano Contratado: <strong><?php echo $plano_contratado; ?></strong></span>
                <br clear="all" />        
                <?php echo $html_plano; ?>
            </div>

            <input type="submit" value="" class="enviar-senha renovar"/>
        </form>
        <?php endif;?>
    </div>
</div>