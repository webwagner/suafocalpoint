<script type="text/javascript" src="<?php echo URL;?>static/js/maskedmoney.js"></script>
<script>
$(document).ready(function(){
    
    $('.tipo_busca').click(function(){
        if($(this).val() == 2){
            $('#box-busca-caracteristicas').show('slow');
            $('#box-busca-codigo').hide();
            $('#box-busca-titulo').hide();
        }
        else if($(this).val() == 1){
            $('#box-busca-codigo').show();
            $('#box-busca-caracteristicas').hide();
            $('#box-busca-titulo').hide();
        } else {
            $('#box-busca-titulo').show();
            $('#box-busca-caracteristicas').hide();
            $('#box-busca-codigo').hide();
        }    
    })
    
    <?php if($uf_corretor->uf == "SP") :?>
    $("#cidade").change(function(){
        
        var cidade = $(this).val();

        $.ajax({
            type: "GET",
            url: "estados_imovel.php",
            data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id;?>,
            dataType: "xml",
            beforeSend: function () {
                $('.bairro').html('<option value="">Aguarde...</option>');
            },
            success: function (xml) {
                var html = '<option value="">Selecione</option>';
                $(xml).find('bairros').each(function () {
                    $(xml).find('bairro').each(function () {
                        var bairro = $(this).find('nome').text();
                        var id_bairro = $(this).find('id').text();
                        html += "<option value='"+id_bairro+"'>"+bairro+"</option>";
                    });
                });
                $('.bairro').html(html);
            },
            error: function () {
                alert("Ocorreu um erro inesperado durante o processamento.");
            }
        });
        
    })
    <?php else:?>
        var cidade = <?php echo $cidade_corretor->id;?>;

        $.ajax({
            type: "GET",
            url: "estados_imovel.php",
            data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id;?>,
            dataType: "xml",
            beforeSend: function () {
                $('.bairro').html('<option value="">Aguarde...</option>');
            },
            success: function (xml) {
                var html = '<option value="">Selecione</option>';
                $(xml).find('bairros').each(function () {
                    $(xml).find('bairro').each(function () {
                        var bairro = $(this).find('nome').text();
                        var id_bairro = $(this).find('id').text();
                        html += "<option value='"+id_bairro+"'>"+bairro+"</option>";
                    });
                });
                $('.bairro').html(html);
            },
            error: function () {
                alert("Ocorreu um erro inesperado durante o processamento.");
            }
        });
    <?php endif;?>
            
    $('.add-bairro').live("click", function(event){
        
        $('.add-bairro').html('<img src="static/img/bt-menos.gif" alt="- Bairros" />');
        $('.add-bairro').removeClass('add-bairro').addClass('remove-bairro');
        
        if($("#cidade").size() > 0)
            var cidade = $("#cidade").val();
        else
            var cidade = <?php echo $cidade_corretor->id;?>;
        
        $.ajax({
            type: "GET",
            url: "estados_imovel.php",
            data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id;?>,
            dataType: "xml",
            beforeSend: function () {
                var html = '<option value="">Aguarde...</option>';
                $('#label-bairro').append('<select id="bairro_aguarde" class="bairro" style="margin: 0 0 15px 0; float: right;" name="bairro[]">'+html+'</select>' );
            },
            success: function (xml) {
                $('#bairro_aguarde').remove();
                var html = '<option value="">Selecione</option>';
                $(xml).find('bairros').each(function () {
                    $(xml).find('bairro').each(function () {
                        var bairro = $(this).find('nome').text();
                        var id_bairro = $(this).find('id').text();
                        html += "<option value='"+id_bairro+"'>"+bairro+"</option>";
                    });
                });
                $('#label-bairro').append('<span class="bloco" style="width: 105px;"></span><select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">'+html+'</select><a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a>' );
            },
            error: function () {
                alert("Ocorreu um erro inesperado durante o processamento.");
            }
        });
    })
    
    $('.remove-bairro').live("click", function(event){
        $(this).prev().remove();
        $(this).prev('span.bloco').remove();
        $(this).remove();
    })
    
    $("#valor_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_venda").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_minimo_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_minimo_venda").maskMoney({thousands:'.', decimal:'', precision:0});
    
    $('.add-tipo').live("click", function(event){
        $('.add-tipo').html('<img src="static/img/bt-menos.gif" alt="- Bairros" />');
        $('.add-tipo').removeClass('add-tipo').addClass('remove-tipo');

        var htm = '<span class="bloco2" style="width: 105px;"></span><select style="margin: 0 0 15px 0; float: left;" name="tipo[]">'+$(this).prev('select').html()+'</select><a style="float: left; margin: 5px 0 0 10px;" class="add-tipo" href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Tipos" /></a>';

        html = $(".tipo").html();
        $(".tipo").html(html+htm);
    })

    $('.remove-tipo').live("click", function(event){
        $(this).prev().remove();
        $(this).prev('span.bloco2').remove();
        $(this).remove();
    })
    
})
</script>

