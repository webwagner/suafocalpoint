<script type="text/javascript">
$(document).ready(function(){
    $("#formulario2").validate();
    $("#formulario").validate();
})
</script>

<div class="center">

    <div class="desc">
        <a href="home" class="logo"><img src="static/img/logo.png" /></a>
    </div>
    
    <div class="bread">
    	<a href="home">Home > </a><span>Fale conosco</span>
    </div>
        
    <div class="box-right" style="padding: 0; width: 100%;">
        
        <?php echo $msg;?>
        
        <form style="width: 600px;" action="" class="form-home" method="post" id="formulario2">
        
            <label>
            	<span>* Seu Nome:</span>
                <input type="text" name="nome" class="required" id="nome" />           
            </label>
        
        	<br clear="all" />
        
            <label>
            	<span>* Seu Email:</span>
                <input type="text" name="email" class="required email" id="email" />           
            </label>
        
            <label class="textarea">
            	<span>* Mensagem::</span><br />
                <textarea name="mensagem" class="required" id="mensagem" style="height:150px; width:400px"></textarea>           
            </label>
            
            <br clear="all" />
            <input type="submit" value="" class="enviar-senha convide" style="margin-right:195px;"/>
        
        </form>
        
    </div>
    

</div>