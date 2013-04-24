<script>
 $(document).ready(function(){
     $("#formulario").validate({
        rules:{
            id_uf:{
                required: true
            },
            cidade:{
                required: true
            }
        },
        messages:{
            id_uf:{
                required: "Campo obrigatório"
            },
            cidade:{
                required: "Campo obrigatório"
            }
        }
    });
});
</script>
<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="Cidades" title="Cidades" />
    <span>Cidades</span>
</div>
<div class="form-c">
    <form action="?pg=cidades&act=salvar" method="post" id="formulario" enctype="multipart/form-data">       
        <?php echo (isset($row->id)) ? "<input type='hidden' name='id' value='".$row->id."' />" : ""; ?> 
        <label>
            <span class="span-c">UF</span>
            <select name="id_uf">
                <?php echo (isset($row_uf->uf)) ? "<option value='".$row_uf->id."'>".$row_uf->uf."</option>" : "<option value=''>Selecione</option>"; ?> 
                <?php foreach($rows as $uf) :?>
                <option value="<?php echo $uf->id;?>"><?php echo $uf->uf;?></option>
                <?php endforeach;?>
            </select>
        </label> 
        <label>
            <span class="span-c">Cidade</span>
            <input type="text" name="cidade" value="<?php echo (isset($row->cidade)) ? $row->cidade : ""; ?>" />
        </label> 
        <input type="submit" class="add" id="bt-salvar-form" value="Salvar" />
    </form>
</div>