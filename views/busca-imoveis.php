<script type="text/javascript" src="<?php echo URL;?>static/js/maskedmoney.js"></script>
<script>
$(document).ready(function(){
    
    $("#valor_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_venda").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_minimo_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
    $("#valor_minimo_venda").maskMoney({thousands:'.', decimal:'', precision:0});
    
    $('.tipo_busca').click(function(){
        if($(this).val() == 2){
            $('#box-busca-caracteristicas').show('slow');
            $('#box-busca-codigo').hide('slow');
            $('#box-busca-titulo').hide('slow');
        } else if($(this).val() == 3){
            $('#box-busca-titulo').show('slow');
            $('#box-busca-codigo').hide('slow');
            $('#box-busca-caracteristicas').hide('slow');
        } else{
            $('#box-busca-codigo').show('slow');
            $('#box-busca-caracteristicas').hide('slow');
            $('#box-busca-titulo').hide('slow');
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
        <?php if(!isset($bairros)) : ?>         
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
                $('#label-bairro').append('<select class="bairro bairro_aguarde" style="margin: 0 0 15px 0; float: right;" name="bairro[]">'+html+'</select>' );
            },
            success: function (xml) {
                $('.bairro_aguarde').remove();
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
    
    <?php if($_SESSION['busca']['tipo_busca'] == 1){ ?>
        $('#box-busca-codigo').show();
        $('#box-busca-caracteristicas').hide();
        $('#box-busca-titulo').hide();
    <?php } else if($_SESSION['busca']['tipo_busca'] == 3){ ?>
        $('#box-busca-titulo').show();
        $('#box-busca-codigo').hide();
        $('#box-busca-caracteristicas').hide();
    <?php }else{ ?>
        $('#box-busca-caracteristicas').show();
        $('#box-busca-codigo').hide();
        $('#box-busca-titulo').hide();
    <?php } ?>
        
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
            <span>Busca de Im�veis</span>
        </div>
        
        <div><?php echo $mens;?></div>
        
        <?php echo $lista_busca;?>
        
        <div class="pagination">
            <div class="pag">
                <?php echo $html_paginacao;?>    
            </div>
        </div>
        
        <div id="busca-imoveis" class="busca-codigo-av">
        
            <form action="<?php echo $_SESSION['login'];?>/busca-imoveis/<?php echo url(3);?>" method="post" id="formulario_b">
            
                <label style="width: auto;" class="radio">
                    <input <?php echo isset($_SESSION['busca']['tipo_busca']) && $_SESSION['busca']['tipo_busca'] == '1' ? 'checked="checked"' : ''; ?> class="tipo_busca" type="radio" name="tipo_busca" value="1" />
                    <span>Por C�digo</span>
                </label>
                
                <label style="width: auto;" class="radio">
                    <input class="tipo_busca" <?php echo isset($_SESSION['busca']['tipo_busca']) && $_SESSION['busca']['tipo_busca'] == '3' ? 'checked="checked"' : ''; ?>  type="radio" name="tipo_busca" value="3" />
                    <span>Por T�tulo</span>
                </label>

                <label class="radio">
                    <input type="radio" <?php echo isset($_SESSION['busca']['tipo_busca']) && $_SESSION['busca']['tipo_busca'] == '2' ? 'checked="checked"' : ''; ?> class="tipo_busca" name="tipo_busca" value="2" />
                    <span>Por Caracter�sticas</span>
                </label>
            
                <br clear="all" />
                
                <div id="box-busca-codigo">
                    <label class="codigo">
                        <span>C�digo do Im�vel <em>(Ex: RRD11)</em></span>
                        <input class="text-codigo" value="<?php echo isset($_SESSION['busca']['codigo']) ? $_SESSION['busca']['codigo'] : ''; ?>" name="codigo" type="text" />
                        <input style="width: 89px;" type="submit" value="Buscar" class="b-av"/>        
                    </label>
                </div>    
                
                <div id="box-busca-titulo" style="display: none;">
                    <label class="codigo">
                        <span>T�tulo do Im�vel</span>
                        <input class="text-codigo" value="<?php echo isset($_SESSION['busca']['titulo']) ? $_SESSION['busca']['titulo'] : ''; ?>" name="titulo" type="text" />
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
                                    <?php if(isset($_SESSION['busca']['cidade'])) :?>
                                        <?php if($_SESSION['busca']['cidade'] == $cidade_sp->id) :?>
                                            <option selected="selected" value="<?php echo $cidade_sp->id;?>"><?php echo $cidade_sp->cidade;?></option>
                                        <?php else :?>
                                            <option value="<?php echo $cidade_sp->id;?>"><?php echo $cidade_sp->cidade;?></option>
                                        <?php endif;?>
                                    <?php else :?>
                                        <option value="<?php echo $cidade_sp->id;?>"><?php echo $cidade_sp->cidade;?></option>   
                                    <?php endif;?>
                                <?php endforeach;?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="cidade" value="<?php echo $cidade_corretor->id;?>" />
                    <?php endif;?>
                        
                    <div style="float: left;">
                        
                        <?php if(isset($bairros)) : ?>         
                            <div class="select" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;" id="label-bairro">
                                <span>Filtrar por Bairro</span>
                                <?php 
                                $i = 1;
                                foreach($_SESSION['busca']['bairro'] as $bairro) : 
                                if($i > 1) :?>
                                <span class="bloco" style="width: 105px;"></span>
                                <?php endif;?>
                                <select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">
                                    <option value="">Selecione</option>
                                    <?php foreach($bairros as $row_bairros) : 
                                    if($row_bairros->id == $bairro) : ?>
                                    <option selected="selected" value="<?php echo $row_bairros->id;?>"><?php echo $row_bairros->bairro;?></option>
                                    <?php else :?>
                                    <option value="<?php echo $row_bairros->id;?>"><?php echo $row_bairros->bairro;?></option>
                                    <?php endif;?> 
                                    <?php endforeach;?>
                                </select>
                                <?php if($i < count($_SESSION['busca']['bairro'])) :?>
                                <a style="float: left; margin: 5px 0 0 10px;" class="remove-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-menos.gif" alt="- Bairros" /></a> 
                                <?php else :?>
                                <a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a> 
                                <?php endif; $i++;  
                                endforeach;?> 
                            </div>
                        <?php else :?>
                            <div class="select" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;" id="label-bairro">
                                <span>Filtrar por Bairro</span>
                                <select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">
                                    <option value="">Selecione</option>
                                </select>
                                <a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a> 
                            </div>
                        <?php endif;?>  

                        <br clear="all" />
                    
                        <div class="select tipo" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;">
                            <span style="text-align: right; width: 105px;">Tipo</span>
                            <?php 
                            if(count($_SESSION['busca']['tipo']) > 0) :
                                $i = 1;
                                foreach($_SESSION['busca']['tipo'] as $arr_tipo) :
                                if($i > 1) :?>
                                <span class="bloco2" style="width: 12px;"></span>
                                <?php endif;?>
                                <select style="margin: 0 0 15px 0; float: left;" name="tipo[]">                                    
                                    <option value="">Selecione</option>
                                    <?php foreach($rows_tipo as $row_tipo) :
                                    if($row_tipo->id == $arr_tipo) :?>
                                    <option selected="selected" value="<?php echo $row_tipo->id;?>"><?php echo $row_tipo->nome;?></option>
                                    <?php else:?>
                                    <option value="<?php echo $row_tipo->id;?>"><?php echo $row_tipo->nome;?></option>                                
                                    <?php endif;?>
                                    <?php endforeach;?>
                                </select>
                                <?php if($i < count($_SESSION['busca']['tipo'])) :?>
                                <a style="float: left; margin: 5px 0 0 10px;" class="remove-tipo" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-menos.gif" alt="- Bairros" /></a> 
                                <?php endif; $i++; 
                                endforeach;
                            else : ?>
                                <select style="margin: 0 0 15px 0;" name="tipo[]">
                                    <option value="">Selecione</option>
                                    <?php foreach ($rows_tipo as $row_tipo) : ?>
                                    <option value="<?php echo $row_tipo->id; ?>"><?php echo $row_tipo->nome; ?></option>
                                    <?php endforeach;?>
                                </select>
                            <?php endif;?>
                            <a style="float: left; margin: 5px 0 0 10px;" class="add-tipo" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Tipos" /></a> 
                        </div>
                        
                    </div>
                
                    <div style="float: right;">
                        <div class="check">
                            <p>Residencial</p>

                            <label>
                                <input <?php echo isset($_SESSION['busca']['residencial_aluguel']) ? "checked='checked'" : "";?> type="checkbox" value="SIM" name="residencial_aluguel" />
                                <span>Aluguel</span>
                            </label>

                            <label>
                                <input <?php echo isset($_SESSION['busca']['residencial_compra']) ? "checked='checked'" : "";?> type="checkbox" value="SIM" name="residencial_compra" />
                                <span>Venda</span>
                            </label>
                        </div>

                        <div class="check">
                            <p>Comercial</p>

                            <label>
                                <input <?php echo isset($_SESSION['busca']['comercial_aluguel']) ? "checked='checked'" : "";?> type="checkbox" value="SIM" name="comercial_aluguel" />
                                <span>Aluguel</span>
                            </label>

                            <label>
                                <input <?php echo isset($_SESSION['busca']['comercial_compra']) ? "checked='checked'" : "";?> type="checkbox" value="SIM" name="comercial_compra" />
                                <span>Venda</span>
                            </label>
                        </div>
                    </div>
                        
                    <div class="busca-avancada">

                        <h3>BUSCA AVAN�ADA</h3>

                        <div id="b-avancada">&nbsp;</div>

                        <div id="busca-avancada-display">

                            <label>
                                <span>Valor do Aluguel at� R$</span>
                                <input value="<?php echo isset($_SESSION['busca']['valor_aluguel']) ? $_SESSION['busca']['valor_aluguel'] : '';?>" type="text" id="valor_aluguel" name="valor_aluguel" />
                            </label>

                            <label>
                                <span>Valor de Venda at� R$</span>
                                <input value="<?php echo isset($_SESSION['busca']['valor_venda']) ? $_SESSION['busca']['valor_venda'] : '';?>" type="text" id="valor_venda" name="valor_venda" />
                            </label>
                            
                            <label>
                                <span>Valor M�nimo de Aluguel R$</span>
                                <input type="text" id="valor_minimo_aluguel" value="<?php echo isset($_SESSION['busca']['valor_minimo_aluguel']) ? $_SESSION['busca']['valor_minimo_aluguel'] : '';?>" name="valor_minimo_aluguel" />
                            </label>

                            <label>
                                <span>Valor M�nimo de Venda R$</span>
                                <input type="text" id="valor_minimo_venda" value="<?php echo isset($_SESSION['busca']['valor_minimo_venda']) ? $_SESSION['busca']['valor_minimo_venda'] : '';?>" name="valor_minimo_venda" />
                            </label>

                            <label>
                                <span>N�mero Atual de Quartos</span>
                                <input value="<?php echo isset($_SESSION['busca']['n_quartos']) ? $_SESSION['busca']['n_quartos'] : '';?>" type="text" name="n_quartos" />
                            </label>

                            <label>
                                <span>Nome do Condom�nio</span>
                                <input value="<?php echo isset($_SESSION['busca']['nome_condominio']) ? $_SESSION['busca']['nome_condominio'] : '';?>" type="text"  name="nome_condominio" />
                            </label>

                            <label>
                                <span>�rea constru�da maior que:<br /><font>(n�o incluindo varandas)</font></span>
                                <input value="<?php echo isset($_SESSION['busca']['area_construida_maior']) ? $_SESSION['busca']['area_construida_maior'] : '';?>" type="text" name="area_construida_maior" /> m�
                            </label>
                            <label>
                                <span>�rea constru�da menor que:<br /><font>(n�o incluindo varandas)</font></span>
                                <input value="<?php echo isset($_SESSION['busca']['area_construida_menor']) ? $_SESSION['busca']['area_construida_menor'] : '';?>" type="text" name="area_construida_menor" /> m� 
                            </label>


                            <label class="av-check av-check-f">
                                <input <?php echo isset($_SESSION['busca']['mobiliado']) ? "checked='checked'" : "";?> type="checkbox" name="mobiliado" />
                                <span>Mobiliado</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo isset($_SESSION['busca']['portaria_h']) ? "checked='checked'" : "";?> type="checkbox" name="portaria_h" />
                                <span>Portaria 24h</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo isset($_SESSION['busca']['varanda']) ? "checked='checked'" : "";?> type="checkbox" name="varanda" />
                                <span>Varanda</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo isset($_SESSION['busca']['piscina']) ? "checked='checked'" : "";?> type="checkbox" name="piscina" />
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
