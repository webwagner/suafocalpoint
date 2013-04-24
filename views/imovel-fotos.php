<link rel="stylesheet" href="<?php echo URL;?>static/css/uploadify.css" type="text/css" />
<script type="text/javascript" src="<?php echo URL;?>static/js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/jquery.uploadify.v2.1.4.min.js"></script>
<script>
$(document).ready(function() {
    
    $("#deletar-imovel").click( function() {
        var imovel = $(this).attr('rel');
        var url_imovel = $(this).attr('class');
        var id_corretor = $(this).attr('corretor');

        jConfirm('<span style="color: red; align: center; font-weight: bold;">Tem certeza que deseja deletar o imóvel '+imovel+'?<br>Após deletado este imóvel não poderá ser recuperado.</span>', 'Deletar Imóvel', function(r) {
        if(r){
            $.getJSON('del_imovel.php',{imovel : url_imovel, corretor : id_corretor} ,function(txt){
                if(txt.valor == 'YES'){
                    jAlert("Imóvel "+imovel+" deletado com sucesso!", 'Deletar Imóvel');
                    window.location.href = '<?php echo URL.$_SESSION['login'];?>';
                }
            })           
        }
        });
    });
    
    $("#submit-form").click(function(){
        
        var i = 0;
        var j = 0;
        
        $('.legendas').each(function(){
            if($(this).val() == "")
                i++;
        })
        
        $('.album').each(function(){
            if($(this).val() == "")
                i++;
        })
        
        if( $('.padrao').length )
            if(!$(".padrao").is(":checked"))
                j++;
        
        if(i == 0 && j == 0){
            $('.mensagem_foto').hide();
            $('#formulario_f').submit();
        }
        else if(j > 0){
            $('.mensagem_padrao').show();
        }
        else{
            $('.mensagem_foto').show();
            $('.mensagem_padrao').hide();
        }
        
    })
    
    <?php if(isset($dados_imovel->id)) :?>
    $.ajax({
        type: "GET",
        url: "lista_imagens_imoveis.php",
        data: "id_imovel=<?php echo $id;?>&login=<?php echo $_SESSION['login'];?>&titulo=<?php echo $titulo_imovel;?>",
        success: function (html) {
            $('#box_imagens').html(html);
        },
        error: function () {
            alert("Ocorreu um erro inesperado durante o processamento.");
        }
    });
    <?php endif;?>
      
    $('#file_upload').uploadify({
        'uploader'  : '<?php echo URL;?>static/swf/uploadify.swf',
        'script'    : '<?php echo URL;?>upload_imagens_imoveis.php',
        'cancelImg' : '<?php echo URL;?>static/img/cancel.png',
        'buttonImg' : '<?php echo URL;?>static/img/bt-escolha-suas-fotos.gif',
        'width'     : 186,
        'height'    : 31,
        'auto'      : true,
        'multi'     : true,
        //'queueSizeLimit' : 10,
        'expressInstall' : '<?php echo URL;?>static/swf/expressInstall.swf',
        'fileExt'     : '*.jpg;*.gif;*.png',
        'fileDesc'    : 'Arquivos de Imagens (.JPG, .GIF, .PNG)',
        'method'      : 'post',
        'scriptData'  : {'id_imovel':<?php echo $id;?>,'titulo':'<?php echo $titulo_imovel;?>','login':'<?php echo $_SESSION['login'];?>'},
        'onComplete'  : function(event, ID, fileObj, response, data) {
            if(response == 'maximo')
                $('#maximo_fotos').show(); 
        },
        'onQueueFull'    : function (event,queueSizeLimit) {
            $('#maximo_fotos').show();
            $('#file_upload').uploadifyClearQueue();
            return false;
        },
        'onAllComplete' : function(event,data) {
            $.ajax({
                type: "GET",
                url: "lista_imagens_imoveis.php",
                data: "id_imovel=<?php echo $id;?>&login=<?php echo $_SESSION['login'];?>&titulo=<?php echo $titulo_imovel;?>",
                success: function (html) {
                    $('#box_imagens').html(html);
                },
                error: function () {
                    alert("Ocorreu um erro inesperado durante o processamento.");
                }
            });
        } 
    })

});
</script>

<div id="content" style="width:670px;">
	
    <div class="page page-imovel">
	
        <div class="breadcumbs">
            <span><?php echo (isset($dados_imovel->id) ? 'Edite' : 'Cadastre');?> seu im&oacute;vel</span>
            <?php if(isset($dados_imovel->id)) :?>
            <a style="margin: 0;" id="deletar-imovel" rel="<?php echo $dados_imovel->titulo;?>" class="<?php echo $dados_imovel->titulo_url;?>" corretor="<?php echo $_SESSION['login'];?>" class="deletar">deletar</a>
            <?php endif;?>
        </div>
        
        <form action="" method="post" id="formulario_f" enctype="multipart/form-data">
            
            <input type="hidden" name="id_cad_foto" value="<?php echo $id;?>" />
            
            <div class="info">
                <span class="num">1</span><p>Escolha as fotos no seu computador <span>(Você poderá enviar até 10 fotos)</span></p>
            </div>
            <div class="info">
            	<span class="num">2</span>
                <p>Insira uma descrição</p>
            </div>
            <div class="info">
                <span class="num">3</span><p>Escolha a foto principal do imóvel <span>(que o representará em buscas e na listagem geral)</span></p>
            </div>
            
            <div class="linha-form">&nbsp;</div>

            <div class="foto foto-c">
                <h3>Fotos</h3>
                <img class="img-foto-cad-album" src="static/img/foto_03.jpg" alt="Fotos" title="Fotos" />
                <span class="tx span-cad-album">Segure a tecla Ctrl do seu computador e selecione até 10 arquivos de imagem<br /><font>(No máximo 2MB para cada foto)</font></span>
                <span class="span-cad-album">
                  <input type="file" name="file_upload" class="photo" id="file_upload" />
                </span>
            </div>  
            
         <div id="box_imagens"></div>  
         
        </form>

        <div class="mensagem_foto">
           <div id="box_imagens"></div>    
           <p>*Você deve selecionar um álbum</p>
        </div>
        <div class="mensagem_padrao">
           <div id="box_imagens"></div>    
           <p>*Você deve selecionar uma foto padrão</p>
        </div>
                      
        <a id="submit-form" style="float: right; margin: 20px 50px 0 0;" class="<?php echo (isset($dados_imovel->id)) ? 'enviar-senha salvar' : 'enviar-senha' ;?>"></a>

        <div id="maximo_fotos" style="color: red; display: none;">O máximo permitido é 10 Fotos!</div>
        
        <?php if(isset($dados_imovel->id)) :?>
        <p style="float: left; width: 100%">*Após terminar cada etapa, não se esqueça de clicar no botão de Salvar</p>
        <?php else:?>
        <p style="float: left; width: 100%">*Após terminar cada etapa, não se esqueça de clicar no botão de Enviar</p>
        <?php endif;?>
    </div>

</div>

