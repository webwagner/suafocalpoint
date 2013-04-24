<script type="text/javascript">
    $(document).ready(function() {
        
        $("#formulario").validate();
        
        $("#estado").change(function(){
            var uf = $(this).val();
            
            if(uf != "")
                location.href = "<?php echo URL; ?>home/conheca-corretores/"+uf;
            else
                location.href = "<?php echo URL; ?>home/conheca-corretores";
        })
        
        $("#cidade").change(function(){
            var cidade = $(this).val();
            var uf = $("#estado").val();
            
            if(cidade != "")
                location.href = "<?php echo URL; ?>home/conheca-corretores/"+uf+"/"+cidade;
            else
                location.href = "<?php echo URL; ?>home/conheca-corretores/"+uf;
        })
        
    })
</script>

<div class="center">

    <div class="desc">
        <a href="home" class="logo"><img src="static/img/logo.png" /></a>
    </div>
    
    <div class="bread">
    	<a href="home">Home > </a><span>Conheça Corretores</span>
    </div>
    
    <div class="box-left" style="width: 100%; background: none;">
    
    	<p>Compradores, Vendedores, Locadores e Locatários você pode visualizar os corretores cadastrados em nossa rede.<br>Selecione um estado, uma cidade e um bairro abaixo que então será exibida uma listagem com os corretores cadastrados que atuam no bairro selecionado:</p>
        
        <form action="home/busca-corretor" method="post" id="formulario">
        
            <label style="float: left; width: 215px; margin-right: 5px;">
                <span style="display: block; margin-bottom: 3px;">Estado:</span>
            	<?php echo $select_estado;?>
            </label>
            
            <label style="float: left; width: 215px; margin-right: 5px;">
                <span style="display: block; margin-bottom: 3px;">Cidade:</span>
                <?php echo $select_cidade;?>
            </label>
            
            <label style="float: left; width: 215px;">
                <span style="display: block; margin-bottom: 3px;">Bairro:</span>
                <?php echo $select_bairro;?>
            </label>
            
            <input style="margin-top: 18px;" type="submit" value="" />
        
        </form>

    </div>

</div>