<div id="content">
    
    <div class="page">
	
        <div class="breadcumbs">
            <span>Imóveis da Minha Rede</span>
        </div>
        
        <?php echo $lista_busca;?>
        
        <div class="pagination">
            <div class="pag">
                <?php echo $html_paginacao;?>    
            </div>
        </div>
        
        <div id="busca-imoveis" class="busca-codigo-av">
        
            <form action="<?php echo $_SESSION['login'];?>/busca-imoveis/contatos" method="post" id="formulario_b">
            
                <label style="width: auto;" class="radio">
                    <input checked="checked" class="tipo_busca" type="radio" name="tipo_busca" value="1" />
                    <span>Por Código</span>
                </label>
                
                <label style="width: auto;" class="radio">
                    <input class="tipo_busca" type="radio" name="tipo_busca" value="3" />
                    <span>Por Título</span>
                </label>

                <label class="radio">
                    <input type="radio" class="tipo_busca" name="tipo_busca" value="2" />
                    <span>Por Características</span>
                </label>
            
                <br clear="all" />
                
                <div id="box-busca-codigo">
                    <label class="codigo">
                        <span>Código do Imóvel <em>(Ex: RRD11)</em></span>
                        <input class="text-codigo" name="codigo" type="text" />
                        <input style="width: 89px;" type="submit" value="Buscar" class="b-av"/>        
                    </label>
                </div>   
                
                <div id="box-busca-titulo" style="display: none;">
                    <label class="codigo">
                        <span>Título do Imóvel</span>
                        <input class="text-codigo" name="titulo" type="text" />
                        <input style="width: 89px;" type="submit" value="Buscar" class="b-av"/>        
                    </label>
                </div>
                
            <div id="box-busca-caracteristicas" style="display: none;">
            
                <input type="hidden" name="uf" value="<?php echo $uf_corretor->id;?>" />
                
                <?php if($uf_corretor->uf == "SP") :?>
                    <div class="select" style="padding: 0; width: 382px; margin: 0 2px 0 0; height: auto;" id="label-cidade">
                        <span>Filtrar por Cidade</span>
                        <select style="margin: 0 0 15px 0; float: right;" id="cidade" name="cidade">
                            <option value="">Selecione</option>
                            <?php foreach($cidades_sp as $cidade_sp) :?>
                            <option value="<?php echo $cidade_sp->id;?>"><?php echo $cidade_sp->cidade;?></option>   
                            <?php endforeach;?>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="cidade" value="<?php echo $cidade_corretor->id;?>" />
                <?php endif;?>

                <div style="float: left;">
                    <div class="select" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;" id="label-bairro">
                        <span>Filtrar por Bairro</span>
                        <select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">
                            <option value="">Selecione</option>
                        </select>
                        <a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a> 
                    </div>

                    <br clear="all" />

                    <div class="select tipo" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;">
                        <span style="text-align: right; width: 105px;">Tipo</span>
                        <select style="margin: 0 0 15px 0;" id="tipo" name="tipo[]">
                            <option value="">Selecione</option>
                            <?php foreach($rows_tipo as $row_tipo) :?>
                            <option value="<?php echo $row_tipo->id;?>"><?php echo $row_tipo->nome;?></option>
                            <?php endforeach;?>
                        </select>
                        <a style="float: left; margin: 5px 0 0 10px;" class="add-tipo" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Tipos" /></a> 
                    </div>
                </div>
                    
                <div style="float: left;">
                    <div class="check">
                        <p>Residencial</p>

                        <label>
                            <input type="checkbox" value="SIM" name="residencial_aluguel" />
                            <span>Aluguel</span>
                        </label>

                        <label>
                            <input type="checkbox" value="SIM" name="residencial_compra" />
                            <span>Venda</span>
                        </label>
                    </div>

                    <div class="check">
                        <p>Comercial</p>

                        <label>
                            <input type="checkbox" value="SIM" name="comercial_aluguel" />
                            <span>Aluguel</span>
                        </label>

                        <label>
                            <input type="checkbox" value="SIM" name="comercial_compra" />
                            <span>Venda</span>
                        </label>
                    </div>
                </div>
                    
                <div class="busca-avancada">

                    <h3>BUSCA AVANÇADA</h3>

                    <div id="b-avancada">&nbsp;</div>

                    <div id="busca-avancada-display">

                        <label>
                            <span>Valor do Aluguel até R$</span>
                            <input type="text" id="valor_aluguel" name="valor_aluguel" />
                        </label>
                        
                        <label>
                            <span>Valor de Venda até R$</span>
                            <input type="text" id="valor_venda" name="valor_venda" />
                        </label>

                        <label>
                            <span>Valor Mínimo de Aluguel R$</span>
                            <input type="text" id="valor_minimo_aluguel" name="valor_minimo_aluguel" />
                        </label>
                        
                        <label>
                            <span>Valor Mínimo de Venda R$</span>
                            <input type="text" id="valor_minimo_venda" name="valor_minimo_venda" />
                        </label>
                        
                        <label>
                            <span>Número Atual de Quartos</span>
                            <input type="text" name="n_quartos" />
                        </label>

                        <label>
                            <span>Nome do Condomínio</span>
                            <input type="text"  name="nome_condominio" />
                        </label>

                        <label>
                            <span>Área construída maior que:<br /><font>(não incluindo varandas)</font></span>
                            <input type="text" name="area_construida_maior" /> m²
                        </label>
                        <label>
                            <span>Área construída menor que:<br /><font>(não incluindo varandas)</font></span>
                            <input type="text" name="area_construida_menor" /> m² 
                        </label>


                        <label class="av-check av-check-f">
                            <input type="checkbox" name="mobiliado" />
                            <span>Mobiliado</span>
                        </label>

                        <label class="av-check">
                            <input type="checkbox" name="portaria_h" />
                            <span>Portaria 24h</span>
                        </label>

                        <label class="av-check">
                            <input type="checkbox" name="varanda" />
                            <span>Varanda</span>
                        </label>

                        <label class="av-check">
                            <input type="checkbox" name="piscina" />
                            <span>Piscina</span>
                        </label>

                        <br clear="all" />

                        <input type="submit" value="Buscar" class="b-av"/>                     	                        

                    </div>

                </div>
       
            </div>
            
            </form>
        
        </div>

    </div>
    
</div>