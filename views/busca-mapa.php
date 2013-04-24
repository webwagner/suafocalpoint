<script type="text/javascript" src="<?php echo URL; ?>static/js/maskedmoney.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
    function mapa(){
    
        var geocoder = new google.maps.Geocoder();
    
        var myLatlng = new google.maps.LatLng(-14.235004,-51.92528);
        var myOptions = {
            zoom: 4,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        $(".enderecos").each(function(i){
            var address = $(this).val();
            var titulo = $(this).attr("titulo");
            var link = $(this).attr("link");
            if (geocoder) {
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK){   
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            icon: "http://gmaps-samples.googlecode.com/svn/trunk/markers/green/marker"+(i+1)+".png"
                        });
                        var infowindow = new google.maps.InfoWindow({ 
                            content: "<p>"+titulo+"</p><a href = '"+link+"'>Detalhes</a>",
                            zIndex: 5
                        });
                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow.open(map,marker);
                            map.setZoom(15);
                            map.setCenter(results[0].geometry.location);
                        });
                    }    
                });
            }
        })
    
    }

    $(document).ready(function(){
    
        <?php if ($_POST['tipo_busca'] == 1) { ?>
            $('#box-busca-codigo').show();
            $('#box-busca-caracteristicas').hide();
            $('#box-busca-titulo').hide();
        <?php } else if ($_POST['tipo_busca'] == 3) { ?>
            $('#box-busca-titulo').show();
            $('#box-busca-codigo').hide();
            $('#box-busca-caracteristicas').hide();
        <?php } else { ?>
            $('#box-busca-caracteristicas').show();
            $('#box-busca-codigo').hide();
            $('#box-busca-titulo').hide();
        <?php } ?>

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

        $("#valor_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
        $("#valor_venda").maskMoney({thousands:'.', decimal:'', precision:0});
        $("#valor_minimo_aluguel").maskMoney({thousands:'.', decimal:'', precision:0});
        $("#valor_minimo_venda").maskMoney({thousands:'.', decimal:'', precision:0});
    
        <?php if ($uf_corretor->uf == "SP") : ?>
            $("#cidade").change(function(){

                var cidade = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "estados_imovel.php",
                    data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id; ?>,
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
        <?php else: ?>
            <?php if (!isset($_POST['bairro'])) : ?>         
                var cidade = <?php echo $cidade_corretor->id; ?>;

                $.ajax({
                    type: "GET",
                    url: "estados_imovel.php",
                    data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id; ?>,
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
        <?php endif; ?>
    <?php endif; ?>

        $('.add-bairro').live("click", function(event){

            $('.add-bairro').html('<img src="static/img/bt-menos.gif" alt="- Bairros" />');
            $('.add-bairro').removeClass('add-bairro').addClass('remove-bairro');

            if($("#cidade").size() > 0)
                var cidade = $("#cidade").val();
            else
                var cidade = <?php echo $cidade_corretor->id; ?>;

            $.ajax({
                type: "GET",
                url: "estados_imovel.php",
                data: "acao=buscaBairro&cidade="+cidade+"&id_corretor="+<?php echo $_SESSION['usuario_logado']->id; ?>,
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

        <?php if ($_POST) { ?>
            mapa();
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
            <span>Busca de Imóveis</span>
        </div>

        <div id="busca-imoveis" class="busca-codigo-av">

            <form action="<?php echo $_SESSION['login']; ?>/busca-mapa" method="post" id="formulario_b">

                <label style="width: auto;" class="radio">
                    <input class="tipo_busca" <?php echo ($_POST['tipo_busca'] == 1 ? 'checked="checked"' : '');?> type="radio" name="tipo_busca" value="1" />
                    <span>Por Código</span>
                </label>

                <label style="width: auto;" class="radio">
                    <input class="tipo_busca" <?php echo ($_POST['tipo_busca'] == 3 ? 'checked="checked"' : '');?> type="radio" name="tipo_busca" value="3" />
                    <span>Por Título</span>
                </label>

                <label class="radio">
                    <input type="radio" class="tipo_busca" <?php echo ($_POST['tipo_busca'] == 2 ? 'checked="checked"' : '');?> name="tipo_busca" value="2" />
                    <span>Por Características</span>
                </label>

                <br clear="all" />

                <div id="box-busca-codigo">
                    <label class="codigo">
                        <span>Código do Imóvel <em>(Ex: RRD11)</em></span>
                        <input class="text-codigo" value="<?php echo isset($_POST['codigo']) ? $_POST['codigo'] : ''; ?>" name="codigo" type="text" />
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

                    <input type="hidden" name="uf" value="<?php echo $uf_corretor->id; ?>" />

                    <?php if ($uf_corretor->uf == "SP") : ?>
                        <div class="select" style="padding: 0; width: 382px; margin: 0 2px 0 0; height: auto;" id="label-cidade">
                            <span>Filtrar por Cidade</span>
                            <select style="margin: 0 0 15px 0; float: left;" id="cidade" name="cidade">
                                <option value="">Selecione</option>
                                <?php foreach ($cidades_sp as $cidade_sp) : ?>
                                    <?php if (isset($_POST['cidade'])) : ?>
                                        <?php if ($_POST['cidade'] == $cidade_sp->id) : ?>
                                            <option selected="selected" value="<?php echo $cidade_sp->id; ?>"><?php echo $cidade_sp->cidade; ?></option>
                                        <?php else : ?>
                                            <option value="<?php echo $cidade_sp->id; ?>"><?php echo $cidade_sp->cidade; ?></option>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <option value="<?php echo $cidade_sp->id; ?>"><?php echo $cidade_sp->cidade; ?></option>   
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="cidade" value="<?php echo $cidade_corretor->id; ?>" />
                    <?php endif; ?>

                   <div style="float: left;">
                        <?php if (isset($_POST['bairro'])) : ?>
                            <div style="padding: 0; margin: 0 60px 0 0; float: left; width: 550px;">         
                                <div class="select" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;" id="label-bairro">
                                    <span>Filtrar por Bairro</span>
                                    <?php
                                    $i = 1;
                                    foreach ($_POST['bairro'] as $bairro) :
                                        if ($i > 1) :
                                            ?>
                                            <span class="bloco" style="width: 105px;"></span>
                                        <?php endif; ?> 
                                        <select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">
                                            <option value="">Selecione</option>
                                            <?php foreach ($bairros as $row_bairros) :
                                                if ($row_bairros->id == $bairro) :
                                                    ?>
                                                    <option selected="selected" value="<?php echo $row_bairros->id; ?>"><?php echo $row_bairros->bairro; ?></option>
                                                <?php else : ?>
                                                    <option value="<?php echo $row_bairros->id; ?>"><?php echo $row_bairros->bairro; ?></option>
                                                <?php endif; ?> 
                                        <?php endforeach; ?>
                                        </select>
                                        <?php if ($i < count($_POST['bairro'])) : ?>
                                            <a style="float: left; margin: 5px 0 0 10px;" class="remove-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-menos.gif" alt="- Bairros" /></a> 
                                        <?php else : ?>
                                            <a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a> 
                                        <?php endif;
                                        $i++;
                                    endforeach;
                                    ?> 
                                </div>
                            </div>
                            <?php else : ?>
                            <div class="select" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;" id="label-bairro">
                                <span>Filtrar por Bairro</span>
                                <select style="margin: 0 0 15px 0; float: left;" class="bairro" name="bairro[]">
                                    <option value="">Selecione</option>
                                </select>
                                <a style="float: left; margin: 5px 0 0 10px;" class="add-bairro" style="text-decoration: underline; color: #999999; font-size: 15px; " href="javascript:void(0)"><img src="static/img/bt-mais.gif" alt="+ Bairros" /></a> 
                            </div>
                            <?php endif; ?> 

                        <br clear="all" />

                        <div class="select tipo" style="padding: 0; width: 410px; margin: 0 2px 0 0; height: auto;">
                            <span style="text-align: right; width: 105px;">Tipo</span>
                            <?php 
                            if(isset($_POST['tipo']) and count($_POST['tipo']) > 0) :
                                $i = 1;
                                foreach($_POST['tipo'] as $arr_tipo) :
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
                                <?php if($i < count($_POST['tipo'])) :?>
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
                                <input <?php echo isset($_POST['residencial_aluguel']) ? "checked='checked'" : ""; ?> type="checkbox" value="SIM" name="residencial_aluguel" />
                                <span>Aluguel</span>
                            </label>

                            <label>
                                <input <?php echo isset($_POST['residencial_compra']) ? "checked='checked'" : ""; ?> type="checkbox" value="SIM" name="residencial_compra" />
                                <span>Venda</span>
                            </label>
                        </div>
                        
                        <div class="check">
                            <p>Comercial</p>

                            <label>
                                <input <?php echo isset($_POST['comercial_aluguel']) ? "checked='checked'" : ""; ?> type="checkbox" value="SIM" name="comercial_aluguel" />
                                <span>Aluguel</span>
                            </label>

                            <label>
                                <input <?php echo isset($_POST['comercial_compra']) ? "checked='checked'" : ""; ?> type="checkbox" value="SIM" name="comercial_compra" />
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
                                <input value="<?php echo isset($_POST['valor_aluguel']) ? $_POST['valor_aluguel'] : ''; ?>" type="text" id="valor_aluguel" name="valor_aluguel" />
                            </label>

                            <label>
                                <span>Valor de Venda até R$</span>
                                <input value="<?php echo isset($_POST['valor_venda']) ? $_POST['valor_venda'] : ''; ?>" type="text" id="valor_venda" name="valor_venda" />
                            </label>

                            <label>
                                <span>Valor Mínimo de Aluguel R$</span>
                                <input type="text" id="valor_minimo_aluguel" value="<?php echo isset($_POST['valor_minimo_aluguel']) ? $_POST['valor_minimo_aluguel'] : ''; ?>" name="valor_minimo_aluguel" />
                            </label>

                            <label>
                                <span>Valor Mínimo de Venda R$</span>
                                <input type="text" id="valor_minimo_venda" value="<?php echo isset($_POST['valor_minimo_venda']) ? $_POST['valor_minimo_venda'] : ''; ?>" name="valor_minimo_venda" />
                            </label>
                            
                            <label>
                                <span>Número Atual de Quartos</span>
                                <input value="<?php echo isset($_POST['n_quartos']) ? $_POST['n_quartos'] : ''; ?>" type="text" name="n_quartos" />
                            </label>

                            <label>
                                <span>Nome do Condomínio</span>
                                <input value="<?php echo isset($_POST['nome_condominio']) ? $_POST['nome_condominio'] : ''; ?>" type="text"  name="nome_condominio" />
                            </label>

                            <label>
                                <span>Área construída maior que:<br /><font>(não incluindo varandas)</font></span>
                                <input value="<?php echo isset($_POST['area_construida_maior']) ? $_POST['area_construida_maior'] : ''; ?>" type="text" name="area_construida_maior" /> m²
                            </label>
                            <label>
                                <span>Área construída menor que:<br /><font>(não incluindo varandas)</font></span>
                                <input value="<?php echo isset($_POST['area_construida_maior']) ? $_POST['area_construida_maior'] : ''; ?>" type="text" name="area_construida_menor" /> m² 
                            </label>


                            <label class="av-check av-check-f">
                                <input <?php echo isset($_POST['mobiliado']) ? "checked='checked'" : ""; ?> type="checkbox" name="mobiliado" />
                                <span>Mobiliado</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo isset($_POST['portaria_h']) ? "checked='checked'" : ""; ?> type="checkbox" name="portaria_h" />
                                <span>Portaria 24h</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo isset($_POST['varanda']) ? "checked='checked'" : ""; ?> type="checkbox" name="varanda" />
                                <span>Varanda</span>
                            </label>

                            <label class="av-check">
                                <input <?php echo isset($_POST['piscina']) ? "checked='checked'" : ""; ?> type="checkbox" name="piscina" />
                                <span>Piscina</span>
                            </label>

                            <br clear="all" />

                            <input type="submit" value="Buscar" class="b-av"/>                     	                        

                        </div>

                    </div>

                </div>

                <?php echo $html; ?>

            </form>

        </div>    
        
         <div>
            <div id="map_canvas"></div>
        </div>

    </div>

</div>
