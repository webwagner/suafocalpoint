<script>
 $(document).ready(function(){
     $("#formulario").validate({
        rules:{
            titulo:{
                required: true
            }
        },
        messages:{
            titulo:{
                required: "Campo obrigatório"
            }
        }
    });
});
</script>
<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="Como conheceu a rede" title="Como conheceu a rede" />
    <span>Como conheceu a rede</span>
</div>
<div class="form-c">
    <form action="?pg=como-conheceu-a-rede&act=salvar" method="post" id="formulario" enctype="multipart/form-data">       
        <?php echo (isset($row->id)) ? "<input type='hidden' name='id' value='".$row->id."' />" : ""; ?> 
        <label>
            <span class="span-c">Título</span>
            <input type="text" name="titulo" value="<?php echo (isset($row->titulo)) ? $row->titulo : ""; ?>" />
        </label> 
        <input type="submit" class="add" id="bt-salvar-form" value="Salvar" />
    </form>
</div>