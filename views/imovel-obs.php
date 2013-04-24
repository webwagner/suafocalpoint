<script type="text/javascript" src="<?php echo URL;?>static/js/maskedinput-1.1.4.js"></script>
<script>
$(document).ready(function() {
    $(".enviar-senha").click( function() {
        $("#formulario").submit();
    })
    
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
    
    $("#telefone_p").mask("(99) 9999-9999"); 
    $("#cep").mask("99999-999"); 
    $("#cep_p").mask("99999-999");
    $("#vencimento").mask("99/99/9999"); 
    
    $("#cep").blur(function(){
        if($.trim($("#cep").val()) != ""){
            $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
                if(resultadoCEP["resultado"]){
                     if(resultadoCEP["resultado"] != 0)
                         $("#endereco").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));   
                }
            });
       }
   })

   $("#cep_p").blur(function(){
        if($.trim($("#cep_p").val()) != ""){
            $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep_p").val(), function(){
                if(resultadoCEP["resultado"]){
                     if(resultadoCEP["resultado"] != 0){
                         $("#endereco_p").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
                         $("#bairro").val(unescape(resultadoCEP["bairro"]));
                         $("#cidade").val(unescape(resultadoCEP["cidade"]));
                     }
                }
            });
       }
   })
})
</script>
<div id="content" style="width:670px;">
	
    <div class="page page-imovel">
	
        <div class="breadcumbs">
            <span><?php echo (isset($dados_imovel->id) ? 'Edite' : 'Cadastre');?> seu im&oacute;vel</span>
            <?php if(isset($dados_imovel->id)) :?>
            <a style="margin: 0;" id="deletar-imovel" rel="<?php echo $dados_imovel->titulo;?>" class="<?php echo $dados_imovel->titulo_url;?>" corretor="<?php echo $_SESSION['login'];?>" class="deletar">deletar</a>
            <?php endif;?>
        </div>
        
        <form action="" method="post" id="formulario">
            
            <input type="hidden" name="id" value="<?php echo $id;?>" />
            
             <label class="imovel" style="width: 100%; height: 80px;">
                 <span style="display: block;">Vencimento do contrato
                     <font style="font-size: 11px; color: #777;"> (Preencha este campo somente quando o imóvel for alugado. Nesta data, você será lembrado de ligar para o proprietário para saber se o imóvel está vago novamente)</font>
                 </span>
                <input style="width: 260px;" type="text" name="vencimento_contrato" value="<?php echo (isset($dados_imovel->vencimento_contrato) ? $dados_imovel->vencimento_contrato : '');?>" id="vencimento" />           
            </label>
            
            <div style="width: 100%; float: left;">
                <label class="imovel">
                    <span>CEP:</span>
                    <input type="text" name="cep" id="cep" value="<?php echo (isset($dados_imovel->cep) ? $dados_imovel->cep :'');?>" />           
                    <a style="font-size: 11px; color: blue;" href="http://correios.com.br/" target="_BLANK">Busque o CEP</a>
                </label>

                <label class="imovel">
                    <span>Endere&ccedil;o do Im&oacute;vel:</span>
                    <input type="text" name="endereco" id="endereco" value="<?php echo (isset($dados_imovel->endereco) ? $dados_imovel->endereco :'');?>" />           
                </label>
            </div>
            
            <div style="width: 100%; float: left;">
                <label class="imovel">
                    <span>Número:</span>
                    <input type="text" name="numero" id="numero" value="<?php echo (isset($dados_imovel->numero) ? $dados_imovel->numero :'');?>" />           
                </label>

                <label class="imovel">
                    <span>Complemento:</span>
                    <input type="text" name="complemento" id="complemento" value="<?php echo (isset($dados_imovel->complemento) ? $dados_imovel->complemento :'');?>" />           
                </label>
            </div>
            
            <label class="imovel" style="width: 550px;">
            	<span>Nome do Propriet&aacute;rio:</span>
                <input type="text" name="nome_proprietario" id="nome_p" value="<?php echo (isset($dados_imovel->nome_proprietario) ? $dados_imovel->nome_proprietario :'');?>" />           
            </label>
            
            <label class="imovel">
            	<span>Telefone do Propriet&aacute;rio:</span>
                <input type="text" name="telefone_proprietario" id="telefone_p" value="<?php echo (isset($dados_imovel->telefone_proprietario) ? $dados_imovel->telefone_proprietario :'');?>" />           
            </label>
        
            <label class="imovel">
            	<span>Email do Propriet&aacute;rio:</span>
                <input type="text" name="email_proprietario" id="email_p" value="<?php echo (isset($dados_imovel->email_proprietario) ? $dados_imovel->email_proprietario :'');?>" />           
            </label>
            
            <div style="width: 100%; float: left;">
                <label class="imovel">
                    <span>CEP:</span>
                    <input type="text" name="cep_proprietario" id="cep_p" value="<?php echo (isset($dados_imovel->cep_proprietario) ? $dados_imovel->cep_proprietario :'');?>" />           
                    <a style="font-size: 11px; color: blue;" href="http://correios.com.br/" target="_BLANK">Busque o CEP</a>
                </label>

                <label class="imovel">
                    <span>Endere&ccedil;o do Propriet&aacute;rio:</span>
                    <input type="text" name="endereco_proprietario" id="endereco_p" value="<?php echo (isset($dados_imovel->endereco_proprietario) ? $dados_imovel->endereco_proprietario :'');?>" />           
                </label>
            </div>
            
            <label class="imovel">
            	<span>Bairro:</span>
                <input type="text" name="bairro_proprietario" id="bairro" value="<?php echo (isset($dados_imovel->bairro_proprietario) ? $dados_imovel->bairro_proprietario :'');?>" />           
            </label>
        
            <label class="imovel">
            	<span>Cidade:</span>
                <input type="text" name="cidade_proprietario" id="cidade" value="<?php echo (isset($dados_imovel->cidade_proprietario) ? $dados_imovel->cidade_proprietario :'');?>" />           
            </label>
        
            <label class="textarea">
            	<span>Observa&ccedil;&otilde;es: <font style="font-size: 10px; font-style: italic;">Essas informações serão visíveis apenas a você</font></span><br />
                <textarea name="observacoes" id="mensagem" style="height:150px; width:550px"><?php echo (isset($dados_imovel->observacoes) ? $dados_imovel->observacoes :'');?></textarea>           
            </label>

            <input style="float: right; margin: 20px 50px 0 0;" type="button" value="" class="<?php echo (isset($dados_imovel->id)) ? 'enviar-senha salvar' : 'enviar-senha' ;?>"/>
            
            <?php if(isset($dados_imovel->id)) :?>
            <p style="float: left; width: 100%">*Após terminar cada etapa, não se esqueça de clicar no botão de Salvar</p>
            <?php else:?>
            <p style="float: left; width: 100%">*Após terminar cada etapa, não se esqueça de clicar no botão de Enviar</p>
            <?php endif;?>
        </form>
    
    </div>

</div>
