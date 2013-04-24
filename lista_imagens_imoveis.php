<?php include('inc/init.inc.php');?>

<script>  
$(document).ready(function(){
    $('.album').each(function(x){
        $(this).change(function(){
            var valor = $(this).find('option').filter(':selected').text();
            $('.legendas').each(function(y){
                if(x == y){
                    if(valor != 'Selecione o Álbum'){
                        $(this).val(valor);
                        if(valor != "Outros" && valor != "Fotos"){
                            $(this).attr("readonly", true);
                            $(this).css("background-color", "#dbdcdd");
                        }
                        else{
                            $(this).attr("readonly", false);
                            $(this).css("background-color", "#ffffff");
                        }
                    }
                }
            })
        })
    })

})
</script>

<div class="header-fotos">
    <p>FOTOS</p>
    <p class="escolha">DESCRIÇÃO</p>
    <p class="legenda">LEGENDA</p>
    <p class="principal">PRINCIPAL</p>
</div>

<?php
$id_imovel = $_GET['id_imovel'];
$login = $_GET['login'];
$titulo = $_GET['titulo'];

/**
* Lista as fotos do album
*/
$mapper = new Mapper();
$mapper->setDbTable(new ImovelAlbum());
$mapper->setWhere('imovel_id = "'.$id_imovel.'"');
$rows = $mapper->getRows();

/**
* Lista as categorias de albuns
*/
$mapper = new Mapper();
$mapper->setDbTable(new Album());
$mapper->setOrder('id ASC');
$rows_albuns = $mapper->getRows();

foreach($rows as $row) :
    
    /**
    * Verifica se está editando
    */
    if($row->album_id != ''){
        $mapper->setWhere('id = '.$row->album_id);
        $alb = $mapper->getRow();
    }
    
    if($row->padrao == "sim")
        $padrao = "checked='checked'";
    else
        $padrao = "";
?>

<div class="albuns">
    
    <?php if($row->album_id != "") :?>
    <form class="form-eraser-foto" action="" method="post">
        <input type="hidden" name="id_album_del" value="<?php echo $row->id;?>" />
        <input type="hidden" name="titulo_imovel" value="<?php echo $titulo;?>" />
        <input type="image" src="static/img/bt-excluir-foto.png" value="Excluir" />
    </form>
    <?php endif;?>
    
    <label class="select cadastro-small cf">
        <span><img style="height: 60px; width: 80px; overflow: hidden; margin-top: -20px;" src="library/phpthumb/phpThumb.php?src=<?php echo URL_ABSOLUTE;?>static/uploads/imoveis/<?php echo $login;?>/<?php echo $titulo;?>/<?php echo $row->foto;?>&w=100" /></span>
    </label>

    <label class="imovel imovel-c end cf-select">
        <input type="hidden" name="id_foto[]" value="<?php echo $row->id;?>" />
        <select name="album[]" class="album select_gray" id="album<?php echo $row->id;?>">
            <option value=''>Selecione o Álbum</option>
            <?php 
            foreach($rows_albuns as $row_albuns) :
                
                $s = "";
                
                if(isset($row->album_id))
                    if($row->album_id == $row_albuns->id)
                        $s = "selected='selected'";
            ?>
            <option <?php echo $s;?> value="<?php echo $row_albuns->id;?>"><?php echo $row_albuns->nome;?></option>
            <?php endforeach;?>
        </select>
    </label>

    <label class="imovel imovel-c cf-end">
        <input type="text" name="legenda[]" <?php echo ($row->legenda == "Sala de Jantar" || $row->legenda == "Sala de Estar" || $row->legenda == "Cozinha" || $row->legenda == "Quarto" || $row->legenda == "Banheiro" || $row->legenda == "Exterior") ? "readonly='true' style='background-color:#dbdcdd;'" : "";?> <?php echo ($row->legenda != "") ? "value = '".$row->legenda."'" : "";?> class="validate[required] legendas" />           
    </label>
    
    <label style="height: auto; float: left; width: 20px; margin: 0px; padding: 0px;">
        <input <?php echo $padrao;?> class="padrao" style="margin-left: 10px; width: 10px;" value="<?php echo $row->id;?>" type="radio" name="padrao[]" />
    </label>
</div>
<?php endforeach;?>


