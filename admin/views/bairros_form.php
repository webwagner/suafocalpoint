<script>
 $(document).ready(function(){
     $("#formulario").validate({
        rules:{
            id_cidade:{
                required: true
            },
            bairro:{
                required: true
            }
        },
        messages:{
            id_cidade:{
                required: "Campo obrigatório"
            },
            bairro:{
                required: "Campo obrigatório"
            }
        }
    });
});
</script>
<div class="tit">
    <img src="static/images/ico-usuarios.jpg" width="40" height="40" alt="bairros" title="bairros" />
    <span>bairros</span>
</div>
<div class="form-c">
    <form action="?pg=bairros&act=salvar" method="post" id="formulario" enctype="multipart/form-data">       
        <?php echo (isset($row->id)) ? "<input type='hidden' name='id' value='".$row->id."' />" : ""; ?> 
        <label>
            <span class="span-c">Cidade</span>
            <select name="id_cidade">
                <?php echo (isset($row_cidade->cidade)) ? "<option value='".$row_cidade->id."'>".$row_cidade->cidade."</option>" : "<option value=''>Selecione</option>"; ?> 
                <?php foreach($rows as $cidade) :?>
                <option value="<?php echo $cidade->id;?>"><?php echo $cidade->cidade;?></option>
                <?php endforeach;?>
            </select>
        </label> 
        <label>
            <span class="span-c">Bairro</span>
            <input type="text" name="bairro" value="<?php echo (isset($row->bairro)) ? $row->bairro : ""; ?>" />
        </label> 
        <input type="submit" class="add" id="bt-salvar-form" value="Salvar" />
    </form>
</div>