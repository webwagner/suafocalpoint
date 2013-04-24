<script>
 $(document).ready(function(){
     $("#formulario").validate({
        rules:{
            uf:{
                required: true
            }
        },
        messages:{
            uf:{
                required: "Campo obrigatório"
            }
        }
    });
});
</script>
<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="Estados" title="Estados" />
    <span>Estados</span>
</div>
<div class="form-c">
    <form action="?pg=estados&act=salvar" method="post" id="formulario" enctype="multipart/form-data">       
        <?php echo (isset($row->id)) ? "<input type='hidden' name='id' value='".$row->id."' />" : ""; ?> 
        <label>
            <span class="span-c">UF</span>
            <input style="text-transform: uppercase;" type="text" maxlength="2" name="uf" value="<?php echo (isset($row->uf)) ? $row->uf : ""; ?>" />
        </label> 
        <input type="submit" class="add" id="bt-salvar-form" value="Salvar" />
    </form>
</div>