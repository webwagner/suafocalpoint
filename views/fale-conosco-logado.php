<script type="text/javascript" src="<?php echo URL;?>static/js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#formulario2").validate();
})
</script>

<div id="content">
    <div class="page">   
        <div class="breadcumbs"> 
            <span>Fale conosco</span>
        </div>
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
        
            <label style="padding-left: 0;" class="textarea">
            	<span>* Mensagem::</span><br />
                <textarea name="mensagem" class="required" id="mensagem" style="height:150px; width:400px"></textarea>           
            </label>
            
            <br clear="all" />
            <input type="submit" value="" class="enviar-senha convide" style="margin-right:195px;"/>
        
        </form>
    </div>
</div>
