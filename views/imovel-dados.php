<script type="text/javascript" src="<?php echo URL;?>static/js/maskedmoney.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/maskedinput-1.1.4.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/estados_imovel.js"></script>
<script type="text/javascript" src="<?php echo URL;?>static/js/jquery.validate.js"></script>
<script>
$(document).ready(function() {
    
    $("#deletar-imovel").click( function() {
        var imovel = $(this).attr('rel');
        var url_imovel = $(this).attr('class');
        var id_corretor = $(this).attr('corretor');

        jConfirm('<span style="color: red; align: center; font-weight: bold;">Tem certeza que deseja deletar o imóvel '+imovel+'?<br>Após deletado este imóvel não poderá ser recuperado</span>.', 'Deletar Imóvel', function(r) {
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
        
    $("#formulario").validate();
    
    $("#vencimento").mask("99/99/9999"); 
    $("#valor_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_venda").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_iptu").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_condominio").maskMoney({thousands:'.', decimal:'', precision:0});
    
    <?php if($uf->uf == "SP") :?>
    var estado = <?php echo $uf->id;?> 
     
    $.ajax({
        type: "GET",
        url: "estados_imovel.php",
        data: "acao=buscaCidade&uf="+estado,
        dataType: "xml",
        beforeSend: function () {
            $('#cidades').html('<option value="">Aguarde...</option>');
        },
        success: function (xml) {
            var html = '<option value="">Selecione a cidade</option>';
            $(xml).find('cidades').each(function () {
                $(xml).find('cidade').each(function () {
                    var cidade = $(this).find('nome').text();
                    var id_cidade = $(this).find('id').text();
                    html += "<option value='"+id_cidade+"'>"+cidade+"</option>";
                });
            });
            $('#cidades').html(html);
        },
        error: function () {
            alert("Ocorreu um erro inesperado durante o processamento.");
        }
    });
    
    $("#cidades").change(function(){
        var cidade = $(this).val();
        $.ajax({
            type: "GET",
            url: "estados_imovel.php",
            data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id;?>,
            dataType: "xml",
            beforeSend: function () {
                $('#bairros').html('<option value="">Aguarde...</option>');
            },
            success: function (xml) {
                var html = '<option value="">Selecione o bairro</option>';
                $(xml).find('bairros').each(function () {
                    $(xml).find('bairro').each(function () {
                        var bairro = $(this).find('nome').text();
                        var id_bairro = $(this).find('id').text();
                        html += "<option value='"+id_bairro+"'>"+bairro+"</option>";
                    });
                });
                $('#bairros').html(html);
            },
            error: function () {
                alert("Ocorreu um erro inesperado durante o processamento.");
            }
        });
    })
    <?php else:?>
    var cidade = <?php echo $cidade->id;?>;
        
    $.ajax({
        type: "GET",
        url: "estados_imovel.php",
        data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id;?>,
        dataType: "xml",
        beforeSend: function () {
            $('#bairros').html('<option value="">Aguarde...</option>');
        },
        success: function (xml) {
            var html = '<option value="">Selecione o bairro</option>';
            $(xml).find('bairros').each(function () {
                $(xml).find('bairro').each(function () {
                    var bairro = $(this).find('nome').text();
                    var id_bairro = $(this).find('id').text();
                    html += "<option value='"+id_bairro+"'>"+bairro+"</option>";
                });
            });
            $('#bairros').html(html);
        },
        error: function () {
            alert("Ocorreu um erro inesperado durante o processamento.");
        }
    });
    <?php endif;?>
    
    $('#aluguel').click(function(){
        if(this.checked == true)
            $('#preco_aluguel').show('slow');
        else
            $('#preco_aluguel').hide('slow');
    })
    
    $('#compra').click(function(){
        if(this.checked == true)
            $('#preco_venda').show('slow');
        else
            $('#preco_venda').hide('slow');
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
            
            <?php if(isset($dados_imovel->id)) :?>
            <input type="hidden" name="id" value="<?php echo $dados_imovel->id;?>" />
            <?php endif;?>
            
            <input type="hidden" name="id_corretor" value="<?php echo $_SESSION['usuario_logado']->id;?>" />
            
            <div class="l-check">
            
                <div class="check">                
                    <label>
                        <input type="checkbox" <?php echo (isset($dados_imovel->residencial) && $dados_imovel->residencial == 'NAO') ? '' : 'checked="checked"';?> name="residencial" value="SIM" class="text-input" id="residencial" />
                        <span>Residencial</span>
                    </label>
                    <label>
                        <input type="checkbox" <?php echo (isset($dados_imovel->comercial) && $dados_imovel->comercial == 'SIM') ? 'checked="checked"' : "";?> name="comercial" value="SIM" class="text-input" id="comercial" />
                        <span>Comercial</span>
                    </label>
                </div>
                
                <div class="check">
                    <label>
                        <input type="checkbox" name="aluguel" <?php echo (isset($dados_imovel->aluguel) && $dados_imovel->aluguel == 'NAO') ? '' : 'checked="checked"';?> value="SIM" class="text-input" id="aluguel"/>
                        <span>Aluguel</span>
                    </label>
                    <label>
                        <input type="checkbox" name="compra" <?php echo (isset($dados_imovel->compra) && $dados_imovel->compra == 'SIM') ? 'checked="checked"' : "";?> value="SIM" class="text-input" id="compra"/>
                        <span>Venda</span>
                    </label>
                </div>
            
            </div>
            
            <div class="linha-form">&nbsp;</div>
        
            <label id="preco_aluguel" <?php echo (isset($dados_imovel->aluguel) && $dados_imovel->aluguel == 'NAO') ? 'style="display:none;"' : '';?> class="imovel imovel-c imovel-menor">
            	<span><strong>Para Aluguel</strong><br />Valor em Reais - R$</span>
                <input type="text" name="valor_aluguel1" value="<?php echo (isset($dados_imovel->valor_aluguel) ? number_format($dados_imovel->valor_aluguel,2,',','.') : '');?>" id="valor_aluguel"/>           
            </label>
        
            <label id="preco_venda" <?php echo (isset($dados_imovel->compra) && $dados_imovel->compra == 'SIM') ? '' : 'style="display:none;"';?> class="imovel imovel-c imovel-menor">
            	<span><strong>Para Venda</strong><br />Valor em Reais - R$</span>
                <input type="text" name="valor_venda1" value="<?php echo (isset($dados_imovel->valor_venda) ? number_format($dados_imovel->valor_venda,2,',','.') : '');?>" id="valor_venda"/>           
            </label>  
            
            <div class="linha-form">&nbsp;</div>

            <label class="imovel imovel-c">
            	<span><?php echo (isset($tipo_imovel->nome) ? 'Tipo:'.$tipo_imovel->nome : '*Tipo:');?></span>
            	<select name="tipo_imovel_id" class="<?php echo (!isset($tipo_imovel->nome) ? 'required' : '');?> select_gray" style="margin-top: 5px;" id="tipo">
                    <option value="">Selecione</option>   
                    <?php foreach($rows_tipo as $row_tipo) :?><option value="<?php echo $row_tipo->id;?>"><?php echo $row_tipo->nome;?></option><?php endforeach;?>
                </select>
            </label>

            <label class="cadastro-all">
            	<span class="blue">*T&iacute;tulo do Im&oacute;vel:</span>
                <input type="text" name="titulo" class="required" id="titulo" value="<?php echo (isset($dados_imovel->titulo) ? $dados_imovel->titulo : '');?>" />           
            </label>
            
            <label style="padding-left: 0;" class="textarea">
                <span class="blue">Informações adicionais do imóvel: <font style="font-size: 10px; font-style: italic;">Essas informação serão visíveis a todos os membros da rede</font></span>
                <textarea name="informacoes_adicionais" style="height:100px; width:590px"><?php echo (isset($dados_imovel->informacoes_adicionais) ? $dados_imovel->informacoes_adicionais : '');?></textarea>           
                <span style="font-size: 12px; display: block; margin-top: 3px;">Ex: número de vagas, suítes, condições gerais, disponibilidade</span>
            </label>
            
            <div class="linha-form">&nbsp;</div>
           
            <p class="inteiro"><strong>Número de Quartos</strong></p>
            <label class="imovel imovel-c">
            	<span><?php echo (isset($dados_imovel->quartos_atual) ? 'Atual: '.$dados_imovel->quartos_atual : '*Atual:');?></span>
            	<select name="quartos_atual" class="<?php echo (!isset($dados_imovel->quartos_atual) ? 'required' : '');?> select_gray" id="n_quartos_atual">
                    <option value="">Selecione</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5_ou_mais">5 ou mais</option>
                </select>
            </label>
        
            <label class="imovel imovel-c">
            	<span><?php echo (isset($dados_imovel->quartos_original) ? 'Original: '.$dados_imovel->quartos_original : 'Original:');?></span>
            	<select name="quartos_original" class="select_gray" id="n_quartos_original">
                    <option value="">Selecione</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5_ou_mais">5 ou mais</option>
                </select>
            </label>
            
            <div class="linha-form">&nbsp;</div>
        
            <label class="imovel imovel-c imovel-metragem">
            	<span><strong>*Área construída</strong><br /><font>(não incluindo varandas)</font></span>
                <input type="text" name="area_construida" class="required" id="area_construida" value="<?php echo (isset($dados_imovel->area_construida) ? $dados_imovel->area_construida : '');?>" /><span class="metro">m²</span>           
            </label>
        
            <label class="imovel imovel-c imovel-metragem">
            	<span><strong>Área Externa</strong><br /><font>&nbsp;</font></span>
                <input type="text" name="area_externa" id="area_externa" value="<?php echo (isset($dados_imovel->area_externa) ? $dados_imovel->area_externa : '');?>" /><span class="metro">m²</span>               
            </label>
        
            <label class="imovel imovel-c imovel-metragem">
            	<span><strong>Terreno</strong><br /><font>&nbsp;</font></span>
                <input type="text" name="terreno" id="terreno" value="<?php echo (isset($dados_imovel->terreno) ? $dados_imovel->terreno : '');?>" /><span class="metro">m²</span>                     
            </label>
            
            <div class="linha-form">&nbsp;</div>
        
            <div class="imovel-radio">

            	<span><strong>Opcionais?</strong></span>
                <label>
                	<input <?php echo (isset($dados_imovel->portaria_24h) && $dados_imovel->portaria_24h == 'SIM' ? 'checked="checked"' : '');?> name="portaria_24h" value="SIM" type="checkbox" />
                    <span class="ch green green-m">Portaria 24h</span>
                </label>
                <label>
                	<input <?php echo (isset($dados_imovel->varanda) && $dados_imovel->varanda == 'SIM' ? 'checked="checked"' : '');?> name="varanda" value="SIM" type="checkbox" />
                    <span class="ch green green-m">Varanda</span>
                </label>
                <label>
                	<input <?php echo (isset($dados_imovel->mobiliado) && $dados_imovel->mobiliado == 'SIM' ? 'checked="checked"' : '');?> name="mobiliado" value="SIM" type="checkbox" />
                    <span class="ch green green-m">Mobiliado</span>
                </label>
            </div>
            
            <div class="linha-form">&nbsp;</div>
        
            <div class="imovel-radio" style="margin-bottom:20px;">
            	<span><strong>Piscina?</strong></span>
                <label style="width:50px">
                    <input <?php echo (isset($dados_imovel->piscina) && $dados_imovel->piscina == 'SIM' ? 'checked="checked"' : '');?> name="piscina" value="SIM" type="radio" class="required" id="piscina" />
                    <span class="green" style="position:absolute">SIM</span>
                </label>
                <label>
                    <input <?php echo (isset($dados_imovel->piscina) && $dados_imovel->piscina == 'NAO' ? 'checked="checked"' : '');?> name="piscina" value="NAO" type="radio" class="required" id="piscina" />
                    <span class="green">NAO</span>
                </label>
        
                <label class="imovel imovel-c imovel-menor" style="width:400px; margin-left:35px;">
                    <span><strong>&nbsp;&nbsp;&nbsp;&nbsp;Nome do Condomínio</strong></span>
                    <input value="<?php echo (isset($dados_imovel->nome_condominio) ? $dados_imovel->nome_condominio : '');?>" type="text" name="nome_condominio" class="cd"/>           
                </label>            
            </div>
            
            <div class="linha-form">&nbsp;</div>
        
            <p class="inteiro">
                <strong>Valor do IPTU</strong>
                <strong style="margin-left:190px;">Valor do Condomínio</strong>
            </p>
            
            <label class="imovel imovel-c">
            	<span class="gr">R$:</span>
                <input type="text" value="<?php echo (isset($dados_imovel->valor_iptu) ? number_format($dados_imovel->valor_iptu,2,',','.') : '');?>" name="valor_iptu1" id="valor_iptu" class="mm" />           
            </label>
        
            <label class="imovel imovel-c">
            	<span class="gr">R$:</span>
                <input type="text" name="valor_condominio1" value="<?php echo (isset($dados_imovel->valor_condominio) ? number_format($dados_imovel->valor_condominio,2,',','.') : '');?>" id="valor_condominio" class="mm" />           
            </label>
            
            <div class="linha-form">&nbsp;</div>
        
            <p class="inteiro">
                <strong>Localização</strong>
            </p>
            
            <input type="hidden" name="uf_imovel" value="<?php echo $uf->id;?>" />
            
            <?php if($uf->uf == "SP") :?>
                <p style="float: left; width: 250px;">
                    <?php echo (isset($cidade_imovel->cidade)) ? '<span style="float:left; width: 200px;">'.$cidade_imovel->cidade.'</span>' : '';?>
                    <label class="select cadastro-small" style="width: 200px; margin-right: 10px;">
                        <select name="cidade_imovel" class="<?php echo (!isset($cidade_imovel->bairro) ? 'required' : '');?>" id="cidades">
                            <option value="">Selecione a cidade</option>
                        </select>
                    </label>
                </p>
            <?php else :?>
                <input type="hidden" name="cidade_imovel" value="<?php echo $cidade->id;?>" />
            <?php endif;?>
            
            <p style="float: left; width: 250px;">
                <?php echo (isset($bairro_imovel->bairro)) ? '<span style="float:left; width: 200px;">'.$bairro_imovel->bairro.'</span>' : '';?>
                <label class="select cadastro-small" style="width: 200px; margin-right: 10px;">
                    <select name="bairro_imovel" class="<?php echo (!isset($bairro_imovel->bairro) ? 'required' : '');?>" id="bairros">
                        <option value="">Selecione o bairro</option>
                    </select>
                </label>
            </p>
            
            <label style="padding-left: 0;" class="textarea">
                <span class="blue">Observações só para Corretores:</span>
                <textarea name="informacoes_adicionais_corretores" style="height:100px; width:590px"><?php echo (isset($dados_imovel->informacoes_adicionais_corretores) ? $dados_imovel->informacoes_adicionais_corretores : '');?></textarea>           
                <span style="font-size: 12px; display: block; margin-top: 3px;">Este campo só os seus parceiros terão acesso.</span>
            </label>
            
            <input style="float: right; margin: 20px 50px 0 0;" type="submit" value="" class="<?php echo (isset($dados_imovel->id)) ? 'enviar-senha salvar' : 'enviar-senha' ;?>"/>
            
            <?php if(isset($dados_imovel->id)) :?>
            <p style="float: left; width: 100%">*Após terminar cada etapa, não se esqueça de clicar no botão de Salvar</p>
            <?php else:?>
            <p style="float: left; width: 100%">*Após terminar cada etapa, não se esqueça de clicar no botão de Enviar</p>
            <?php endif;?>
        </form>
    
    </div>

</div>


