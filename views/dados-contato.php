<script type="text/javascript" src="<?php echo URL;?>static/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/maskedinput-1.1.4.js"></script>	
<script>
$(document).ready(function() {
    	
    $("#formulario").validate(); 
    $("#telefone").mask("9999-9999");
    $("#celular").mask("9999-9999");
    $("#telefone2").mask("9999-9999");
    $("#celular2").mask("9999-9999");
    $("#ddd").mask("(99)");
    $("#ddd_celular").mask("(99)"); 
    $("#ddd2").mask("(99)");
    $("#ddd_celular2").mask("(99)"); 
    
//    $('#estado').change(function(){       
//        var uf = $(this).val();
//        
//        if(uf != "")
//            $('#cidade').addClass("required");
//        else
//            $('#cidade').removeClass("required");
//             
//        $.ajax({
//            type: "GET",
//            url: "estados.php",
//            data: "acao=buscaCidade&uf="+uf,
//            dataType: "xml",
//            success: function (xml) {
//                var html = '<option value="">Selecione</option>';
//                $(xml).find('cidades').each(function () {
//                    $(xml).find('cidade').each(function () {
//                        var cidade = $(this).find('nome').text();
//                        var id_cidade = $(this).find('id').text();
//                        html += "<option value='"+id_cidade+"'>"+cidade+"</option>";
//                    });
//                });
//                $('#cidade').html(html);
//            },
//            error: function () {
//                alert("Ocorreu um erro inesperado durante o processamento.");
//            }
//        });
//
//    })
    
})
</script>

<div id="content">
	
    <div class="page">
	
        <div class="breadcumbs">
            <span>Editar Perfil > Dados de Contato</span>
        </div>
        
        <?php echo $msg;?>
        
  <form action="" method="post" id="formulario">
            
        <input name="id" type="hidden" value="<?php echo $dados->id;?>" />
      
        <label class="cadastro-all">
            <span>Empresa:</span>
            <input type="text" name="empresa" value="<?php echo ($dados->empresa != "" ? $dados->empresa : "");?>" class="text-input" id="endereco"/>           
        </label>
        
        <label class="cadastro-all">
            <span>Website:</span>
            <input type="text" name="website" value="<?php echo ($dados->website != "" ? $dados->website : "");?>" class="text-input" />           
        </label>

        <label class="cadastro-all">
            <span>Endere&ccedil;o: <font size="1">(Esta informação estará disponível publicamente)</font></span>
            <input type="text" name="rua" value="<?php echo ($dados->rua != "" ? $dados->rua : "");?>" class="text-input" id="endereco"/>           
        </label>
            <br clear="all" />
        <label class="cadastro-small">
            <span>N&uacute;mero:</span>
            <input type="text" name="numero" value="<?php echo ($dados->numero != "" ? $dados->numero : "");?>" class="text-input" id="numero"/>           
        </label>

        <label class="cadastro-m" style="width:250px;">
            <span>Complemento:</span>
            <input type="text" name="complemento" value="<?php echo ($dados->complemento != "" ? $dados->complemento : "");?>" />           
        </label>

        <label class="cadastro-m">
            <span>Bairro:</span>
            <input type="text" name="bairro" class="text-input" value="<?php echo ($dados->bairro != "" ? $dados->bairro : "");?>" id="bairro"/>           
        </label>
        <br clear="all" />
<!--        <label class="cadastro-small" style="margin-right:10px;">
            <span>Estado:</span>
            <select name="uf" id="estado">
                <option value="">Selecione</option>
                <?php //foreach($estados as $est) :?>
                <option value="<?php //echo $est->id;?>"><?php //echo $est->uf;?></option>
                <?php //endforeach ;?>
            </select>
        </label>
        <span style="float: left; color:red; margin: 25px 20px 0 0;"><?php //echo $dados->uf;?></span>

        <label class="cadastro-m" style="margin:0; width:250px;">
            <span>Cidade:</span>
            <select name="cidade" class="text-input" id="cidade">
                <option value="">Selecione</option>
            </select>
        </label><span style="float: left; color:red; margin: 25px 0 0 10px;"><?php //echo $dados->cidade;?></span>
        <br clear="all" />-->
        
        <div style="margin-bottom: 10px; width: 100%; float: left;">
            <label class="cadastro-ddd">
                <span>*Telefone:</span>
                <input type="text" name="ddd" class="text-input required" id="ddd" value="<?php echo $ddd;?>" />           
            </label>

            <label class="cadastro-m-ddd">
                <span>&nbsp;</span>
                <input type="text" name="telefone" class="text-input required" id="telefone" value="<?php echo $tel;?>" />           
            </label>

            <label class="cadastro-ddd">
                <span>celular:</span>
                <input type="text" name="ddd_celular" value="<?php echo $ddd_celular;?>" class="text-input" id="ddd_celular" />           
            </label>

            <label class="cadastro-m-ddd" style="margin-right:0">
                <span>&nbsp;</span>
                <input type="text" name="celular" value="<?php echo $celular;?>" class="text-input" id="celular"/>           
            </label>
        </div>
        <div>
            <label class="cadastro-ddd">
                <span>Telefone:</span>
                <input type="text" name="ddd2" class="text-input" id="ddd2" value="<?php echo $ddd2;?>" />           
            </label>

            <label class="cadastro-m-ddd">
                <span>&nbsp;</span>
                <input type="text" name="telefone2" class="text-input" id="telefone2" value="<?php echo $tel2;?>" />           
            </label>

            <label class="cadastro-ddd">
                <span>celular:</span>
                <input type="text" name="ddd_celular2" value="<?php echo $ddd_celular2;?>" class="text-input" id="ddd_celular2" />           
            </label>

            <label class="cadastro-m-ddd" style="margin-right:0">
                <span>&nbsp;</span>
                <input type="text" name="celular2" value="<?php echo $celular2;?>" class="text-input" id="celular2"/>           
            </label>
        </div>

        <input type="submit" value="" class="enviar-senha salvar"/>

    </form>
    
    </div>

</div>
